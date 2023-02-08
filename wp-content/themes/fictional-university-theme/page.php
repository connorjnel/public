<!-- Single Page Template -->

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

        <?php

        // Check if current page has a parent page
        $hasParent = wp_get_post_parent_id(get_the_ID());

        if ($hasParent == True) { ?>

            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($hasParent) ?>"><i class="fa fa-home" aria-hidden="true">
                        </i> Back to <?php echo get_the_title($hasParent) ?></a> <span class="metabox__main"><?php the_title() ?></span>
                </p>
            </div>

        <?php }
        ?>


        <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink($hasParent) ?>"><?php echo get_the_title($hasParent) ?></a></h2>
            <ul class="min-list">
                <?php

                if ($hasParent == True) {
                    $findChildrenOf = $hasParent;
                } else {
                    $findChildrenOf = get_the_ID();
                }

                wp_list_pages(array(
                    'title_li' => NULL,
                    'child_of' => $findChildrenOf,
                ));
                ?>
            </ul>
        </div>

        <div class="generic-content">
            <?php the_content() ?>
        </div>
    </div>

<?php
}

get_footer();

?>