<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function filter_main_query($query)
{
    /**
     * =========================================
     * news
     * =========================================
     */
    if (! is_admin() && $query->is_main_query() && is_post_type_archive('news')) {
        // post per pagination
        $post_per_page = 12;
        $query->set('posts_per_page', $post_per_page);

        $_GET_search_value = (isset($_GET['search'])) ? $_GET['search'] : '';

        if ($_GET_search_value) {
            $query->set('s', $_GET_search_value);
        }

        return;
    }

    /**
     * =========================================
     * faq
     * =========================================
     */
    if (! is_admin() && $query->is_main_query() && is_post_type_archive('faq')) {
        // post per pagination
        $post_per_page = -1;
        $query->set('posts_per_page', $post_per_page);

        return;
    }
/**
 * Stakeholder Archive Query Modifications
 */
if (!is_admin() && $query->is_main_query() && is_post_type_archive('stakeholder')) {
    // Set posts per page
    $query->set('posts_per_page', 24);

    // Get query parameters
    $search_value = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $country = isset($_GET['country']) ? sanitize_text_field($_GET['country']) : '';
    $regions = isset($_GET['regions']) ? sanitize_text_field($_GET['regions']) : '';

    // Initialize meta query with AND relation
    $meta_query = array(
        'relation' => 'AND',
        array(
            'relation' => 'OR',
            array(
                'key' => 'title_hideshow',
                'value' => 'show',
                'compare' => '='
            ),
            array(
                'key' => 'title_hideshow',
                'compare' => 'NOT EXISTS'
            )
        )
    );

    // Get country ID
    $country_id = '';
    if ($country) {
        $country_post = get_posts([
            'post_type' => 'region',
            'name' => $country,
            'posts_per_page' => 1,
            'fields' => 'ids'
        ]);
        $country_id = !empty($country_post) ? $country_post[0] : '';
    }

    // Get region ID
    $regions_id = '';
    if ($regions) {
        $region_post = get_posts([
            'post_type' => 'region',
            'name' => $regions,
            'posts_per_page' => 1,
            'fields' => 'ids'
        ]);
        $regions_id = !empty($region_post) ? $region_post[0] : '';
    }

    // Add country to meta query
    if ($country_id) {
        $meta_query[] = array(
            'key' => 'regions',
            'value' => $country_id,
            'compare' => 'LIKE'
        );
    }

    // Add region to meta query
    if ($regions_id) {
        $meta_query[] = array(
            'key' => 'regions',
            'value' => $regions_id,
            'compare' => 'LIKE'
        );
    }

    // Set meta query if additional conditions exist
    if (count($meta_query) > 1 || $meta_query[0]['relation'] === 'AND') {
        $query->set('meta_query', $meta_query);
    }

    // Initialize tax query with AND relation
    $tax_query = array(
        'relation' => 'AND'
    );

    // Add category to tax query
    if ($category) {
        $tax_query[] = array(
            'taxonomy' => 'stakeholder-category',
            'field' => 'slug',
            'terms' => $category
        );
        $query->set('tax_query', $tax_query);
    }

    // Set search query
    if ($search_value) {
        $query->set('s', $search_value);
    }

    return;
}

    /**
     * =========================================
     * report
     * =========================================
     */
    if (! is_admin() && $query->is_main_query() && is_post_type_archive('report')) {
        // post per pagination
        $post_per_page = 21;
        $query->set('posts_per_page', $post_per_page);
        // Get the parameter
        $_GET_search_value = (isset($_GET['search'])) ? $_GET['search'] : '';
        $_GET_submission = (isset($_GET['submission'])) ? $_GET['submission'] : '';
        $_GET_country = (isset($_GET['country'])) ? $_GET['country'] : '';
        $country_id = '';
        if ($_GET_country) {
            $country_post = get_posts(['post_type' => 'region', 'name' => $_GET_country]);
            $country_id = isset($country_post[0]->ID) ? $country_post[0]->ID : '';
        }

        // search value
        if ($_GET_search_value) {
            $query->set('s', $_GET_search_value);
        }

        // order by

        // $query->set('meta_key', 'report_year');
        // $query->set('orderby', 'date');
        // $query->set('order', 'DESC');

        // meta query
        $meta_query = array(
            'relation' => 'AND',
        );
        if ($country_id) {
            $meta_query[] = array(
                'key' => 'select_country',
                'value' => $country_id,
                'compare' => 'LIKE',
            );

            $query->set('meta_query', $meta_query);

        }
        // tax query
        $tax_query = array(
            'relation' => 'OR',
        );
        if ($_GET_submission) {
            $tax_query[] = array(
                'taxonomy' => 'report-submission',
                'field' => 'slug',
                'terms' => $_GET_submission,
            );
        }

        if ($_GET_submission) {
            $query->set('tax_query', $tax_query);
        }

        return;
    }

    /**
     * =========================================
     * search
     * =========================================
     */
    if (is_search()) {
        // post per pagination
        $post_per_page = 12;
        $query->set('posts_per_page', $post_per_page);
        $query->set('post__not_in', [get_option('page_on_front')]);
        return;
    }
}
add_action('pre_get_posts', 'filter_main_query', 11);
