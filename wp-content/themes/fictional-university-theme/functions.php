<?php 

// Load main stylesheet
function uni_theme_files() {
    wp_enqueue_style( 'uni_theme_mainstyle', get_stylesheet_uri());
}

// Fire/Call functions
add_action('wp_enqueue_scripts', 'uni_theme_files');