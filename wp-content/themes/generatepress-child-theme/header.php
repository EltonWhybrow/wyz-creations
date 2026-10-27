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

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-M5FWJGF7');
    </script>
    <!-- End Google Tag Manager -->

</head>



<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5FWJGF7"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- coupon banner  test-->
    <!-- <div id="info-top-banner" class="bg-[var(--color-wyz-creations-guest-black-chalk)] text-[var(--color-wyz-guest-white)] text-center">
        <div class="relative mx-5 md:mx-[10vw]">🎉 Limited Time: Get 20% off your first trip membership - Use code <span>TRAVEL20</span> <i class="fas fa-close"></i>
        </div>
    </div> -->

    <div id="top-section" class="hidden md:block z-50 relative bg-wyz-creations-guest-light-gray">
        <div class="relative flex flex-row justify-between items-center p-2 px-4">
            <span class="sale-notice">Autumn sale now on — <span id="sale-countdown" aria-live="polite"></span></span>

            <div class="flex items-center gap-3">
                <a href="/subscribe" id="open-linkme" class="menu-link-secondary">
                    FREE products!</a>
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
    </div>

    <header id="masthead" role="banner" class="top-0 z-[102] sticky bg-white">

        <!-- Top Section with Promo and Account Links -->


        <!-- Secondary section with logo and navigation -->
        <div class="flex justify-between items-center mx-[3vw] py-2">
            <a href="<?php echo home_url('/'); ?>" class="site-branding">
                <img
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wyz-creations-logo.svg"
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


            <div class="flex gap-4 md:gap-5 ml-2 min-w-0 align-middle">

                <!-- Search bar -->
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="header-search">
                    <div class="header-search-wrap">
                        <label for="header-search-input" class="header-search-icon" aria-label="Search">
                            <?php echo wyzcreations_icon('magnifying-glass'); ?>
                        </label>
                        <input
                            type="search"
                            name="s"
                            id="header-search-input"
                            placeholder="Search..."
                            class="header-search-input"
                            style="font-size: 16px;"
                            value="<?php echo get_search_query(); ?>">
                        <input type="hidden" name="post_type" value="product">
                    </div>
                </form>

                <!-- Desktop Icons (Wishlist and Cart) -->
                <a href="<?php echo home_url('/favourites'); ?>" class="relative flex items-center text-wyz-creations-guest-black-chalk! menu-link-icons">
                    <?php echo wyzcreations_icon('heart'); ?>
                    <?php $favourites_count = wyzcreations_get_favourites_count(); ?>
                    <span class="favourites-count-badge<?php echo $favourites_count > 0 ? '' : ' hidden'; ?>"><?php echo esc_html($favourites_count); ?></span>
                </a>
                <a href="<?php echo home_url('/cart'); ?>" class="relative flex items-center text-wyz-creations-guest-black-chalk! menu-link-icons">
                    <?php echo wyzcreations_icon('basket-shopping'); ?>
                    <?php $cart_count = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <span class="cart-count-badge<?php echo $cart_count > 0 ? '' : ' hidden'; ?>"><?php echo esc_html($cart_count); ?></span>
                </a>

                <!-- Mobile Menu Toggle (Burger Icon) -->
                <button id="mobile-menu-toggle"
                    class="lg:hidden flex flex-col justify-center items-center bg-wyz-creations-guest-black-chalk! rounded-lg w-10 h-10 transition-colors"
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
        class="lg:hidden invisible z-[103] fixed inset-0 bg-black/50 opacity-0 transition-opacity duration-300">
    </div>

    <!-- Hidden menu data source — JS reads the nested <ul> structure from here.
         mobile_source=true bypasses Add_Submenu_Toggle_Walker so we get clean
         standard <ul><li> output without the nav-links-zone <div> wrapper. -->
    <div id="mobile-menu-source" class="hidden" aria-hidden="true">
        <?php wp_nav_menu(['theme_location' => 'primary', 'mobile_source' => true, 'fallback_cb' => false, 'container_id' => 'mobile-menu-source-nav']); ?>
    </div>

    <!-- Mobile Menu Panel -->
    <nav id="mobile-menu-panel"
        class="lg:hidden top-0 right-0 z-[105] fixed bg-white shadow-xl w-[80%] h-full transition-transform translate-x-full duration-300 transform"
        role="navigation"
        aria-label="Mobile menu">

        <div class="flex flex-col h-full">

            <!-- Header row: back arrow (hidden at level 0) + close button -->
            <div class="flex justify-between items-center px-5 border-gray-100 border-b h-[68px] shrink-0">

                <!-- Back button (hidden at level 0) -->
                <div id="mobile-header-back" class="hidden items-center gap-2 min-w-0">
                    <button id="mobile-menu-back"
                        class="flex justify-center items-center bg-wyz-creations-guest-light-gray rounded-full w-9 h-9 shrink-0"
                        aria-label="Go back">
                        <?php echo wyzcreations_icon('chevron-left'); ?>
                    </button>
                    <span id="mobile-menu-back-title" class="font-semibold text-wyz-creations-guest-black-chalk text-lg truncate"></span>
                </div>

                <!-- Spacer so close button stays right when back is hidden -->
                <div class="flex-1"></div>

                <!-- Close button (always visible) -->
                <button id="mobile-menu-close"
                    class="flex justify-center items-center bg-wyz-creations-guest-black-chalk p-0! rounded-full w-8 h-8 shrink-0"
                    aria-label="Close mobile menu">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Sliding panels: 3-screen track, JS translates to show current level -->
            <div class="relative flex-1 overflow-hidden">
                <div id="mobile-menu-track"
                    class="flex h-full"
                    style="width:300%;transform:translateX(0);transition:transform .3s cubic-bezier(.4,0,.2,1)">
                    <div class="overflow-y-auto mobile-menu-screen" style="width:33.333%"></div>
                    <div class="overflow-y-auto mobile-menu-screen" style="width:33.333%"></div>
                    <div class="overflow-y-auto mobile-menu-screen" style="width:33.333%"></div>
                </div>
            </div>

            <!-- Subscribe callout -->
            <div class="bg-wyz-creations-guest-black-chalk/80 mx-4 mb-4 rounded-2xl overflow-hidden shrink-0">
                <div class="px-5 pt-4 pb-0">
                    <p class="mb-0! font-bold text-white! text-sm text-center uppercase tracking-wide">Subscriber exclusive</p>
                </div>
                <div class="px-5 py-4">
                    <p class="mb-0.5! font-bold text-white! text-base leading-snug"><?php echo wyzcreations_subscribe_discount(); ?>% off your first order</p>
                    <p class="mb-3! text-white/70 text-sm leading-snug">Plus a chance to win free T-shirts when you join the Wyz Creations community.</p>
                    <a href="<?php echo home_url('/subscribe'); ?>"
                        class="flex justify-center wyz-btn btn-sm"
                        style="background:var(--color-wyz-creations-guest-orange);color:#fff;border-color:var(--color-wyz-creations-guest-orange);">
                        Join Us — It's Free
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center gap-8 bg-wyz-creations-guest-black-chalk/80 p-3 border-t shrink-0">
                <a href="<?php echo home_url('/my-account'); ?>"
                    class="flex flex-1 mt-0! wyz-btn btn-sm secondary">
                    My Account
                </a>
                <div class="flex items-center gap-5 pr-3">
                    <a href="<?php echo home_url('/favourites'); ?>"
                        class="flex justify-center items-center text-white! text-2xl no-underline!">
                        <span class="inline-flex relative">
                            <?php echo wyzcreations_icon('heart'); ?>
                            <?php $mobile_fav_count = wyzcreations_get_favourites_count(); ?>
                            <span class="favourites-count-badge<?php echo $mobile_fav_count > 0 ? '' : ' hidden'; ?>"><?php echo esc_html($mobile_fav_count); ?></span>
                        </span>
                    </a>
                    <a href="<?php echo home_url('/cart'); ?>"
                        class="flex justify-center items-center text-white! text-2xl no-underline!">
                        <span class="inline-flex relative">
                            <?php echo wyzcreations_icon('basket-shopping'); ?>
                            <?php $mobile_cart_count = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                            <span class="cart-count-badge<?php echo $mobile_cart_count > 0 ? '' : ' hidden'; ?>"><?php echo esc_html($mobile_cart_count); ?></span>
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </nav>