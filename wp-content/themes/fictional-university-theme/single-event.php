<!-- Single Event Post Template -->

<?php

get_header();

while (have_posts()) {
    the_post();
    pageBanner(); ?>



    <div class="container container--narrow page-section">

        <div class="post-item">
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

            <?php
            $relatedPrograms = get_field('related_programs');
            if ($relatedPrograms) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
                echo '<ul class="link-list min-list">';
                foreach ($relatedPrograms as $program) { ?>
                    <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program) ?></a></li>
            <?php }
                echo '</ul>';
            }
            ?>
        </div>

    </div>


<?php }
get_footer();
?>