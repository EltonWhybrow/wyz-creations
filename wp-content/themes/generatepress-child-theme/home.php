<?php get_header(); ?>

<div class="content-area news-page" id="primary">



    <!-- Page Title -->
    <h1><?php echo single_post_title('', false); ?></h1>

    <?php if (have_posts()) : ?>

        <div class="gap-8 grid grid-cols-1 md:grid-cols-2">

            <?php while (have_posts()) : the_post(); ?>

                <article class="p-4 border rounded-lg news-card">

                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-auto']); ?>
                        </a>
                    <?php endif; ?>

                    <h2 class="mt-4 font-semibold text-xl">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <p class="mt-2 text-gray-500 text-sm">
                        <?php echo get_the_date(); ?>
                    </p>

                    <div class="mt-3 text-base">
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </div>

                </article>

            <?php endwhile; ?>

        </div>

        <div class="mt-10">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else : ?>

        <p>No news found.</p>

    <?php endif; ?>




</div>



<?php get_footer(); ?>