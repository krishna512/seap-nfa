<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ===========================
 * seach box
 * ===========================
 */
if (!function_exists('seap_search_box')) {
    function seap_search_box($arg = []) {
        $class_name = 'search-box ';
        $class_name .= (isset($arg['class'])) ? $arg['class'] : '';
        $form_class = (isset($arg['form_class'])) ? $arg['form_class'] : 'filter-form';
        $id_name = (isset($arg['id'])) ? $arg['id'] : 'seap_search_box';
        $data_url = (isset($arg['data_url'])) ? $arg['data_url'] : home_url(get_post_type());
        $search_value = (isset($_GET['search'])) ? $_GET['search'] : '';

?>
        <div class="<?php echo $class_name; ?> " id="<?php echo $id_name; ?>">
            <form action="" method="get" data-url="<?php echo $data_url; ?>" class="<?php echo $form_class; ?>" role="search">
                <input type="text" name="search" id="search_input" value="<?php echo $search_value; ?>" placeholder="Search...">
                <button type="submit">
                    <?php echo useSVG('search'); ?>
                    <button>
            </form>
        </div>
        <?php
    }
}

/**
 * ===========================
 * search drop down when drop-down array value is provided
 * ===========================
 */
if (!function_exists('seap_custom_drop_down')) {
    function seap_custom_drop_down($drop_downs, $arg = []) {


        $class_name = (isset($arg['class'])) ? $arg['class'] : 'search-drop-down';
        $wrapper_class = (isset($arg['wrapper_class'])) ? $arg['wrapper_class'] : '';

        $id = (isset($arg['id'])) ? $arg['id'] : 'search-drop-down';
        $name = (isset($arg['name'])) ? $arg['name'] : 'drop-down';
        $term = (isset($arg['term'])) ? $arg['term'] : 'Select Term';
        $_GET_category = (isset($_GET[$name])) ? $_GET[$name] : '';
        wp_enqueue_style('select2');
        wp_enqueue_script('select2');

        if ($drop_downs && is_array($drop_downs)) {
        ?>
            <div class="<?php echo $wrapper_class; ?>">
                <select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class_name; ?>">
                    <option value="" value_id="-1">
                        <?php echo __($term, 'seap'); ?>
                    </option>
                    <?php
                    foreach ($drop_downs as $key => $drop_down) {
                        $value_id = ($drop_down->ID) ?: '';
                        $select_country = ($_GET_category == $drop_down->post_name) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $drop_down->post_name; ?>" value_id="<?php echo $value_id; ?>" ; <?php echo $select_country; ?>>
                            <?php
                            if ($drop_down->post_name === 'regional-overview') {
                                echo "Region";
                            } else {
                                echo $drop_down->post_title;
                            }
                            ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        <?php
        }
    }
}

/**
 * ===========================
 * search category drop down
 * ===========================
 */
if (!function_exists('seap_search_category_drop_down')) {
    function seap_search_category_drop_down($taxonomy, $arg = []) {

        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false,]);

        $class_name = (isset($arg['class'])) ? $arg['class'] : 'search-category';
        $wrapper_class = (isset($arg['wrapper_class'])) ? $arg['wrapper_class'] : '';
        $default_option = (isset($arg['default_option'])) ? $arg['default_option'] : 'Select category';
        $id = (isset($arg['id'])) ? $arg['id'] : 'search-category';
        $name = (isset($arg['name'])) ? $arg['name'] : 'category';
        $_GET_category = (isset($_GET[$name])) ? $_GET[$name] : '';
        wp_enqueue_style('select2');
        wp_enqueue_script('select2');
        if ($terms && is_array($terms)) {
        ?>
            <div class="<?php echo $wrapper_class; ?>">
                <select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class_name; ?>">
                    <option value="">
                        <?php echo $default_option; ?>
                    </option>
                    <?php
                    foreach ($terms as $key => $term) {
                        $select_country = ($_GET_category == $term->slug) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $term->slug; ?>" <?php echo $select_country; ?>>
                            <?php echo $term->name; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        <?php
        }
    }
}

/**
 * ===========================
 * search country drop down
 * ===========================
 */
if (!function_exists('seap_search_country_drop_down')) {
    function seap_search_country_drop_down($all_countries, $arg = []) {
        $class_name = 'search-country ';
        $class_name .= (isset($arg['class'])) ? $arg['class'] : '';
        $wrapper_class = (isset($arg['wrapper_class'])) ? $arg['wrapper_class'] : '';
        $id = (isset($arg['id'])) ? $arg['id'] : 'search-country';
        $name = (isset($arg['name'])) ? $arg['name'] : 'search_country';

        $_GET_search_country = (isset($_GET[$name])) ? $_GET[$name] : '';
        wp_enqueue_style('select2');
        wp_enqueue_script('select2');
        $_GET_stakeholder_regions = (isset($_GET['regions'])) ? $_GET['regions'] : '';
        $show = 1;
        if ($_GET_stakeholder_regions) {
            $region_post = get_posts(['post_type' => 'region', 'name' => $_GET_stakeholder_regions]);
            $_GET_stakeholder_regions = isset($region_post[0]->ID) ? $region_post[0]->ID : '';
        }
        ?>
        <div class="<?php echo $wrapper_class; ?>">
            <select name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class_name; ?>">
                <option value="">
                    <?php echo __('Select country', 'seap'); ?>
                </option>

                <?php
                if ($all_countries && is_array($all_countries)) {
                    foreach ($all_countries as $key => $country) {
                        $select_country = ($_GET_search_country == $country->post_name) ? 'selected' : '';
                        $country_name = $country->post_title;
                        $flag_src = get_country_flag_url(get_country_2_digit_code($country_name));
                        $post_parent_id = $country->post_parent;
                        if ($_GET_stakeholder_regions) {
                            $show = ((int) $_GET_stakeholder_regions != (int) $post_parent_id) ? 0 : 1;
                        }
                ?>
                        <option flag_src="<?php echo $flag_src; ?>" value="<?php echo $country->post_name; ?>" link-id="<?php echo $post_parent_id; ?>" show="<?php echo $show; ?>" <?php echo $select_country; ?>>
                            <?php echo $country_name; ?>
                        </option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <?php
    }
}

/**
 * ===========================
 * seach count information
 * ===========================
 */
if (!function_exists('seap_search_count_info')) {
    function seap_search_count_info($arg = []) {
        global $wp_query;
        $count_search_result = ($wp_query->found_posts) ?: '';
        $GET_search = (isset($_GET['s'])) ? $_GET['s'] : '';
        $name = (isset($arg['name'])) ? $arg['name'] : 'search';
        $display = (isset($arg['display'])) ? $arg['display'] : true;
        if ($display == 'true' || $display == 1 || $display == true) {
            $display = true;
        } else {
            $display = false;
        }
        if (!$GET_search) {
            $GET_search = (isset($_GET[$name])) ? $_GET[$name] : '';
        }
        if ($name === 'country' || $name === 'regions' || $name === 'region') {
            $region_post = get_posts(['post_type' => 'region', 'name' => $GET_search]);
            $GET_search = isset($region_post[0]->ID) ? $region_post[0]->post_title : $GET_search;
        }
        if (!$display) {
            $GET_search = '--';
        }
        if ($count_search_result && $GET_search) {
        ?>
            <div class="search-info">
                <?php
                if ($display) {
                    echo "Showing " . $count_search_result . ' results for "' . $GET_search . '"';
                } else {
                    echo "Showing " . $count_search_result . ' results.';
                }
                ?>
            </div>
            <?php
        }
    }
}



/**
 * compare country result section
 */
if (!function_exists('compare_country_section')) {
    function compare_country_section($country_slug, $theme, $post_type = 'region') {
        if ($post = get_posts(['post_type' => $post_type, 'name' => $country_slug])) {
            $content = $theme_id = '';
            $country_id = isset($post[0]->ID) ? $post[0]->ID : '';
            if ($country_id) {

                if ($theme === 'overview') {
                    $theme_id = $country_id;
                } elseif ($theme === 'laws') {
                    $theme_id = get_field('select_law', $country_id);
                } elseif ($theme === 'population') {
                    $theme_id = get_field('select_population', $country_id);
                } elseif ($theme === 'causes-of-statelessness') {
                    $theme_id = get_field('causes_of_statelessness', $country_id);
                } elseif ($theme === 'stakeholders') {
                    $stakholders = get_field('select_stakholders', $country_id);
                    if ($stakholders && is_array($stakholders)) {
                        foreach ($stakholders as $key => $stakholder_id) {
                            $content .= stakeholders_card($stakholder_id);
                        }
                    }
                } elseif ($theme === 'legal_identity') {
                    $theme_id = get_field('select_legal_identity', $country_id);
                } elseif ($theme === 'digital_identity_rights') {
                    $theme_id = get_field('select_digital_identity_rights', $country_id);
                }

                if ($theme_id) {
                    $content = get_post_field('post_content', $theme_id);
                    $content = apply_filters('the_content', $content, $theme_id);
                }

                // $country_code = get_country_2_digit_code(get_the_title($country_id));
                // $flag_src = get_country_flag_url($country_code, $flag_type = "svg");

                ob_start();

            ?>
                <div class="compare-data h-full" data-id="<?php echo $country_id; ?>"
                    data-title=" <?php echo strtolower(get_the_title($country_id)) ?>">
                    <div class="compare-title mb-4 sm:mb-6 grid gap-1 justify-items-center">
                        <div class="sm:text-2xl font-semibold text-n-60">
                            <a href="<?php echo get_the_permalink($country_id); ?>">
                                <?php echo get_the_title($country_id); ?>
                            </a>
                        </div>
                    </div>
                    <div class=" compare-content">
                        <div class="wp-block-post-content entry-content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                    <?php echo do_shortcode('[citenote_display_list]'); ?>
                </div>
<?php
                $output_content = ob_get_contents();
                ob_end_clean();
                return $output_content;
            }
        }
        return '';
    }
}
