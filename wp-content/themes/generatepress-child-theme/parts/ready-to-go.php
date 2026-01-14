<?php
$ready_title = get_field('ready_title');
$ready_subtitle = get_field('ready_subtitle');
$ready_item_1 = get_field('ready_item_1');
$ready_item_2 = get_field('ready_item_2');
$ready_item_3 = get_field('ready_item_3');
$ready_item_4 = get_field('ready_item_4');
$protect_title = get_field('protect_title');
$protect_price = get_field('protect_price');
$protect_price_per = get_field('protect_price_per');
$protect_list_items = get_field('protect_list_items'); // group field
$protect_button = get_field('protect_button');

$protect_smallprint = get_field('protect_smallprint');


?>
<section class="px-5 py-[60px] md:py-24">
    <div class="mx-auto max-w-6xl container">
        <!-- Main Heading -->
        <div class="mb-12 md:mb-16 md:text-center">
            <h1 class="text-[36px]! md:text-[64px]! font-semibold! text-(--color-truvi-guest-black-chalk) mb-5 md:mb-2!">
                <?php echo esc_html($ready_title); ?>
            </h1>
            <p class="mx-auto! max-w-4xl text-[20px] md:text-[24px]">
                <?php echo esc_html($ready_subtitle); ?>
            </p>
        </div>
    </div>

    <div class="flex lg:flex-row flex-col-reverse gap-[90px] md:gap-20 lg:px-[10vw] pt-5! md:pt-0! included">
        <div class="w-full lg:w-3/5">
            <div class="mb-4 font-semibold text-[15px] text-truvi-guest-dark-gray md:text-lg text-right"><span>Truvi</span><span class="ml-2 md:ml-5">Insurance</span></div>
            <?php
            $ready_items = array(
                $ready_item_1,
                $ready_item_2,
                $ready_item_3,
                $ready_item_4
            );
            ?>

            <ul class="protect-covered">
                <?php foreach ($ready_items as $item): ?>
                    <li>
                        <?php echo esc_html($item); ?>
                        <span class="flex">
                            <img
                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/tick-icon.svg"
                                alt="tick Icon"
                                class="mx-4 md:mx-6 w-8 h-8" />
                            <img
                                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cross-icon.svg"
                                alt="cross Icon"
                                class="mx-4 md:mx-6 w-8 h-8" />
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="mt-12 text-xl md:text-left text-center"> <?php echo esc_html($protect_smallprint); ?></div>
        </div>
        <div class="protect-trip w-full lg:w-2/5 bg-(--color-truvi-guest-black-chalk) text-[var(--color-wyz-guest-white)] rounded-[50px] flex flex-col justify-between p-8 md:p-[50px]">
            <h4 class="md:mb-2.5! text-[32px]! md-5!"><?php echo esc_html($protect_title); ?></h4>
            <h3 class="border-b! border-(--color-truvi-guest-light-gray) text-[64px]! font-semibold font-family-heading inline leading-6! md:leading-none! pb-5!"><?php echo esc_html($protect_price); ?><span class="font-family-heading text-[24px]"><?php echo esc_html($protect_price_per); ?></span></h3>

            <?php
            $protect_list_items = get_field('protect_list_items');

            if ($protect_list_items && is_array($protect_list_items)) :
                // Filter out empty values and get only the list item sub-fields
                $items = array_filter($protect_list_items, function ($value, $key) {
                    // Include items that are strings and not empty
                    // AND whose key starts with 'item_' or contains 'list'
                    return is_string($value) && !empty($value) &&
                        (strpos($key, 'item_') === 0 ||
                            strpos($key, 'list') !== false ||
                            strpos($key, 'feature') !== false);
                }, ARRAY_FILTER_USE_BOTH);

                if (!empty($items)) :
            ?>
                    <ul class="space-y-3 mt-6 mb-6">
                        <?php foreach ($items as $item) : ?>
                            <li class="flex items-start">
                                <img
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/double-check-icon.svg"
                                    alt="tick Icon"
                                    class="mr-4 w-8 h-8" />
                                <span><?php echo esc_html($item); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>



            <!-- Button -->
            <?php if ($protect_button) : ?>
                <div class="mt-8 slide-up">
                    <a
                        href="<?php echo esc_url($protect_button['url']); ?>"
                        target="<?php echo esc_attr($protect_button['target']); ?>"
                        class="mx-auto w-full transition-all duration-300 wyz-btn secondary">
                        <?php echo esc_html($protect_button['title']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>