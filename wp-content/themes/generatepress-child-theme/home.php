<?php get_header(); ?>


<div class="content-area news-page" id="primary">



    <!-- Page Title -->
    <h1><?php echo single_post_title('', false); ?></h1>

    <?php if (have_posts()) : ?>

        <div id="blog-posts-grid" class="gap-8 grid grid-cols-1 md:grid-cols-2">

            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('parts/blog-card'); ?>
            <?php endwhile; ?>

        </div>

        <?php global $wp_query; $blog_max_pages = (int) $wp_query->max_num_pages; ?>
        <div id="blog-infinite-sentinel" class="w-full"<?php if ($blog_max_pages > 1): ?> data-max-pages="<?php echo $blog_max_pages; ?>"<?php endif; ?>></div>
        <div id="blog-infinite-loader" class="hidden py-10 w-full text-center">
            <span class="inline-block rounded-full w-10 h-10 animate-spin" style="border: 4px solid var(--color-wyz-creations-guest-orange); border-top-color: transparent;"></span>
        </div>

    <?php else : ?>

        <p>No news found.</p>

    <?php endif; ?>




</div>


<?php
// Page Builder sections for the News/blog page, rendered full width above
// the post grid (which always still renders below regardless of whether
// any sections are configured — the grid is the page's actual content).
if (function_exists('wyzcreations_news_page_has_builder_rows') && wyzcreations_news_page_has_builder_rows()) :
    $news_page_id = (int) get_option('page_for_posts');
    $layouts = wyzcreations_home_builder_layouts();
    while (have_rows('home_page_builder', $news_page_id)) : the_row();
        $layout = get_row_layout();
        if (isset($layouts[$layout])) {
            get_template_part('parts/' . $layouts[$layout]);
        }
    endwhile;
endif;
?>



<?php get_footer(); ?>