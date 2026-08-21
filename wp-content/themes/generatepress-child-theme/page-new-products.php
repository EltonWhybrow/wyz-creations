<?php

/**
 * Template Name: New Products
 */

get_header();
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
        <h1 class="mb-[1em] CUSTOM-woocommerce-products-header"><?php the_title(); ?></h1>

        <?php
        // Custom query for latest products
        $paged = max(1, get_query_var('paged'));
        $args = [
            'post_type'      => 'product',
            'posts_per_page' => 16,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'paged'          => $paged,
        ];

        $loop = new WP_Query($args);

        if ($loop->have_posts()) :

            // Optional: WooCommerce result count + sorting
            do_action('woocommerce_before_shop_loop');

            // Start product loop wrapper
            echo '<div class="gap-2 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">';

            while ($loop->have_posts()) : $loop->the_post();
                wc_get_template_part('content', 'product');
            endwhile;

            echo '</div>';

            // Optional: WooCommerce pagination
            do_action('woocommerce_after_shop_loop');

        else :
            echo '<p>No new products found.</p>';
        endif;

        wp_reset_postdata();
        ?>

    </main>
</div>

<?php
// Page Builder sections, rendered full width below the product grid —
// outside the boxed #primary wrapper, matching how sections render
// everywhere else on the site.
if (have_rows('home_page_builder')) :
    $layouts = wyzcreations_home_builder_layouts();
    while (have_rows('home_page_builder')) : the_row();
        $layout = get_row_layout();
        if (isset($layouts[$layout])) {
            get_template_part('parts/' . $layouts[$layout]);
        }
    endwhile;
endif;
?>

<?php get_footer(); ?>