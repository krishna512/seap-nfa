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

$lables_inforamtion = (get_field('lables_inforamtion')) ?: '';
$description = (get_field('description')) ?: '';

/**
 * =================================================
 * HTML output of the lables block
 * =================================================
 */

?>

<section id="<?php echo $id; ?>" class="<?php echo esc_attr($class_name); ?> lables ">
    <?php
    if ($lables_inforamtion && is_array($lables_inforamtion)) {
    ?>
        <div class="label-information">
            <?php
            foreach ($lables_inforamtion as $key => $lable) {
                /**
                 * // icons
                 * none : None
                 * allow : Allow
                 * block : Block
                 * warning : Warning
                 * custom : Custom icon
                 */
                $icon = '';
                if ($lable['icon'] == 'allow') {
                    $icon = get_stylesheet_directory_uri() . '/assets/icons/allow.svg';;
                } else if ($lable['icon'] == 'block') {
                    $icon = get_stylesheet_directory_uri() . '/assets/icons/block.svg';;
                } else if ($lable['icon'] == 'warning') {
                    $icon = get_stylesheet_directory_uri() . '/assets/icons/warning.svg';;
                } else if ($lable['icon'] == 'custom') {
                    $icon = $lable['custom_icon'];
                }
            ?>
                <div class="each-information">
                    <?php
                    if ($icon) {
                    ?>
                        <img src="<?php echo $icon; ?>" class="icon" alt="icon">
                    <?php
                    }
                    if ($lable['description']) {
                    ?>
                        <div class="description">
                            <?php echo $lable['description']; ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    }
    ?>

    <?php if ($description) { ?>
        <div class="desciption">
            <?php echo $description; ?>
        </div>
    <?php } ?>

</section>