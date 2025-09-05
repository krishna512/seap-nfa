<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


/**
 * =======================================================
 * Gutenberg Editor Content
 * =======================================================
 */

if (!function_exists('gutenbergEditorContent')) {
    function gutenbergEditorContent()
    {
        ?>
        <div class="wp-block-post-content entry-content">
            <?php the_content(); ?>
        </div>
        <?php
    }
}



if (!function_exists('get_content_resource_block')) {
    /**
     * get the resource block content for post type report and other (post)
     * @param string $post_type
     */
    function get_content_resource_block($post_type = 'report')
    {
        $parameters = array(
            'post_type' => $post_type,
            'posts_per_page' => 4,
            'post_status' => array('publish'),
        );

        $posts = new WP_Query($parameters);
        ob_start();

        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                ?>
                <div class="<?php echo $post_type; ?>">
                    <div class=" publish-date">
                        <?php echo get_the_date('d M, Y'); ?>
                    </div>
                    <div class=" post-title">
                        <a href="<?php echo get_the_permalink(); ?>">
                            <?php echo get_the_title() ?>
                        </a>
                    </div>
                    <div class=" post-description">
                        <?php
                        if ($post_type === 'report') {
                            $location = get_field('location', get_the_ID());
                            $country_name = get_the_title($location);
                            $sub_region_name = get_the_title(get_post($location)->post_parent);
                            $flag_src = get_country_flag_url(get_country_2_digit_code($country_name));
                            ?>
                            <img src="<?php echo $flag_src; ?>" alt="flag">
                            <span>
                                <?php echo $country_name . ', ' . $sub_region_name; ?>
                            </span>
                            <?php
                        } else {
                            ?>
                            <p>
                                <?php echo get_the_excerpt(); ?>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
            ?>
            <div class=" view-all">
                <a href="/<?php echo ($post_type === 'report') ? " report" : "news"; ?>">
                    <?php echo ($post_type === 'report') ? "View all reports" : "View all news"; ?>
                </a>
            </div>
            <?php
        }
        $output_content = ob_get_contents();
        ob_end_clean();
        return $output_content;
    }
}

if (!function_exists('get_sub_region_countries')) {
    /**
     * return sub regions countries
     * type_of_region ::
     * => region : Region
     * => sub-region : Sub Region
     * => country : Country
     * @param int $post_id
     * @param int $collection if empty there will not be collection columns
     */
    function get_sub_region_countries($post_id, $collection = 7, $post_type = 'region')
    {
        ob_start();
        $type_of_region = get_post_meta($post_id, 'type_of_region', true);
        if ($type_of_region === 'sub-region') {
            $sub_region_child_arg = array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'post_status' => array('publish'),
                'post_parent__in' => [$post_id]
            );
            $sub_region_child = new WP_Query($sub_region_child_arg);
            if ($sub_region_child->have_posts()) {
                ?>

                <div class=" column countries">
                    <?php
                    $i = 0;
                    while ($sub_region_child->have_posts()) {
                        $sub_region_child->the_post();
                        $country_name = get_the_title();
                        $country_code = get_country_2_digit_code($country_name);
                        $flag_src = get_country_flag_url($country_code);
                        if ($i == $collection) {
                            echo '</div><div class="column countries">';
                            $i = 0;
                        }
                        ?>
                        <div data-count="<?php echo $i; ?>" class="item" country-name="<?php echo $country_name ?>">
                            <a class="inline-flex gap-x-2 py-2 px-1  text-[#fff] items-start countries-item"
                                href="<?php echo get_the_permalink(); ?>">
                                <span class=" country-flag flex shrink-0 relative top-0.5">
                                    <img src="<?php echo $flag_src; ?>" alt="flag" class="w-4 shrink-0" />
                                </span>
                                <span class=" country-name link-hover-border">
                                    <?php echo $country_name ?>
                                </span>
                            </a>
                        </div>
                        <?php
                        $i++;
                    }
                    wp_reset_postdata();
                    ?>
                </div>

                <?php
            }
        }
        $output_content = ob_get_contents();
        ob_end_clean();
        return $output_content;
    }
}


if (!function_exists('get_sub_region_sections')) {
    /**
     * return sub region sections for header sub menu
     * @param int $post_id
     * @param string $url
     */
    function get_sub_region_sections($post_id, $url)
    {
        $current_post_type = get_post_type($post_id);
        if ($post_id == '13') {
            $title = "Regional Overview";
        } else {
            $title = "Sub-Regional Overview";
        }
        ob_start();
        if ($current_post_type === 'region') {
            ?>
            <div class="sub-menu__content">
                <p class="menu-subtitle"><?php echo $title; ?></p>

                <p class="menu-overview">
                    <a href="<?php echo $url; ?>#overview">
                        <span class="icon"> <?php echo useSVG('overview') ?></span>
                        <span class="link-hover-border">Overview</span>
                    </a>
                </p>
                <?php
                if (get_field('select_law', $post_id)) {
                    ?>
                    <p class="menu-law">
                        <a href="<?php echo $url; ?>#law">
                            <span class="icon"> <?php echo useSVG('law') ?></span>
                            <span class="link-hover-border">Law</span>
                        </a>
                    </p>
                    <?php
                }
                if (get_field('select_population', $post_id)) {
                    ?>
                    <p class="menu-population">
                        <a href="<?php echo $url; ?>#population">
                            <span class="icon"> <?php echo useSVG('population') ?></span>
                            <span class="link-hover-border">Population</span>
                        </a>
                    </p>
                    <?php
                }
                if (get_field('causes_of_statelessness', $post_id)) {
                    ?>
                    <p class="menu-causes_of_statelessness">
                        <a href="<?php echo $url; ?>#causes-of-statelessness">
                            <span class="icon"> <?php echo useSVG('cause') ?></span>
                            <span class="link-hover-border">Causes of
                                Statelessness</span>
                        </a>
                    </p>
                    <?php
                }
                ?>
            </div>
            <?php
        } elseif ($current_post_type === 'digital-id') {
            ?>
            <div class="sub-menu__content">
                <p class="menu-subtitle"> Sub-Regional Overview </p>

                <p class="menu-legal-identity">
                    <a href="<?php echo $url; ?>#legal-identity">
                        <span class="icon"> <?php echo useSVG('legal-identity') ?></span>
                        <span class="link-hover-border">Legal Identity</span>
                    </a>
                </p>

                <p class="menu-overview">
                    <a href="<?php echo $url; ?>#digital-id-overview">
                        <span class="icon"> <?php echo useSVG('overview') ?></span>
                        <span class="link-hover-border">Digital ID Overview</span>
                    </a>
                </p>

                <p class="menu-law">
                    <a href="<?php echo $url; ?>#law">
                        <span class="icon"> <?php echo useSVG('law') ?></span>
                        <span class="link-hover-border">Law</span>
                    </a>
                </p>

                <p class="menu-designed-to-include">
                    <a href="<?php echo $url; ?>#designed-to-include">
                        <span class="icon"> <?php echo useSVG('menu_globe') ?></span>
                        <span class="link-hover-border">
                            Designed to include?
                        </span>
                    </a>
                </p>

            </div>
            <?php
        } else {
            echo 'only accept region and digital-id post type';
        }
        $output_content = ob_get_contents();
        ob_end_clean();
        return $output_content;
    }
}


/**
 * =======================================================
 * seap breadcrumb content
 * =======================================================
 */
if (!function_exists('get_seap_breadcrumb')) {
    /**
     * @return html breadcrumbs content
     */
    function get_seap_breadcrumb()
    {
        return YIPL_BREADCRUMB::get_yipl_breadcrumb();
    }
}