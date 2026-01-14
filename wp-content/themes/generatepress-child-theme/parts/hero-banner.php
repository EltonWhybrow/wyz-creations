<?php
$hero_image = get_field('hero_image');
$title = get_field('title');
$subtitle = get_field('sub_title');
$button_link = get_field('button_link');
$guests_protected = get_field('guests_protected');

// Extract guests protected group
$guests_title = $guests_protected['title'] ?? '';
$guests_subtitle = $guests_protected['guest_sub_title'] ?? 'otherwise';
$guest_1 = $guests_protected['guest_1'] ?? '';
$guest_2 = $guests_protected['guest_2'] ?? '';
$guest_3 = $guests_protected['guest_3'] ?? '';
?>

<section class="relative flex justify-center items-center mx-auto overflow-hidden hero-banner">

    <?php if ($hero_image) : ?>
        <div
            class="z-0 absolute inset-0 mx-5 md:mx-[50px] my-2 rounded-[50px] overflow-hidden"
            style="background: linear-gradient(180deg, rgba(161, 73, 1, 0.75) 0%, rgba(73, 64, 54, 0) 100%), url('<?php echo esc_url($hero_image['url']); ?>') 55% 75% / cover no-repeat;">
        </div>
    <?php endif; ?>

    <!-- Main Content Container -->
    <div class="z-10 relative mx-auto px-5! py-[30px] md:py-40 text-center banner-content container">
        <?php if ($title) : ?>
            <h1 class="mb-2.5! px-4! md:px-0! pt-2.5! stagger-words">
                <?php echo esc_html($title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($subtitle) : ?>
            <p class="mx-auto! mb-3 px-5! max-w-4xl text-[18px] text-[var(--color-wyz-guest-white)]/90 lg:text-2xl text-center leading-normal! slide-up">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>

        <!-- Button desktop -->
        <?php if ($button_link) : ?>
            <div class="hidden md:block my-8 slide-up">
                <a
                    href="<?php echo esc_url($button_link['url']); ?>"
                    target="<?php echo esc_attr($button_link['target']); ?>"
                    class="group relative bg-[var(--color-truvi-guest-black-chalk)] mx-auto w-fit overflow-hidden text-[var(--color-wyz-guest-white)]! transition-all duration-300 wyz-btn">
                    <span class="absolute inset-0 bg-[var(--color-wyz-guest-white)] rounded-full transition-transform -translate-x-[100%] group-hover:translate-x-0 duration-400"></span>
                    <span class="z-10 group-hover:text-black"> <?php echo esc_html($button_link['title']); ?></span>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($guests_title || $guests_subtitle || $guest_1 || $guest_2 || $guest_3) : ?>
            <div class="flex justify-center items-center gap-4 mx-auto">

                <div class="flex justify-center items-center -space-x-4">
                    <?php if ($guest_1) : ?>
                        <div class="z-10 relative">
                            <div class="shadow-lg border-2 border-white rounded-full w-10 h-10 overflow-hidden">
                                <img
                                    src="<?php echo esc_url($guest_1['url']); ?>"
                                    alt="<?php echo esc_attr($guest_1['alt']); ?>"
                                    class="w-full h-full object-cover" />
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($guest_2) : ?>
                        <div class="z-20 relative">
                            <div class="shadow-lg border-2 border-white rounded-full w-10 h-10 overflow-hidden">
                                <img
                                    src="<?php echo esc_url($guest_2['url']); ?>"
                                    alt="<?php echo esc_attr($guest_2['alt']); ?>"
                                    class="w-full h-full object-cover" />
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($guest_3) : ?>
                        <div class="z-30 relative">
                            <div class="shadow-lg border-2 border-white rounded-full w-10 h-10 overflow-hidden">
                                <img
                                    src="<?php echo esc_url($guest_3['url']); ?>"
                                    alt="<?php echo esc_attr($guest_3['alt']); ?>"
                                    class="w-full h-full object-cover" />
                            </div>
                        </div>
                    <?php endif; ?>
                </div>


                <div class="text-left">
                    <?php if ($guests_title) : ?>
                        <h3 class="!mb-0 font-semibold text-[var(--color-wyz-guest-white)] !text-base md:text-3xl">
                            <?php echo esc_html($guests_title); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ($guests_subtitle) : ?>
                        <p class="!mb-0 text-[var(--color-wyz-guest-white)] text-base">
                            <?php echo esc_html($guests_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Button mobile -->
        <?php if ($button_link) : ?>
            <div class="md:hidden block my-2.5 md:my-8 px-5 slide-up">
                <a
                    href="<?php echo esc_url($button_link['url']); ?>"
                    target="<?php echo esc_attr($button_link['target']); ?>"
                    class="mx-auto w-full md:w-fit transition-all duration-300 wyz-btn secondary">
                    <?php echo esc_html($button_link['title']); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Scroll Indicator -->
    <div class="hidden md:block bottom-8 left-1/2 z-10 absolute -translate-x-1/2 animate-bounce transform">
        <a href="#things-go-wrong">
            <svg class="w-8 h-8 text-[var(--color-wyz-guest-white)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </a>

    </div>
</section>