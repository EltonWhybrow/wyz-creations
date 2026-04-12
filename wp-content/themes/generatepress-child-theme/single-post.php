<?php get_header(); ?>

<div class="single-p-page content-area" id="primary">


    <?php while (have_posts()) : the_post(); ?>

        <article>

            <h1 class="mb-4 font-bold text-4xl">
                <?php the_title(); ?>
            </h1>

            <p class="mb-8 text-gray-500">
                <?php echo get_the_date(); ?>
            </p>

            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded-lg']); ?>
                </div>
            <?php endif; ?>

            <div class="max-w-none prose">
                <?php the_content(); ?>
            </div>

            <div class="flex justify-between mt-12 pt-6 border-t post-navigation">

                <div class="prev-post">
                    <?php previous_post_link(
                        '%link',
                        '← Previous Post<br><span class="opacity-70 text-sm">%title</span>'
                    ); ?>
                </div>

                <div class="text-right next-post">
                    <?php next_post_link(
                        '%link',
                        'Next Post →<br><span class="opacity-70 text-sm">%title</span>'
                    ); ?>
                </div>

            </div>

        </article>

    <?php endwhile; ?>




</div>

<?php get_footer(); ?>