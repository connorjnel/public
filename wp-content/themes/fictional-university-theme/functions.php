<?php

// Add search route php
include get_theme_file_path('inc/search-route.php');

// Custom page banner and title, subtitle function
function pageBanner($args = NULL)
{
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }

    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }

?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: 
        url(<?php echo $args['photo']; ?>);">
        </div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><? echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div>

<?php }

// Load stylesheets, js scripts, font files
function uni_theme_files()
{
    wp_enqueue_script('uni_theme_js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

    // Disabled due to not having API Key
    // wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyCFTn3ZxEnJDlEBTLR-bXyFRkiWxNZqvwk', NULL, '1.0', true);

    wp_enqueue_style('google_font', '//fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
    wp_enqueue_style('font_awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
    wp_enqueue_style('uni_theme_main_style', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('uni_theme_extra_style', get_theme_file_uri('/build/index.css'));

    wp_localize_script('uni_theme_js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}

// Theme setup, generate page titles, register menu
function uni_features()
{
    // Allows generation of page titles in head
    add_theme_support('title-tag');
    // Allow featured images
    add_theme_support('post-thumbnails');
    // Add custom thumbail sizes
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    // Register menu locations, lets it be edited in WP backend
    register_nav_menu('headerMenuLocation', 'Header Main Menu');
    register_nav_menu('footerMenu1', 'Footer Menu 1');
    register_nav_menu('footerMenu2', 'Footer Menu 2');
}

// Control excerpt length - better to use echo wp_trim_words(get_the_content(), 14);
function custom_excerpt_length($length)
{
    return 50;
}

// Modify default query 
function uni_adjust_queries($query)
{
    // Modify default query on program archive page
    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1); // Always show all posts
    }

    //Modify default query on events archive page to only show upcoming events
    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
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

// Customize REST API
function university_custom_rest()
{
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {
            return get_the_author();
        }
    ));
}

// Add API key for ACF Google Maps -  Disabled
// function uniMapKey($api)
// {
//     $api['key'] = '';
//     return $api;
// };

// Function to redirect subs to frontend
function redirectSubsToFrontend()
{
    $ourCurrentUser = wp_get_current_user();

    if (count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

// Function to remove admin bar for subscribers
function no_subs_admin_bar()
{
    $current_user = wp_get_current_user();
    if (count($current_user->roles) == 1 && $current_user->roles[0] == 'subscriber') {
        add_filter('show_admin_bar', '__return_false');
    }
}

// Custom link for login page logo link
function ourHeaderUrl()
{
    return esc_url(site_url('/'));
}

// Custom login page add custom css
function customLoginCSS()
{
    wp_enqueue_style('google_font', '//fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap');
    wp_enqueue_style('font_awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
    wp_enqueue_style('uni_theme_main_style', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('uni_theme_extra_style', get_theme_file_uri('/build/index.css'));
}

// Change login page header text
function loginTitle()
{
    return get_bloginfo('name');
}


// Actions/Filters/Hooks
add_action('wp_enqueue_scripts', 'uni_theme_files');
add_action('after_setup_theme', 'uni_features');
add_filter('excerpt_length', 'custom_excerpt_length', 999);
add_action('pre_get_posts', 'uni_adjust_queries');

// Disabled due to not having API key
// add_filter('acf/fields/google_map/api', 'uniMapKey'); 

// Customize REST API
add_action('rest_api_init', 'university_custom_rest');

// Redirect subscriber account out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

// Disable admin bar for subscribers
add_action('wp_loaded', 'no_subs_admin_bar');

// Customize login screen
add_filter('login_headerurl', 'ourHeaderUrl');

// Load CSS on login screen
add_action('login_enqueue_scripts', 'customLoginCSS');

// Change Powered by Wordpress on login screen
add_filter('login_headertitle', 'loginTitle');
