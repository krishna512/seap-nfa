<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}



/**
 * =======================================================
 * Dynamic SVG icon
 * =======================================================
 */

if (!function_exists('useSVG')) {
    function useSVG($filename = 'sample-icon') {
        $icon = get_stylesheet_directory() . '/assets/icons/' . $filename . '.svg';

        $svg_icon_content = @file_get_contents($icon);

        return $svg_icon_content;
    }
}

/**
 * =========================================================
 * Excerpt
 * =========================================================
 */
if (!function_exists('excerpt')) {
    function excerpt(int $limit = 168, $id = '') {
        if ($id) {
            $post = get_post($id);
            $excerpt = get_the_excerpt($post);
        } else {
            $excerpt = get_the_excerpt();
        }

        if ($excerpt) {
            $excerpt = substr($excerpt, 0, $limit) . ' ...';
        }

        return $excerpt;
    }
}

function default_excerpt_length($length) {
    return 168;
}
add_filter("excerpt_length", "default_excerpt_length");



if (!function_exists('get_json_country_code')) {
    /**
     * Country Code Data : https://datahub.io/core/country-list
     *                     https://countrycode.org/
     * read the assets/country-2-digit-code.json
     * 
     */
    function get_json_country_code() {
        global $json_country_code;
        $json_country_code = '';
        $country_code = get_template_directory_uri() . '/assets/country-2-digit-code.json';
        $country_code_response = wp_remote_get($country_code);
        if (is_array($country_code_response) && !is_wp_error($country_code_response)) {
            $json_country_code = json_decode($country_code_response['body']);
        }
    }
}
// execute get_json_country_code function to set global $json_country_code;
get_json_country_code();




if (!function_exists('get_country_2_digit_code')) {
    /**
     * return lowercase 2-digit country code
     * @param string $country_name
     */
    function get_country_2_digit_code($country_name) {
        global $json_country_code;
        $country_name = str_replace('&nbsp;', '', htmlentities($country_name));
        $country_name = trim($country_name);

        // check exact country in json file
        if ($json_country_code) {
            foreach ($json_country_code as $key => $country) {
                if (strtolower($country->Name) == strtolower($country_name)) {
                    return strtolower($country->Code);
                }
            }

            // again check country name contain in json
            foreach ($json_country_code as $key => $country) {
                if (str_contains(strtolower($country->Name), strtolower($country_name))) {
                    return strtolower($country->Code);
                }
            }
        }


        // check if 2 digit code is present in post info
        $country_post_id = get_country_id($country_name);
        if ($country_post_id) {
            $country_code_2_digit = get_field('2_digit_country_code', $country_post_id);
            if ($country_code_2_digit) {
                return strtolower($country_code_2_digit);
            }
        }

        // get country information from restcountries.com api
        $api_point = "https://restcountries.com/v3.1/name/" . str_replace(' ', '%20', strtolower($country_name));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);         // Disable SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = json_decode(curl_exec($ch), true);
        if ($response && isset($response[0]['cca2'])) {
            if ($code_2_digit = strtolower($response[0]['cca2'])) {
                return $code_2_digit;
            }
        }

        return "";
    }
}


if (!function_exists('get_country_flag_url')) {
    /**
     * Country Flag : https://flagpedia.net/download/api
     * https://flagpedia.net/download/images
     * Get the country flag url
     * @param string $country_code
     * @param string $flag_size = waving(20x15), same_width(w40), same_height(h120) only for "png" flag_type
     * @param string $flag_type = png, svg
     * @return string country_flag_url
     */
    function get_country_flag_url($country_code, $flag_type = "png", $flag_size = "w20") {
        $flag_url = "";
        if ($country_code) {
            if ($flag_type === 'png') {
                $flag_url = "https://flagcdn.com/" . $flag_size . "/" . $country_code . ".png";
            }
            if ($flag_type === 'svg') {
                $flag_url = "https://flagcdn.com/" . $country_code . ".svg";
            }
        }
        return $flag_url;
    }
}

if (!function_exists('get_type_of_region_except_country')) {
    /**
     * get all sub regions of default 'region' post type
     * type_of_region ::
     * => region : Region
     * => sub-region : Sub Region
     * => country : Country
     */
    function get_type_of_region_except_country($post_type = 'region') {
        $type_of_region_except_country = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => array('publish'),
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => 'type_of_region',
                    'value' => 'sub-region',
                    'compare' => '=',
                ],
                [
                    'key' => 'type_of_region',
                    'value' => 'region',
                    'compare' => '=',
                ]
            ],
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $type_of_region_except_country = get_posts($type_of_region_except_country);
        return $type_of_region_except_country;
    }
}

if (!function_exists('get_all_sub_regions')) {
    /**
     * get all sub regions of default 'region' post type
     * type_of_region ::
     * => region : Region
     * => sub-region : Sub Region
     * => country : Country
     */
    function get_all_sub_regions($post_type = 'region') {
        $sub_regions = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => array('publish'),
            'meta_query' => [
                [
                    'key' => 'type_of_region',
                    'value' => 'sub-region',
                    'compare' => '=',
                ]
            ],
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $sub_regions = get_posts($sub_regions);
        return $sub_regions;
    }
}


if (!function_exists('get_all_countries')) {
    /**
     * get all countries of default 'region' post type
     * type_of_region ::
     * => region : Region
     * => sub-region : Sub Region
     * => country : Country
     */
    function get_all_countries($post_type = 'region') {

        $countries_arg = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => array('publish'),
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => 'type_of_region',
                    'value' => 'country',
                    'compare' => '=',
                ]
            ],
            'orderby' => 'title',
            'order' => 'ASC',
        );
        $countries = get_posts($countries_arg);
        return $countries;
    }
}


if (!function_exists('get_country_id')) {
    /**
     * get country id by country name
     */
    function get_country_id($country_name, $post_type = 'region') {

        $countries_arg = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => array('publish'),
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => 'type_of_region',
                    'value' => 'country',
                    'compare' => '=',
                ]
            ],
            's' => $country_name,
            'search_columns' => array('post_name', 'post_title'),
            'orderby' => 'title',
            'order' => 'ASC',
        );
        $countries = get_posts($countries_arg);
        return isset($countries[0]) ? $countries[0]->ID : '';
    }
}




if (!function_exists('get_all_stakeholder')) {
    /**
     * get all stakeholder post type
     */
    function get_all_stakeholder() {

        $stakeholder_arg = array(
            'post_type' => 'stakeholder',
            'posts_per_page' => -1,
            'post_status' => array('publish'),
        );
        $stakeholder = get_posts($stakeholder_arg);
        return $stakeholder;
    }
}


/**
 * =======================================================
 * News listing vertical
 * =======================================================
 */

if (!function_exists('news_listing_vertical')) {
    function news_listing_vertical($query = []) {
        $default = array(
            'post_type' => 'news',
            'posts_per_page' => 10,
            'post_status' => array('publish'),
        );

        $args = array_merge($default, $query);

        $posts = new WP_Query($args);

        if ($posts->have_posts()) {
?>
            <div class="grid grid-cols-1 gap-2.5">

                <?php
                while ($posts->have_posts()) {

                    $posts->the_post();

                    $id = get_the_ID();

                    news_listing_vertical_card($id);
                }
                wp_reset_postdata(); ?>
            </div>

        <?php }
    }
}

/**
 * =======================================================
 * reports listing vertical
 * =======================================================
 */

if (!function_exists('reports_listing_vertical')) {
    function reports_listing_vertical($query = []) {
        $default = array(
            'post_type' => 'report',
            'posts_per_page' => 10,
            'post_status' => array('publish'),
        );

        $args = array_merge($default, $query);

        $posts = new WP_Query($args);

        if ($posts->have_posts()) {
        ?>
            <div class="grid grid-cols-1 gap-2.5">

                <?php
                while ($posts->have_posts()) {

                    $posts->the_post();

                    $id = get_the_ID();

                    report_listing_vertical_card($id);
                }
                wp_reset_postdata(); ?>
            </div>

<?php }
    }
}


/**
 * =========================================================
 * generate_bubble_chart_series
 * =========================================================
 */
if (!function_exists('generate_bubble_chart_series')) {
    function generate_bubble_chart_series($values, $labels) {
        $total_val = 0;
        $max_rad = 150;
        $series = [];
        foreach ($values as $key => $value) {
            $total_val = $total_val + $value;
        }
        foreach ($values as $key => $value) {
            $radious = ceil($value / $total_val * $max_rad);
            $series[] = [
                'name' => $labels[$key],
                'data' => [
                    [$key + 1, $value, $radious]
                ]
            ];
        }
        return $series;
    }
}

/**
 * =========================================================
 * Youtube Video Thumbnail
 * =========================================================
 */
if (!function_exists('acf_youtube_thumbnail')) {
    function acf_youtube_thumbnail($oembed) {

        $url = parse_url($oembed);

        if (isset($url['query'])) {
            $id = explode('v=', $url['query']);
            return '<img loading="lazy" class ="absolute w-full h-full inset-0 object-cover" src="http://img.youtube.com/vi/' . $id[1] . '/hqdefault.jpg"/>';
        } else {
            return "";
        }
    }
}



/**
 * =========================================================
 * get_region location
 * =========================================================
 */

if (!function_exists('get_region_location')) {
    function get_region_location() {
        $location_id = (get_field('select_region')) ?: '';
        if ($location_id) {
            return get_the_title($location_id);
        }
        $location_id = (get_field('select_sub_region')) ?: '';
        if ($location_id) {
            return get_the_title($location_id);
        }
        $location_id = (get_field('select_country')) ?: '';
        if ($location_id) {
            return get_the_title($location_id);
        }
        $location_id = (get_field('region')) ?: '';
        if ($location_id) {
            return get_the_title($location_id);
        }

        $post_type = get_post_type();
        $post_id = get_the_ID();
        if ($post_type == 'law') {
            $key = 'select_law';
        } elseif ($post_type == 'population') {
            $key = 'select_population';
        } elseif ($post_type == 'statelessness') {
            $key = 'causes_of_statelessness';
        } elseif ($post_type == 'stakeholder') {
            $key = 'select_stakholders';
        } else {
            $key = '';
        }
        if ($key && $post_id) {
            $region_arr = array(
                'post_type' => 'region',
                'posts_per_page' => -1,
                'post_status' => array('publish'),
                'meta_query' => [
                    'relation' => 'OR',
                    [
                        'key' => $key,
                        'value' => $post_id,
                        'compare' => 'LIKE',
                    ]
                ]
            );
            $region_post = get_posts($region_arr);
            if ($region_post && is_array($region_post)) {
                $location = '';
                foreach ($region_post as $key => $value) {
                    if ($key === 0) {
                        $location .= $value->post_title;
                    } else {
                        $location .= ', ' . $value->post_title;
                    }
                }
                return $location;
            }
        }

        return '';
    }
}


/**
 * seap_default_thumbnail
 */
function seap_default_thumbnail() {
    return get_template_directory_uri() . '/assets/images/default-thumbnail.png';
}


/**
 * get_sub_section_image_url
 * @param int $post_id
 * @return string
 */
function get_sub_section_image_url($post_id, $current_post = '') {
    $post_type = get_post_type($post_id);
    $image = (get_the_post_thumbnail_url($post_id)) ?: '';
    if (!$image) {
        $selector = str_replace([' ', '-'], '_', $post_type) . '_image';
        $current_post = ($current_post) ?: get_the_ID();
        $parent_id = wp_get_post_parent_id($current_post);
        $type_of_region = get_post_meta($current_post, 'type_of_region', true);
        if ($type_of_region == 'country') {
            $selector_image = get_field($selector, $parent_id);
        } else {
            $selector_image = get_field($selector, $current_post);
        }

        if (is_array($selector_image)) {
            $image = wp_get_attachment_image_url($selector_image['id'], 'full');
        } elseif (is_int($selector_image)) {
            $image = wp_get_attachment_image_url($selector_image, 'full');
        } else {
            $image = $selector_image;
        }
    }
    if (!$image) {
        $theme_image_path =  '/assets/images/theme-' . $post_type . '.png';
        if (file_exists(get_template_directory() . $theme_image_path)) {
            $image = get_template_directory_uri() . $theme_image_path;
        } else {
            $image = seap_default_thumbnail();
        }
    }
    return $image;
}


/**
 * 
 */
function build_seap_menu_tree(array $menu_items) {
    $menu = [];
    $items_by_id = [];

    // Index items by ID and initialize children
    foreach ($menu_items as $item) {
        $item->children = [];
        $items_by_id[$item->ID] = $item;
    }

    // Build tree
    foreach ($items_by_id as $item) {
        if ($item->menu_item_parent && isset($items_by_id[$item->menu_item_parent])) {
            $items_by_id[$item->menu_item_parent]->children[] = $item;
        } else {
            $menu[] = $item;
        }
    }

    return $menu;
}
