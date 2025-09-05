<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ===========================
 * Button
 * ===========================
 */
if (!function_exists('text_button')) {
    function text_button($options)
    {

        $defaults = array(
            'text' => 'View all',
            'url' => '#',
            'color' => 'white'
        );

        $values = array_merge($defaults, $options);
        ob_start();
        ?>
        <a href="<?php echo $values['url']; ?>"
            class="view-all-btn text-sm tracking-[0.084px] font-bold pb-0.5  hover:border-b-40 inline-block">
            <?php echo $values['text']; ?>
        </a>
        <?php
        $output_content = ob_get_contents();
        ob_end_clean();

        return $output_content;
    }
}

/**
 * ===========================
 * Primary Button
 * ===========================
 */
if (!function_exists('primary_button')) {
    function primary_button($options)
    {
        $defaults = array(
            'text' => 'View all',
            'url' => '#',
        );
        $values = array_merge($defaults, $options);

        $class_name = "btn button-primary ";
        $class_name .= (isset($options['class'])) ? $options['class'] : '';
        $attr = (isset($options['attr'])) ? $options['attr'] : '';
        ob_start();
        ?>
        <a href="<?php echo $values['url']; ?>" class="<?php echo $class_name; ?>" <?php echo $attr; ?>>
            <?php echo $values['text']; ?>
        </a>
        <?php
        $output_content = ob_get_contents();
        ob_end_clean();

        return $output_content;
    }
}

if (!function_exists('related_field_btn')) {

    function related_field_btn($label, $link)
    {
        ob_start();

        ?>
        <div class="w-fit z-40 pb-3.5 mx-auto">

            <a href="<?php echo $link; ?>" class="view-seap-btn">

                <span><?php echo $label; ?> </span>
                <span class="text-base leading-[0]"><?php echo useSVG('right-arrow'); ?> </span>
            </a>
        </div>
        <?php
    }
    $output_content = ob_get_contents();
    ob_end_clean();

    return $output_content;
}

/**
 * ===========================
 * Expand Drop Down Button
 * ===========================
 */
function explore_drop_down_buttons($buttons = array(), $btn_type = 'btn-ocean-blue', )
{
    $btn_type_class = ($btn_type == 'btn-ocean-blue') ? 'button-primary' : 'button-white';
    ob_start();
    ?>
    <div class="<?php echo $btn_type; ?> explore_drop_down_buttons inline-flex mt-6 pointer-events-auto gap-x-3 relative">
        <?php
        if ($buttons) {
            foreach ($buttons as $key => $btn) {
                if ($key > 0) {
                    break;
                }
                ?>
                <a href="<?php echo esc_url($btn['link']); ?>">
                    <div class="<?php echo $btn_type_class; ?> text-sm">
                        <?php echo esc_html($btn['label']); ?>
                    </div>
                </a>
                <?php
            }
            if (count($buttons) > 1) {
                ?>
                <div class="download-wrapper">
                    <button class="download-btn-toggle bg-transparent border flex border-n-10  rounded cursor-pointer">
                        <span class="text-[8px] py-[22px] px-[18px] text-b-50">
                            <?php echo useSvg('dropdown-arrow'); ?>
                        </span>
                    </button>

                    <div class="download-content absolute w-full left-0 divide-y divide-n-10 bg-n-0 rounded z-[5]">
                        <?php
                        foreach ($buttons as $key => $btn) {
                            if ($key == 0) {
                                continue;
                            }
                            ?>
                            <a href="<?php echo esc_url($btn['link']); ?>" class="dropdown-download__btn">
                                <?php echo esc_html($btn['label']); ?>
                                <span class="dropdown-download__icon">
                                    <?php echo useSvg('download-bold'); ?>
                                </span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
    $output_content = ob_get_contents();
    ob_end_clean();

    return $output_content;
}