<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


/**
 * =========================================================
 * Page Hero Content
 * =========================================================
 */
if (!function_exists('page_hero_content')) {
    function page_hero_content($post_type = "")
    {
        //don't show the page_hero_content in front page 
        if (is_front_page()) {
            return '';
        }
        if (is_archive()) {
            $queried_object = get_queried_object();
            if (is_tax()) {
                $pageIdentify = $queried_object;
                $label = $queried_object->name;
            } else {
                $posttype = $queried_object->name;
                $label = $queried_object->label;
                $pageIdentify = $posttype . '_options';
            }
            if ($post_type) {
                $label = get_post_type_object($post_type)->label;
                $pageIdentify = $post_type . '_options';
            }
            $heading = (function_exists('get_field') && $heading = get_field('heading', $pageIdentify)) ? $heading : $label;
            $sub_heading = (function_exists('get_field') && $sub_heading = get_field('sub_heading', $pageIdentify)) ? $sub_heading : '';
            $bannerImageID = (function_exists('get_field') && $background_image = get_field('background_image', $pageIdentify)) ? $background_image : '';
        } elseif (is_singular()) {

            $title_hideshow = (function_exists('get_field') && $title_hideshow = get_field('title_hideshow')) ? $title_hideshow : get_the_title();

            $feature_image = (function_exists('get_field') && $feature_image = get_field('feature_image')) ? $feature_image : get_the_title();
            $heading = (function_exists('get_field') && $heading = get_field('heading')) ? $heading : get_the_title();
            $sub_heading = (function_exists('get_field') && $sub_heading = get_field('sub_heading')) ? $sub_heading : '';
            $bannerImageID = (function_exists('get_field') && $fearure_image = get_field('background_image')) ? $fearure_image : '';
        } else {
            $heading = '';
            $sub_heading = '';
            $bannerImageID = (get_post_thumbnail_id()) ?: '';
        }

        if (!$bannerImageID) {
            $bannerImageID = (get_post_thumbnail_id()) ?: '';
        }

        ob_start();
        ?>
        <div class=" hero-section page-hero-banner pt-28 pb-[69px] sm:py-[133px] relative overflow-hidden">

            <div class="relative z-[5] container">
                <div class="grid justify-items-center gap-16">
                    <?php echo get_seap_breadcrumb(); ?>


                    <h1 class="heading text-white relative text-center ">
                        <?php echo $heading; ?>
                    </h1>

                </div>
                <div class="grid justify-items-center">
                    <span class="bottom-lines mt-2 text-center bg-white max-w-[240px]"> </span>
                </div>
                <?php if ($sub_heading) { ?>
                    <p class=" text-center sub_heading mt-4 text-lg text-n-0">
                        <?php echo $sub_heading; ?>
                    </p>
                <?php } ?>
            </div>
            <?php
            if ($bannerImageID) {
                echo wp_get_attachment_image($bannerImageID, "full", false, array("class" => "absolute w-full h-full object-cover inset-0"));
            }
            ?>


        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



/**
 * =========================================================
 * Page Hero Content StakeHolder
 * =========================================================
 */
if (!function_exists('page_hero_content_stakeholder')) {
    function page_hero_content_stakeholder($post_type = "")
    {
        //don't show the page_hero_content in front page 
        if (is_front_page()) {
            return '';
        }
        if (is_archive()) {
            $queried_object = get_queried_object();
            if (is_tax()) {
                $pageIdentify = $queried_object;
                $label = $queried_object->name;
            } else {
                $posttype = $queried_object->name;
                $label = $queried_object->label;
                $pageIdentify = $posttype . '_options';
            }
            if ($post_type) {
                $label = get_post_type_object($post_type)->label;
                $pageIdentify = $post_type . '_options';
            }
            $heading = (function_exists('get_field') && $heading = get_field('heading', $pageIdentify)) ? $heading : $label;
            $sub_heading = (function_exists('get_field') && $sub_heading = get_field('sub_heading', $pageIdentify)) ? $sub_heading : '';
            $bannerImageID = (function_exists('get_field') && $background_image = get_field('background_image', $pageIdentify)) ? $background_image : '';
        } elseif (is_singular()) {

            $title_hideshow = (function_exists('get_field') && $title_hideshow = get_field('title_hideshow')) ? $title_hideshow : get_the_title();
            $feature_image = get_field('feature_image'); // Get the ACF select field

            // $feature_image = (function_exists('get_field') && $feature_image = get_field('feature_image')) ? $feature_image : get_the_title();
            $heading = (function_exists('get_field') && $heading = get_field('heading')) ? $heading : get_the_title();
            $sub_heading = (function_exists('get_field') && $sub_heading = get_field('sub_heading')) ? $sub_heading : '';
            $bannerImageID = (function_exists('get_field') && $fearure_image = get_field('background_image')) ? $fearure_image : '';
        } else {
            $heading = '';
            $sub_heading = '';
            $bannerImageID = (get_post_thumbnail_id()) ?: '';
        }

        if (!$bannerImageID) {
            $bannerImageID = (get_post_thumbnail_id()) ?: '';
        }

        ob_start();
        ?>
        <div
            class=" hero-section lg:min-h-[590px] stakeholder-hero-section page-hero-banner pt-28 pb-[69px] sm:py-[133px] relative overflow-hidden">

            <img src="<?php echo get_template_directory_uri() .
                '/assets/images/single-stakeholder-left.svg'; ?>" alt="Map image"
                class="absolute top-[113px] z-[5] left-[-302px] sm:left-[-348px] max-w-[502px]  sm:max-w-[587px] ">

            <div class="relative z-[6] container">
                <div class="grid justify-items-center gap-16 max-w-[777px] mx-auto">
                    <?php echo get_seap_breadcrumb(); ?>
                    <div class="grid justify-items-center gap-8">
                        <?php if ($feature_image) { ?>
                            <div class="bg-n-0 rounded-lg px-5 w-[180px] py-3 flex items-center justify-center text-center">
                                <img class="h-[70px] object-contain" src="<?php echo $feature_image; ?>" alt="">
                            </div>
                        <?php } ?>

                        <?php
                        // Check if ACF is active
                        if (function_exists('get_field')) {
                            $title_hideshow = get_field('title_hideshow'); // Get the ACF select field
                
                            // Handle array output from title_hideshow
                            $hideshow_value = is_array($title_hideshow) ? $title_hideshow['value'] : $title_hideshow;

                            if ($hideshow_value === 'show' && !empty($heading)) {
                                // Display custom heading for 'show'
                                echo '<h1 class="heading text-n-0 relative max-sm:text-3xl text-center leading-[0.99] tracking-[-0.041em]">' . esc_html($heading) . '</h1>';
                            } elseif ($hideshow_value === 'hide') {
                                // Display 'Stakeholders' for 'hide'
                                echo '<h1 class="heading text-n-0 max-sm:text-3xl relative text-center leading-[0.99] tracking-[-0.041em]"> Stakeholders </h1>';
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

            <img src="<?php echo get_template_directory_uri() .
                '/assets/images/single-stakeholder-right.svg'; ?>" alt="Map image"
                class="absolute top-[103px] z-[5] right-[-299px]  sm:right-[-340px] min-w-[480px] sm:min-w-[731px]">



        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



/**
 * =========================================================
 * Region Hero Content
 * =========================================================
 */
if (!function_exists('region_hero_content')) {
    function region_hero_content()
    {
        $post_type = get_post_type();
        $background_image_ID = (function_exists('get_field') && $background_image_ID = get_field('background_image')) ? $background_image_ID : '';
        $background_image_url = ($background_image_ID) ? wp_get_attachment_image_url($background_image_ID, "full") : '';

        $map_image_ID = (function_exists('get_field') && $map_image_ID = get_field('map_image')) ? $map_image_ID : '';
        $map_image_url = ($map_image_ID) ? wp_get_attachment_image_url($map_image_ID) : '';

        $type_of_region = get_post_meta(get_the_ID(), 'type_of_region', true);
        $class_names = $type_of_region;
        if ($type_of_region === 'region') {
            $class_names .= " lg:ml-20 md:pt-[75px] lg:basis-[542px]";
        } elseif ($type_of_region === 'sub-region') {
            $class_names .= " lg:ml-20  md:pt-24  max-sm:pb-[22px] w-full z-[30]";
            // sm:basis-[48%]
        } else {
            $class_names .= " pt-12 sm:pt-[87px] pb-14 sm:pb-[18px]";
        }
        ob_start();
        ?>
        <div
            class="hero-section single_hero-banner pt-28 sm:pt-[124px] pb-5 sm:pb-[68px] relative overflow-hidden <?php echo $type_of_region === 'sub-region' ? 'sub-region-hero' : '' ?>">
            <img src=" <?php echo $background_image_url; ?>" class=" absolute inset-0 w-full h-full object-cover"
                loading="lazy" />
            <div class="container relative ">
                <div
                    class="single-info <?php echo $type_of_region != "country" ? 'flex flex-col md:flex-row max-sm:gap-y-3  sm:gap-x-10' : 'grid justify-items-center '; ?>  <?php echo $type_of_region != 'sub-region' ? 'z-20' : ''; ?>  relative ">
                    <?php echo get_seap_breadcrumb(); ?>
                    <!-- lg:ml-24 -->
                    <div class="region-single-header  <?php echo $class_names; ?> text-n-0 ">
                        <?php
                        if ($type_of_region === "country") {
                            $country_code = get_country_2_digit_code(get_the_title());
                            $flag_src = get_country_flag_url($country_code, $flag_type = 'svg', $flag_size = 'w320');
                            ?>
                            <div class="flag text-center mb-8">
                                <img src=" <?php echo $flag_src; ?>" alt=" flag" class="w-[40%] sm:w-[16%]" />
                            </div>
                            <?php
                        }
                        ?>
                        <div
                            class="<?php echo $type_of_region === "country" ? 'grid justify-items-center gap-3 text-center' : 'grid gap-2 sm:gap-[22px]'; ?> ">
                            <h1>
                                <?php echo get_the_title(); ?>
                            </h1>

                            <p class=" text-sm">Last updated :
                                <?php echo get_the_modified_date('F d, Y'); ?>
                            </p>

                            <?php if ($type_of_region === "country") { ?>
                                <div class="flex justify-center ">

                                    <?php
                                    //
                                    if ($type_of_region === "country") {
                                        $compare_slug = ($post_type == 'digital-id') ? 'compare-countries-digital-id' : 'compare-countries';
                                        $options = array(
                                            'class' => 'compare-countris-btn',
                                            'text' => 'Compare with other countries',
                                            'url' => home_url('/' . $compare_slug . '/?theme=laws&country_1=' . get_post_field('post_name')),
                                        );
                                        echo text_button($options);
                                    }
                                    ?>
                                    <?php ?>
                                </div>
                            <?php } ?>
                        </div>

                        <?php
                        if ($type_of_region === 'region' || $type_of_region === 'sub-region') { ?>
                            <div
                                class="<?php echo $type_of_region === 'region' ? 'md:grid sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-4' : 'sub-region-content' ?> mt-[69px] hidden md:grid hero-left-content">
                                <?php
                                if ($type_of_region === 'region') {
                                    $all_sub_regions = get_all_sub_regions($post_type);
                                    foreach ($all_sub_regions as $key => $sub_region) {
                                        $region_color = (get_field('sub_region_color', $sub_region->ID)) ?: '';
                                        ?>
                                        <div class="<?php echo $sub_region->post_name; ?> flex gap-2">

                                            <a class=" flex gap-2" href="<?php echo get_the_permalink($sub_region->ID); ?>">
                                                <span class=" shrink-0 w-[18px] h-[18px] rounded-full relative top-1"
                                                    style="background-color: <?php echo $region_color; ?>">
                                                </span>
                                                <p>


                                                    <?php echo $sub_region->post_title; ?>
                                                </p>
                                            </a>
                                        </div>

                                        <?php
                                    }
                                }
                                if ($type_of_region === 'sub-region') {
                                    echo get_sub_region_countries(get_the_ID(), $collection = '', $post_type);
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    if ($type_of_region != "country") {
                        ?>
                        <div
                            class=" <?php echo $type_of_region === 'region' ? 'md:basis-[60%]' : ' top-[-74px]  z-[15] md:w-[50%] md:absolute md:right-0' ?> max-md:flex max-md:justify-end ">
                            <!-- sm:basis-2/3 -->
                            <img src=" <?php echo $map_image_url; ?>" class="max-md:w-[68%]" />
                        </div>

                        <?php
                    }
                    ?>
                </div>
                <?php
                if ($type_of_region === 'region' || $type_of_region === 'sub-region') { ?>
                    <!-- Mobile Responsive Modal -->

                    <div class="md:hidden">
                        <?php

                        $options = array(
                            // 'url' => get_post_type_archive_link('news'),
                        );
                        if ($type_of_region === 'region') {
                            $options['text'] = 'View sub regions →';
                            // $options['url'] = '#region';
                        } else {
                            $options['text'] = 'View countries →';
                            // $options['url'] = '#countires';
                        }


                        echo '<div class="relative z-10 btn-open inline-block  md:hidden mt-3  text-white">' . text_button($options) . '</div>';
                        ?>

                        <div class="modal">

                            <?php if ($type_of_region === 'region' || $type_of_region === 'sub-region') { ?>
                                <div class="popup-wrapper container">
                                    <div class="popup-modal invisible opacity-0 relative z-[70] p-4">
                                        <div class="modal-content-wrapper">
                                            <div class="font-bold text-n-50 mb-3">
                                                <?php if ($type_of_region === 'region') {
                                                    echo "Sub regions";
                                                } else {
                                                    echo 'Countries';
                                                }

                                                ?>

                                            </div>

                                            <?php
                                            if ($type_of_region === 'region') {
                                                $all_sub_regions = get_all_sub_regions($post_type);
                                                foreach ($all_sub_regions as $key => $sub_region) {
                                                    $region_color = (get_field('sub_region_color', $sub_region->ID)) ?: '';
                                                    ?>
                                                    <div class=" <?php echo $sub_region->post_name; ?> border-b border-n-10">
                                                        <a class=" flex gap-2 py-3" href="<?php echo get_the_permalink($sub_region->ID); ?>">
                                                            <span class=" shrink-0 w-[18px] h-[18px] rounded-full relative"
                                                                style="background-color: <?php echo $region_color; ?>">
                                                            </span>
                                                            <p>
                                                                <?php echo $sub_region->post_title; ?>
                                                            </p>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            if ($type_of_region === 'sub-region') {
                                                echo get_sub_region_countries(get_the_ID(), $collection = 3, $post_type);
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div id="pop-up__overlay" class="fixed z-[60] inset-0 w-full h-full invisible opacity-0"></div>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- End Responsive Modal -->
                <?php } ?>

            </div>
        </div>


        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}