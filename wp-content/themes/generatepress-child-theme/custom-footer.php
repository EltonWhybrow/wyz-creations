<?php

/**
 * Custom Footer – Replace the default GeneratePress footer completely
 */
?>
<footer id="colophon" class="bg-[radial-gradient(39.47%_143.28%_at_50%_143.28%,#4E4E4E_0%,#191615_100%)] px-5 md:px-24 py-14 md:py-20 md:text-left text-center" role="contentinfo">
    <div class="mx-auto w-full xl:max-w-[85%] truvi-footer">
        <div class="flex md:flex-row flex-col md:justify-between md:items-start gap-0 md:gap-8">

            <!-- Column 1 – About / Logo -->
            <div class="w-full md:w-2/5">
                <div class="mb-3 footer-logo">

                    <img
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/linkme-logo-white.png"
                        alt="<?php bloginfo('name'); ?>"
                        class="mx-auto md:mx-0 w-[80px]" />

                </div>
                <!-- <p class="w-full md:w-[65%] text-[var(--color-wyz-guest-white)] text-base">
                    In association with: <br>
                </p> -->
            </div>

            <!-- Column 2 – Services -->
            <div class="flex sm:flex-row flex-col justify-between gap-4 md:gap-8 w-full md:w-3/5">
                <div class="footer-col">
                    <h4>WideSign Creative</h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-services',     // we'll register this in a sec
                        'fallback_cb'    => '__return_false',
                        'depth'          => 1,
                        'container'      => false,
                        'items_wrap'     => '<ul class="footer-menu">%3$s</ul>',

                    ));
                    ?>
                </div>

                <!-- Column 3 – Support -->
                <div class="footer-col">
                    <h4>Franks Emporium</h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-support',     // we'll register this in a sec
                        'fallback_cb'    => '__return_false',
                        'depth'          => 1,
                        'container'      => false,
                        'items_wrap'     => '<ul class="footer-menu">%3$s</ul>',

                    ));
                    ?>
                </div>

                <!-- Column 4 – Company -->

            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="mt-10 pt-10 border-white border-t text-[var(--color-wyz-guest-white)] text-base">
            © <?php echo date('Y'); ?> WYZCreations - All rights reserved

        </div>
    </div>

    <div id="linkme-panel">
        <button id="close-linkme" aria-label="Close menu">✕</button>

        <div class="linkme-content">
            <!-- YOUR MENU / CONTENT HERE -->
            <h2 class="!mb-0">Subscribe</h2>
            <p class="!mb-10">You'll get notified of new Tees and special discounts</p>
            <?php echo do_shortcode('[contact-form-7 id="c06b1a3" title="Contact form 1"]'); ?>
        </div>
    </div>
    </div>

    <button id="backToTop" class="back-to-top" aria-label="Back to top">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>