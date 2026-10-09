# Short-Laxi

Shortlaxi global editorial website and WordPress theme.

This repository is the source of truth for **Shortlaxi**, a custom, mobile-first
WordPress block theme for a global English-language publication. The production
target is **WordPress.com** (`shortlaxi.wordpress.com`).

## Repository layout

```
.
├── shortlaxi/                 The theme (this folder is what gets installed)
│   ├── style.css              Theme header (name, version, requirements)
│   ├── theme.json             Design system: colours, type, spacing, block styles
│   ├── functions.php          Stylesheet enqueue, logo support, pattern category
│   ├── assets/css/theme.css   Small mobile-first enhancements theme.json can't express
│   ├── templates/             Page templates (home, single, page, archive, search, 404…)
│   ├── parts/                 Header and footer template parts
│   ├── patterns/              Translatable block patterns used by templates
│   ├── styles/night.json      "Night" dark style variation
│   ├── styles/blocks/         "Kicker" and "Standfirst" block styles
│   ├── screenshot.png         1200×900 preview shown in Appearance → Themes
│   └── readme.txt             WordPress theme readme
├── bin/validate.php           Static checks (no WordPress needed)
├── bin/package.sh             Builds dist/shortlaxi-<version>.zip from committed files
└── .github/workflows/theme.yml  CI: validate, schema-check, package
```

## Theme overview

| Area | Approach |
| --- | --- |
| Type | Block (full site editing) theme, `theme.json` v3, WordPress 7.1+ |
| Layout | 42rem reading measure, 76rem wide; one column on phones, grids auto-fit up to three columns |
| Typography | System serif (Charter/Georgia family) for reading, system sans for UI. No web-font downloads |
| Colour | Paper/Ink/Crimson palette; every text pairing passes WCAG AA (most AAA), also in "Night" |
| Front page | Lead story + "Top stories" rail, then a paginated "Latest" grid (skips the first five) |
| Articles | Breadcrumbs, section kicker, headline, byline with reading time, wide featured image, topics, author box, previous/next, comments, "More from Shortlaxi" |
| Accessibility | Skip link, single `h1` per view, visible focus rings, reduced-motion support, no horizontal scroll at 375px |
| Editing | All copy lives in PHP patterns (translatable); templates are editable in the Site Editor |

Editors get two extra block styles: **Kicker** (small uppercase section label
with a top rule, for headings/paragraphs) and **Standfirst** (larger intro
paragraph under a headline).

## Develop and validate

Requirements: PHP 7.4+ (and `git` for packaging).

```sh
php bin/validate.php      # PHP lint, JSON, headers, pattern/part references, screenshot size
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
   Climate, Culture, Opinion). The footer "Sections" list shows them automatically.
2. **Menus**: in **Appearance → Editor → Navigation**, create a *Primary* menu
   (section links) and a *Footer* menu (About, Contact, Editorial Standards,
   Privacy). Then in **Patterns → Header / Footer**, select each navigation block
   and pick its menu. Until then, both fall back to a list of pages.
3. **Reading**: leave **Settings → Reading → Your homepage displays** on
   *Your latest posts* to use the editorial front page.
4. **Identity**: set the site title, tagline and (optionally) a logo and site icon.
5. **Posts**: give every story a featured image (cards use 3:2, the lead 16:9) and a
   hand-written excerpt (it becomes the card summary).
6. **Optional**: try the *Night* variation in **Appearance → Editor → Styles**.

Changes made in the Site Editor are stored in the database and override the theme
files. To get updated theme templates later, use **Reset** on the edited
template, or copy the change back into this repository.

## Roadmap

- Bundle self-hosted web fonts (via `theme.json` `fontFace`) once the brand is chosen
- Section front template (`category.html`) with a lead story per category
- Newsletter sign-up pattern (Jetpack Subscribe block on WordPress.com)
- "Live"/"Analysis"/"Opinion" post labels and an opinion byline variant
