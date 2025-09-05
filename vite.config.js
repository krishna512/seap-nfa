import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import * as glob from 'glob';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const { resolve } = path;

/**
 * ====================================================================
 * Getting all scss files relative url
 *
 * All custom elementor widget css
 * ====================================================================
 */
let block_scss = Object.fromEntries(
  glob
    .sync('app/blocks/*/*.scss')
    .map((file) => [
      path.relative('resources/sass', file.slice(0, file.length - path.extname(file).length)),
      fileURLToPath(new URL(file, import.meta.url)),
    ])
);
block_scss = Object.values(block_scss);

// let block_gutenberg_scss = Object.fromEntries(
//   glob
//     .sync('app/blocks-gutenberg/**/*.scss')
//     .map((file) => [
//       path.relative('resources/sass', file.slice(0, file.length - path.extname(file).length)),
//       fileURLToPath(new URL(file, import.meta.url)),
//     ])
// );
// block_gutenberg_scss = Object.values(block_gutenberg_scss);

// let sass = Object.fromEntries(
//   glob
//     .sync('app/elementor-addon/assets/scss/**/*.scss')
//     .map((file) => [
//       path.relative('resources/sass', file.slice(0, file.length - path.extname(file).length)),
//       fileURLToPath(new URL(file, import.meta.url)),
//     ])
// );

// sass = Object.values(sass);

// main global scss file
let mainSCSS = fileURLToPath(new URL('resources/sass/main.scss', import.meta.url));
let adminSCSS = fileURLToPath(new URL('resources/sass/admin.scss', import.meta.url));

/**
 * ====================================================================
 * Getting all js files relative url
 *
 * All custom elementor widget js
 * ====================================================================
 */
// let js = Object.fromEntries(
//   glob
//     .sync('app/elementor-addon/assets/js/**/*.js')
//     .map((file) => [
//       path.relative('resources/js', file.slice(0, file.length - path.extname(file).length)),
//       fileURLToPath(new URL(file, import.meta.url)),
//     ])
// );
// js = Object.values(js);

let block_js = Object.fromEntries(
  glob
    .sync('app/blocks/*/*.js')
    .map((file) => [
      path.relative('resources/js', file.slice(0, file.length - path.extname(file).length)),
      fileURLToPath(new URL(file, import.meta.url)),
    ])
);
block_js = Object.values(block_js);

// main global js file
let mainJS = fileURLToPath(new URL('resources/js/app.js', import.meta.url));
let adminJS = fileURLToPath(new URL('resources/js/admin/admin-seap.js', import.meta.url));


let input = [mainSCSS, adminSCSS, block_scss, mainJS, adminJS, block_js];
input = [].concat(...input);

/**
 * ====================================================================
 * Configurations required by vite
 * ====================================================================
 */
export default defineConfig({
  base: '',
  plugins: [
    laravel({
      input,
      publicDirectory: 'dist',
      assetsDir: 'assets',
      refresh: ['**.php', '**.js', '**.scss', '**.css'],
    }),
  ],
  server: {
    port: 2222,
  },
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: 'dist',
    assetsDir: 'assets',
  },
  resolve: {
    alias: [
      {
        find: /~(.+)/,
        replacement: process.cwd() + '/node_modules/$1',
      },
    ],
  },
});
