<?php

/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package seap
 * 
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();

$queried_object = get_queried_object();

$template_folder = 'app/template-parts/';

$archive_folder = $template_folder . 'archive/';

$single_folder = $template_folder . 'single/';

if (is_singular()) {

	$current_post_type = get_post_type();

	$filename = ($current_post_type === 'page') ? 'page-' . get_post_field('post_name') : $current_post_type;

	get_template_part($single_folder . 'single', $filename);
} elseif (is_archive() || is_home()) {

	$archive_filename = isset($queried_object->name) ? $queried_object->name : '';
	$filename = (is_category() || is_tag() || is_tax()) ? "taxonomy" : $archive_filename;
	/**
	 * This will look for template for example: archive-[postTypeID].php or archive-[taxonomyID].php automatically depending on the type of archive
	 * 
	 * if not found it will select default template which is archive.php or template.php
	 */
	get_template_part($archive_folder . 'archive', $filename);
} elseif (is_search()) {

	get_template_part($template_folder . '/search');
} else {

	get_template_part($template_folder . '/404');
}

get_footer();
