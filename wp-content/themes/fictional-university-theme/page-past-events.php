<?php
get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'Recap of our past events.',
    'photo' => 'https://images.unsplash.com/photo-1536008758366-72fbc5b16911?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80'
));
?>

<div class="container container--narrow page-section">
    <?php

    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1),
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'compare' => '<=',
                'value' => $today,
                'type' => 'numeric',
            )
        )
    ));

    while ($pastEvents->have_posts()) {
        $pastEvents->the_post();
        get_template_part('/template-parts/content', get_post_type());
    }
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages,
    ));
    ?>
</div>

<?php
get_footer();
?>