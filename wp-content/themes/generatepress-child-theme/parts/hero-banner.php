<?php
$hero_image   = wyzcreations_builder_field('hero_image');
$video        = wyzcreations_builder_field('video');
$video_loop   = wyzcreations_builder_field('video_loop');
$title        = wyzcreations_builder_field('title');
$subtitle     = wyzcreations_builder_field('sub_title');
$button_link     = wyzcreations_builder_field('button_link');
$button_link_2   = wyzcreations_builder_field('button_link_2');
$overlay_opacity = wyzcreations_builder_field('overlay_opacity');
$overlay_opacity = ($overlay_opacity !== '' && $overlay_opacity !== false) ? (int) $overlay_opacity : 75;
$opacity_top     = round($overlay_opacity / 100, 2);
$opacity_mid     = round($overlay_opacity * 0.8 / 100, 2);

$hero_image_mobile    = wyzcreations_builder_field('hero_image_mobile');
$hero_mobile_center   = wyzcreations_builder_field('hero_mobile_center');
$hero_image_url       = $hero_image['url'] ?? '';
$hero_image_id        = $hero_image['id']  ?? 0;
$hero_image_mobile_id = $hero_image_mobile['id'] ?? 0;
?>

<section class="relative justify-center h-[calc(100vh-160px)] overflow-hidden hero-banner">

    <!-- Hero image: rendered immediately as the LCP element — no spinner,
         no opacity-0. fetchpriority=high tells the browser to fetch it
         as early as possible. wp_get_attachment_image supplies srcset. -->
    <?php if ($hero_image_id) : ?>
        <div class="z-0 absolute inset-0 overflow-hidden hero-banner-image-wrap">
            <?php if ($hero_image_mobile_id) :
                $mobile_src    = wp_get_attachment_image_url($hero_image_mobile_id, 'full');
                $mobile_srcset = wp_get_attachment_image_srcset($hero_image_mobile_id, 'full');
            ?>
                <picture class="absolute inset-0 w-full h-full">
                    <source
                        media="(max-width: 767px)"
                        srcset="<?php echo esc_attr($mobile_srcset ?: $mobile_src); ?>"
                        sizes="100vw">
                    <?php echo wp_get_attachment_image($hero_image_id, 'full', false, [
                        'class'         => 'absolute inset-0 w-full h-full object-cover hero-banner-image',
                        'style'         => 'object-position: 55% 75%;',
                        'fetchpriority' => 'high',
                        'loading'       => 'eager',
                        'decoding'      => 'async',
                        'sizes'         => '100vw',
                        'alt'           => '',
                    ]); ?>
                </picture>
            <?php else : ?>
                <?php echo wp_get_attachment_image($hero_image_id, 'full', false, [
                    'class'         => 'absolute inset-0 w-full h-full object-cover hero-banner-image',
                    'style'         => 'object-position: 55% 75%;',
                    'fetchpriority' => 'high',
                    'loading'       => 'eager',
                    'decoding'      => 'async',
                    'sizes'         => '100vw',
                    'alt'           => '',
                ]); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($video) : ?>
        <div class="z-0 absolute inset-0 w-full">
            <video
                class="opacity-0 w-full h-[calc(100vh-160px)] object-cover transition-opacity duration-700 hero-banner-video"
                autoplay
                <?php if ($video_loop) echo 'loop'; ?>
                muted
                playsinline
                preload="none"
                poster="<?php echo esc_url($hero_image_url); ?>"
                data-src="<?php echo esc_url($video['url']); ?>"
                data-mime-type="<?php echo esc_attr($video['mime_type']); ?>">
            </video>
        </div>
    <?php endif; ?>

    <!-- Unified overlay: sits above image/video (z-[1]), below text content (z-10) -->
    <?php if ($overlay_opacity > 0) : ?>
        <div class="z-[1] absolute inset-0"
            style="background: linear-gradient(180deg, rgba(0,0,0,<?php echo $opacity_top; ?>) 0%, rgba(0,0,0,<?php echo $opacity_mid; ?>) 70%, rgba(0,0,0,0) 100%);"></div>
    <?php endif; ?>

    <!-- Main Content Container -->
    <div class="z-10 flex flex-col pt-14 pb-[60px] absolute! banner-content <?php echo $hero_mobile_center ? 'left-0! right-0! top-1/2! -translate-y-1/2! px-6 items-center text-center lg:top-auto! lg:translate-y-0! lg:bottom-6! lg:left-12! lg:right-auto! lg:items-start! lg:text-left! lg:px-0!' : 'bottom-6! left-12! text-left'; ?>">

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

    <!-- Scroll Indicator -->
    <div class="hidden md:block bottom-8 left-1/2 z-10 absolute -translate-x-1/2 animate-bounce transform">
        <a href="#show-me">
            <svg class="w-8 h-8 text-[var(--color-wyz-guest-white)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </a>
    </div>
</section>
