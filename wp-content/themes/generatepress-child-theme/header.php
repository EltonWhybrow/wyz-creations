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
    <!-- <div id="info-top-banner" class="bg-[var(--color-wyz-creations-guest-black-chalk)] text-[var(--color-wyz-guest-white)] text-center">
        <div class="relative mx-5 md:mx-[10vw]">🎉 Limited Time: Get 20% off your first trip membership - Use code <span>TRAVEL20</span> <i class="fas fa-close"></i>
        </div>
    </div> -->

    <div id="top-section" class="z-50 relative bg-wyz-creations-guest-light-gray">
        <div class="relative flex flex-row items-center items-justified-right gap-3 p-2 px-4">
            <a href="/subscribe" id="open-linkme" class="menu-link-secondary">
                Get 15% OFF</a>
            |
            <?php
            // Check if on My Account page
            $is_my_account_page = false;

            $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
            if ($myaccount_page_id && is_page($myaccount_page_id)) {
                $is_my_account_page = true;
            }
            ?>
            <a href="/help" class="menu-link-secondary">
                Help
            </a>
            |
            <?php if ($is_my_account_page && is_user_logged_in()): ?>
                <a href="<?php echo esc_url(wc_logout_url()); ?>" class="menu-link-secondary">
                    Sign out
                </a>
            <?php endif; ?>
            <?php if (!is_user_logged_in()): ?>
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                    class="menu-link-secondary">
                    Sign In
                </a>
            <?php endif; ?>
            <?php if (!$is_my_account_page && is_user_logged_in()): ?>
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                    class="menu-link-secondary">
                    My Account
                </a>
            <?php endif; ?>
        </div>
    </div>

    <header id="masthead" role="banner" class="top-0 z-50 sticky bg-white">

        <!-- Top Section with Promo and Account Links -->


        <!-- Secondary section with logo and navigation -->
        <div class="flex justify-between items-center mx-[3vw] py-2">
            <a href="<?php echo home_url('/'); ?>" class="site-branding">
                <img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-logo.png"
                    alt="<?php bloginfo('name'); ?>"
                    class="w-14" />
            </a>



            <?php
            wp_nav_menu(
                array(
                    'container_id'    => 'primary-menu',
                    'container_class' => 'main-menu lg:mt-4 px-6 pt-0 md:px-[5vw] lg:bg-transparent md:flex gap-4',
                    'menu_class'      => 'md:flex lg:-mx-4 block md:flex-row flex-col lg:gap-0 gap-4',
                    'theme_location'  => 'primary',
                    'li_class'        => 'lg:mx-4 text-black-chalk font-dm-sans relative py-10',
                    'fallback_cb'     => false,
                )
            );
            ?>

            <!-- Desktop Navigation -->
            <!-- <nav id="wyz-creations-navigation" class="hidden md:flex items-center" role="navigation">
                <?php //
                // wp_nav_menu(
                //   array(
                //      'theme_location' => 'primary',
                //     'menu_id'        => 'wyz-creations-menu',
                //     'menu_class'     => '',
                //     'container'      => false,
                //     'walker'         => new Desktop_Mega_Menu_Walker(), // todo: remove
                //   )
                // );
                // 
                ?>
            </nav> -->


            <div class="flex gap-3 align-middle">

                <!-- Search bar  -->
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex">

                    <div class="relative w-full">
                        <i class="top-1/2 left-4 absolute text-gray-500 -translate-y-1/2 fa-solid fa-magnifying-glass"></i>

                        <input
                            type="search"
                            name="s"
                            placeholder="Search..."
                            class="bg-wyz-creations-guest-light-gray py-2 pr-4 pl-10 rounded-full w-full"
                            value="<?php echo get_search_query(); ?>">

                        <input type="hidden" name="post_type" value="product">
                    </div>

                </form>

                <!-- Desktop Icons (Wishlist and Cart) -->
                <div class="flex items-center gap-3">
                    <a href="<?php echo home_url('/favourites'); ?>" class="hidden md:flex text-wyz-creations-guest-black-chalk! menu-link-icons"> <i class="fa-solid fa-heart" aria-hidden="true"></i></a>
                    <a href="<?php echo home_url('/cart'); ?>" class="hidden md:flex text-wyz-creations-guest-black-chalk! menu-link-icons"> <i class="fa-solid fa-basket-shopping" aria-hidden="true"></i></a>
                </div>

                <!-- Mobile Menu Toggle (Burger Icon) -->
                <button id="mobile-menu-toggle"
                    class="md:hidden flex flex-col justify-center items-center bg-wyz-creations-guest-black-chalk! rounded-lg w-10 h-10 transition-colors"
                    aria-label="Toggle mobile menu"
                    aria-expanded="false">
                    <span class="bg-white mb-1.5 w-6 h-0.5 transition-all duration-300 burger-line"></span>
                    <span class="bg-white mb-1.5 w-6 h-0.5 transition-all duration-300 burger-line"></span>
                    <span class="bg-white w-6 h-0.5 transition-all duration-300 burger-line"></span>
                </button>
            </div>
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
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-logo.png"
                    alt="<?php bloginfo('name'); ?>"
                    class="w-20" />

                <button id="mobile-menu-close"
                    class="md:hidden flex justify-center items-center !bg-[var(--color-wyz-creations-guest-black-chalk)] !p-0 rounded-lg w-10 h-10"
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
                        'menu_id'        => 'wyz-creations-mobile-menu',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Mobile_Menu_Walker(), // Optional: Custom walker for mobile
                    )
                );
                ?>
            </div>

            <!-- Mobile Menu Footer -->

            <div class="flex flex-col gap-3 p-6 border-t">


                <a href="<?php echo home_url('/cart'); ?>"
                    class="flex w-full text-center wyz-btn primary">
                    View Cart
                </a>
            </div>
        </div>
    </nav>