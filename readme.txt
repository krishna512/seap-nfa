=== Hello Elementor Child ===

Implementation of Vite + TailwindCSS in Wordpress Theme development. Auto generating CSS, auto refresh on every file save/edit and easy production build tool with no hassle.

## Main features

- fast Auto browser refresh/sync file change/save
- extremely small CSS as there is no unsued css at all
- keep your local domain while developing
- `yarn build` for production packing Javascript and CSS

## Installation (Node.js/Yarn required):

```bash
yarn
```

Quick commands:
```bash
# dev server start
yarn dev

# production build
yarn build
```

## Setup

Entry point file **main.js** is where you include all your scripts and styles. It can be changed via **vite.config.json** and **functions.php**.

## Development with live preview/refresh

Ensure **define("IS_VITE_DEVELOPMENT", true);** exists in your **wp-config.php**. Just run **npm run dev** and refresh your development website.

```bash
yarn dev
```
After Vite dev server is started open your installed Wordpress website in any browser or refresh it. Then you can start editing index.php, or any other php file in your theme, by adding elements and Tailwind classes. After saving changes your browser page eg your site should refresh immediately. You can freely edit asset files like styles.css, scripts.js too.

## Production build

Just run **yarn build**, set defined **IS_VITE_DEVELOPMENT** to **false** and refresh local website.

```bash
yarn build
```
Wordpress should load now production generated assets.

Note: To ensure classes used inside CMS to be processed just add them to safelist.txt and run build again.

