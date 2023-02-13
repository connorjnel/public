<?php

// Load stylesheets, js scripts, font files
function uni_theme_files()
{
    wp_enqueue_script('uni_theme_js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('google_font', '//fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
    wp_enqueue_style('font_awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
    wp_enqueue_style('uni_theme_main_style', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('uni_theme_extra_style', get_theme_file_uri('/build/index.css'));
}

// Theme setup, generate page titles, register menu
function uni_features()
{
    // Allows generation of page titles in head
    add_theme_support('title-tag');
    // Register menu locations, lets it be edited in WP backend
    register_nav_menu('headerMenuLocation', 'Header Main Menu');
    register_nav_menu('footerMenu1', 'Footer Menu 1');
    register_nav_menu('footerMenu2', 'Footer Menu 2');
}

// Control excerpt length
function custom_excerpt_length($length)
{
    return 50;
}

// Modify default query for events archive page
function uni_adjust_queries($query)
{
    $today = date('Ymd');
    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric',
            )
        ));
    }
}

// Actions/Filters
add_action('wp_enqueue_scripts', 'uni_theme_files');
add_action('after_setup_theme', 'uni_features');
add_filter('excerpt_length', 'custom_excerpt_length', 999);
add_action('pre_get_posts', 'uni_adjust_queries');
