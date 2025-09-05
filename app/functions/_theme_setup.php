<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('theme_setup')) {
    function theme_setup() {

        // manage document title
        add_theme_support('title-tag');

        // Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails');

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images.
        add_theme_support('align-wide');

        // Add support for editor styles.
        add_theme_support('editor-styles');

        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        // Add custom theme logo
        add_theme_support('custom-logo');

        // allows the use of HTML5 markup for the 
        // search forms, comment forms, comment lists, gallery, and caption
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list'
            )
        );

        // register location for nav menus
        register_nav_menus(
            array(
                'primary_menu' => esc_html__('Primary Menu (SEAP style)', 'seap'),
                'secondary_menu' => esc_html__('Secondary Menu', 'seap'),
                'footer_menu' => esc_html__('Footer Menu', 'seap'),
            )
        );
    }

    add_action('after_setup_theme', 'theme_setup');
}

add_filter('body_class', function ($classes) {
    return array_merge($classes, array('font-manrope'));
});



/**
 * https://developer.wordpress.org/reference/classes/wp_admin_bar/add_menu/
 */
function menu_region_admin($wp_admin_bar) {

    // Add edit links for region post type
    if (get_post_type() === 'region') {
        $law_id = (get_field('select_law', get_the_ID())) ?: '';
        if ($law_id) {
            $args = array(
                'id' => 'edit_law',
                'title' => 'Edit Law',
                'href' => admin_url('/post.php?post=' . $law_id . '&action=edit'),
                'parent' => 'edit'
            );
            $wp_admin_bar->add_menu($args);
        }

        $population_id = (get_field('select_population', get_the_ID())) ?: '';
        if ($population_id) {
            $args = array(
                'id' => 'edit_population',
                'title' => 'Edit Population',
                'href' => admin_url('/post.php?post=' . $population_id . '&action=edit'),
                'parent' => 'edit'
            );
            $wp_admin_bar->add_menu($args);
        }

        $statelessness_id = (get_field('causes_of_statelessness', get_the_ID())) ?: '';
        if ($statelessness_id) {
            $args = array(
                'id' => 'edit_csuses_of_statelessness',
                'title' => 'Edit Causes of Statelessness',
                'href' => admin_url('/post.php?post=' . $statelessness_id . '&action=edit'),
                'parent' => 'edit'
            );
            $wp_admin_bar->add_menu($args);
        }
    }
    // Add edit links for digital-id post type
    if (get_post_type() === 'digital-id') {
        $id = (get_field('select_legal_identity', get_the_ID())) ?: '';
        if ($id) {
            $args = array(
                'id' => 'edit_legal_identity',
                'title' => 'Edit Legal Identity',
                'href' => admin_url('/post.php?post=' . $id . '&action=edit'),
                'parent' => 'edit'
            );
            $wp_admin_bar->add_menu($args);
        }
        $law_id = (get_field('select_law', get_the_ID())) ?: '';
        if ($law_id) {
            $args = array(
                'id' => 'edit_law',
                'title' => 'Edit Law',
                'href' => admin_url('/post.php?post=' . $law_id . '&action=edit'),
                'parent' => 'edit'
            );
            $wp_admin_bar->add_menu($args);
        }
        $id = (get_field('select_digital_identity_rights', get_the_ID())) ?: '';
        if ($id) {
            $args = array(
                'id' => 'edit_digital_identity_rights',
                'title' => 'Edit Designed to Include',
                'href' => admin_url('/post.php?post=' . $id . '&action=edit'),
                'parent' => 'edit'
            );
            $wp_admin_bar->add_menu($args);
        }
    }
}
add_action('admin_bar_menu', 'menu_region_admin', 999);



/**
 * https://developer.wordpress.org/reference/hooks/manage_posts_columns/
 */
// manage_post_columns_data();
function manage_post_columns_data() {

    function set_region_list_columns($columns) {
        $new_columns = array();
        $before = 'date'; // move before this
        foreach ($columns as $key => $value) {
            if ($key == $before) {
                $new_columns['regions'] = __('Regions', 'seap');
            }
            $new_columns[$key] = $value;
        }
        return $new_columns;
    }
    add_filter('manage_law_posts_columns', 'set_region_list_columns', 10);
    add_filter('manage_population_posts_columns', 'set_region_list_columns', 10);
    add_filter('manage_statelessness_posts_columns', 'set_region_list_columns', 10);


    function set_region_custom_column_data($column_name, $post_id) {
        if ('regions' === $column_name) {
            $post_type = get_post_type();
            if ($post_type == 'law') {
                $key = 'select_law';
            } elseif ($post_type == 'population') {
                $key = 'select_population';
            } elseif ($post_type == 'statelessness') {
                $key = 'causes_of_statelessness';
            }
            if ($key && $post_id) {
                $region_arr = array(
                    'post_type' => 'region',
                    'posts_per_page' => -1,
                    'post_status' => array('publish'),
                    'meta_query' => [
                        'relation' => 'OR',
                        [
                            'key' => $key,
                            'value' => $post_id,
                            'compare' => '=',
                        ]
                    ]
                );
                $region_post = get_posts($region_arr);
                if ($region_post && is_array($region_post)) {
                    foreach ($region_post as $key => $value) {
?>
                        <div>
                            <?php echo $value->post_title; ?>
                        </div>
                        <div>
                            <a href="<?php echo admin_url('/post.php?post=' . $value->ID . '&action=edit'); ?>">
                                Edit
                            </a>
                            <a href="<?php echo get_the_permalink($value->ID); ?>">
                                view
                            </a>
                        </div>
        <?php
                    }
                }
            }
        }
    }
    add_action('manage_law_posts_custom_column', 'set_region_custom_column_data', 10, 2);
    add_action('manage_population_posts_custom_column', 'set_region_custom_column_data', 10, 2);
    add_action('manage_statelessness_posts_custom_column', 'set_region_custom_column_data', 10, 2);
}


/**
 * ===== hide admin site side menus ======
 * */
function hide_siteadmin() {
    // To remove menu 
    remove_menu_page('edit.php');
    //  submenu pages
    remove_submenu_page('themes.php', 'theme-editor.php');

    //To remove_submenu_page wp-admin/customize.php
    global $submenu;
    foreach ($submenu['themes.php'] as $i => $item) {
        if (str_contains($item[2], 'customize.php')) {
            unset($submenu['themes.php'][$i]);
            if (str_contains($_SERVER['REQUEST_URI'], 'customize.php')) {
                if (wp_redirect('/wp-admin/admin.php?page=seap-options', $status = 302, $x_redirect_by = 'SEAP')) {
                    die;
                }
            }
        }
    }
}
add_action('admin_menu', 'hide_siteadmin', 999);


/**
 * admin_notices hooks
 * https://developer.wordpress.org/reference/hooks/admin_notices/
 */
function seap_admin_notice_success() {
    $theme_customize = (isset($_GET['theme_customize'])) ? $_GET['theme_customize'] : '';
    if ($theme_customize || $theme_customize == 0) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p> <strong>Theme customize page is blocked by SEAP theme</strong> </p>
        </div>
<?php
    }
}
add_action('admin_notices', 'seap_admin_notice_success');



/**
 * =====  menus order ======
 * https://developer.wordpress.org/reference/hooks/custom_menu_order/
 * https://support.advancedcustomfields.com/forums/topic/options-page-wp-admin-menu-order/
 * */
function seap_custom_menu_order($menu_ord) {
    if (!$menu_ord) return true;
    return array(
        'index.php', // Dashboard

        'separator1', // First separator
        'edit.php', // this is the default POST admin menu 
        'edit.php?post_type=region',
        'edit.php?post_type=digital-id',
        'edit.php?post_type=law',
        'edit.php?post_type=population',
        'edit.php?post_type=statelessness',
        'edit.php?post_type=stakeholder',
        'edit.php?post_type=faq',
        'edit.php?post_type=glossary',
        'edit.php?post_type=news',
        'edit.php?post_type=report',
        'edit.php?post_type=page', // this is the default page menu
        'upload.php', // Media

    );
}
add_filter('custom_menu_order', 'seap_custom_menu_order');
add_filter('menu_order', 'seap_custom_menu_order');

// 
/**
 * ============================
 * Change request using hook
 * https://developer.wordpress.org/reference/hooks/request/
 * ============================
 */
function seap_rewrite_request($query) {
    if (isset($query['post_type'])) {
        if ($query['post_type'] === 'faq' && isset($query['name'])) {
            if (wp_redirect('/how-to-use')) {
                die;
            }
            if (wp_redirect(get_post_type_archive_link('faq'))) {
                die;
            }
        }
    }
    return $query;
}
add_filter('request', 'seap_rewrite_request', 9999, 1);
