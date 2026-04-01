<?php
/* Template Name: Favourites */
get_header();

if (is_user_logged_in()) {
    $favourites = get_user_meta(get_current_user_id(), 'favourites', true);
} else {
    $favourites = isset($_COOKIE['favourites'])
        ? json_decode(stripslashes($_COOKIE['favourites']), true)
        : [];
}
?>
<div class="content-area" id="primary">
    <?php
    if (!empty($favourites)) {

        $args = [
            'post_type' => 'product',
            'post__in'  => $favourites
        ];

        $loop = new WP_Query($args);

        echo '<div class="gap-6 grid grid-cols-2 md:grid-cols-4">';

        while ($loop->have_posts()) : $loop->the_post();
            wc_get_template_part('content', 'product');
        endwhile;

        echo '</div>';
    } else {
        echo '<p class="text-gray-500">No favourites yet.</p>';
    }
    ?>
</div>
<?php

get_footer();
