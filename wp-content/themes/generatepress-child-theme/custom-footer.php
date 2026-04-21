<?php

/**
 * Custom Footer – Replace the default GeneratePress footer completely
 */

?>

<footer id="colophon" class="px-20 pt-20 pb-10 md:text-left text-center" role="contentinfo">
    <div id="main-footer" class="mx-auto">

        <div class="py-4 pb-10 w-full footer-menu">
            <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mx-auto">

                <!-- MENU COLUMNS -->
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'depth'          => 2,
                    'walker'         => new Mega_Menu_Walker(),
                    'items_wrap'     => '%3$s',
                ));
                ?>

                <!-- STATIC IMAGE COLUMN -->
                <div class="flex justify-end items-start col-span-1">
                    <img
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-logo.png"
                        alt="<?php bloginfo('name'); ?>"
                        class="mx-auto md:mx-0 w-24" />
                </div>

            </div>
        </div>


        <!-- Bottom Bar -->
        <div class="pt-14 font-semibold text-wyz-creations-guest-black-chalk/60 text-sm">
            <span> © <?php echo date('Y'); ?> WYZCreations - All rights reserved</span>
            | <span><a href="<?php echo home_url('/privacy-policy/'); ?>" class="hover:text-wyz-creations-guest-black-chalk">Privacy & Cookie Policy</a></span>

        </div>

    </div>

</footer>

<button id="backToTop" class="back-to-top" aria-label="Back to top">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</button>


<div id="menu-overlay"></div>

<!-- // Subscribe Modal -->
<div id="linkme-panel">
    <button id="close-linkme" aria-label="Close menu">✕</button>

    <div class="linkme-content">
        <h2 class="mb-2 text-lg">Subscribe</h2>
        <h3 class="mb-6 text-wyz-creations-guest-light-gray text-xl">Get 15% OFF your first order!</h3>
        <ul class="mb-6 ml-4! list-disc list-outside list">
            <li>Be notified first about new T-shirt drops</li>
            <li>Receive exclusive discounts and promo codes</li>
            <li>Chance to win a FREE T-shirt every month</li>

        </ul>
        <?php echo do_shortcode('[contact-form-7 id="c06b1a3" title="Subscribe form"]'); ?>
    </div>
</div>

<!-- // TODO: check if needed -->
</body>

</html>