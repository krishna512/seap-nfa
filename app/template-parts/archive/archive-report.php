<?php
$posttype = get_post_type();

echo page_hero_content($posttype);
?>
<div id="<?php echo $posttype; ?>-archive" class="report-archive pt-[42px] sm:pt-16 pb-[42px]">
    <div class="container">
        <div class="filter-box">
            <?php
            $arg = [
                'class' => 'report-search',
                'form_class' => 'report-filter-form'
            ];
            seap_search_box($arg);
            // report-submission category drop down
            $arg = [
                'id' => 'search-submission',
                'wrapper_class' => 'search-categories-drop-down w-full',
                'name' => 'report-submission',
                'default_option' => 'Select submission'
            ];
            seap_search_category_drop_down($taxonomy = 'report-submission', $arg);
            // country drop down
            $all_countries = get_all_countries();
            $arg = [
                "id" => "select-country",
                'wrapper_class' => 'search-countries-drop-down w-full',
                "name" => "country"
            ];
            seap_search_country_drop_down($all_countries, $arg);
            ?>
        </div>
        <div id="filter-area" class=" filter-container ">
            <?php
            if (have_posts()) {
                seap_search_count_info();
            ?>
                <div class="items grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                    <?php
                    while (have_posts()) {
                        the_post();
                        $id = get_the_ID();
                        report_card($id);
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <div>
                    <p>No report data found at the moment, please try to search with other keyword. </p>
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