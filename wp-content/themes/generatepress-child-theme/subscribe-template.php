<?php

/**
 * Template Name: Subscribe
 */

get_header();
?>

<div class="content-area" id="primary">
    <main class="pt-8 site-main" id="main">

        <!-- Page Title -->
        <h1><?php the_title(); ?></h1>

        <?php
        set_query_var('page_content', get_the_content());
        get_template_part('parts/form-split');
        ?>
    </main>
</div>

<?php get_footer(); ?>