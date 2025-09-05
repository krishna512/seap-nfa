<?php

/**
 * 
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
global $wp;
$seap_logo = get_seap_logo();
$menu_name = 'primary_menu';
$menu_locations = get_nav_menu_locations();
$primary_menu = wp_get_nav_menu_items($menu_locations[$menu_name]);
$primary_menu = build_seap_menu_tree($primary_menu);
?>

<nav class="header">
    <div class="container py-4 sm:py-5 flex justify-between text-caption paragraph-small items-center">

        <!-- Hamburger Menu -->
        <div id="hamburger"
            class="lg:hidden hamburger-toggle z-[80] sm:z-[91]   w-6 h-[18px] cursor-pointer flex flex-col items-center justify-between">

            <span class="w-full h-0.5 bg-b-40"> </span>
            <span class="w-full h-0.5 bg-b-40"> </span>
            <span class="w-full h-0.5 bg-b-40"> </span>
        </div>

        <div id="hamburger-overlay" class="fixed w-full h-full inset-0"></div>

        <div class="hamburger-menu relative">
            <div class="hamburger-menu-wrap relative top-[82px] max-h-[80vh] pb-4  overflow-auto">
                <div class="hamburger-content grid container text-n-40">
                    <ul class="items-center hamburger-main-title  gap-x-4">
                        <?php
                        foreach ($primary_menu as $key => $menu) {
                            if (empty($menu->menu_item_parent)) {
                                $active_menu = ($menu->url == home_url($wp->request) . '/') ? 'active' : '';
                                $active_menu = ($menu->url == home_url($wp->request)) ? 'active' : $active_menu;
                                ?>
                        <li class="<?php echo $active_menu; ?> <?php echo str_replace(' ', '-', strtolower($menu->title)); ?> group  text-base leading-[1.6] font-semibold hamburger-menu__item menu-item-has-children relative"
                            menu-item="<?php echo $menu->ID; ?>">
                            <div class="nav-title-wrapper w-full">
                                <a href="<?php echo $menu->url; ?>">
                                    <span><?php echo $menu->title; ?> </span>
                                </a>
                            </div>
                            <?php
                                    if (isset($menu->children) && $menu->children) {
                                        $child_menus = $menu->children; ?>
                            <div class="seap-child-hamburger-menu pl-3  grid space-y-1">
                                <ul class="items-center hamburger-menu__wrapper gap-x-4 divide-y divide-n-10"
                                    menu-item-parent="<?php echo $menu->ID; ?>">
                                    <?php
                                                foreach ($child_menus as $key => $child_menu_item) {
                                                    $first_child_open = ($key === 0) ? 'open' : '';
                                                    if ($child_menu_item->object === 'region' || $child_menu_item->object === 'digital-id') {
                                                        $object_id = $child_menu_item->object_id;
                                                        $active_menu = ($object_id == get_the_ID()) ? 'active' : '';
                                                        $region_color = (get_field('sub_region_color', $object_id)) ?: ''; ?>
                                    <li class="<?php echo $first_child_open; ?> <?php echo str_replace(' ', '-', strtolower($child_menu_item->title)); ?> group text-sm leading-[1.6] font-medium hamburger-menu__item menu-item-has-children relative"
                                        menu-item="<?php echo $child_menu_item->ID; ?>">
                                        <a href="<?php echo $child_menu_item->url; ?>">
                                            <?php echo $child_menu_item->title; ?>
                                        </a>
                                        <div class="hamburger-menu__sub-menu grid space-y-1  mb-2 ">
                                            <?php
                                                                echo get_sub_region_sections($object_id, $menu->url);
                                                                $countries = get_sub_region_countries($object_id, $collection = 6, get_post_type($object_id));
                                                                if ($countries) {
                                                                    $title = 'Country Overview';
                                                                    if (get_post_type($object_id) == 'digital-id') {
                                                                        $title = 'Country Factsheets';
                                                                    }
                                                                    echo '<div class="submenu-countries__wrapper">';
                                                                    echo '<div class="menu-subtitle">' . $title . '</div>';
                                                                    echo '<div class="submenu-countries">';
                                                                    echo $countries;
                                                                    echo '</div>';
                                                                    echo '</div>';
                                                                }

                                                                ?>
                                        </div>
                                    </li>
                                    <?php
                                                    } else {
                                                        $active_menu = ($child_menu_item->url == home_url($wp->request) . '/') ? 'active' : '';
                                                        $active_menu = ($child_menu_item->url == home_url($wp->request)) ? 'active' : $active_menu;
                                                        ?>
                                    <li class="nav-menu-item text-sm leading-[1.6] text-n-40 font-medium <?php echo $active_menu; ?> <?php echo str_replace(' ', '-', strtolower($child_menu_item->title)); ?> group"
                                        menu-item="<?php echo $child_menu_item->ID; ?>">
                                        <a href="<?php echo $child_menu_item->url; ?>">
                                            <?php echo $child_menu_item->title; ?>

                                        </a>
                                    </li>
                                    <?php
                                                    }
                                                }
                                                ?>
                                </ul>
                            </div>
                            <?php
                                    }
                                    ?>
                        </li>
                        <?php

                            }
                        }
                        ?>
                    </ul>

                    <div class="">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'secondary_menu',
                                'menu_id' => 'secondary-menu',
                                'menu_class' => 'hamburger-menu__wrapper secondary-hamburger gap-x-2 text-base leading-[1.6]',
                            )
                        );
                        ?>
                    </div>

                </div>


            </div>
        </div>

        <!-- HamburgerMenu End's Here -->

        <div class="flex items-center gap-x-6 header-content">
            <div class="text-xl relative z-[80] header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" title="Home">
                    <?php
                    if ($seap_logo) {
                        ?>
                    <img src="<?php echo $seap_logo; ?>" alt="logo" class="w-[78px]">
                    <?php
                    } else {
                        echo useSVG('logo');
                    }
                    ?>
                </a>

            </div>
            <ul class=" seap-menu items-center nav-menu gap-x-4 navbar-menu hidden lg:flex ">
                <?php
                foreach ($primary_menu as $key => $menu) {
                    if (empty($menu->menu_item_parent)) {
                        $active_menu = ($menu->url == home_url($wp->request) . '/') ? 'active' : '';
                        $active_menu = ($menu->url == home_url($wp->request)) ? 'active' : $active_menu;
                        ?>
                <li class="nav-menu-item seap-menu-list <?php echo $active_menu; ?> <?php echo str_replace(' ', '-', strtolower($menu->title)); ?> group"
                    menu-item="<?php echo $menu->ID; ?>">
                    <a href="<?php echo $menu->url; ?>">
                        <?php echo $menu->title; ?>
                    </a>
                    <?php
                            if (isset($menu->children) && $menu->children) {
                                $child_menus = $menu->children; ?>
                    <div class="seap-child-menu border-t border-n-10">

                        <div class="container seap-child-menu-wrapper min-h-[280px] 2xl:min-h-[260px] h-full flex">

                            <ul class="seap-child-left relative" menu-item-parent="<?php echo $menu->ID; ?>">
                                <?php
                                            foreach ($child_menus as $key => $child_menu_item) {
                                                $first_child_open = ($key === 0) ? 'open' : '';
                                                if ($child_menu_item->object === 'region' || $child_menu_item->object === 'digital-id') {
                                                    $object_id = $child_menu_item->object_id;
                                                    $active_menu = ($object_id == get_the_ID()) ? 'active' : '';
                                                    $region_color = (get_field('sub_region_color', $object_id)) ?: ''; ?>
                                <li class=" nav-menu-item text-n-50  <?php echo $active_menu . ' ' . $first_child_open; ?> <?php echo str_replace(' ', '-', strtolower($child_menu_item->title)); ?> group"
                                    menu-item="<?php echo $child_menu_item->ID; ?>">
                                    <a href="<?php echo $child_menu_item->url; ?>"
                                        class="relative text-[18px] leading-[1.6] flex">
                                        <span class="relative">
                                            <?php echo $child_menu_item->title; ?>
                                            <span
                                                class="line line-bottom w-full h-[1px]  absolute left-0 bottom-0 transition-all duration-300 opacity-0  bg-n-50">
                                                <!--       class="line w-full absolute left-0 bottom-0 border-b border-n-50 opacity-0 transition-all duration-300"> -->
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <?php
                                                } else {
                                                    $active_menu = ($child_menu_item->url == home_url($wp->request) . '/') ? 'active' : '';
                                                    $active_menu = ($child_menu_item->url == home_url($wp->request)) ? 'active' : $active_menu;
                                                    ?>
                                <li class=" nav-menu-item text-n-50  <?php echo $active_menu . ' ' . $first_child_open; ?> <?php echo str_replace(' ', '-', strtolower($child_menu_item->title)); ?> group"
                                    menu-item="<?php echo $child_menu_item->ID; ?>">
                                    <a href="<?php echo $child_menu_item->url; ?>"
                                        class="relative text-[18px] leading-[1.6] flex">
                                        <span class="relative"> <?php echo $child_menu_item->title; ?>
                                            <span
                                                class="line w-full h-[1px] left-0 absolute bottom-0 transition-all duration-300 opacity-0  bg-n-50">
                                            </span>
                                        </span>

                                    </a>
                                </li>
                                <?php
                                                }
                                            }
                                            ?>

                                <div class="absolute top-0 bottom-0 right-0  horizontal-line h-full w-[1px] bg-n-30">
                                </div>
                                <span class="indicator block absolute top-0 right-0 text-[27px] z-10 text-n-0">
                                    <?php echo useSVG('indicator') ?>
                                </span>
                            </ul>


                            <ul class="seap-child-right relative" menu-item-parent="<?php echo $menu->ID; ?>">
                                <?php
                                            foreach ($child_menus as $key => $child_menu_item) {
                                                $first_child_open = ($key === 0) ? 'open' : '';
                                                if ($child_menu_item->object === 'region' || $child_menu_item->object === 'digital-id') {
                                                    $object_id = $child_menu_item->object_id;
                                                    $active_menu = ($object_id == get_the_ID()) ? 'active' : '';
                                                    $region_color = (get_field('sub_region_color', $object_id)) ?: ''; ?>
                                <li class=" nav-menu-item <?php echo $active_menu . ' ' . $first_child_open; ?> <?php echo str_replace(' ', '-', strtolower($child_menu_item->title)); ?> group"
                                    menu-item="<?php echo $child_menu_item->ID; ?>">
                                    <div class=" sub-menu navbar-menu--submenu">
                                        <?php
                                                            echo get_sub_region_sections($object_id, $child_menu_item->url);

                                                            $countries = get_sub_region_countries($object_id, $collection = 6, get_post_type($object_id));
                                                            if ($countries) {
                                                                $title = 'Country Overview';
                                                                if (get_post_type($object_id) == 'digital-id') {
                                                                    $title = 'Country Factsheets';
                                                                }
                                                                echo '<div class="submenu-countries__wrapper">';
                                                                echo '<div class="menu-subtitle">' . $title . '</div>';
                                                                echo '<div class="submenu-countries">';
                                                                echo $countries;
                                                                echo '</div>';
                                                                echo '</div>';
                                                            }
                                                            ?>
                                    </div>
                                </li>
                                <?php
                                                } else {
                                                    if (isset($child_menu_item->children) && $child_menu_item->children) {
                                                        ?>
                                <li class=" nav-menu-item <?php echo $active_menu . ' ' . $first_child_open; ?> <?php echo str_replace(' ', '-', strtolower($child_menu_item->title)); ?> group"
                                    menu-item="<?php echo $child_menu_item->ID; ?>">
                                    <ul class="sub-menu navbar-menu--submenu"
                                        menu-item-parent="<?php echo $child_menu_item->ID; ?>">
                                        <?php
                                                                $child_child_menu_items = $child_menu_item->children;
                                                                foreach ($child_child_menu_items as $child_child_key => $child_child_menu_item) {
                                                                    $child_child_menu_item_id = $child_child_menu_item->ID;
                                                                    $active_menu = ($child_child_menu_item->url == home_url($wp->request) . '/') ? 'active' : '';
                                                                    $active_menu = ($child_child_menu_item->url == home_url($wp->request)) ? 'active' : $active_menu;
                                                                    $apply_custom_information = get_field('apply_custom_information', $child_child_menu_item_id);
                                                                    if ($apply_custom_information) {
                                                                        $image_url = get_field('image', $child_child_menu_item_id);
                                                                        $description = get_field('description', $child_child_menu_item_id);
                                                                        $cta = get_field('cta', $child_child_menu_item_id);
                                                                        ?>
                                        <li class=" sub-menu-item <?php echo $active_menu; ?> <?php echo str_replace(' ', '-', strtolower($child_child_menu_item->title)); ?> group"
                                            menu-item="<?php echo $child_child_menu_item_id; ?>">
                                            <div class="menu-item-description-wrapper max-w-[198px] w-full space-y-2">
                                                <div
                                                    class="nav-introduction-img relative pt-[50.5%] overflow-hidden rounded">
                                                    <img class="menu-item-image absolute object-cover inset-0 w-full h-full "
                                                        src="<?php echo $image_url; ?>" alt="image" loading="lazy">

                                                </div>
                                                <div class="description text-n-40 text-xs leading-[1.3]">
                                                    <?php echo $description; ?>
                                                </div>
                                                <div class="cta-wrapper py-1 ">
                                                    <?php
                                                                                    foreach ($cta as $key => $value) {
                                                                                        if (!$value['label']) {
                                                                                            continue;
                                                                                        }
                                                                                        ?>


                                                    <a href="<?php echo $value['link']; ?>"
                                                        class="button-secondary block small-secondary-btn">
                                                        <?php echo $value['label']; ?>
                                                    </a>
                                                    <?php
                                                                                    }

                                                                                    ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                                                    } else {
                                                                        ?>
                                        <li class=" sub-menu-item <?php echo $active_menu; ?> <?php echo str_replace(' ', '-', strtolower($child_child_menu_item->title)); ?> group"
                                            menu-item="<?php echo $child_child_menu_item_id; ?>">
                                            <a href="<?php echo $child_child_menu_item->url; ?>">
                                                <?php echo $child_child_menu_item->title; ?>
                                            </a>
                                        </li>
                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                    </ul>
                                </li>
                                <?php
                                                    }
                                                }
                                            }
                                            ?>
                            </ul>

                        </div>
                    </div>
                    <?php
                            }
                            ?>
                </li>
                <?php

                    }
                }
                ?>
            </ul>
        </div>
        <div class="flex gap-x-4 search">
            <div class="hidden lg:block">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'secondary_menu',
                        'menu_id' => 'secondary-menu',
                        'menu_class' => ' secondary_menu--nav-menu nav__menu flex gap-x-4 text-sm navbar-menu',
                    )
                );
                ?>
            </div>
            <div class="search relative z-[80]  ">
                <div class="search__wrapper">

                    <button
                        class="search__icon bg-transparent text-base leading-none cursor-pointer text-b-40 lg:text-n-60">
                        <?php echo useSVG('search'); ?>
                        <span class="cursor-pointer">
                        </span>
                    </button>

                    <div class="search__modal p-5">
                        <div id="search__overlay"></div>
                        <div class="w-full h-full relative mx-auto max-w-[601px] mt-[8.625rem]">

                            <div class="relative pointer-events-auto  z-[60] basis-[601px]">
                                <form role="search" id="search-form" action="<?php echo esc_url(home_url('/')); ?>"
                                    method="get" class="search-form w-full pointer-events-auto relative">
                                    <div class=" search__form--wrapper flex bg-n-50 rounded overflow-hidden relative">

                                        <input type="search"
                                            class="search-input border border-n-20 w-full bg-white pl-9 pr-4 text-n-30 text-sm "
                                            placeholder="Search..." value="" aria-label="search nico" name="s"
                                            id="search-input" value="<?php echo esc_attr(get_search_query()); ?>">

                                        <button
                                            class="shrink-0 cursor-pointer search-button -ml-1 py-2 px-4 sm:py-3 sm:px-6 md:py-4 md:sm:px-10 rounded-e bg-b-40 hover:border-b-50 hover:bg-b-50 border border-b-40 overflow-hidden ease">
                                            <span class="text-sm text-white"> Search </span>
                                            <button>
                                    </div>
                                </form>

                            </div>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>