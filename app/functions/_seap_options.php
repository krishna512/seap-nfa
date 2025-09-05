<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * =======================================================
 * SEAP site logo url
 * =======================================================
 */
if (!function_exists('get_seap_logo')) {
    function get_seap_logo() {
        $custom_logo_id = get_theme_mod('custom_logo');
        $url = $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'full') : '';
        $site_logo = (function_exists('get_field') && $site_logo = get_field('site_logo', 'option')) ? $site_logo : $url;
        if (is_array($site_logo)) {
            $logo_id = $site_logo['id'];
            return wp_get_attachment_image_url($logo_id);
        } elseif (is_int($site_logo)) {
            $logo_id = $site_logo;
            return wp_get_attachment_image_url($logo_id);
        } else {
            return $site_logo;
        }
        return "";
    }
}

/**
 * =======================================================
 * SEAP site contact_information array
 * =======================================================
 */
if (!function_exists('get_seap_contact_information')) {
    function get_seap_contact_information() {
        $contact_information = (function_exists('get_field') && $contact_information = get_field('contact_information', 'option')) ? $contact_information : '';
        if (is_array($contact_information)) {
            return $contact_information;
        }
        return "";
    }
}

/**
 * =======================================================
 * SEAP site footer_information array
 * =======================================================
 */
if (!function_exists('get_seap_footer_information')) {
    function get_seap_footer_information() {
        $footer_information = (function_exists('get_field') && $footer_information = get_field('footer_information', 'option')) ? $footer_information : '';
        if (is_array($footer_information)) {

            $footer_information['footer_header'] = isset($footer_information['footer_header']) ? $footer_information['footer_header'] : '';
            $footer_information['footer_header'] = ($footer_information['footer_header']) ?: 'Comprehensive Mapping of Statelessness in the Asia Pacific';

            $footer_information['footer_button_type'] = ($footer_information['footer_button_type']) ?: 'single';
            $footer_information['explore_drop_down_buttons'] = ($footer_information['explore_drop_down_buttons']) ?: [];
            $footer_information['footer_button_label'] = isset($footer_information['footer_button_label']) ? $footer_information['footer_button_label'] : '';
            $footer_information['footer_button_label'] = ($footer_information['footer_button_label']) ?: 'Download the report';

            $footer_information['footer_button_link'] = isset($footer_information['footer_button_link']) ? $footer_information['footer_button_link'] : '';

            $footer_information['copyright'] = (isset($footer_information['copyright'])) ? $footer_information['copyright'] : '';
            $footer_information['copyright'] = ($footer_information['copyright']) ?: 'Nationality For All. All rights reserved.';

            $footer_info['quick_links'] = (isset($footer_info['quick_links'])) ? $footer_info['quick_links'] : '';

            return $footer_information;
        }
        return "";
    }
}


/**
 * =======================================================
 * SEAP site faq page information array
 * =======================================================
 */
if (!function_exists('get_seap_faq_page_information')) {
    function get_seap_faq_page_information() {
        $faq_information = (function_exists('get_field') && $faq_information = get_field('faq_information', 'option')) ? $faq_information : '';
        if (is_array($faq_information)) {
            // search_description
            if (isset($faq_information['search_description'])) {
                $faq_information['search_description'] = ($faq_information['search_description']) ?: 'or choose a category to quickly find the help you need';
            } else {
                $faq_information['search_description'] = '';
            }
            // For contact_block_header
            if (isset($faq_information['contact_block_header'])) {
                $faq_information['contact_block_header'] = ($faq_information['contact_block_header']) ?: 'You still have a question?';
            } else {
                $faq_information['contact_block_header'] = '';
            }
            // For contact_block_body
            if (isset($faq_information['contact_block_body'])) {
                $faq_information['contact_block_body'] = ($faq_information['contact_block_body']) ?: 'If you cannot find answer to your question you can always contact us';
            } else {
                $faq_information['contact_block_body'] = '';
            }
            return $faq_information;
        }
        return "";
    }
}
