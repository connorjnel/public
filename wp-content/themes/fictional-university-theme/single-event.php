<!-- Single Event Post Template -->

<?php

get_header();

while (have_posts()) {
    the_post(); ?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title() ?></h1>
            <div class="page-banner__intro">
                <!--TODO Add call for custom field sub title -->
                <p>DONT FORGET TO REPLACE</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">

        <div class="post-item">
            <h2><?php the_title(); ?></h2>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true">
                        </i> Events Home</a>
                    <span class="metabox__main"> Event Date:
                        <?php
                        $eventDate = new DateTime(get_field('event_date'));
                        echo $eventDate->format('M d Y');
                        ?>
                    </span>
                </p>
            </div>
            <div class="generic-content">
                <p><?php the_content(); ?></p>
            </div>
        </div>

    </div>


<?php }
get_footer();
?>