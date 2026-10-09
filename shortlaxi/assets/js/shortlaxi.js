/**
 * Shortlaxi front-end behaviour. Vanilla JS, no dependencies, loaded with `defer`.
 *
 * - Menu button: collapses the sidebar to an icon rail on desktop, opens it as a
 *   drawer on tablet and phone (focus moved in, Escape/scrim close, page inert).
 * - Bookmarks: saved post IDs live in localStorage; bookmark lists are filled from
 *   the REST API.
 * - Share: "Copy link" and the native share sheet, when the browser supports them.
 *
 * Everything degrades gracefully: without this file, navigation, search and all
 * links still work.
 */
( function () {
	'use strict';

	var doc = document;
	var root = doc.documentElement;
	var l10n = window.shortlaxiL10n || {};
	var desktop = window.matchMedia( '(min-width: 1024px)' );
	var SIDEBAR_KEY = 'shortlaxi:sidebar-collapsed';
	var BOOKMARKS_KEY = 'shortlaxi:bookmarks';

	function t( key, fallback ) {
		return l10n[ key ] || fallback;
	}

	function storage( key, value ) {
		try {
			if ( value === undefined ) {
				return window.localStorage.getItem( key );
			}
			if ( value === null ) {
				window.localStorage.removeItem( key );
			} else {
				window.localStorage.setItem( key, value );
			}
		} catch ( e ) {
			// Private mode or storage disabled: features still work for this page view.
		}
		return null;
	}

	/* Polite live region for status messages. */
	var live = doc.createElement( 'div' );
	live.className = 'screen-reader-text';
	live.setAttribute( 'role', 'status' );
	live.setAttribute( 'aria-live', 'polite' );
	doc.body.appendChild( live );

	function announce( message ) {
		live.textContent = '';
		window.setTimeout( function () {
			live.textContent = message;
		}, 50 );
	}

	/* ------------------------------------------------------------------ *
	 * Sidebar: collapsible rail on desktop, drawer below 1024px.
	 * ------------------------------------------------------------------ */
	var sidebar = doc.getElementById( 'shortlaxi-sidebar' ) || doc.querySelector( '.shortlaxi-sidebar' );
	var toggles = Array.prototype.slice.call( doc.querySelectorAll( '.shortlaxi-menu-toggle' ) );
	var inertTargets = Array.prototype.slice.call( doc.querySelectorAll( '.shortlaxi-content, .shortlaxi-header' ) );
	var scrim = null;
	var closeButton = null;
	var lastFocus = null;

	function isDrawerOpen() {
		return root.classList.contains( 'shortlaxi-drawer-open' );
	}

	function syncToggles() {
		var expanded;
		var label;

		if ( desktop.matches ) {
			expanded = ! root.classList.contains( 'shortlaxi-sidebar-collapsed' );
			label = expanded ? t( 'collapseMenu', 'Collapse sidebar' ) : t( 'expandMenu', 'Expand sidebar' );
		} else {
			expanded = isDrawerOpen();
			label = expanded ? t( 'closeMenu', 'Close main menu' ) : t( 'openMenu', 'Open main menu' );
		}

		toggles.forEach( function ( button ) {
			button.setAttribute( 'aria-expanded', expanded ? 'true' : 'false' );
			button.setAttribute( 'aria-label', label );
		} );
	}

	function setInert( on ) {
		inertTargets.forEach( function ( node ) {
			if ( on ) {
				node.setAttribute( 'inert', '' );
			} else {
				node.removeAttribute( 'inert' );
			}
		} );
	}

	function openDrawer() {
		lastFocus = doc.activeElement;
		root.classList.add( 'shortlaxi-drawer-open' );
		sidebar.setAttribute( 'role', 'dialog' );
		sidebar.setAttribute( 'aria-modal', 'true' );
		setInert( true );
		syncToggles();
		closeButton.focus();
	}

	function closeDrawer( restoreFocus ) {
		if ( ! isDrawerOpen() ) {
			return;
		}
		root.classList.remove( 'shortlaxi-drawer-open' );
		sidebar.removeAttribute( 'role' );
		sidebar.removeAttribute( 'aria-modal' );
		setInert( false );
		syncToggles();
		if ( restoreFocus !== false && lastFocus && lastFocus.focus ) {
			lastFocus.focus();
		}
	}

	if ( sidebar && toggles.length ) {
		// Close button and scrim exist only for the drawer presentation.
		closeButton = doc.createElement( 'button' );
		closeButton.type = 'button';
		closeButton.className = 'shortlaxi-drawer-close';
		closeButton.setAttribute( 'aria-label', t( 'closeMenu', 'Close main menu' ) );
		closeButton.innerHTML = '<svg aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg>';
		sidebar.insertBefore( closeButton, sidebar.firstChild );

		scrim = doc.createElement( 'div' );
		scrim.className = 'shortlaxi-scrim';
		scrim.setAttribute( 'aria-hidden', 'true' );
		doc.body.appendChild( scrim );

		toggles.forEach( function ( button ) {
			button.hidden = false;
			button.setAttribute( 'aria-controls', sidebar.id );
			button.addEventListener( 'click', function () {
				if ( desktop.matches ) {
					var collapsed = root.classList.toggle( 'shortlaxi-sidebar-collapsed' );
					storage( SIDEBAR_KEY, collapsed ? '1' : null );
					syncToggles();
				} else if ( isDrawerOpen() ) {
					closeDrawer();
				} else {
					openDrawer();
				}
			} );
		} );

		closeButton.addEventListener( 'click', function () {
			closeDrawer();
		} );
		scrim.addEventListener( 'click', function () {
			closeDrawer();
		} );

		doc.addEventListener( 'keydown', function ( event ) {
			if ( ! isDrawerOpen() ) {
				return;
			}
			if ( event.key === 'Escape' ) {
				event.preventDefault();
				closeDrawer();
				return;
			}
			if ( event.key === 'Tab' ) {
				// Keep focus inside the open drawer.
				var focusable = sidebar.querySelectorAll( 'a[href], button:not([disabled]), input, [tabindex]:not([tabindex="-1"])' );
				var first = focusable[ 0 ];
				var last = focusable[ focusable.length - 1 ];
				if ( event.shiftKey && doc.activeElement === first ) {
					event.preventDefault();
					last.focus();
				} else if ( ! event.shiftKey && doc.activeElement === last ) {
					event.preventDefault();
					first.focus();
				}
			}
		} );

		// Following a link inside the drawer (e.g. to a #section) closes it.
		sidebar.addEventListener( 'click', function ( event ) {
			if ( isDrawerOpen() && event.target.closest && event.target.closest( 'a[href]' ) ) {
				closeDrawer( false );
			}
		} );

		var onBreakpoint = function () {
			closeDrawer( false );
			syncToggles();
		};
		if ( desktop.addEventListener ) {
			desktop.addEventListener( 'change', onBreakpoint );
		} else if ( desktop.addListener ) {
			desktop.addListener( onBreakpoint );
		}

		syncToggles();
	}

	/* ------------------------------------------------------------------ *
	 * Category chips: keep the active chip in view.
	 * ------------------------------------------------------------------ */
	Array.prototype.forEach.call( doc.querySelectorAll( '.shortlaxi-chips' ), function ( list ) {
		var active = list.querySelector( '[aria-current="page"]' );
		if ( active && list.scrollWidth > list.clientWidth ) {
			list.scrollLeft = Math.max( 0, active.offsetLeft - ( list.clientWidth - active.offsetWidth ) / 2 );
		}
	} );

	/* ------------------------------------------------------------------ *
	 * Bookmarks.
	 * ------------------------------------------------------------------ */
	function getBookmarks() {
		var raw = storage( BOOKMARKS_KEY );
		var list = [];
		try {
			list = JSON.parse( raw || '[]' );
		} catch ( e ) {
			list = [];
		}
		return Array.isArray( list )
			? list.map( Number ).filter( function ( id ) {
					return id > 0;
			  } )
			: [];
	}

	function setBookmarks( list ) {
		storage( BOOKMARKS_KEY, list.length ? JSON.stringify( list ) : null );
	}

	function syncBookmarkButtons( scope ) {
		var saved = getBookmarks();
		Array.prototype.forEach.call( ( scope || doc ).querySelectorAll( '.wp-block-shortlaxi-bookmark-button[data-post-id]' ), function ( button ) {
			var isSaved = saved.indexOf( Number( button.getAttribute( 'data-post-id' ) ) ) !== -1;
			var label = button.querySelector( '.shortlaxi-bookmark__label' );
			button.hidden = false;
			button.setAttribute( 'aria-pressed', isSaved ? 'true' : 'false' );
			if ( label ) {
				label.textContent = isSaved ? t( 'unsave', 'Saved' ) : t( 'save', 'Save' );
			}
		} );
	}

	doc.addEventListener( 'click', function ( event ) {
		var button = event.target.closest && event.target.closest( '.wp-block-shortlaxi-bookmark-button[data-post-id]' );
		if ( ! button ) {
			return;
		}
		event.preventDefault();
		var id = Number( button.getAttribute( 'data-post-id' ) );
		var saved = getBookmarks();
		var index = saved.indexOf( id );
		if ( index === -1 ) {
			saved.unshift( id );
			announce( t( 'saved', 'Saved to bookmarks' ) );
		} else {
			saved.splice( index, 1 );
			announce( t( 'removed', 'Removed from bookmarks' ) );
		}
		setBookmarks( saved );
		syncBookmarkButtons();
		renderBookmarkLists();
	} );

	function textFromHtml( html ) {
		return new window.DOMParser().parseFromString( html || '', 'text/html' ).body.textContent.trim();
	}

	function make( tag, className, text ) {
		var node = doc.createElement( tag );
		if ( className ) {
			node.className = className;
		}
		if ( text ) {
			node.textContent = text;
		}
		return node;
	}

	function buildCard( post ) {
		var embedded = post._embedded || {};
		var media = ( embedded[ 'wp:featuredmedia' ] || [] )[ 0 ];
		var terms = ( embedded[ 'wp:term' ] || [] )[ 0 ] || [];
		var title = textFromHtml( post.title && post.title.rendered );
		var item = make( 'li', 'shortlaxi-card' );

		if ( media && media.source_url ) {
			var sizes = ( media.media_details && media.media_details.sizes ) || {};
			var src = ( sizes.medium_large || sizes.large || sizes.medium || {} ).source_url || media.source_url;
			var mediaLink = make( 'a', 'shortlaxi-card__media' );
			mediaLink.href = post.link;
			mediaLink.tabIndex = -1;
			mediaLink.setAttribute( 'aria-hidden', 'true' );
			var img = make( 'img' );
			img.src = src;
			img.alt = '';
			img.loading = 'lazy';
			img.decoding = 'async';
			mediaLink.appendChild( img );
			item.appendChild( mediaLink );
		}

		var body = make( 'div', 'shortlaxi-card__body' );
		if ( terms[ 0 ] && terms[ 0 ].name ) {
			body.appendChild( make( 'p', 'shortlaxi-card__kicker', textFromHtml( terms[ 0 ].name ) ) );
		}
		var heading = make( 'h3', 'shortlaxi-card__title' );
		var link = make( 'a', '', title );
		link.href = post.link;
		heading.appendChild( link );
		body.appendChild( heading );

		var excerpt = textFromHtml( post.excerpt && post.excerpt.rendered );
		if ( excerpt ) {
			body.appendChild( make( 'p', 'shortlaxi-card__excerpt', excerpt ) );
		}

		var meta = make( 'div', 'shortlaxi-card__meta' );
		var time = make( 'time' );
		time.dateTime = post.date;
		try {
			time.textContent = new Intl.DateTimeFormat( root.lang || undefined, { dateStyle: 'medium' } ).format( new Date( post.date ) );
		} catch ( e ) {
			time.textContent = post.date.slice( 0, 10 );
		}
		meta.appendChild( time );

		var save = make( 'button', 'wp-block-shortlaxi-bookmark-button' );
		save.type = 'button';
		save.setAttribute( 'data-post-id', String( post.id ) );
		save.innerHTML = '<svg class="shortlaxi-icon" aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"><path d="M6 3h12a1 1 0 0 1 1 1v17l-7-4.5L5 21V4a1 1 0 0 1 1-1z"/></svg>';
		var saveLabel = make( 'span', 'shortlaxi-bookmark__label screen-reader-text' );
		save.appendChild( saveLabel );
		save.appendChild( make( 'span', 'screen-reader-text', '“' + title + '”' ) );
		meta.appendChild( save );

		body.appendChild( meta );
		item.appendChild( body );
		return item;
	}

	function renderBookmarkLists() {
		Array.prototype.forEach.call( doc.querySelectorAll( '.wp-block-shortlaxi-bookmarks[data-endpoint]' ), function ( container ) {
			var grid = container.querySelector( '.shortlaxi-bookmarks__grid' );
			var empty = container.querySelector( '.shortlaxi-bookmarks__empty' );
			var limit = Number( container.getAttribute( 'data-limit' ) ) || 0;
			var ids = getBookmarks();
			if ( limit ) {
				ids = ids.slice( 0, limit );
			}

			container.classList.toggle( 'is-empty', ! ids.length );
			if ( ! ids.length ) {
				grid.hidden = true;
				grid.textContent = '';
				empty.hidden = false;
				return;
			}

			var endpoint = container.getAttribute( 'data-endpoint' );
			var url =
				endpoint +
				( endpoint.indexOf( '?' ) === -1 ? '?' : '&' ) +
				'include=' + ids.join( ',' ) +
				'&per_page=' + ids.length +
				'&orderby=include&_embed=wp:featuredmedia,wp:term' +
				'&_fields=id,link,title,excerpt,date,_links,_embedded';

			container.setAttribute( 'aria-busy', 'true' );
			window
				.fetch( url, { credentials: 'same-origin' } )
				.then( function ( response ) {
					if ( ! response.ok ) {
						throw new Error( response.status );
					}
					return response.json();
				} )
				.then( function ( posts ) {
					grid.textContent = '';
					posts.forEach( function ( post ) {
						grid.appendChild( buildCard( post ) );
					} );
					grid.hidden = ! posts.length;
					empty.hidden = !! posts.length;
					container.classList.toggle( 'is-empty', ! posts.length );
					syncBookmarkButtons( grid );
				} )
				.catch( function () {
					grid.hidden = true;
					empty.hidden = false;
					empty.querySelector( 'p' ).textContent = t( 'loadFailed', 'Your bookmarks could not be loaded. Please try again.' );
				} )
				.then( function () {
					container.setAttribute( 'aria-busy', 'false' );
				} );
		} );
	}

	syncBookmarkButtons();
	renderBookmarkLists();

	// Enhanced (no-reload) pagination swaps in new cards: keep their bookmark buttons in sync.
	if ( window.MutationObserver ) {
		var pending = false;
		new window.MutationObserver( function () {
			if ( pending ) {
				return;
			}
			pending = true;
			window.requestAnimationFrame( function () {
				pending = false;
				syncBookmarkButtons();
			} );
		} ).observe( doc.querySelector( 'main' ) || doc.body, { childList: true, subtree: true } );
	}

	/* ------------------------------------------------------------------ *
	 * Share controls.
	 * ------------------------------------------------------------------ */
	Array.prototype.forEach.call( doc.querySelectorAll( '.shortlaxi-share__native' ), function ( button ) {
		if ( navigator.share ) {
			button.parentNode.hidden = false;
			button.addEventListener( 'click', function () {
				navigator.share( { title: button.getAttribute( 'data-title' ), url: button.getAttribute( 'data-url' ) } ).catch( function () {} );
			} );
		}
	} );

	Array.prototype.forEach.call( doc.querySelectorAll( '.shortlaxi-share__copy' ), function ( button ) {
		if ( ! ( navigator.clipboard && navigator.clipboard.writeText ) ) {
			return;
		}
		button.parentNode.hidden = false;
		button.addEventListener( 'click', function () {
			navigator.clipboard.writeText( button.getAttribute( 'data-url' ) ).then(
				function () {
					button.classList.add( 'is-done' );
					announce( t( 'copied', 'Link copied to clipboard' ) );
					window.setTimeout( function () {
						button.classList.remove( 'is-done' );
					}, 2000 );
				},
				function () {
					announce( t( 'copyFailed', 'Could not copy the link.' ) );
				}
			);
		} );
	} );

	/* ------------------------------------------------------------------ *
	 * Table of contents: open by default on wide screens.
	 * ------------------------------------------------------------------ */
	if ( desktop.matches ) {
		Array.prototype.forEach.call( doc.querySelectorAll( '.shortlaxi-toc__details' ), function ( details ) {
			details.open = true;
		} );
	}
} )();
