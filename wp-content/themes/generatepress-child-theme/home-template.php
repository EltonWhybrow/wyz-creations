<?php

/**
 * Template Name: Home Template
 * Description: Full-width template that uses only free ACF fields
 */

get_header(); ?>

<!-- Hero Banner -->
<?php get_template_part('parts/hero-banner'); ?>

<!-- Trusted Companies section -->
<?php //get_template_part('parts/trusted-companies'); 
?>


<div class="z-10 relative mx-auto px-5! py-[20px] md:py-30 text-center banner-content container">
    <?php
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
    );

    $products = new WP_Query($args);

    if ($products->have_posts()) :
        echo '<div class="gap-6 grid grid-cols-1 md:grid-cols-4">';
        while ($products->have_posts()) : $products->the_post();
            wc_get_template_part('content', 'product');
        endwhile;
        echo '</div>';
    endif;

    wp_reset_postdata();
    ?>
</div>

<!-- Things go wrong section -->
<?php //   get_template_part('parts/things-go-wrong'); 
?>

<!-- Stats section -->
<?php // get_template_part('parts/stats'); 
?>

<!-- Steps section -->
<?php // get_template_part('parts/steps'); 
?>

<!-- Ready to go section -->
<?php // get_template_part('parts/ready-to-go'); 
?>

<!-- Trusted Travelers section -->
<?php // get_template_part('parts/trusted-travelers'); 
?>

<!-- FAQs section -->
<?php // get_template_part('parts/faqs'); 
?>

<!-- Call to Action section -->
<?php // get_template_part('parts/call-to-action'); 
?>

<?php get_footer(); ?>