<?php

/**
 * =================================================
 * Support custom "anchor" values.
 * =================================================
 */
$id = '';
if (!empty($block['anchor'])) {
    $id = esc_attr($block['anchor']);
}

// use generated id if custom anchor is not provided
$id = $block['id'];

// Create class attribute allowing for custom "className" and "align" values.
$class_name = '';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}


/**
 * =================================================
 * Get acf field values
 * =================================================
 */

$box = get_field('box');
$content_type = (get_field('content_type')) ?: ''; //  page, custom
$box_per_row = (get_field('box_per_row')) ?: ''; // three, four
if ($box_per_row === 'three') {
    $class_name .= ' layout-3-box';
} elseif ($box_per_row === 'four') {
    $class_name .= ' layout-4-box';
} else {
    $class_name .= ' layout-box';
}
/**
 * =================================================
 * HTML output of the layout-box block
 * =================================================
 */

?>

<section id="<?php echo $id; ?>" class="<?php echo esc_attr($class_name); ?> img-section">
    <div class="container mt-5 sm:mt-20">
        <div class="image-card">
            <?php
            if ($box) {
                foreach ($box as $key => $value) {
                    $title = $background_image = $url = '';
                    if ($content_type === 'custom') {
                        $title = ($value['title']) ?: '';
                        $background_image = ($value['background_image']) ?: '';
                        $url = ($value['url']) ?: '#';
                    } elseif ($content_type === 'page') {
                        $page_id = ($value['page']) ?: '';
                        if ($page_id) {
                            $title = get_the_title($page_id);
                            $background_image = get_the_post_thumbnail_url($page_id);
                            $url = get_the_permalink($page_id);
                        }
                    }

                    ?>
                    <div class="image-card-wrapper">
                        <div class="each-item relative overflow-hidden rounded-xl ">
                            <a href="<?php echo $url ?>">
                                <div class=" relative pt-[64%] invert-color">
                                    <img src="<?php echo $background_image; ?>" alt="image"
                                        class=" absolute w-full h-full inset-0  object-cover">
                                </div>


                                <div class="absolute z-10 inset-0 p-8 grid justify-items-center items-center ">
                                    <p class=" text-2xl sm:display-small text-n-0 text-center">
                                        <?php echo $title; ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>