# Short-Laxi

Shortlaxi global editorial website and WordPress theme.

This repository is the source of truth for **Shortlaxi**, a custom, mobile-first
WordPress block theme for a global English-language publication. Shortlaxi
publishes written articles; its interface borrows the familiar content-discovery
patterns of video apps (top search bar, collapsible sidebar, category chips,
thumbnail grids, trending and latest feeds) with its own Midnight-and-gold
identity. The production target is **WordPress.com** (`shortlaxi.wordpress.com`).

## Repository layout

```
.
├── shortlaxi/                    The theme (this folder is what gets installed)
│   ├── style.css                 Theme header (name, version, requirements)
│   ├── theme.json                Design tokens: palette, type, spacing, radii, block styles
│   ├── functions.php             Assets, early sidebar state, includes
│   ├── inc/
│   │   ├── navigation.php        Sidebar view links, current item, landmark label
│   │   ├── queries.php           Query Loop roles (featured, top, latest, trending, related)
│   │   ├── content.php           Table-of-contents data and matching heading anchors
│   │   └── blocks.php            Registers theme blocks, shared SVG icons
│   ├── blocks/                   Server-rendered theme blocks (block.json + render.php)
│   │   ├── category-chips/       "All" + categories as scrollable chips
│   │   ├── share/                Copy link, native share, X, Facebook, LinkedIn, WhatsApp, email
│   │   ├── toc/                  Article table of contents (3+ headings)
│   │   ├── bookmark-button/      Save/unsave a story (stored in the reader's browser)
│   │   └── bookmarks/            Reader's saved stories, loaded from the REST API
│   ├── assets/css/theme.css      Layout, shell, cards and interaction styles
│   ├── assets/js/shortlaxi.js    Sidebar/drawer, bookmarks, share (vanilla, deferred)
│   ├── assets/js/editor-blocks.js  Build-free editor previews for theme blocks
│   ├── assets/images/mark.svg    Brand mark
│   ├── templates/                home, single, page, archive, search, 404, index,
│   │                             page-explore, page-latest, page-trending, page-bookmarks
│   ├── parts/                    header, sidebar, footer
│   ├── patterns/                 Translatable patterns used by templates
│   ├── styles/daylight.json      Light style variation
│   ├── styles/blocks/            "Kicker" and "Standfirst" block styles
│   ├── screenshot.png            1200×900 preview shown in Appearance → Themes
│   └── readme.txt                WordPress theme readme
├── bin/validate.php              Static checks (no WordPress needed)
├── bin/package.sh                Builds dist/shortlaxi-<version>.zip from committed files
└── .github/workflows/theme.yml   CI: validate, schema-check, package
```

## Theme overview

| Area | Approach |
| --- | --- |
| Type | Block (full site editing) theme, `theme.json` v3, WordPress 7.1+, no plugins or build step |
| Shell | Sticky top bar (menu, logo, centred search); sidebar with Home, Explore, Latest Articles, Trending, Bookmarks and Categories |
| Responsive | Phone: compact bar, search toggle, drawer menu, one-column feed. Tablet (768px+): wide search, drawer, 2–3 columns. Desktop (1024px+): persistent sidebar that collapses to an icon rail (remembered), up to 4 columns |
| Colour | Midnight `#0B1020`, sidebar `#111827`, cards `#172033`, gold `#D4AF37`, text `#F9FAFB` / `#9CA3AF`. All text pairs pass WCAG AA (most AAA). *Daylight* variation for a light site |
| Typography | System sans for UI and headlines, system serif for article body (1.1875rem / 1.75). No web-font downloads |
| Front page | Category chips → featured story → top-stories grid → ranked trending row → "Saved for later" shelf → paginated latest articles (no-reload paging) |
| Cards | 16:9 image, category, title (2 lines), excerpt (2 lines), date, reading time, bookmark; whole card clickable |
| Articles | Large image, breadcrumbs, category, title, byline with avatar/date/reading time, bookmark + share, table of contents, body, topics, share row, author box, related articles (same category), comments |
| Accessibility | Skip link, one `h1` per view, landmarks, gold focus rings, modal drawer with focus trap and Escape, `aria-pressed`/`aria-current`, live-region announcements, reduced-motion support, no horizontal overflow from 320px to 2560px |

### How the feeds choose stories

All feeds are WordPress Query Loops over real posts. Each is tagged with a
`shortlaxiRole` that `inc/queries.php` uses to shape the query:

- **Featured**: the newest *sticky* post (Posts → Edit → "Stick to the top of the blog"),
  or the newest post when nothing is sticky.
- **Top stories / Latest articles**: newest posts, never repeating the featured story.
- **Trending**: most comments first, newest as tie-break. To rank by real traffic,
  return an ordered list of post IDs from the `shortlaxi_trending_post_ids` filter
  (for example from Jetpack Stats on WordPress.com).
- **Related articles**: same category as the article being read, falling back to recent posts.

### Bookmarks

Readers can save stories with the bookmark button. Saved IDs live in the reader's
browser (`localStorage`); no account, cookie banner or plugin is involved. The
Bookmarks page and the home "Saved for later" shelf load those stories from the
public REST API.

## Develop and validate

Requirements: PHP 7.4+ (and `git` for packaging).

```sh
php bin/validate.php      # PHP + JS syntax, JSON, headers, pattern/part/block references, screenshot
bin/package.sh            # validates, then writes dist/shortlaxi-<version>.zip
```

CI runs the same checks on PHP 7.4 and 8.3, validates every JSON file against
the official `theme.json` schema, and uploads the zip as a build artifact.

Bump the version in **both** `shortlaxi/style.css` (`Version`) and
`shortlaxi/readme.txt` (`Stable tag`). The validator fails if they differ.

## Installing on WordPress.com

`shortlaxi.wordpress.com` is currently on the **free plan**, which cannot install
custom themes. WordPress.com's plan entitlements (October 2026) are:

| Capability | Plans |
| --- | --- |
| Upload a custom theme (zip) | Personal, Premium, Business, Commerce |
| GitHub Deployments, SFTP/SSH, staging sites | Business, Commerce |

### Option A: upload the zip (Personal plan or higher)

1. Upgrade the site at <https://wordpress.com/plans/shortlaxi.wordpress.com>.
2. Build the zip: run `bin/package.sh`, or download the `shortlaxi-theme-zip`
   artifact from the latest successful **Theme** workflow run on GitHub.
3. In the site's WP Admin open **Appearance → Themes**, use the **Upload theme**
   button, choose `shortlaxi-<version>.zip`, then **Activate**.
4. To update later, upload the newer zip and choose **Replace current with uploaded**.

### Option B: deploy from GitHub (Business plan or higher)

1. In the site's WordPress.com dashboard open **GitHub Deployments** (under the
   hosting/developer tools), connect GitHub and pick this repository and the `main` branch.
2. Set the destination directory to `/wp-content/themes/shortlaxi`.
3. Use **Advanced** mode with `.github/workflows/theme.yml`. The workflow uploads
   the contents of `shortlaxi/` as an artifact named `wpcom` (WordPress.com's
   convention for Advanced mode; confirm against its current docs when connecting).
   **Simple** mode copies the whole repository, which would nest the theme one
   folder too deep.
4. Activate **Shortlaxi** under **Appearance → Themes** after the first deploy.

Deployments merge files into the destination folder. Files deleted from the
repository are not removed from the site automatically.

## After activating: one-time site setup

1. **Categories**: create the sections (for example World, Business, Technology,
   Climate, Culture, Opinion). Chips, the sidebar and Explore pick them up automatically;
   chips are ordered by number of posts.
2. **View pages**: create four empty pages with these slugs. WordPress applies the
   matching template automatically, and the sidebar links switch to them:

   | Page title | Slug | Shows |
   | --- | --- | --- |
   | Explore | `explore` | Category tiles and top stories |
   | Latest Articles | `latest` | Every article, newest first, paginated |
   | Trending | `trending` | Ranked most-discussed articles |
   | Bookmarks | `bookmarks` | The reader's saved articles |

   Until a page exists, its sidebar link jumps to the matching section of the front page.
3. **Footer menu**: in **Appearance → Editor → Navigation**, create a *Footer* menu
   (About, Contact, Editorial Standards, Privacy) and select it in the footer's
   navigation block. Until then it lists all pages.
4. **Reading**: leave **Settings → Reading → Your homepage displays** on
   *Your latest posts* to use the discovery front page.
5. **Identity**: set the site title and tagline. Uploading a logo replaces the gold
   "S" mark and wordmark in the top bar.
6. **Posts**: give every story a 16:9 featured image (1600×900 or larger) and a
   hand-written excerpt (the card summary). Mark one story sticky to feature it.
   Insert the **Sources and references** pattern at the end of reported pieces.
7. **Optional**: switch to the *Daylight* variation in **Appearance → Editor → Styles**.

Changes made in the Site Editor are stored in the database and override the theme
files. To get updated theme templates later, use **Reset** on the edited
template, or copy the change back into this repository.

## Roadmap

- Rank Trending by real traffic via `shortlaxi_trending_post_ids` (Jetpack Stats)
- Bundle self-hosted web fonts (via `theme.json` `fontFace`) once the brand is chosen
- "Load more" button as an alternative to numbered pagination
- Section front template (`category.html`) with a lead story per category
- Newsletter sign-up pattern (Jetpack Subscribe block on WordPress.com)
