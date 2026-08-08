# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository shape

This is a full WordPress install (Local by Flywheel), but git only tracks `wp-content/themes/` — WordPress core (`wp-admin/`, `wp-includes/`, root `wp-*.php`), plugins, and uploads are all gitignored and exist only on disk locally. In practice, all real work happens in `wp-content/themes/generatepress-child-theme/`, a child theme of the (also-vendored, tracked) `generatepress` parent theme. Treat `generatepress-child-theme/` as the project root when reasoning about "the codebase."

The site is a WooCommerce store (site name "wyz-creations"). Key plugins present locally (not tracked in git): WooCommerce, WooCommerce Gateway Stripe, ACF / ACF Pro, Contact Form 7, Akismet, Classic Editor, All-in-One WP Migration.

## Build commands

Run from `wp-content/themes/generatepress-child-theme/`:

```bash
npm install
npm run dev          # watches both CSS and JS together
npm run watch:css     # Tailwind v4 CLI watch: input/wyz-creations-styles.css -> assets/css/wyz-creations-styles.css
npm run watch:js      # chokidar watch on assets/js/input -> copies to wyz-creations-main.min.js (unminified copy, dev only)
npm run build         # production build: minified CSS + terser-minified JS
npm run css:build     # tailwindcss --minify
npm run js:build      # terser --compress --mangle
```

There is no lint or test setup in this repo (no PHPUnit/PHPCS/ESLint config) — don't invent commands for these.

Compiled/generated files are checked into git (`assets/css/wyz-creations-styles.css`, `assets/js/wyz-creations-main.min.js`). Always edit the `input/` sources (`assets/css/input/**/*.css`, `assets/js/input/wyz-creations-main.js`) and rebuild — never hand-edit the compiled output.

## CSS architecture

Tailwind v4, imported via a single entrypoint `assets/css/input/wyz-creations-styles.css`, which `@import`s `theme.css` (custom `@theme` tokens — colors like `--color-wyz-creations-guest-*`, fonts) followed by `base.css`, `utilities.css`, and one file per UI section under `components/` (e.g. `header.css`, `hero-banner.css`, `best-sellers.css`, `wc-overrides.css` for WooCommerce style overrides). When adding a new visual component, add a new `components/<name>.css` file and `@import` it from the entrypoint rather than growing an existing file.

`tailwind.config.js` sets `important: "#wyz-creations"` — this scopes Tailwind's `!important` strategy; scope selector-specificity issues with generatepress's own CSS accordingly.

`style.css` (the theme stylesheet header WordPress requires) also carries hard resets to strip GeneratePress's default container/padding so Tailwind layouts aren't fought by the parent theme.

## PHP template architecture

- `functions.php` is the single hub for theme setup: asset enqueueing, nav menus, WooCommerce hook overrides, the AJAX favourites endpoint, RSS/media feed tweaks, and Open Graph image filtering for Yoast. Read it before adding new hooks — related logic is very likely already here.
- Page templates live at the theme root as `*-template.php` (e.g. `home-template.php`, `contact-template.php`, `linkme-template.php`, `categories-template.php`, `promo-template.php`) and are selected via WordPress's `Template Name:` header comment, assigned to pages in wp-admin. `page-new-products.php` uses the `page-{slug}.php` convention instead.
- Reusable page sections live in `parts/` and are pulled in with `get_template_part('parts/xxx')` (no `.php`), e.g. `parts/hero-banner.php`, `parts/best-sellers.php`, `parts/category-upsell.php`. New homepage/landing sections should follow this same pattern: a `parts/<name>.php` template plus a matching `assets/css/input/components/<name>.css`.
- `woocommerce/content-product.php` overrides WooCommerce's default product-loop template (theme template overriding pattern — WooCommerce looks for `woocommerce/*` inside the active theme first).
- Favourites (wishlist) is a custom feature: `wp_ajax_toggle_favourite` / `wp_ajax_nopriv_toggle_favourite` in `functions.php` stores product IDs in user meta (logged-in) or a `favourites` cookie (guests); the frontend half is `assets/js/favourites.js`.

## Deployment

`.github/workflows/prod_release.yml` runs on push to `main`: strips dev-only files (README, package.json/lock, .git, .gitignore, .github), archives the tree, then FTP-deploys it to a CloudLogin server via `SamKirkland/FTP-Deploy-Action`, gated behind the `production` GitHub Environment (secrets `FTP_USER_PROD` / `FTP_PWD_PROD`). `staging_release.yml` is currently fully commented out/disabled — there is no working staging deploy path.
