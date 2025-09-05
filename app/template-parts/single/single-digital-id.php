<?php

$id = get_the_ID();
$posttype = ($posttype = get_post_type()) ?: "digital-id";
$permalink = get_the_permalink();
$title = get_the_title();

?>


<div id="<?php echo $posttype; ?>-single" class="">
    <?php echo region_hero_content(); ?>

    <div class="<?php echo $posttype; ?>-single-container">
        <?php



        /**
         * Legal Identity section
         */
        ?>
        <div id="legal-identity" class="pt-20 lg:pt-[60px] pb-20 relative overflow-hidden section container">
            <div class=" grid gap-8  lg:py-[42px] max-w-[1015px] mx-auto">
                <div class="flex flex-col lg:flex-row gap-4  sm::gap-6 lg:gap-[38px] items-center">
                    <h1 class="text-b-40 font-semibold">
                        Legal Identity
                    </h1>
                    <div class="overview-content space-y-4 sm:space-y-5 text-base sm:text-lg leading-[2] text-n-50">
                        <?php

                        $legal_identity_id = (get_field('select_legal_identity')) ?: '';
                        if ($legal_identity_id) {
                            $legal_post = get_post($legal_identity_id);
                            $legal_post_content = apply_filters('the_content', $legal_post->post_content, $legal_identity_id);
                            echo $legal_post_content;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        /**
         * Digital ID Overview
         */
        if (get_the_content()) {
            $overview_background_image = get_sub_section_image_url(get_the_ID())
                ?>
            <div id="digital-id-overview" class="title-with-image section">


                <div class="title-wrapper mb-12">
                    <h1 class="main-title">
                        <span class="relative">
                            Digital ID Overview
                            <span class="bottom-line"> </span>
                        </span>
                    </h1>
                    <img src="<?php echo $overview_background_image; ?>" class="absolute inset-0 w-full h-full object-cover"
                        alt="overview_background_image" />
                </div>
                <div class="digital-id-overview-content single-content single-content-container">
                    <div class="wp-block-post-content entry-content">
                        <?php the_content(); ?>
                    </div>

                </div>
            </div>
            <?php
        }
        /**
         * law section
         */
        $law_id = (get_field('select_law')) ?: '';
        if ($law_id) {
            $law_post = get_post($law_id);
            $law_background_image = get_sub_section_image_url($law_id);
            $law_content = apply_filters('the_content', $law_post->post_content, $law_id);
            ?>

            <div id="law" class="title-with-image  section">
                <div class="title-wrapper mb-6  sm:mb-12">
                    <h1 class="main-title">
                        <span class="relative">
                            Law
                            <span class="bottom-line"> </span>
                        </span>
                    </h1>
                    <img src="<?php echo $law_background_image; ?>" class="absolute inset-0 w-full h-full object-cover"
                        alt="law_background_image" />
                </div>
                <div class="law-content single-content single-content-container">
                    <div class="wp-block-post-content entry-content">

                        <?php echo $law_content; ?>
                    </div>

                </div>
            </div>
            <?php
        }


        /**
         * select_digital_identity_rights
         */
        $digital_identity_rights_id = (get_field('select_digital_identity_rights')) ?: '';
        if ($digital_identity_rights_id) {
            $digital_identity_rights_post = get_post($digital_identity_rights_id);
            $background_image = get_sub_section_image_url($digital_identity_rights_id);
            $digital_identity_rights_post_content = apply_filters('the_content', $digital_identity_rights_post->post_content, $digital_identity_rights_id);
            ?>
            <div id="designed-to-include" class="title-with-image section">
                <div class="title-wrapper mb-12">
                    <div class="main-title">
                        <h1>
                            <span class="relative">
                                Designed to Include?
                                <span class="bottom-line"> </span>
                            </span>
                        </h1>

                        <p class="mt-3 text-base sm:text-lg leading-[2] font-medium text-n-0">The Impact of Digital ID and
                            Legal
                            Identity on
                            Citizenship and
                            Nationality Rights</p>
                    </div>

                    <img src="<?php echo $background_image; ?>" class="absolute inset-0 w-full h-full object-cover"
                        alt="background_image" />
                </div>


                <div class="single-content single-content-container">
                    <div class="wp-block-post-content entry-content">

                        <?php echo $digital_identity_rights_post_content; ?>
                    </div>

                </div>
            </div>
            <?php
        }

        /**
         * end
         */

        echo do_shortcode('[citenote_display_list]');

        ?>




        <div class="secondary-menu_region  region-sticky-nav max-w-[890px] max-sm:w-full mx-auto sticky bottom-0 z-10">
            <?php
            /**
             * SEAP Statelessness Report
             * This section will show the link to the Statelessness Overview report if it exists.
             */
            $seap_statelessness_report_id = get_field('seap_statelessness_report', get_the_ID());
            if ($seap_statelessness_report_id) {
                echo related_field_btn(
                    'See Statelessness Overview',
                    get_permalink($seap_statelessness_report_id)
                );
            }
            ?>


            <ul
                class="flex menu-region-tab digital-region-tab floating-nav  max-sm:w-full sm:gap-x-4 bg-n-0  px-2 sm:px-4 rounded-b text-b-40 justify-between sm:justify-center">

                <li class="overview item" id="overview-item" theme-data="">
                    <a href="#<?php echo $posttype; ?>-single"
                        class="flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm max-sm:text-[10px] max-sm:leading-[1.6] max-sm:text-center">
                        <span class="max-sm:text-[20px] sm:leading-[0]">
                            <?php echo useSvg('legal-identity') ?>
                        </span>
                        Legal Identity
                    </a>
                </li>
                <li class="digital-id-overview item" theme-data="digital-id-overview">
                    <a href="#digital-id-overview"
                        class="flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm  max-sm:text-[10px] max-sm:leading-[1.6] max-sm:text-center">
                        <span class=" max-sm:text-[20px] sm:leading-[0]">
                            <?php echo useSvg('overview') ?>
                        </span>
                        Digital ID Overview
                    </a>
                </li>
                <li class="law item" theme-data="law"><a href="#law"
                        class="flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm max-sm:text-[10px] max-sm:leading-[1.6] max-sm:text-center">
                        <span class="max-sm:text-[20px]">
                            <?php echo useSvg('law') ?>
                        </span>
                        Law
                    </a>
                </li>
                <li class="cause-of-statelessness item " theme-data="designed-to-include">
                    <a class="flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm max-sm:text-[10px] max-sm:leading-[1.6] max-sm:text-center"
                        href="#designed-to-include">
                        <span class="max-sm:text-[20px]">
                            <?php echo useSvg('menu_globe') ?>
                        </span>
                        Designed to include?
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>