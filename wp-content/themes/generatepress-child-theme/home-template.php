<?php

/**
 * Template Name: Home Template
 * Description: Full-width template that uses only free ACF fields
 */

get_header(); ?>

<!-- Hero Banner -->
<?php get_template_part('parts/hero-banner'); ?>

<!-- Trusted Companies section -->
<?php get_template_part('parts/trusted-companies'); ?>

<!-- Things go wrong section -->
<?php get_template_part('parts/things-go-wrong'); ?>

<!-- Stats section -->
<?php get_template_part('parts/stats'); ?>

<!-- Steps section -->
<?php get_template_part('parts/steps'); ?>

<!-- Ready to go section -->
<?php get_template_part('parts/ready-to-go'); ?>

<!-- Trusted Travelers section -->
<?php get_template_part('parts/trusted-travelers'); ?>

<!-- FAQs section -->
<?php get_template_part('parts/faqs'); ?>

<!-- Call to Action section -->
<?php get_template_part('parts/call-to-action'); ?>

<?php get_footer(); ?>