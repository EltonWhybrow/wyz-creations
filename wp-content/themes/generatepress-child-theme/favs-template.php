<?php
/* Template Name: Wish List */
get_header();

$wishlist = wyzcreations_get_stored_wishlist();
?>
<div class="content-area" id="primary">
    <main class="pt-8 site-main" id="main">


        <!-- Page Title -->
        <h1 class="mb-[1em] CUSTOM-woocommerce-products-header"><?php the_title(); ?></h1>

        <?php if (!is_user_logged_in()): ?>
            <div class="mb-6">
                <p class="mb-1.5! text-xs text-wyzc-brown">Your Wish List is only saved on this device and will expire in 14 days. Sign in to save permanently — your account is created at first checkout.</p>
                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="wyz-btn btn-xs inline-flex" style="background:var(--color-wyz-creations-guest-black-chalk);color:#fff;border-color:var(--color-wyz-creations-guest-black-chalk);">Sign In</a>
            </div>
        <?php endif; ?>

        <?php
        if (!empty($wishlist)) {

            $args = [
                'post_type' => 'product',
                'post__in'  => $wishlist,
                'orderby'   => 'post__in'
            ];

            $loop = new WP_Query($args);

            do_action('woocommerce_before_shop_loop');

            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'wyzcreations_favs_large_thumbnail', 10);

            echo '<div class="gap-2 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">';

            while ($loop->have_posts()) : $loop->the_post();
                echo '<div class="product-item" data-product-id="' . get_the_ID() . '">';
                wc_get_template_part('content', 'product');
                echo '</div>';
            endwhile;

            echo '</div>';

            remove_action('woocommerce_before_shop_loop_item_title', 'wyzcreations_favs_large_thumbnail', 10);
            add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

            do_action('woocommerce_after_shop_loop');

            wp_reset_postdata();
        } else {
            echo '<p class="text-gray-500">Your Wish List is empty.</p>';
        }
        ?>
    </main>
</div>
<?php

get_footer();
