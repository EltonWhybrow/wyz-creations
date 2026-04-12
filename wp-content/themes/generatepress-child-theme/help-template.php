<?php

/**
 * Template Name: Help Template
 * Description: Full-width template that uses only free ACF fields
 */



get_header(); ?>

<!-- Hero Banner -->
<?php // get_template_part('parts/hero-banner'); 
?>
<div class="content-area" id="primary">
    <main class="pt-8 site-main" id="main">

        <?php the_content(); ?>

        <!-- FAQs section -->
        <?php get_template_part('parts/faqs');
        ?>

    </main>
</div>






<?php get_footer(); ?>