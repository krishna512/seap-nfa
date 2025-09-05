<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * https://www.advancedcustomfields.com/resources/local-json/
 * 
 * ================================================
 * Specify custom folder for acf json sync
 * ================================================
 */
function acf_json_save_point($path) {
    return get_stylesheet_directory() . '/app/acf-json';
}

add_filter('acf/settings/save_json', 'acf_json_save_point');


/**
 * ================================================
 * Save CPT/tax/options-page json in specific folder
 * ================================================
 */
function acf_cpt_save_folder($path) {
    return get_stylesheet_directory() . '/app/acf-json/post-types';
}

add_filter('acf/settings/save_json/type=acf-post-type', 'acf_cpt_save_folder');

function acf_tax_save_folder($path) {
    return get_stylesheet_directory() . '/app/acf-json/taxonomies';
}
add_filter('acf/settings/save_json/type=acf-taxonomy', 'acf_tax_save_folder');

function acf_options_page_save_folder($path) {
    return get_stylesheet_directory() . '/app/acf-json/options-page';
}
add_filter('acf/settings/save_json/type=acf-ui-options-page', 'acf_options_page_save_folder');


/**
 * Save blocktypes json in specific folder
 */
function acf_blocktype_save_folder($path) {
    return get_stylesheet_directory() . '/app/acf-json/block-types';
}

add_filter('acf/settings/save_json/type=acfe-dbt', 'acf_blocktype_save_folder');


/**
 * ================================================
 * Local Sync - Load json file on theme load.
 * ================================================
 */

add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point($paths) {

    unset($paths[0]);

    $paths[] = get_stylesheet_directory() . '/app/acf-json';
    $paths[] = get_stylesheet_directory() . '/app/acf-json/post-types';
    $paths[] = get_stylesheet_directory() . '/app/acf-json/taxonomies';
    $paths[] = get_stylesheet_directory() . '/app/acf-json/options-page';

    return $paths;
}


/**
 * ================================================
 * Enable/Disable acf extended modules
 * ================================================
 */

add_action('acf/init', 'my_acfe_modules');
function my_acfe_modules() {
    // disable block type module
    acf_update_setting('acfe/modules/block_types', false);

    // disable forms module
    acf_update_setting('acfe/modules/forms', false);

    // disable options module
    acf_update_setting('acfe/modules/options', false);

    // disable post type module
    acf_update_setting('acfe/modules/post_types', false);

    // disable taxonomies module
    acf_update_setting('acfe/modules/taxonomies', false);

    // disable options pages module
    acf_update_setting('acfe/modules/options_pages', false);
}


/**
 * ================================================
 * hooks after or before the post has been saved
 * https://www.advancedcustomfields.com/resources/acf-save_post/ 
 * ================================================
 */

add_action('acf/save_post', 'after_save_post', 11);
function after_save_post($post_id) {
    $current_post_type = get_post_type($post_id);
    if ($current_post_type === 'region' || $current_post_type === 'digital-id') {
        // Update the post parent based on the type_of_region
        // This is to ensure that the region is correctly nested
        $type_of_region = get_field('type_of_region', $post_id);
        $parent_post = 0;
        if ($type_of_region === 'country') {
            $select_sub_region = get_field('select_sub_region', $post_id);
            // If the type of region is country, we need to set the parent post to the selected sub-region
            $parent_post = $select_sub_region;
        }
        if ($type_of_region === 'sub-region') {
            $select_region = get_field('select_region', $post_id);
            // If the type of region is sub-region, we need to set the parent post to the selected region
            $parent_post = $select_region;
        }
        $post_arr = [
            'ID' => $post_id,
            'post_parent'  => $parent_post,
        ];
        wp_update_post($post_arr);
        // 
        // Update the regions field based on the selected law, population, and causes of statelessness
        // This is to ensure that the region is correctly linked to the laws, populations, and causes of statelessness.
        $select_law_id = (int)get_field('select_law', $post_id);
        update_field('regions', $post_id, $select_law_id);

        if ($current_post_type === 'region') {
            $select_population_id = (int)get_field('select_population', $post_id);
            $causes_of_statelessness_id = (int)get_field('causes_of_statelessness', $post_id);
            update_field('regions', $post_id, $select_population_id);
            update_field('regions', $post_id, $causes_of_statelessness_id);
        }
        if ($current_post_type === 'digital-id') {
            $select_legal_identity_id = (int)get_field('select_legal_identity', $post_id);
            $select_digital_identity_rights_id = (int)get_field('select_digital_identity_rights', $post_id);
            update_field('regions', $post_id, $select_legal_identity_id);
            update_field('regions', $post_id, $select_digital_identity_rights_id);
        }
    }

    if ($current_post_type === 'law') {
        $regions_id = (int)get_field('regions', $post_id);
        update_field('select_law', $post_id, $regions_id);
    }

    if ($current_post_type === 'population') {
        $regions_id = (int)get_field('regions', $post_id);
        update_field('select_population', $post_id, $regions_id);
    }

    if ($current_post_type === 'statelessness') {
        $regions_id = (int)get_field('regions', $post_id);
        update_field('causes_of_statelessness', $post_id, $regions_id);
    }

    if ($current_post_type === 'legal-identity') {
        $regions_id = (int)get_field('regions', $post_id);
        update_field('select_legal_identity', $post_id, $regions_id);
    }
    
    if ($current_post_type === 'digital-id-right') {
        $regions_id = (int)get_field('regions', $post_id);
        update_field('select_digital_identity_rights', $post_id, $regions_id);
    }
}


/**
 * ================================================
 * Load Region and sub-region post type in region post
 * in their respective fields 
 * https://www.advancedcustomfields.com/resources/acf-fields-post_object-query/
 * ================================================
 */

add_filter('acf/fields/post_object/query/name=select_region', 'load_select_region', 10);
function load_select_region($select_region_args) {
    $select_region_args['meta_query'] = [
        [
            'key' => 'type_of_region',
            'value' => 'region',
            'compare' => '=',
        ]
    ];
    // $select_region_args['post_parent'] = 0;
    return $select_region_args;
}

add_filter('acf/fields/post_object/query/name=select_sub_region', 'load_select_sub_region', 10);
function load_select_sub_region($args) {
    $args['meta_query'] = [
        [
            'key' => 'type_of_region',
            'value' => 'sub-region',
            'compare' => '=',
        ]
    ];

    return $args;
}

add_filter('acf/fields/post_object/query/name=select_country', 'load_select_country', 10);
function load_select_country($select_country_args) {
    $select_country_args['meta_query'] = [
        [
            'key' => 'type_of_region',
            'value' => 'country',
            'compare' => '=',
        ]
    ];
    return $select_country_args;
}

add_filter('acf/fields/post_object/query/name=regions', 'load_select_type_regions', 10);
function load_select_type_regions($regions_arg) {
    if (isset($_POST['selected_region_type']) && !empty($_POST['selected_region_type'])) {
        // If the selected region type is not empty, filter the regions by that type
        $regions_arg['post_type'] = $_POST['selected_region_type'];
    }
    return $regions_arg;
}

add_filter('acf/fields/post_object/query/name=select_law', 'load_select_law', 10, 3);
function load_select_law($args, $field, $post_id) {
    $post_type = get_post_type($post_id);

    if (!$post_type) {
        return $args; // fallback to default query
    }
    if ($post_type === 'region' || $post_type === 'digital-id') {
        $args['post_type'] = 'law';
        $args['meta_query'] = [
            'relation' => 'OR',
            [
                'key' => 'type',
                'value' => $post_type,
                'compare' => '=',
            ],
            [
                'key' => 'type',
                'compare' => 'NOT EXISTS',
            ],
        ];
    }

    return $args;
}


add_filter('acf/fields/post_object/query/name=select_population', 'load_select_population', 10, 3);
function load_select_population($args, $field, $post_id) {
    // Get the post type of the post being edited.
    $post_type = get_post_type($post_id);
    if (!$post_type) {
        return $args; // fallback to default query
    }
    if ($post_type === 'region' || $post_type === 'digital-id') {
        $args['post_type'] = 'population';
        $args['meta_query'] = [
            'relation' => 'OR',
            [
                'key' => 'type',
                'value' => $post_type,
                'compare' => '=',
            ],
            [
                'key' => 'type',
                'compare' => 'NOT EXISTS',
            ],
        ];
    }

    return $args;
}

add_filter('acf/fields/post_object/query/name=causes_of_statelessness', 'load_causes_of_statelessness', 10, 3);
function load_causes_of_statelessness($args, $field, $post_id) {
    // Get the post type of the post being edited.
    $post_type = get_post_type($post_id);
    if (!$post_type) {
        return $args; // fallback to default query
    }
    if ($post_type === 'region' || $post_type === 'digital-id') {
        $args['post_type'] = 'statelessness';
        $args['meta_query'] = [
            'relation' => 'OR',
            [
                'key' => 'type',
                'value' => $post_type,
                'compare' => '=',
            ],
            [
                'key' => 'type',
                'compare' => 'NOT EXISTS',
            ],
        ];
    }

    return $args;
}


/**
 * ================================================
 * https://www.advancedcustomfields.com/resources/acf-options_page-save/ 
 * https://developer.wordpress.org/reference/functions/get_theme_mod/ 
 * ================================================
 */
add_filter('acf/options_page/save', 'save_options_page_site_info', 10, 2);
function save_options_page_site_info($post_id, $menu_slug) {
    if ('seap-options' !== $menu_slug) {
        return;
    }

    $site_logo = (function_exists('get_field') && $site_logo = get_field('site_logo', 'option')) ? $site_logo : '';
    $logo_id = '';
    if (is_array($site_logo)) {
        $logo_id = $site_logo['id'];
    } elseif (is_int($site_logo)) {
        $logo_id = $site_logo;
    }
    update_option('site_logo', $logo_id);

    $site_favicon = (function_exists('get_field') && $site_favicon = get_field('site_favicon', 'option')) ? $site_favicon : '';
    $favicon_id = '';
    if (is_array($site_favicon)) {
        $favicon_id = $site_favicon['id'];
    } elseif (is_int($site_favicon)) {
        $favicon_id = $site_favicon;
    }
    update_option('site_icon', $favicon_id);
}
