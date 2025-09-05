<?php

/**
 * Template Name: Compare countries
 * Template Post Type: page
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package seap
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$compare_countries_type = get_field('compare_countries_type') ?: "region";
$all_countries = get_all_countries($compare_countries_type);
$country_1 = (isset($_GET['country_1'])) ? $_GET['country_1'] : '';
$country_2 = (isset($_GET['country_2'])) ? $_GET['country_2'] : '';
$theme = (isset($_GET['theme'])) ? $_GET['theme'] : 'laws';
$theme = $theme ? $theme : 'laws';
wp_enqueue_script('apex-chart');


get_header();

?>

<div id="compare-countries" class="<?php echo get_post_type(); ?> compare-countries pt-16 sm:pt-20">
    <div class="relative overflow-hidden">
        <div class="container pt-12 sm:pt-14 pb-20">
            <div class="heading mb-10 sm:mb-[72px]">
                <div class="grid justify-items-center gap-9 md:gap-[42px] text-center">
                    <?php echo get_seap_breadcrumb(); ?>

                    <h1 class="relative text-b-40">
                        <?php echo get_the_title(); ?>
                    </h1>
                </div>
                <div class="grid justify-items-center w-full md:mt-2">
                    <span class="bottom-lines text-center bg-b-40 max-w-[233px]"></span>
                </div>
            </div>

            <div class=" about-comparison description sm:px-6  max-w-[1018px] mx-auto">
                <?php the_content(); ?>
            </div>

            <div class="sm:px-6 sm:pt-6 pb-20 md:pb-24 max-w-[1018px] mx-auto grid gap-5">

                <div class="compare-countries-filter relative z-10">
                    <p class="text-sm sm:text-base  text-n-60 mb-2 sm:mb-3"> Select Country </p>
                    <form action="" method="get" class="filter-form"
                        data-url="<?php echo get_permalink(); ?>">
                        <input type="hidden" name="theme" value="<?php echo $theme ? $theme : 'laws'; ?>">
                        <div class="grid grid-cols-2 gap-2 sm:gap-6">
                            <?php
                            $arg = [
                                "id" => "compare-country-1",
                                "class" => "country-1",
                                "name" => "country_1"
                            ];
                            seap_search_country_drop_down($all_countries, $arg);
                            $arg = [
                                "id" => "compare-country-2",
                                "class" => "country-2",
                                "name" => "country_2",
                            ];
                            seap_search_country_drop_down($all_countries, $arg);
                            ?>
                        </div>
                    </form>
                </div>

                <div class="secondary-menu_compare-countries relative z-10">
                    <p class="text-sm sm:text-base text-n-60 mb-2 sm:mb-3">Select a themes</p>
                    <ul class="flex bg-white justify-between filter-wrapper border border-n-20">
                        <?php
                        if ($compare_countries_type == 'region') {
                        ?>
                            <li class="filter-theme <?php echo ($theme == 'laws') ? 'active' : ''; ?>" theme-data="laws">
                                <?php echo useSVG('law'); ?>
                                <span>Law</span>
                            </li>
                            <li class="filter-theme <?php echo ($theme == 'population') ? 'active' : ''; ?>"
                                theme-data="population">
                                <?php echo useSVG('population'); ?>
                                <span>Population</span>
                            </li>
                            <li class="filter-theme <?php echo ($theme == 'causes-of-statelessness') ? 'active' : ''; ?>"
                                theme-data="causes-of-statelessness">
                                <?php echo useSVG('cause'); ?>
                                <span class='large-screen-title'>Cause of Statelessness</span>
                                <span class='small-screen-title'>Cause</span>
                            </li>
                        <?php
                        }
                        if ($compare_countries_type == 'digital-id') {
                        ?>
                            <li class="filter-theme <?php echo ($theme == 'legal_identity') ? 'active' : ''; ?>" theme-data="legal_identity">
                                <?php echo useSVG('legal-identity'); ?>
                                <span>Legal Identity</span>
                            </li>
                            <li class="filter-theme <?php echo ($theme == 'overview') ? 'active' : ''; ?>"
                                theme-data="overview">
                                <?php echo useSVG('overview'); ?>
                                <span>Digital ID Overview</span>
                            </li>
                            <li class="filter-theme <?php echo ($theme == 'laws') ? 'active' : ''; ?>" theme-data="laws">
                                <?php echo useSVG('law'); ?>
                                <span>Law</span>
                            </li>
                            <li class="filter-theme <?php echo ($theme == 'digital_identity_rights') ? 'active' : ''; ?>"
                                theme-data="digital_identity_rights">
                                <?php echo useSVG('menu_globe'); ?>
                                <span>Designed to include?</span>
                            </li>
                        <?php
                        }

                        ?>
                    </ul>
                </div>
            </div>

            <div class="loader">
                <div id="loader-container" class="per-loader">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>

            <div id="filter-area" class="compare-result">
                <?php
                if ($country_1 && $country_2 && ($country_1 != $country_2)) {
                ?>
                    <div class="compare-countries-content grid grid-cols-2 gap-5  mb-20 md:mb-24">
                        <div class="country-1">
                            <?php
                            if ($country_1) {
                                echo compare_country_section($country_1, $theme, $compare_countries_type);
                            }
                            ?>
                        </div>

                        <div class="country-2">
                            <?php
                            if ($country_2) {
                                echo compare_country_section($country_2, $theme, $compare_countries_type);
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

        </div>
        <div class="">
            <img src="<?php echo get_template_directory_uri() .
                            '/assets/images/compare-left-map.svg'; ?>" alt="Map image"
                class="absolute top-0 max-sm:left-[-112px] ">
            <img src="<?php echo get_template_directory_uri() .
                            '/assets/images/compare-right-map.svg'; ?>" alt="Map image"
                class=" absolute right-0 top-0 max-sm:w-[130px] max-sm:top-[64px] max-sm:right-[-51px] ">
        </div>
    </div>
</div>

<?php

get_footer();
