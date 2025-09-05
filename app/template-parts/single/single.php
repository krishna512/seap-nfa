<?php
if (!is_front_page()) {
    $posttype = ($posttype = get_post_type()) ?: "page";
?>
    <div id="<?php echo $posttype; ?>-single" class="">
        <?php echo page_hero_content(); ?>
        <div class="content-wrapper">
            <?php gutenbergEditorContent(); ?>
        </div>
    </div>
<?php
    echo do_shortcode('[citenote_display_list]');
} else {
    gutenbergEditorContent();
}
