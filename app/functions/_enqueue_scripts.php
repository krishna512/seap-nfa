<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * main style css and script js is enqueue through app/lib/_setup.php from Theme class
 * resources/sass/main.scss
 * resources/js/app.js
 * new Theme();
 */
new Theme();


/**
 * ===================================================
 * Enqueue in frontend
 * ===================================================
 */

add_action('wp_enqueue_scripts', 'enqueue_theme_scripts', 11);
/**
 * ===================================================
 * Enqueue in gutenberg
 * ===================================================
 */
add_action('enqueue_block_editor_assets', 'enqueue_theme_scripts', 11);

/**
 * ===================================================
 * ===================================================
 */
function enqueue_theme_scripts()
{
    wp_enqueue_style('theme-fonts', 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700&family=Manrope:wght@400;500;600;700&display=swap', array(), null);
}

/**
 * ===================================================
 * register_scripts
 * ===================================================
 */
function register_scripts()
{

    // gsap js
    wp_register_script(
        'gsap-library',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.3/gsap.min.js',
        array(),
        THEME_VERSION,
        true
    );

    // swiper js
    wp_register_style(
        'swiper-bundle',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css'
    );

    wp_register_script(
        'swiper-bundle',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        THEME_VERSION,
        true
    );

    // chart.js
    wp_register_script(
        'cn-chart',
        'https://cdn.jsdelivr.net/npm/chart.js',
        array(),
        THEME_VERSION,
        true
    );

    wp_register_script(
        'cn-chart-datalabels',
        'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2',
        array(),
        THEME_VERSION,
        true
    );

    wp_register_script(
        'apex-chart',
        'https://cdn.jsdelivr.net/npm/apexcharts',
        array(),
        THEME_VERSION,
        array(
            'strategy' => 'async'
        )
    );

    // dataTables
    // https://datatables.net/
    wp_register_script(
        'dataTables',
        'https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js',
        array(),
        THEME_VERSION,
        true
    );

    wp_register_style(
        'dataTables',
        'https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css'
    );

    // lightGallery
    wp_register_style(
        'lightGallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lightgallery-bundle.min.css',
        array(),
        THEME_VERSION
    );

    wp_register_script(
        'lightGallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js',
        array('jquery'),
        THEME_VERSION,
        true
    );

    wp_register_script(
        'lightGallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/thumbnail/lg-thumbnail.min.js',
        array('jquery'),
        THEME_VERSION,
        true
    );

    wp_register_script(
        'lightGallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/mediumZoom/lg-medium-zoom.min.js',
        array('jquery'),
        THEME_VERSION,
        true
    );

    wp_register_script(
        'lightGallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/fullscreen/lg-fullscreen.min.js',
        array('jquery'),
        THEME_VERSION,
        true
    );
    wp_register_script(
        'lightGallery',
        'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/hash/lg-hash.min.js',
        array('jquery'),
        THEME_VERSION,
        true
    );


    // select2 js
    wp_register_script(
        'select2',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        array(),
        THEME_VERSION,
        true
    );

    wp_register_style(
        'select2',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
    );
}
add_action('init', 'register_scripts');


/**
 * ===================================================
 *  Enqueue in backend admin area
 * ===================================================
 */
function admin_enqueue_scripts_list()
{
    Vite::enqueue_module();
    // style css
    wp_enqueue_style('theme-admin-style', Vite::asset('resources/sass/admin.scss'), [], null, 'screen');
    // style js
    wp_enqueue_script(
        'theme-admin-script',
        Vite::asset('resources/js/admin/admin-seap.js'),
        array('jquery'),
        filemtime(get_stylesheet_directory(Vite::asset('resources/js/admin/admin-seap.js')))
    );
}
add_action('admin_enqueue_scripts', 'admin_enqueue_scripts_list', 20);