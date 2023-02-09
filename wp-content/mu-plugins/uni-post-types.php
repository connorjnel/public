<?php


// Custom post type
function uni_post_types()
{
    register_post_type('event', array(
        'public' => TRUE,
        'show_in_rest' => TRUE,
        'menu_icon' => 'dashicons-calendar-alt',
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Name',
        )
    ));
}

add_action('init', 'uni_post_types');
