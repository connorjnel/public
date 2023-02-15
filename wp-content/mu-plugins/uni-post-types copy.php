<?php


// Custom post type
function uni_post_types()
{
    register_post_type('event', array(
        'public' => TRUE,
        'show_in_rest' => TRUE,
        'has_archive' => TRUE,
        'taxonomies' => array('post_tag'),
        'supports' => array(
            'title', 'editor', 'excerpt',
        ),
        'rewrite' => array(
            'slug' => 'events',
        ),
        'menu_icon' => 'dashicons-calendar-alt',
        'menu_position' => 5,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event',
        )
    ));
}

add_action('init', 'uni_post_types');
