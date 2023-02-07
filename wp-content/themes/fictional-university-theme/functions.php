<?php 

// Load main stylesheet
function uni_theme_files() {
    wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
    wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
    wp_enqueue_style( 'uni_theme_main_style', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style( 'uni_theme_extra_style', get_theme_file_uri('/build/index.css'));

}

// Fire/Call functions
add_action('wp_enqueue_scripts', 'uni_theme_files');