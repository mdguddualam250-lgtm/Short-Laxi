<?php
/**
 * Static checks for the Shortlaxi theme. No WordPress install or Composer needed.
 *
 * Usage: php bin/validate.php [theme-dir]
 * Exit code is non-zero when any check fails.
 */

$theme_dir = rtrim( $argv[1] ?? dirname( __DIR__ ) . '/shortlaxi', '/' );
$errors    = array();
$checks    = 0;

/**
 * Records a failed check.
 *
 * @param string $message What went wrong.
 */
function fail( $message ) {
	global $errors;
	$errors[] = $message;
}

/**
 * Lists files under the theme directory that match a regex.
 *
 * @param string $dir     Directory.
 * @param string $pattern Regex applied to the relative path.
 * @return string[] Relative paths.
 */
function theme_files( $dir, $pattern ) {
	$found = array();
	$it    = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ) );
	foreach ( $it as $file ) {
		$rel = substr( $file->getPathname(), strlen( $dir ) + 1 );
		if ( preg_match( $pattern, $rel ) ) {
			$found[] = $rel;
		}
	}
	sort( $found );
	return $found;
}

/**
 * Reads WordPress-style "Key: value" file headers.
 *
 * @param string $contents File contents.
 * @return array<string,string>
 */
function read_headers( $contents ) {
	$headers = array();
	if ( preg_match_all( '/^[ \t\/*#@]*([A-Za-z][A-Za-z ]+):[ \t]*(.+)$/m', $contents, $m, PREG_SET_ORDER ) ) {
		foreach ( $m as $match ) {
			$key = trim( $match[1] );
			if ( ! isset( $headers[ $key ] ) ) {
				$headers[ $key ] = trim( $match[2] );
			}
		}
	}
	return $headers;
}

if ( ! is_dir( $theme_dir ) ) {
	fwrite( STDERR, "Theme directory not found: $theme_dir\n" );
	exit( 2 );
}

// 1. PHP syntax.
foreach ( theme_files( $theme_dir, '/\.php$/' ) as $rel ) {
	++$checks;
	$out = array();
	exec( escapeshellarg( PHP_BINARY ) . ' -l ' . escapeshellarg( "$theme_dir/$rel" ) . ' 2>&1', $out, $code );
	if ( 0 !== $code ) {
		fail( "PHP syntax error in $rel: " . implode( ' ', $out ) );
	}
}

// 2. JSON syntax and theme.json version.
$theme_json = null;
foreach ( theme_files( $theme_dir, '/\.json$/' ) as $rel ) {
	++$checks;
	$data = json_decode( file_get_contents( "$theme_dir/$rel" ), true );
	if ( JSON_ERROR_NONE !== json_last_error() ) {
		fail( "Invalid JSON in $rel: " . json_last_error_msg() );
		continue;
	}
	if ( isset( $data['version'] ) && 3 !== $data['version'] ) {
		fail( "$rel should use theme.json version 3." );
	}
	if ( 'theme.json' === $rel ) {
		$theme_json = $data;
	}
}

// 3. Theme header and readme agree.
++$checks;
$style  = read_headers( (string) file_get_contents( "$theme_dir/style.css" ) );
$readme = read_headers( (string) file_get_contents( "$theme_dir/readme.txt" ) );
foreach ( array( 'Theme Name', 'Version', 'Requires at least', 'Tested up to', 'Requires PHP', 'License', 'Text Domain' ) as $key ) {
	if ( empty( $style[ $key ] ) ) {
		fail( "style.css is missing the \"$key\" header." );
	}
}
if ( ( $style['Version'] ?? '' ) !== ( $readme['Stable tag'] ?? '' ) ) {
	fail( 'style.css Version (' . ( $style['Version'] ?? '?' ) . ') does not match readme.txt Stable tag (' . ( $readme['Stable tag'] ?? '?' ) . ').' );
}
foreach ( array( 'Requires at least', 'Tested up to', 'Requires PHP' ) as $key ) {
	if ( ( $style[ $key ] ?? '' ) !== ( $readme[ $key ] ?? '' ) ) {
		fail( "\"$key\" differs between style.css and readme.txt." );
	}
}
$text_domain = $style['Text Domain'] ?? 'shortlaxi';

// 4. Pattern headers.
$pattern_slugs = array();
foreach ( theme_files( $theme_dir, '/^patterns\/.+\.php$/' ) as $rel ) {
	++$checks;
	$headers = read_headers( (string) file_get_contents( "$theme_dir/$rel" ) );
	if ( empty( $headers['Title'] ) || empty( $headers['Slug'] ) ) {
		fail( "$rel needs Title and Slug headers." );
		continue;
	}
	if ( 0 !== strpos( $headers['Slug'], "$text_domain/" ) ) {
		fail( "$rel slug \"{$headers['Slug']}\" should start with \"$text_domain/\"." );
	}
	if ( isset( $pattern_slugs[ $headers['Slug'] ] ) ) {
		fail( "Duplicate pattern slug {$headers['Slug']} in $rel and {$pattern_slugs[ $headers['Slug'] ]}." );
	}
	$pattern_slugs[ $headers['Slug'] ] = $rel;
}

// 5. Every referenced pattern and template part exists; templates contain no hard-coded copy.
$parts = array_map(
	static function ( $rel ) {
		return basename( $rel, '.html' );
	},
	theme_files( $theme_dir, '/^parts\/.+\.html$/' )
);
foreach ( theme_files( $theme_dir, '/^(templates|parts|patterns)\/.+\.(html|php)$/' ) as $rel ) {
	++$checks;
	$markup = (string) file_get_contents( "$theme_dir/$rel" );
	if ( preg_match_all( '/<!-- wp:pattern \{"slug":"([^"]+)"/', $markup, $m ) ) {
		foreach ( $m[1] as $slug ) {
			if ( ! isset( $pattern_slugs[ $slug ] ) ) {
				fail( "$rel references missing pattern \"$slug\"." );
			}
		}
	}
	if ( preg_match_all( '/<!-- wp:template-part \{"slug":"([^"]+)"/', $markup, $m ) ) {
		foreach ( $m[1] as $slug ) {
			if ( ! in_array( $slug, $parts, true ) ) {
				fail( "$rel references missing template part \"$slug\"." );
			}
		}
	}
	// Block comment delimiters must balance.
	preg_match_all( '/<!-- wp:([a-z0-9\/-]+)(?: \{.*?\})? -->/', $markup, $open );
	preg_match_all( '/<!-- \/wp:([a-z0-9\/-]+) -->/', $markup, $close );
	if ( count( $open[1] ) !== count( $close[1] ) ) {
		fail( "$rel has " . count( $open[1] ) . ' opening and ' . count( $close[1] ) . ' closing block comments.' );
	}
	// HTML templates cannot be translated, so visible copy must live in PHP patterns.
	if ( '.html' === substr( $rel, -5 ) ) {
		$text = trim( preg_replace( '/\s+/', ' ', strip_tags( preg_replace( '/<!--.*?-->/s', '', $markup ) ) ) );
		if ( '' !== $text ) {
			fail( "$rel contains hard-coded text (\"" . substr( $text, 0, 60 ) . '"); move it into a pattern so it can be translated.' );
		}
	}
}

// 6. Custom templates declared in theme.json have files.
foreach ( $theme_json['customTemplates'] ?? array() as $template ) {
	++$checks;
	if ( ! file_exists( "$theme_dir/templates/{$template['name']}.html" ) ) {
		fail( "theme.json declares custom template {$template['name']} but templates/{$template['name']}.html is missing." );
	}
}

// 7. Theme blocks: metadata, render files and every reference from templates/patterns.
$theme_blocks = array();
foreach ( theme_files( $theme_dir, '/^blocks\/[^\/]+\/block\.json$/' ) as $rel ) {
	++$checks;
	$meta = json_decode( (string) file_get_contents( "$theme_dir/$rel" ), true );
	$dir  = dirname( $rel );
	if ( ! is_array( $meta ) || empty( $meta['name'] ) ) {
		fail( "$rel is missing a block name." );
		continue;
	}
	if ( 0 !== strpos( $meta['name'], "$text_domain/" ) ) {
		fail( "$rel block name \"{$meta['name']}\" should start with \"$text_domain/\"." );
	}
	if ( 3 !== ( $meta['apiVersion'] ?? 0 ) ) {
		fail( "$rel should use apiVersion 3." );
	}
	if ( isset( $meta['render'] ) && 0 === strpos( $meta['render'], 'file:' ) && ! file_exists( "$theme_dir/$dir/" . substr( $meta['render'], 7 ) ) ) {
		fail( "$rel points to a missing render file." );
	}
	$theme_blocks[ $meta['name'] ] = $rel;
}
foreach ( theme_files( $theme_dir, '/^(templates|parts|patterns)\/.+\.(html|php)$/' ) as $rel ) {
	if ( preg_match_all( '/<!-- wp:(' . preg_quote( $text_domain, '/' ) . '\/[a-z0-9-]+)/', (string) file_get_contents( "$theme_dir/$rel" ), $m ) ) {
		foreach ( array_unique( $m[1] ) as $name ) {
			++$checks;
			if ( ! isset( $theme_blocks[ $name ] ) ) {
				fail( "$rel uses unregistered theme block \"$name\"." );
			}
		}
	}
}

// 8. Template parts declared in theme.json exist.
foreach ( $theme_json['templateParts'] ?? array() as $part ) {
	++$checks;
	if ( ! file_exists( "$theme_dir/parts/{$part['name']}.html" ) ) {
		fail( "theme.json declares template part {$part['name']} but parts/{$part['name']}.html is missing." );
	}
}

// 9. JavaScript syntax (when Node.js is available).
$node = trim( (string) shell_exec( 'command -v node 2>/dev/null' ) );
foreach ( theme_files( $theme_dir, '/\.js$/' ) as $rel ) {
	if ( '' === $node ) {
		echo "Note: Node.js not found; skipped syntax check of $rel\n";
		continue;
	}
	++$checks;
	$out = array();
	exec( escapeshellarg( $node ) . ' --check ' . escapeshellarg( "$theme_dir/$rel" ) . ' 2>&1', $out, $code );
	if ( 0 !== $code ) {
		fail( "JavaScript syntax error in $rel: " . implode( ' ', $out ) );
	}
}

// 10. Screenshot.
++$checks;
$shot = @getimagesize( "$theme_dir/screenshot.png" );
if ( ! $shot ) {
	fail( 'screenshot.png is missing or unreadable.' );
} elseif ( 1200 !== $shot[0] || 900 !== $shot[1] ) {
	fail( "screenshot.png should be 1200x900, got {$shot[0]}x{$shot[1]}." );
}

if ( $errors ) {
	fwrite( STDERR, "FAILED: " . count( $errors ) . " problem(s) in $checks checks\n - " . implode( "\n - ", $errors ) . "\n" );
	exit( 1 );
}
echo "OK: $checks checks passed for " . ( $style['Theme Name'] ?? 'theme' ) . ' ' . ( $style['Version'] ?? '' ) . "\n";
