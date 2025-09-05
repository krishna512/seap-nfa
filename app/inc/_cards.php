<?php


// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit; 
}

/**
 * ===========================
 * stakeholders_card
 * ===========================
 */
if (!function_exists('stakeholders_card')) {
    function stakeholders_card($post_id) {
        $title = get_the_title($post_id);
        $permalink = get_the_permalink($post_id);
        $locations = '';
        $class_name = '';
        $no_link = '';
        if (is_front_page()) {
            $class_name .= 'rounded-t-xl';
        } else {
            $class_name .= "rounded-xl";
        }

        if (!$permalink) {
            $no_link .= "no-link";
        }
?>
<div class="bg-white swiper-slide <?php echo $class_name; ?> stakeholders_card">
    <?php if (has_post_thumbnail()) { ?>
    <a href="<?php echo $permalink; ?>" class="  block relative image pt-[60%] min-h-[84px] <?php echo $no_link; ?>"
        <?php echo (get_field('website_link', $post_id)) ? 'target=""' : ""; ?>>
        <?php echo get_the_post_thumbnail($post_id, 'medium_large', array('class' => 'absolute w-full max-h-[84px] left-0 top-1/2 object-contain px-5', 'style' => 'transform:translateY(-50%)')) ?>
    </a>
    <?php } ?>
    <a href="<?php echo $permalink; ?>"
        class="<?php echo (!has_post_thumbnail()) ? 'h-full' : ' ' ?> <?php echo $no_link; ?>  block"
        <?php echo (get_field('website_link', $post_id)) ? 'target=""' : ""; ?>>
        <div
            class="<?php echo (!has_post_thumbnail()) ? 'h-full items-center py-24 sm:py-20' : 'pt-2 pb-6' ?> px-6 content flex justify-center">

            <h3
                class="<?php echo (!has_post_thumbnail()) ? 'text-lg' : 'text-sm' ?>  tracking-[0.084px] font-bold text-n-60 font-manrope text-center">

                <?php echo $title; ?>
            </h3>
            <?php
                    if ($locations && is_array($locations)) { ?>
            <?php
                        foreach ($locations as $key => $location) {
                            $country_name = get_the_title($location);
                            $sub_region_name = get_the_title(get_post($location)->post_parent);
                            $flag_src = get_country_flag_url(get_country_2_digit_code($country_name));
                        ?>
            <div class="flex flex-wrap gap-1 text-xs">
                <span class="inline-flex items-center">
                    <?php if ($flag_src) { ?>
                    <img width="16" src="<?php echo $flag_src; ?>" alt="flag" class="h-auto mr-1">
                    <?php } ?>
                    <?php echo $country_name; ?>
                    <?php if ($sub_region_name) {
                                        echo ', ';
                                    } ?>
                </span>
                <?php if ($sub_region_name) { ?>
                <span class="inline-flex items-center">
                    <?php echo $sub_region_name; ?>
                </span>
            </div>
            <?php }
                            } ?>
            <?php } ?>
        </div>
    </a>
</div>
<?php
    }
}


/**
 * ===========================
 * News listing vertical Card
 * ===========================
 */
if (!function_exists('news_listing_vertical_card')) {
    function news_listing_vertical_card($post_id) {
        $title = get_the_title($post_id);
        $excerpt = ($exp = excerpt('66', $post_id)) ? "<p class='text-base leading-relaxed'>{$exp}</p>" : '';
        $permalink = get_the_permalink($post_id);
        $permalink = (get_field('news_source_link', $post_id)) ?: $permalink;

    ?>
<div class="post-item py-4 pl-2 border-b border-[#D8CCBC]">
    <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"
        class="block text-sm leading-relaxed mb-1">
        <?php echo get_the_date('d M, Y'); ?>
    </time>

    <h3 class="text-h6">
        <a href="<?php echo $permalink; ?>"
            <?php echo (get_field('news_source_link', $post_id)) ? 'target="_blank"' : ""; ?>>
            <?php echo $title; ?>
        </a>
    </h3>

    <?php echo $excerpt; ?>
</div>
<?php
    }
}

/**
 * ===========================
 * News Card
 * ===========================
 */
if (!function_exists('news_card')) {
    function news_card($post_id) {
        $permalink = get_the_permalink($post_id);
        $thumbnail_image = (has_post_thumbnail($post_id)) ? get_the_post_thumbnail_url($post_id) : seap_default_thumbnail();
        $select_country_id = (get_field('select_country', $post_id)) ?: '';
        $permalink = (get_field('news_source_link', $post_id)) ?: $permalink;
    ?>
<div class="post-item">
    <div class="thumbnail-image">
        <a href="<?php echo $permalink; ?>"
            <?php echo (get_field('news_source_link', $post_id)) ? 'target="_blank"' : ""; ?>>
            <div class="image-container">
                <div class="image-wrapper"><img src="<?php echo $thumbnail_image; ?>" alt="thumbnail"></div>
                <div class='click-to-read'>
                    <div class="text-container">
                        <div>Click to read </div>
                        <?php echo useSVG('arrow'); ?>
                    </div>
                </div>
            </div>
        </a>

    </div>
    <div class="flex">
        <div datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"
            class="block text-sm leading-relaxed mb-1">
            <?php echo get_the_date('d M, Y'); ?>
        </div>
        <?php if ($select_country_id) { ?>
        <div class="post-country">
            <?php echo useSVG('global'); ?>
            <?php echo ($select_country_id) ? get_the_title($select_country_id) : ""; ?>
        </div>

        <?php } ?>

    </div>
    <div class="post-title">
        <a href="<?php echo $permalink; ?>">
            <?php echo get_the_title(); ?>
        </a>
    </div>

</div>
<?php
    }
}

/**
 * ===========================
 * Report listing vertical Card
 * ===========================
 */
if (!function_exists('report_listing_vertical_card')) {
    function report_listing_vertical_card($post_id) {
        $title = get_the_title();
        $excerpt = ($exp = excerpt('66', $post_id)) ? "<p class='text-base leading-relaxed'>{$exp}</p>" : '';
        $permalink = get_the_permalink($post_id);
        $location_id = ''; //(get_field('select_country', $post_id)) ?: '';
        $location_name = ($location_id) ? get_the_title($location_id) : '';
        $flag_src = '';
        // if ($location_name) {
        //     $country_code = get_country_2_digit_code($location_name);
        //     $flag_src = get_country_flag_url($country_code);
        // }
        $report_categories = ''; //(get_field('report-categories', $post_id)) ?: '';
        $file_url = (get_field('file', $post_id)) ?: '';

    ?>
<div class="post-item py-4 pl-2 border-b border-[#D8CCBC]">

    <h3 class="text-h6">
        <a href="<?php echo $permalink; ?>" class="no-link">
            <?php echo $title; ?>
        </a>
    </h3>
    <?php
            if ($report_categories && is_array($report_categories)) {
                foreach ($report_categories as $key => $categories) {
            ?>
    <div class="text-sm">
        <?php echo $categories->name; ?>
    </div>
    <?php
                }
            }
            if ($location_name) { ?>
    <div class="mt-2">
        <img src="<?php echo $flag_src; ?>" class="h-2" />
        <span class="text-xs leading-[1.36] text-n-60">
            <?php echo $location_name; ?>
        </span>
    </div>
    <?php
            }
            if ($file_url) { ?>
    <a href="<?php echo $file_url ?>" class="mt-2 inline-flex items-center gap-x-1" download=''>
        Download File
        <span class="leading-[0]">
            <?php echo useSvg('download'); ?>
        </span>
    </a>
    <?php } ?>
</div>
<?php
    }
}



/**
 * ===========================
 * report Card
 * ===========================
 */
if (!function_exists('report_card')) {
    function report_card($id) {
        $permalink = get_the_permalink($id);
        $thumbnail_image = (has_post_thumbnail($id)) ? get_the_post_thumbnail_url($id) : seap_default_thumbnail($id);
        $file_url = (get_field('file', $id)) ?: '';
        $select_country_id = (get_field('select_country', $id)) ?: '';
        $report_categories = (get_field('report_submission', $id)) ?: '';
    ?>
<div class="post-item">
    <div class="thumbnail-image">
        <a href="<?php echo $permalink; ?>" class="no-link">
            <div class="image-container">
                <div class="image-wrapper"><img src="<?php echo $thumbnail_image; ?>" alt="thumbnail"></div>
                <!-- <div class='click-to-read'>
                        <div class="text-container">
                            <div>Click to read </div>
                            <?php echo useSVG('arrow'); ?>
                        </div>
                    </div> -->
            </div>
        </a>

    </div>
    <div class="flex">
        <?php
                if ($report_categories && is_array($report_categories)) {
                    foreach ($report_categories as $key => $categories) {
                ?>
        <div class="text-sm">
            <?php echo $categories->name; ?>
        </div>
        <?php
                    }
                }

                if ($select_country_id) {
                    ?>
        <div class="post-country">
            <?php echo useSVG('global'); ?>
            <?php echo get_the_title($select_country_id); ?>
        </div>
        <?php } ?>
    </div>
    <div class="post-title">
        <a href="<?php echo $permalink; ?>" class="no-link">
            <?php echo get_the_title(); ?>
        </a>
    </div>
    <?php if ($file_url) { ?>
    <a href="<?php echo $file_url ?>" class="mt-2 inline-flex items-center gap-x-1" download=''>
        Download File
        <span class="leading-[0]">
            <?php echo useSvg('download'); ?>
        </span>
    </a>
    <?php } ?>

</div>
<?php
    }
}