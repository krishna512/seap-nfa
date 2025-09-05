<?php

$id = get_the_ID();
$posttype = ($posttype = get_post_type()) ?: "region";
$permalink = get_the_permalink();
$title = get_the_title();

?>


<div id="<?php echo $posttype; ?>-single" class="">
    <?php echo region_hero_content(); ?>

    <div class="<?php echo $posttype; ?>-single-container">
        <div id="overview" class="pt-20 lg:pt-[60px] pb-20 relative overflow-hidden section container">
            <div class=" grid gap-8  lg:py-[42px] max-w-[1015px] mx-auto">
                <div class="flex flex-col lg:flex-row gap-4  sm::gap-6 lg:gap-[38px] items-center">
                    <h1 class="text-b-40 font-semibold">Overview</h1>
                    <div class="overview-content space-y-4 sm:space-y-5 text-base sm:text-lg leading-[2] text-n-50">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        /**
         * Law section
         */
        $law_id = (get_field('select_law')) ?: '';
        if ($law_id) {
            $law_post = get_post($law_id);
            $law_background_image = get_sub_section_image_url($law_id);
            //(get_the_post_thumbnail_url($law_id)) ?: get_template_directory_uri() . '/assets/images/theme-popilation.jpg';
            $law_content = apply_filters('the_content', $law_post->post_content, $law_id);
            ?>

            <div id="law" class="title-with-image  section">
                <div class="title-wrapper mb-6  sm:mb-12">
                    <h1 class="main-title">
                        <span class="relative"> Law
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
         * Population section
         */
        $population_id = (get_field('select_population')) ?: '';
        if ($population_id) {
            $population = get_post($population_id);
            $population_background_image = get_sub_section_image_url($population_id);
            $population_content = apply_filters('the_content', $population->post_content, $population_id);
            ?>
            <div id="population" class="title-with-image section">
                <div class="title-wrapper mb-12">
                    <h1 class="main-title">
                        <span class="relative"> Population
                            <span class="bottom-line"> </span>
                        </span>
                    </h1>
                    <img src=" <?php echo $population_background_image; ?>"
                        class="absolute inset-0 w-full h-full object-cover" alt="population_background_image" />
                </div>
                <div class="population-content single-content single-content-container">
                    <div class="wp-block-post-content entry-content">
                        <?php echo $population_content; ?>
                    </div>

                </div>
            </div>
            <?php
        }

        /**
         * Cause of Statelessness section
         */
        $statelessness_id = (get_field('causes_of_statelessness')) ?: '';
        if ($statelessness_id) {
            $statelessness = get_post($statelessness_id);
            $statelessness_background_image = get_sub_section_image_url($statelessness_id);

            $statelessness_content = apply_filters('the_content', $statelessness->post_content, $statelessness_id);
            ?>
            <div id="causes-of-statelessness" class="title-with-image section">
                <div class="title-wrapper mb-12">
                    <h1 class="main-title">
                        <span class="relative"> Causes of Statelessness
                            <span class="bottom-line"> </span>
                        </span>
                    </h1>
                    <img src="<?php echo $statelessness_background_image; ?>"
                        class="absolute inset-0 w-full h-full object-cover" alt="statelessness_background_image" />
                </div>
                <div class="statelessness-content single-content single-content-container">
                    <div class="wp-block-post-content entry-content">

                        <?php echo $statelessness_content; ?>
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


        <div
            class="secondary-menu_region region-sticky-nav statelessness-nav  max-w-[890px] max-sm:w-full mx-auto sticky bottom-0 z-10">
            <?php
            /**
             * Sticky button for SEAP Digital ID
             * This button will appear if the region has a SEAP Digital ID associated with it.
             */
            $seap_digital_id = get_field('seap_digital_id', get_the_ID());
            if ($seap_digital_id) {
                echo related_field_btn(
                    'See Digital ID',
                    get_permalink($seap_digital_id)
                );
            }

            ?>

            <ul
                class="flex menu-region-tab single-region-tab floating-nav  max-sm:w-full sm:gap-x-4 bg-n-0  px-2 sm:px-4 rounded-b text-b-40 justify-between sm:justify-center">
                <li class="overview item" id="overview-item" theme-data="">
                    <a href="#<?php echo $posttype; ?>-single"
                        class="flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm max-sm:text-[10px] max-sm:text-center max-sm:leading-[1.6]">
                        <span class="max-sm:text-[20px] sm:leading-[0]">
                            <?php echo useSvg('overview') ?>
                        </span>
                        Overview
                    </a>
                </li>
                <li class="law item" theme-data="laws"><a href="#law"
                        class="flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm  max-sm:text-[10px] max-sm:text-center max-sm:leading-[1.6]">
                        <span class=" max-sm:text-[20px] sm:leading-[0]">
                            <?php echo useSvg('law') ?>
                        </span>
                        Law</a></li>
                <li class="population item" theme-data="population"><a href="#population"
                        class="flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm max-sm:text-[10px] max-sm:text-center max-sm:leading-[1.6]">
                        <span class="max-sm:text-[20px]">
                            <?php echo useSvg('population') ?>
                        </span>
                        Population</a></li>
                <li class="cause-of-statelessness item " theme-data="causes-of-statelessness">
                    <a class="small-screen-title flex flex-col sm:flex-row items-center gap-x-1 max-sm:items-center max-md:text-sm  max-sm:text-[10px] max-sm:text-center max-sm:leading-[1.6]"
                        href="#causes-of-statelessness">
                        <span class="max-sm:text-[20px]">
                            <?php echo useSvg('cause') ?>
                        </span>
                        Cause</a>
                    <a class="large-screen-title" href="#causes-of-statelessness">
                        <span class="">
                            <?php echo useSvg('cause') ?>
                        </span>
                        Causes of Statelessness</a>
                </li>
            </ul>
        </div>
    </div>
</div>