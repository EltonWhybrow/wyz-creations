<?php

/**
 * Template Name: Home Template
 * Description: Full-width template that uses only free ACF fields
 */

get_header(); ?>

<!-- Hero Banner -->
<?php get_template_part('parts/hero-banner'); ?>

<!-- Categroy Upsell -->
<?php get_template_part('parts/category-upsell'); ?>

<!-- Trusted Companies section -->
<?php // get_template_part('parts/trusted-companies');
?>

<!-- Stats section -->
<? //php // get_template_part('parts/stats');
?>



<!-- Ready to go section -->
<?php // get_template_part('parts/ready-to-go');
?>

<!-- Best Seller section -->
<?php get_template_part('parts/best-sellers');
?>

<!-- Socail media strip -->
<?php get_template_part('parts/socials');
?>


<!-- Call to Action section -->
<?php get_template_part('parts/call-to-action');
?>

<!-- Reviews section -->
<?php get_template_part('parts/feedback');
?>

<!-- Call to Action section -->
<?php get_template_part('parts/category-cta');
?>


<?php get_footer(); ?>