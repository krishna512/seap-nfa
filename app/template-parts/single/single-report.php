<?php


$id = get_the_ID();
$posttype = ($posttype = get_post_type()) ?: "report";
$permalink = get_the_permalink();
$title = get_the_title();

$location_id = (get_field('region')) ?: '';
$location_name = ($location_id) ? get_the_title($location_id) : '';
$file_url = (get_field('file')) ?: '';
$report_categories = (get_field('report-categories')) ?: '';


?>
<div id="<?php echo $posttype; ?>-single" class="report-details">
    <?php echo page_hero_content(); ?>
    <div class="container  pt-14 pb-[58px]">
        <div class="wp-block-post-content entry-content ">
            <?php
            if ($location_name) {
                ?>
                <div class="text-sm">
                    <span class="font-bold">Country: </span>
                    <?php echo $location_name; ?>
                </div>
                <?php
            }
            if ($report_categories) {
                ?>
                <div class="text-sm">
                    <span class="font-bold">Category: </span>
                    <?php
                    foreach ($report_categories as $key => $categories) {
                        ?>
                        <div class="category-name">
                            <?php echo $categories->name; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php

            }
            ?>
            <div class="report-paragraph">
                <?php gutenbergEditorContent(); ?>
            </div>

            <div class="flex justify-center download-button ">
                <?php
                if ($file_url) {
                    $options = array(
                        'text' => 'Download File',
                        'url' => $file_url,
                        'attr' => 'download'
                    );
                    echo primary_button($options);
                }
                ?>
            </div>
        </div>
    </div>
</div>