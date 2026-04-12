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
    <main class="pt-8 site-main" id="main">


        <?php
        // WooCommerce breadcrumbs
        if (function_exists('woocommerce_breadcrumb')) {
            woocommerce_breadcrumb([
                'wrap_before' => '<nav class="mb-[1em] text-[.92em] text-[#767676] CUSTOM-woocommerce-breadcrumb">',
                'wrap_after'  => '</nav>',
            ]);
        }
        ?>

        <!-- Page Title -->
        <h1 class="mb-[1em] CUSTOM-woocommerce-products-header">Your <?php the_title(); ?></h1>


        <?php
        if (!empty($favourites)) {

            $args = [
                'post_type' => 'product',
                'post__in'  => $favourites,
                'orderby'   => 'post__in'
            ];

            $loop = new WP_Query($args);

            do_action('woocommerce_before_shop_loop');

            echo '<div class="gap-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">';

            while ($loop->have_posts()) : $loop->the_post();
                echo '<div class="product-item" data-product-id="' . get_the_ID() . '">';
                wc_get_template_part('content', 'product');
                echo '</div>';
            endwhile;

            echo '</div>';

            do_action('woocommerce_after_shop_loop');

            wp_reset_postdata();
        } else {
            echo '<p class="text-gray-500">No favourites yet.</p>';
        }
        ?>
    </main>
</div>
<?php

get_footer();
