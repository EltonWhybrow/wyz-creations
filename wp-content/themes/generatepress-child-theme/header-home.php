<?php

/**
 * Child Theme Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class('link-back'); ?>>
    <!-- coupon banner  -->
    <div id="info-top-banner" class="bg-[var(--color-truvi-guest-dark-gray)] text-[var(--color-wyz-guest-white)]">
        <div class="relative flex justify-between items-center gap-4 p-2">
            <span class="flex-1 text-center">
                🎉 FREE 🎉 website for small your business
                <a href="https://widesign.co.uk" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-400! underline">
                    @WideSign
                </a>
            </span>
            <div class="flex flex-shrink-0 justify-center text-white/85 hover:text-white align-middle">
                <i class="fas fa-close"></i>
            </div>
        </div>
    </div>
    <div id="link-container" class="mx-auto max-w-[500px]">
        <header id="masthead" class="flex items-center gap-2 bg-white p-5 md:px-6 lg:px-[100px]" role="banner">
            <div class="w-3/4">
                <a href="<?php echo home_url('/'); ?>" class="">
                    <img
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-logo.png"
                        alt="<?php bloginfo('name'); ?>"
                        class="w-auto" />

                </a>
            </div>
            <div class="w-1/4">
                <a href="mailto:info@wyzcreations.com" class="pb-1"> <img
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-mail.png"
                        alt="email us"
                        class="pb-2 w-auto" />
                </a>

                <a href="#" id="open-linkme" class="pt-1"> <img
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-subscribe.png"
                        alt="subscribe"
                        class="pt-2 w-auto" />
                </a>

            </div>

        </header>