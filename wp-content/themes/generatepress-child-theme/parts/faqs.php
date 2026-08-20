<div id="faqs" class="py-6 faqs-module">

    <div class="relative mb-10 faq-search">

        <input
            type="text"
            id="faqSearchInput"
            placeholder="Search FAQs..."
            class="p-4 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black w-full text-lg" />

        <button
            type="button"
            id="faqClearSearch"
            class="hidden top-1/2 right-4 absolute text-gray-400 hover:text-black -translate-y-1/2"
            aria-label="Clear search">
            ✕
        </button>

    </div>
    <p id="faqNoResults" class="hidden mt-4 text-gray-500">
        No FAQs found matching your search.
    </p>



    <!-- FAQ Accordion -->
    <div class="mx-auto max-w-4xl faq-accordion">
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
                <div class="mx-auto faq-item" data-faq-item>
                    <button class="group flex justify-between items-center w-full text-left transition-colors duration-200 faq-question"
                        aria-expanded="false"
                        aria-controls="<?php echo $faq_id; ?>"
                        data-faq-toggle>
                        <h3 class="text-5 md:text-[24px]! text-(--color-wyz-creations-guest-black-chalk) font-medium pr-8 mb-0!">
                            <?php echo get_the_title(); ?>
                        </h3>
                        <span class="flex-shrink-0 ml-4 faq-icon">
                            <i class="transition-transform duration-300 fa-solid fa-chevron-down"></i>
                        </span>
                    </button>

                    <div id="<?php echo $faq_id; ?>"
                        class="overflow-hidden text-[18px] md:text-[20px] transition-all duration-500 faq-answer"
                        style="max-height: 0;">

                        <?php the_content(); ?>

                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        else:
            ?>
            <p class="py-8 text-gray-500 text-center">No FAQs found. Add some in the admin panel.</p>
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