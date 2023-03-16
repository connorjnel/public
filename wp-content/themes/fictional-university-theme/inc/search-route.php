<?php
add_action('rest_api_init', 'university_register_search');

function university_register_search()
{
    register_rest_route('university/v1', 'custom_search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
}

// Function selecting data for API
function universitySearchResults()
{
    return ' Congrats, you created a route';
}
