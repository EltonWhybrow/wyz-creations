<?php
$hero_image = get_field('hero_image');
$title = get_field('title');
$subtitle = get_field('sub_title');
$button_link = get_field('button_link');
$button_link = get_field('button_link');
$button_link_2 = get_field('button_link_2');
$guests_protected = get_field('guests_protected');

// Extract guests protected group
$guests_title = $guests_protected['title'] ?? '';
$guests_subtitle = $guests_protected['guest_sub_title'] ?? 'otherwise';
$guest_1 = $guests_protected['guest_1'] ?? '';
$guest_2 = $guests_protected['guest_2'] ?? '';
$guest_3 = $guests_protected['guest_3'] ?? '';
?>

<section class="relative justify-center h-[calc(100vh-160px)] overflow-hidden hero-banner">

    <?php $video = get_field('video'); ?>

    <?php if ($video): ?>
        <div class="absolute w-full">
            <video
                autoplay
                loop
                muted
                playsinline
                class="w-full h-[calc(100vh-160px)] object-cover">
                <source src="<?php echo esc_url($video['url']); ?>" type="<?php echo esc_attr($video['mime_type']); ?>">
            </video>


            <!-- Overlay -->
            <div class="z-1 absolute inset-0 bg-black/60"></div>

            <!-- Main Content Container -->
            <div class="bottom-6! left-12! z-10 flex flex-col pt-14 pb-[60px] text-left absolute! banner-content">

                <?php if ($subtitle) : ?>
                    <p class="mb-0! ml-1! text-[18px] text-wyz-guest-white/90 lg:text-2xl leading-normal! slide-up">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>


                <?php if ($title) : ?>
                    <h1 class="stagger-words">
                        <?php echo esc_html($title); ?>
                    </h1>
                <?php endif; ?>



                <!-- CTA buttons -->
                <div class="flex flex-wrap gap-2">
                    <?php if ($button_link) : ?>

                        <a
                            href="<?php echo esc_url($button_link['url']); ?>"
                            target="<?php echo esc_attr($button_link['target']); ?>"
                            class="group relative wyz-btn btn-lg primary">
                            <?php echo esc_html($button_link['title']); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($button_link_2) : ?>
                        <a
                            href="<?php echo esc_url($button_link_2['url']); ?>"
                            target="<?php echo esc_attr($button_link_2['target']); ?>"
                            class="group relative wyz-btn btn-lg secondary">
                            <?php echo esc_html($button_link_2['title']); ?>
                        </a>

                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <!-- hero image -->
    <?php if ($hero_image) : ?>




        <div
            class="z-0 absolute inset-0 my-2 overflow-hidden"
            style="background:  linear-gradient(
    180deg,
    rgba(0, 0, 0, 0.75) 0%,
    rgba(0, 0, 0, 0.6) 70%,
    rgba(0, 0, 0, 0) 100%
  ), url('<?php echo esc_url($hero_image['url']); ?>') 55% 75% / cover no-repeat;">


            <!-- Main Content Container -->
            <div class="bottom-6! left-12! z-10 flex flex-col pt-14 pb-[60px] text-left absolute! banner-content">

                <?php if ($subtitle) : ?>
                    <p class="mb-0! ml-1! text-[18px] text-wyz-guest-white/90 lg:text-2xl leading-normal! slide-up">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>


                <?php if ($title) : ?>
                    <h1 class="stagger-words">
                        <?php echo esc_html($title); ?>
                    </h1>
                <?php endif; ?>



                <!-- CTA buttons -->
                <div class="flex flex-wrap gap-2">
                    <?php if ($button_link) : ?>

                        <a
                            href="<?php echo esc_url($button_link['url']); ?>"
                            target="<?php echo esc_attr($button_link['target']); ?>"
                            class="group relative wyz-btn btn-lg primary">
                            <?php echo esc_html($button_link['title']); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($button_link_2) : ?>
                        <a
                            href="<?php echo esc_url($button_link_2['url']); ?>"
                            target="<?php echo esc_attr($button_link_2['target']); ?>"
                            class="group relative wyz-btn btn-lg secondary">
                            <?php echo esc_html($button_link_2['title']); ?>
                        </a>

                    <?php endif; ?>
                </div>
            </div>


        </div>






    <?php endif; ?>






    </div>

    <!-- Scroll Indicator -->
    <div class="hidden md:block bottom-8 left-1/2 z-10 absolute -translate-x-1/2 animate-bounce transform">
        <a href="#category-anchor">
            <svg class="w-8 h-8 text-[var(--color-wyz-guest-white)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </a>

    </div>
</section>