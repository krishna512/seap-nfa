<?php
$posttype = get_post_type();

echo page_hero_content();
?>
<div id="<?php echo $posttype; ?>-archive" class="">
    <div class="container">
        <div class="filter-box">
            <?php
            seap_search_box(['class' => 'news-search']);
            ?>
        </div>
        <div id="filter-area" class="filter-container ">
            <?php
            if (have_posts()) {

                seap_search_count_info();
            ?>
                <div class="card-grid-container">
                    <?php
                    while (have_posts()) {
                        the_post();
                        $id = get_the_ID();
                        news_card($id);
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <div>
                    <p>No data available </p>
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