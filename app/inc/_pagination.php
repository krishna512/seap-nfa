<?php



// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit; 
}

// pagination
function main_query_pagination()
{

    global $wp_query, $svgIcon;

    $big = 999999999;

    $rightIcon = useSvg('double-right-arrow');
    $leftIcon = useSvg('double-left-arrow');

    $paginate = paginate_links(
        array(
            'prev_text' => sprintf('%s<div class="hidden sm:block">Previous</div>', $leftIcon),
            'next_text' => sprintf('<div class="hidden sm:block">Next</div> %s', $rightIcon),
            // 'next_text' => "Next" . sprintf($rightIcon),
        )
    );

    $paginate = str_replace('next', 'next', $paginate);

    $html_paginate = "";

    if ($paginate) {
        $html_paginate .= '<div class="navigation pagination" role="navigation">';
        $html_paginate .= '<div class="nav-links">';
        $html_paginate .= $paginate;
        $html_paginate .= '</div>';
        $html_paginate .= '</div>';
    }
    return $html_paginate;
}

function custom_query_pagination($query, $paged)
{

    global $wp_query, $svgIcon;

    $big = 999999999;
    $rightIcon = useSvg('double-left-arrow');
    $leftIcon = useSvg('double-right-arrow');

    $paginate = paginate_links(
        array(
            'base' => str_replace($big, '%#%', html_entity_decode(get_pagenum_link($big))),
            'total' => $query->max_num_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
            'show_all' => false,
            'type' => 'plain',
            'end_size' => 4,
            'mid_size' => 1,
            'prev_next' => true,
            'prev_text' => sprintf($leftIcon),
            'next_text' => sprintf($rightIcon),
            'add_args' => false,
            'add_fragment' => '',
        )
    );

    $paginate = str_replace('next', 'next', $paginate);
    $html_paginate = "";

    if ($paginate) {
        $html_paginate .= '<div class="navigation pagination " role="navigation">';
        $html_paginate .= '<div class="nav-links">';
        $html_paginate .= $paginate;
        $html_paginate .= '</div>';
        $html_paginate .= '</div>';
    }

    return $html_paginate;
}

function paged()
{
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }
    return $paged;
}