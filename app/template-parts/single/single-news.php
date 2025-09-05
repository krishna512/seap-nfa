<?php

$id = get_the_ID();
$posttype = ($posttype = get_post_type()) ?: "news";
$permalink = get_the_permalink();
$title = get_the_title();
$thumbnail_image = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : '';
$published_date = get_the_date('d M, Y');

?>
<div id="<?php echo $posttype; ?>-single" class="">
    <div class="container">
        <div>
            <?php echo get_seap_breadcrumb(); ?>
            <h1> <?php echo $title; ?> </h1>
            <div class="feature-image">
                <img src="<?php echo $thumbnail_image; ?>" alt="">
            </div>
            <div class="post-date">
                <p>Published date : <span><?php echo $published_date; ?></span> </p>
            </div>
            <div>
                <?php gutenbergEditorContent(); ?>
            </div>
        </div>
        <div class="more-news">
            <h2>More news</h2>
            <?php
            $args = array(
                'post_type' => 'news',
                'posts_per_page' => 3,
                'post_status' => array('publish'),
            );
            $posts = new WP_Query($args);
            if ($posts->have_posts()) {
                ?>
                <div class="card-grid-container">
                    <?php
                    while ($posts->have_posts()) {

                        $posts->the_post();

                        $id = get_the_ID();

                        news_card($id);
                    }
                    wp_reset_postdata(); ?>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
    <div class="bg-image-1 hidden sm:block">
        <img src="<?php echo get_template_directory_uri() .
            '/assets/images/bg-country-left.png'; ?>">
    </div>
    <div class="bg-image-2 hidden sm:block">
        <img src="<?php echo get_template_directory_uri() .
            '/assets/images/bg-country-right.png'; ?>">
    </div>
</div>