<?php
$faq_title = get_field('faq_title');
$faq_subtitle = get_field('faq_subtitle');

?>

<div id="faqs" class="faqs-module px-5 md:px-[10vw] py-[60px] md:py-20">
    <!-- Header -->
    <div class="faqs-header mb-16">
        <h2 class="text-[36px]! md:text-[64px]! leading-9! font-semibold! md:leading-[60px]! mb-0!">
            <?php echo esc_html($faq_title); ?>
        </h2>
        <p class="text-lg mt-4">
            <?php echo esc_html($faq_subtitle); ?>
        </p>
    </div>

    <!-- FAQ Accordion -->
    <div class="faq-accordion max-w-4xl mx-auto">
        <?php
        $faq_args = array(
            'post_type' => 'faq',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        $faq_query = new WP_Query($faq_args);

        if ($faq_query->have_posts()):
            $index = 0;
            while ($faq_query->have_posts()): $faq_query->the_post();
                $index++;
                $faq_id = 'faq-' . get_the_ID();
        ?>
                <div class="faq-item mx-auto">
                    <button class="faq-question w-full text-left flex justify-between items-center transition-colors duration-200 group"
                        aria-expanded="false"
                        aria-controls="<?php echo $faq_id; ?>"
                        data-faq-toggle>
                        <h3 class="text-5 md:text-[24px]! text-(--color-truvi-guest-black-chalk) font-medium pr-8 mb-0!">
                            <?php echo get_the_title(); ?>
                        </h3>
                        <span class="faq-icon flex-shrink-0 ml-4">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/add-icon.svg"
                                alt="Open FAQ"
                                class="w-6 h-6 icon-add">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/minus-icon.svg"
                                alt="Close FAQ"
                                class="w-6 h-6 icon-minus">
                        </span>
                    </button>

                    <div id="<?php echo $faq_id; ?>"
                        class="faq-answer text-[18px] md:text-[20px] overflow-hidden transition-all duration-500"
                        style="max-height: 0;">

                        <?php the_content(); ?>

                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        else:
            ?>
            <p class=" text-center py-8 text-gray-500">No FAQs found. Add some in the admin panel.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqButtons = document.querySelectorAll('[data-faq-toggle]');
        const headerHeight = 40;
        const MOBILE_BREAKPOINT = 768; // Common mobile breakpoint

        // Open first FAQ by default
        if (faqButtons.length > 0) {
            const firstButton = faqButtons[0];
            const firstTarget = document.getElementById(firstButton.getAttribute('aria-controls'));
            if (firstTarget) {
                firstButton.setAttribute('aria-expanded', 'true');
                firstButton.classList.add('active');
                firstTarget.style.maxHeight = firstTarget.scrollHeight + 'px';
            }
        }

        faqButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                const targetId = this.getAttribute('aria-controls');
                const target = document.getElementById(targetId);

                // Close all other FAQs
                faqButtons.forEach(otherButton => {
                    if (otherButton !== this) {
                        otherButton.setAttribute('aria-expanded', 'false');
                        otherButton.classList.remove('active');
                        const otherTarget = document.getElementById(otherButton.getAttribute('aria-controls'));
                        if (otherTarget) otherTarget.style.maxHeight = '0';
                    }
                });

                // Toggle current FAQ
                if (isExpanded) {
                    // Close current FAQ
                    this.setAttribute('aria-expanded', 'false');
                    this.classList.remove('active');
                    if (target) target.style.maxHeight = '0';
                } else {
                    // Open current FAQ
                    this.setAttribute('aria-expanded', 'true');
                    this.classList.add('active');
                    if (target) {
                        const buttonElement = this;

                        // Function to scroll after FAQ opens
                        const scrollAfterOpen = () => {
                            target.removeEventListener('transitionend', scrollAfterOpen);

                            // CHECK IF MOBILE - only scroll on mobile
                            if (window.innerWidth <= MOBILE_BREAKPOINT) {
                                const rect = buttonElement.getBoundingClientRect();
                                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                                const targetPosition = Math.max(0, rect.top + scrollTop - headerHeight);

                                // Smooth scroll
                                window.scrollTo({
                                    top: targetPosition,
                                    behavior: 'smooth'
                                });
                            }
                        };

                        // Listen for transition end
                        target.addEventListener('transitionend', scrollAfterOpen);

                        // Start opening animation
                        target.style.maxHeight = target.scrollHeight + 'px';

                        // Fallback timeout
                        setTimeout(scrollAfterOpen, 500);
                    }
                }
            });
        });
    });
</script>