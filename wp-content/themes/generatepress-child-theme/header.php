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
        <div class="relative mx-5 md:mx-[10vw]">🎉 Limited Time: Get 20% off your first trip membership - Use code <span>TRAVEL20</span> <i class="fas fa-close"></i>
        </div>
    </div>

    <header id="masthead" class="flex justify-between items-center px-5 md:px-6 lg:px-[100px] py-3" role="banner">
        <a href="<?php echo home_url('/'); ?>" class="site-branding">
            <img
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-logo.png"
                alt="<?php bloginfo('name'); ?>"
                class="w-28" />
        </a>

        <!-- Desktop Navigation -->
        <nav id="truvi-navigation" class="hidden md:flex items-center" role="navigation">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'truvi-menu',
                    'menu_class'     => '',
                    'container'      => false,
                )
            );
            ?>
        </nav>

        <div class="">

            <?php
            // Check if on My Account page
            $is_my_account_page = false;

            $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
            if ($myaccount_page_id && is_page($myaccount_page_id)) {
                $is_my_account_page = true;
            }
            ?>

            <!-- If ON account page and logged in -->
            <?php if ($is_my_account_page && is_user_logged_in()): ?>
                <a href="<?php echo esc_url(wc_logout_url()); ?>" class="hidden md:flex wyz-btn primary">
                    Sign out
                </a>
            <?php endif; ?>

            <div class="flex gap-2">
                <!-- If NOT on account page and logged in ?? && is_user_logged_in() && current_user_can('customer') ??-->
                <?php if (!$is_my_account_page): ?>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                        class="hidden md:flex px-4! rounded-full wyz-btn secondary">
                        <i class="fas fa-user"></i>
                    </a>
                <?php endif; ?>


                <!-- Desktop Button -->
                <!-- If NOT on account page -->
                <?php if (!$is_my_account_page): ?>
                    <a href="<?php echo home_url('/?add-to-cart=61&quantity=1'); ?>" class="hidden md:flex wyz-btn primary">Get Protected</a>
                <?php endif; ?>

            </div>

            <!-- Mobile Menu Toggle (Burger Icon) -->
            <button id="mobile-menu-toggle"
                class="md:hidden flex flex-col justify-center items-center !bg-[var(--color-truvi-guest-black-chalk)] rounded-lg w-10 h-10 transition-colors"
                aria-label="Toggle mobile menu"
                aria-expanded="false">
                <span class="bg-white mb-1.5 w-6 h-0.5 transition-all duration-300 burger-line"></span>
                <span class="bg-white mb-1.5 w-6 h-0.5 transition-all duration-300 burger-line"></span>
                <span class="bg-white w-6 h-0.5 transition-all duration-300 burger-line"></span>
            </button>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay"
        class="md:hidden invisible z-40 fixed inset-0 bg-black/50 opacity-0 transition-opacity duration-300">
    </div>

    <!-- Mobile Menu Panel -->
    <nav id="mobile-menu-panel"
        class="md:hidden top-0 right-0 z-50 fixed bg-white shadow-xl w-[90%] h-full transition-transform translate-x-full duration-300 transform"
        role="navigation"
        aria-label="Mobile menu">

        <div class="flex flex-col h-full">
            <!-- Mobile Menu Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/truvi-logo-black.png"
                    alt="<?php bloginfo('name'); ?>"
                    class="w-28" />

                <button id="mobile-menu-close"
                    class="md:hidden flex justify-center items-center !bg-[var(--color-truvi-guest-black-chalk)] !p-0 rounded-lg w-10 h-10"
                    aria-label="Close mobile menu">
                    <!-- Just an SVG X icon -->
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Items -->
            <div class="flex-1">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'truvi-mobile-menu',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Mobile_Menu_Walker(), // Optional: Custom walker for mobile
                    )
                );
                ?>
            </div>

            <!-- Mobile Menu Footer -->

            <div class="flex flex-col gap-3 p-6 border-t">
                <!-- If NOT on account page and logged in -->
                <?php if (!$is_my_account_page && is_user_logged_in() && current_user_can('customer')): ?>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                        class="px-4! rounded-full wyz-btn secondary">
                        <i class="mr-2 fas fa-user"></i> My Account
                    </a>
                <?php endif; ?>
                <?php if (!$is_my_account_page): ?>
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                        class="px-4! rounded-full wyz-btn secondary">
                        <i class="mr-3 fas fa-user"></i> My Account
                    </a>
                <?php endif; ?>
                <a href="<?php echo home_url('/cart'); ?>"
                    class="flex w-full text-center wyz-btn primary">
                    Get Protected
                </a>
            </div>
        </div>
    </nav>