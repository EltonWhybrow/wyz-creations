<?php

$feedback_title = get_sub_field('feedback_title');

$feedback_link = get_sub_field('feedback_link');
?>

<div class="relative overflow-hidden section steps-slider-module"




    <div class="z-10 relative">
    <div class="w-full">
        <div class="w-full">

            <!-- Content Section -->
            <!-- More link to feedback -->
            <div class="hidden md:flex justify-end px-5 pt-[50px] md:pt-[60x]">
                <?php /*
                    // If feedback_link is actually a link/URL field
                    if ($feedback_link):
                        if (is_array($feedback_link) && isset($feedback_link['url'])):
                    ?>
                            <div class="hidden md:block slide-up">
                                <a href="<?php echo esc_url($feedback_link['url']); ?>"
                                    class="inline-flex items-center font-medium text-wyz-creations-guest-black-chalk! text-2xl transition-colors duration-300"
                                    target="<?php echo esc_attr($feedback_link['target'] ?? '_self'); ?>">
                                    <?php echo esc_html($feedback_link['title'] ?? 'Learn More'); ?>
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        <?php elseif ($feedback_link): ?>
                            <!-- If it's just text -->
                            <p class="mt-4 max-w-2xl">
                                <?php echo esc_html($feedback_link); ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; */ ?>
            </div>

            <!-- Full Width Steps Slider -->
            <div class="relative pt-[30px] md:pt-0 pb-[30px] md:pb-[60px] md:pl-[150px]! w-full">
                <!-- Review title inside slider -->
                <div class="md:block top-[255px] -left-[150px] absolute -rotate-90 hiiden">
                    <?php if ($feedback_title): ?>
                        <h2 class="mb-0! font-semibold! text-[36px] md:text-[100px] leading-0">

                            <span class="text-wyzc-brown"><?php echo esc_html($feedback_title); ?></span>
                        </h2>
                    <?php endif; ?>
                </div>

                <div class="half-slide-right mb-0 steps-slider">
                    <?php if (have_rows('feedback_repeater')) : ?>
                        <?php while (have_rows('feedback_repeater')) : the_row();
                            $item_image = get_sub_field('feedback_image');
                            $item_title = get_sub_field('feedback_title');
                            $item_content = get_sub_field('feedback_content');
                        ?>
                            <div class="step-slider-item">
                                <div class="group block h-full">
                                    <div class="relative flex flex-col justify-between md:gap-1 bg-wyz-creations-guest-light-gray shadow p-5 md:p-14 rounded-[10px] h-full min-h-80 md:min-h-[480px] overflow-hidden text-wyzc-brown">
                                        <i class="-right-12 -bottom-3 fa-quote-left absolute opacity-10 text-[150px] text-wyzc-brown md:text-[200px] fa-solid"></i>


                                        <!-- Title & Content Overlay - Slides up on Hover -->
                                        <div class="flex items-center p-0">
                                            <div class="w-full">
                                                <div class="steps-content">



                                                    <?php if ($item_content): ?>
                                                        <div class="font-normal [&_p]:text-[40px] text-center">
                                                            <?php echo wp_kses_post($item_content); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Image/Icon Area -->
                                        <div class="flex flex-col justify-center items-center gap-4 align-middle">
                                            <?php if ($item_title): ?>
                                                <h3 class="font-light text-wyzc-brown text-2xl">
                                                    <?php echo esc_html($item_title); ?>
                                                </h3>
                                            <?php endif; ?>
                                            <div class="relative h-full overflow-hidden">
                                                <?php
                                                if ($item_image):
                                                    // Handle ACF image field (could be array, ID, or URL)
                                                    if (is_array($item_image) && isset($item_image['url'])):
                                                        // ACF image array
                                                        $image_url = $item_image['url'];
                                                        $image_alt = $item_image['alt'] ?? ($item_title ?: 'Step image');
                                                    elseif (is_numeric($item_image)):
                                                        // Attachment ID
                                                        $image_url = wp_get_attachment_image_url($item_image, 'large');
                                                        $image_alt = get_post_meta($item_image, '_wp_attachment_image_alt', true) ?: ($item_title ?: 'Step image');
                                                    else:
                                                        // URL string
                                                        $image_url = $item_image;
                                                        $image_alt = $item_title ?: 'Step image';
                                                    endif;
                                                else:
                                                    // Fallback avatar when no image is set
                                                    $image_url = get_stylesheet_directory_uri() . '/assets/img/default_avatar.webp';
                                                    $image_alt = $item_title ?: 'Step image';
                                                endif;
                                                ?>
                                                <img src="<?php echo esc_url($image_url); ?>"
                                                    alt="<?php echo esc_attr($image_alt); ?>"
                                                    class="rounded-full w-12 h-12" />
                                            </div>

                                        </div>



                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="col-span-full py-8 text-center">
                            <p class="inline-block bg-black/50 p-4 rounded-lg font-dm-sans text-white style-md">
                                No steps content found. Please add content to your step groups.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php /*
                // If feedback_link is actually a link/URL field
                if ($feedback_link):
                    // Check if it's an ACF link array
                    if (is_array($feedback_link) && isset($feedback_link['url'])):
                ?>
                        <div class="md:hidden block">
                            <a href="<?php echo esc_url($feedback_link['url']); ?>"
                                class="inline-flex items-center px-5 pt-0 pb-12 font-medium text-white! text-2xl transition-colors duration-300 no-underline!"
                                target="<?php echo esc_attr($feedback_link['target'] ?? '_self'); ?>">
                                <?php echo esc_html($feedback_link['title'] ?? 'Learn More'); ?>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    <?php elseif ($feedback_link): ?>
                 
                        <p class="mt-4 max-w-2xl">
                            <?php echo esc_html($feedback_link); ?>
                        </p>
                    <?php endif; ?>
                <?php endif; */ ?>
        </div>
    </div>
</div>
</div>

<script>
    jQuery(document).ready(function($) {
        // This slider is intialized by gsay to start when entering viewport
        function initSlider($slider) {
            var $items = $slider.find('.step-slider-item');

            if ($items.length > 0 && !$slider.hasClass('slick-initialized')) {
                $slider.slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    pauseOnHover: true,
                    centerMode: false,
                    focusOnSelect: false,
                    infinite: $items.length > 3,
                    adaptiveHeight: true,
                    variableWidth: false,
                    edgePadding: 0,

                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                arrows: false
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                arrows: false,
                                centerMode: true,
                                centerPadding: '20px'
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                centerMode: true,
                                arrows: false,
                                centerPadding: '20px'
                            }
                        }
                    ]
                });

                // Refresh ScrollTrigger after slider initializes
                if (window.ScrollTrigger) {
                    setTimeout(() => ScrollTrigger.refresh(), 300);
                }
            }
        }

        // Initialize all sliders immediately (fallback if GSAP not available)
        $('.steps-slider').each(function() {
            var $slider = $(this);

            // If GSAP ScrollTrigger is available, use it
            if (window.gsap && window.gsap.registerPlugin && window.ScrollTrigger) {
                // Create a ScrollTrigger for each slider
                ScrollTrigger.create({
                    trigger: this,
                    start: "top 95%", // When top of slider is 85% from top of viewport
                    onEnter: () => initSlider($slider),
                    once: true, // Only trigger once
                    markers: false // Set to true for debugging
                });
            } else {
                // Fallback: initialize immediately
                initSlider($slider);
            }
        });
    });
</script>