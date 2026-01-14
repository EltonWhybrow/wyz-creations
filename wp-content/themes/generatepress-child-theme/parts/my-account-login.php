<div id="custom-woo-form" class="relative flex md:flex-row flex-col justify-center items-center gap-[30px] md:gap-28 pb-[50px] md:pb-[120px]">
    <div class="flex flex-col flex-1 gap-8 mx-auto md:text-left text-center contact-us-content">
        <header>


            <?php
            $current_url = $_SERVER['REQUEST_URI'];

            // Check for action parameter FIRST (WooCommerce uses this for lost password)
            if (isset($_GET['action']) && $_GET['action'] === 'lostpassword') {
                echo '<h1 class="mb-2.5! md:px-0! pt-2.5! slide-up">
            Reset Password
          </h1>
          ';
            }
            // Check if URL contains 'lost-password'
            elseif (strpos($current_url, 'lost-password') !== false) {
                echo '<h1 class="mb-2.5! md:px-0! pt-2.5! slide-up">
            Reset Password
          </h1>
          ';
            }
            // Check if URL is the main my-account page (login)
            elseif (strpos($current_url, '/my-account') !== false) {
                // Check if it's exactly /my-account/ with no endpoints
                // Remove query parameters first
                $clean_url = strtok($current_url, '?');

                if (
                    rtrim($clean_url, '/') === '/my-account' ||
                    rtrim($clean_url, '/') === '/truvi-guests/my-account'
                ) {
                    echo '<h1 class="mb-2.5! md:px-0! pt-2.5! slide-up">
                Login
              </h1>
              <p class="slide-up">Please log in to access your trip protection area</p>';
                } else {
                    // It's a my-account page but with some endpoint
                    echo 'normal';
                }
            } else {
                echo 'normal';
            }
            ?>

        </header>
        <div class="hidden md:block pt-8 border-[var(--color-truvi-guest-black-chalk)] border-t slide-up">
            <div class="mx-auto my-0! max-w-4xl text-[18px] lg:text-2xl leading-normal!">
                <h4 class="mb-1!">Don't have an account yet?</h4>
                <p>You can set up account when you purchase your first trip protection membership</p>
            </div>
            <a
                href="<?php echo home_url('/?add-to-cart=61&amp;quantity=1'); ?>"
                class="mt-3 md:w-fit transition-all duration-300 wyz-btn primary">
                Get Protected
            </a>
        </div>
    </div>

    <div
        class="flex-1 my-2 w-full md:w-auto">
        <?php echo do_shortcode('[woocommerce_my_account login="true"]'); ?>
    </div>

    <div class="md:hidden pt-8 border-[var(--color-truvi-guest-black-chalk)] border-t slide-up">
        <div class="mx-auto my-0! max-w-4xl text-[18px] lg:text-2xl leading-normal!">
            <h4 class="mb-1!">Don't have an account yet?</h4>
            <p>You can set up account when you purchase your first trip protection membership</p>
        </div>
        <a
            href="<?php echo home_url('/?add-to-cart=61&amp;quantity=1'); ?>"
            class="mt-3 md:w-fit transition-all duration-300 wyz-btn primary">
            Get Protected
        </a>
    </div>
</div>