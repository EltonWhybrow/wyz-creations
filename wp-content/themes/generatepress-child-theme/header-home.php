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

<body <?php body_class(); ?>>
    <!-- coupon banner  -->
    <div id="info-top-banner" class="bg-[var(--color-truvi-guest-black-chalk)] text-[var(--color-wyz-guest-white)] text-center">
        <div class="relative mx-5 md:mx-[10vw]">🎉 Limited Offer: FREE website for your small to medium business from our partners <span><a href="https://widesign.co.uk" target="_blank">WideSign</a></span> <i class="fas fa-close"></i>
        </div>
    </div>

    <header id="masthead" class="flex justify-center items-center px-5 md:px-6 lg:px-[100px] py-8" role="banner">
        <a href="<?php echo home_url('/'); ?>" class="site-branding">
            <img
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-logo.png"
                alt="<?php bloginfo('name'); ?>"
                class="w-32" />
        </a>

    </header>