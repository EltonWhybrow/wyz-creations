<?php
/**
 * Blog post card — used by home.php loop and the infinite-scroll AJAX handler.
 * Expects the_post() / setup_postdata() to have been called before inclusion.
 */
?>
<article class="p-4 border rounded-lg news-card">

    <?php if (has_post_thumbnail()) : ?>
        <a class="block rounded-lg w-full h-48 overflow-hidden" href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover', 'loading' => 'lazy', 'decoding' => 'async']); ?>
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
