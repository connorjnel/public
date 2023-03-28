<!-- My Notes Page Template -->

<?php

// Redirect user to homepage if not logged in
if (!is_user_logged_in()) {
    esc_url((wp_redirect('/')));
    exit;
};

get_header();

while (have_posts()) {
    the_post();
    pageBanner(array(
        'title' => 'My Custom Notes',
        'subtitle' => 'Keep all your notes organised in one spot',
        'photo' => 'https://images.unsplash.com/photo-1527345931282-806d3b11967f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80'
    )); ?>

    <div class="container container--narrow page-section">

        <ul class="min-list link-list" id="my-notes">
            <?php $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => -1,
                'author' => get_current_user_id(),
            ));

            while ($userNotes->have_posts()) {
                $userNotes->the_post(); ?>

                <li data-id="<?php the_ID(); ?>">
                    <input readonly class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                </li>

            <?php }

            ?>
        </ul>

    </div>

<?php
}

get_footer();

?>