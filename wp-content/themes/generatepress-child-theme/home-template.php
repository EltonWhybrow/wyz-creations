<?php

/**
 * Template Name: Home Template
 * Description: Full-width template that uses only free ACF fields
 */

get_header();

// Sections and their order are controlled by the "Sections" flexible
// content field (see inc/acf-home-flexible-content.php). Falls back to
// the original fixed order if that field hasn't been set up on this page yet.
$home_builder_layouts = wyzcreations_home_builder_layouts();

if (have_rows('home_page_builder')) :
    while (have_rows('home_page_builder')) : the_row();
        $layout = get_row_layout();
        if (isset($home_builder_layouts[$layout])) {
            get_template_part('parts/' . $home_builder_layouts[$layout]);
        }
    endwhile;
else :
    get_template_part('parts/hero-banner');
    get_template_part('parts/category-upsell');
    get_template_part('parts/best-sellers');
    get_template_part('parts/socials');
    get_template_part('parts/call-to-action');
    get_template_part('parts/feedback');
    get_template_part('parts/category-cta');
endif;

get_footer(); ?>