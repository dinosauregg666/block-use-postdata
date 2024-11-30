<?php

function generateHTML($id) {

    $post = new WP_Query(array(
        'post_type' => 'post',
        'p' => $id
    ));

    while($post -> have_posts()) {
        $post -> the_post();
        ob_start(); ?>
            <div>
                <div style="width: 200px; height: 200px; background-image: url(<?php the_post_thumbnail_url(); ?>);"></div>
                <div>
                    <h5><?php echo esc_html(the_title()); ?></h5>
                    <p><?php echo wp_trim_words(get_the_content(),30); ?></p>
                </div>
            </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }
}