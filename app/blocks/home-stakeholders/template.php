<?php
$id = '' . $block['id'];
$className = '';

if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= 'home-stakeholders align' . $block['align'];
}

$default_background_img = get_template_directory_uri() . '/assets/images/stakeholders-bg.jpg';
$background_image = ($background_image = get_field('background_image')) ? $background_image : $default_background_img;
// 

$stakeholder_args = array(
    'post_type' => 'stakeholder',
    'posts_per_page' => 10,
    'post_status' => array('publish'),
    'orderby' => 'rand',
    'meta_query' => array(
        'relation' => 'OR',
            array(
                'key' => 'title_hideshow',
                'value' => 'show',
                'compare' => '='
            ),
            array(
                'key' => 'title_hideshow',
                'compare' => 'NOT EXISTS' // Includes posts where the field is not set (null)
            )
    )
);
$styles = "#{$id}.home-stakeholders{
    background: linear-gradient(0deg, rgba(48, 57, 120, 0.90) 0%, rgba(48, 57, 120, 0.90) 100%), url('{$background_image}'), lightgray 0px -569.006px / 100% 414.578% no-repeat;
    background-repeat: no-repeat;
    background-blend-mode: hard-light, normal;
    background-size: cover;
}";

/**
 * =================================================
 * Get acf field values
 * =================================================
 */
$title = (get_field('section_title')) ?: __('Section Title', 'seap');
$button_label = (get_field('button_label')) ?: __('View all stakeholders', 'seap');

/**
 * =================================================
 * HTML output of the chart block
 * =================================================
 */
?>

<section id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
    <style id='<?php echo $id; ?>-styles-inline-css' type='text/css'>
        <?php echo $styles;
        ?>
    </style>
    <div class="">
        <div class="relative flex carousel-container max-sm:flex-col">
            <div
                class="flex-1 sm:absolute pt-14 sm:pt-[70px] z-10 h-full inset-0 title text-white sm:pb-12 sm:w-[50%] lg:w-[40%]">
                <div
                    class="relative z-10 flex flex-col justify-between slider-container sm:h-full gap-y-11 max-sm:pr-4">
                    <h2 class="">
                        <?php echo $title; ?>
                    </h2>
                    <div>
                        <?php
                        $options = array(
                            'text' => $button_label,
                            'url' => get_post_type_archive_link('stakeholder'),
                        );
                        echo text_button($options); ?>
                    </div>
                </div>
                <div class="title-overlay">
                </div>
            </div>
            <div class="stakeholders pt-20 sm:w-[130%]">
                <?php
                $stakeholder_post = new WP_Query($stakeholder_args);
                if ($stakeholder_post->have_posts()) {
                    ?>
                    <div id='stakeholder-slider' class="h-full swiper stakeholderSwiper">
                        <div class="swiper-wrapper">
                            <?php
                            while ($stakeholder_post->have_posts()) {
                                $stakeholder_post->the_post();
                                $id = get_the_ID();
                                $title = get_the_title($id);
                                $permalink = get_the_permalink($id);
                                $locations = get_field('locations', $id);
                         

                                stakeholders_card($id);
                            }
                            wp_reset_postdata(); ?>
                        </div>
                        <div class="swiper-pagination"></div>

                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</section>