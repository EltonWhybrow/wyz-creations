<?php

$split_heading   = get_sub_field('split_heading');
$split_image     = get_sub_field('split_image');
$split_paragraph = get_sub_field('split_paragraph');
$split_content   = get_sub_field('split_content');
$split_button    = get_sub_field('split_button');
$split_flip      = (bool) get_sub_field('split_flip');
?>

<section id="call-to-action-split" class="px-5 lg:px-20 py-[50px] md:py-[100px] call-to-action-split">
    <div class="items-center gap-8 md:gap-16 grid grid-cols-1 md:grid-cols-2 mx-auto max-w-7xl">

        <div class="<?php echo $split_flip ? 'md:order-2' : 'md:order-1'; ?>">
            <?php if ($split_image) : ?>
                <div class="rounded-[35px] w-full overflow-hidden scale-hover">
                    <img
                        src="<?php echo esc_url($split_image['url']); ?>"
                        alt="<?php echo esc_attr($split_image['alt'] ?? ''); ?>"
                        class="w-full h-[300px] md:h-[480px] object-cover"
                        loading="lazy">
                </div>
            <?php endif; ?>
        </div>

        <div class="flex flex-col call-to-action-split-content <?php echo $split_flip ? 'md:order-1' : 'md:order-2'; ?>">
            <?php if ($split_heading) : ?>
                <h2 class="mb-4 font-semibold text-[32px] md:text-[44px] leading-tight">
                    <?php echo esc_html($split_heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($split_paragraph) : ?>
                <p class="mb-4 text-[18px] md:text-xl leading-relaxed">
                    <?php echo esc_html($split_paragraph); ?>
                </p>
            <?php endif; ?>

            <?php if ($split_content) : ?>
                <div class="mb-6">
                    <?php echo apply_filters('the_content', $split_content); ?>
                </div>
            <?php endif; ?>

            <?php if ($split_button) : ?>
                <div class="mt-2 slide-up">
                    <a
                        href="<?php echo esc_url($split_button['url']); ?>"
                        target="<?php echo esc_attr($split_button['target'] ?: '_self'); ?>"
                        class="inline-block wyz-btn btn-lg primary">
                        <?php echo esc_html($split_button['title']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>
