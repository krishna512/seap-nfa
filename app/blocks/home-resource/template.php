<?php
$id = '' . $block['id'];
$className = 'home-resource';

if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

$titleCSS = 'text-h3 mb-3';


/**
 * =================================================
 * Get acf field values
 * =================================================
 */
$news_title = (get_field('news_title')) ?: __('News', 'seap');
$news_button_label = (get_field('news_button_label')) ?: __('View all news', 'seap');
$reports_title = (get_field('reports_title')) ?: __('UPR Submission Nationality Rights', 'seap');
$reports_button_label = (get_field('reports_button_label')) ?: __('View all reports', 'seap');

/**
 * =================================================
 * HTML output of the chart block
 * =================================================
 */

?>

<section id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?> pt-20 md:pt-32 pb-14">
    <div class="container">
        <div class="grid sm:grid-cols-2 gap-6 max-sm:gap-y-20">

            <?php
            /** 
             * News 
             **/
            ?>
            <div class="news pr-7">
                <h2 class="<?php echo $titleCSS; ?>">
                    <?php echo $news_title; ?>
                </h2>

                <?php
                $query = array(
                    'posts_per_page' => 4,
                );
                echo news_listing_vertical($query);

                $options = array(
                    'text' => $news_button_label,
                    'url' => get_post_type_archive_link('news'),
                );
                echo '<div class="mt-3">' . text_button($options) . '</div>';
                ?>
            </div>

            <?php
            /** 
             * UDP Report 
             **/
            ?>
            <div class="udp-report">
                <h2 class="<?php echo $titleCSS; ?>">
                    <?php echo $reports_title; ?>
                </h2>

                <?php
                $query = array(
                    'posts_per_page' => 4,
                );
                echo reports_listing_vertical($query);

                $options = array(
                    'text' => $reports_button_label,
                    'url' => get_post_type_archive_link('report'),
                );
                echo '<div class="mt-3">' . text_button($options) . '</div>';
                ?>
            </div>


        </div>
    </div>
</section>