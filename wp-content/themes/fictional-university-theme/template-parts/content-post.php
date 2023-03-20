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