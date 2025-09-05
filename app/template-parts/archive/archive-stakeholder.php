<?php
$posttype = 'stakeholder';

echo page_hero_content($posttype);
?>
<div id="<?php echo $posttype; ?>-archive" class="pb-10 sm:pb-14 stakeholder-archive">
    <div class="container">
        <div class="filter-box">
            <?php
            // form with search box
            seap_search_box(['class' => 'stakeholder-search']);
            // stakeholder category drop down
            $arg = [
                'wrapper_class' => 'search-stakeholder-categories w-full',
            ];
            seap_search_category_drop_down($taxonomy = 'stakeholder-category', $arg);
            // Select regions drop down
            $arg = [
                'class' => 'search-regions',
                'wrapper_class' => 'search-stakeholder-regions w-full',
                'id' => 'search-stakeholder-regions',
                'name' => 'regions',
                'term' => "Select regions"
            ];
            seap_custom_drop_down(get_type_of_region_except_country(), $arg);
            // country drop down
            $all_countries = get_all_countries();
            $arg = [
                "id" => "select-country",
                'wrapper_class' => 'search-stakeholder-countries w-full',
                "name" => "country"
            ];
            seap_search_country_drop_down($all_countries, $arg);
            ?>

        </div>
        <div id="filter-area" class=" filter-container ">
            <?php
            if (have_posts()) {
                $_GET_search = (isset($_GET['search'])) ? $_GET['search'] : '';
                $_GET_category = (isset($_GET['category'])) ? $_GET['category'] : '';
                $_GET_country = (isset($_GET['country'])) ? $_GET['country'] : '';
                $_GET_regions = (isset($_GET['regions'])) ? $_GET['regions'] : '';

                $arg = [];
                if ($_GET_search || $_GET_category || $_GET_country || $_GET_regions) {
                    $arg = [
                        'display' => false
                    ];
                }
                seap_search_count_info($arg);
            ?>
                <div class="stakeholders-content single-content  mx-auto">
                    <?php
                    while (have_posts()) {
                        the_post();
                        $id = get_the_ID();
                        stakeholders_card($id);
                    }
                    ?>
                </div>
            <?php
            } else {

            ?>
                <div>
                    <p>No stakeholder found at the moment, please try to search with other keyword or country </p>
                </div>
            <?php

            }
            // echo main_query_pagination();
            ?>

            <?php if (main_query_pagination()) { ?>

                <div class="pt-14">

                    <?php echo main_query_pagination(); ?>

                </div>

            <?php } ?>
        </div>
    </div>
</div>