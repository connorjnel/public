<!-- Search results page -->
<?php
$bannerImage =  esc_url(site_url('/')) . '/wp-content/uploads/2023/03/markus-winkler-afW1hht0NSs-unsplash-1500x350.jpg';

get_header();
pageBanner(array(
    'title' => 'Search Results',
    'subtitle' => 'You searched for &ldquo;' . get_search_query() . '&rdquo;',
    'photo' => $bannerImage,
));
?>


<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post(); ?>

        <div class="post-item">
            <h2><a href="<?php the_permalink(); ?>" class="headline headline--medium headline--post-title"><?php the_title(); ?></a></h2>
            <div class="metabox">
                <p>Posted By: <?php the_author_posts_link(); ?> on: <?php the_time('d.m.y.h:i a'); ?> in <?php echo get_the_category_list(', '); ?></p>
            </div>
            <div class="generic-content">
                <p><?php the_excerpt(); ?></p>
                <p><a href="<?php echo the_permalink(); ?>" class="btn btn--blue">Continue Reading</a></p>
            </div>
        </div>

    <?php }
    echo paginate_links();
    ?>
</div>

<?php
get_footer();
?>