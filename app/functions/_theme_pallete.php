<?php
/**
 * https://developer.wordpress.org/reference/functions/add_theme_support/
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

add_theme_support(
    'editor-color-palette',
    array(
        array(
            'name' => __('Purple', 'seap'),
            'slug' => 'purple',
            'color' => '#303978',
        ),
        array(
            'name' => __('Orange', 'seap'),
            'slug' => 'orange',
            'color' => '#DC9122',
        ),
        array(
            'name' => __('Red', 'seap'),
            'slug' => 'red',
            'color' => '#CC5254',
        ),
        array(
            'name' => __('Blue', 'seap'),
            'slug' => 'blue',
            'color' => '#599DE0',
        ),
        array(
            'name' => __('Green', 'seap'),
            'slug' => 'green',
            'color' => '#74AF61',
        ),
        array(
            'name' => __('Yellow', 'seap'),
            'slug' => 'yellow',
            'color' => '#F3B415',
        ),
        array(
            'name' => __('Brown', 'seap'),
            'slug' => 'brown',
            'color' => '#663F59',
        ),
        array(
            'name' => __('Neutral', 'seap'),
            'slug' => 'neutral',
            'color' => '#43455A',
        ),
    )
);


add_filter('acf/load_field/name=gutenberg_color_picker', 'acf_dynamic_colors_load');
function acf_dynamic_colors_load($field) {

    // get array of colors created using editor-color-palette
    $colors = get_theme_support('editor-color-palette');

    $field['choices'] = [];

    // if this array is empty, continue
    if (!empty($colors)) {

        // loop over each color and create option
        foreach ($colors[0] as $color) {
            $field['choices'][$color['color']] = $color['name'];
        }
    }

    $field['choices']['custom'] = 'Custom';

    return $field;
}
