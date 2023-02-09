<?php


// Custom post type
function uni_post_types()
{
    register_post_type('event', array(
        'public' => TRUE,
        'menu_icon' => 'dashicons-calendar-alt',
        'labels' => array(
            'name' => 'Events',
        )
    ));
}

add_action('init', 'uni_post_types');
