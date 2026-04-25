<?php
$steps_heading_pt1 = get_field('steps_heading_pt1');
$steps_heading_pt2 = get_field('steps_heading_pt2');
$steps_bg_image = get_field('steps_bg_image');
$steps_link = get_field('steps_link');

// Define the group names
$step_groups = array('step_1', 'step_2', 'step_3', 'step_4');
?>

<div class="relative overflow-hidden section steps-slider-module"
    <?php if ($steps_bg_image && is_array($steps_bg_image) && isset($steps_bg_image['url'])): ?>
    style="background: linear-gradient(180deg, rgba(255, 255, 255, 0.80) 0%, rgba(161, 73, 1, 0.5) 100%), url('<?php echo esc_url($steps_bg_image['url']); ?>') 0% 70% / cover no-repeat;"
    <?php endif; ?>>


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative">
        <div class="w-full">
            <div class="w-full">

                <!-- Content Section -->
                <!-- More link to feedback -->
                <div class="hidden md:flex justify-end px-5 pt-[50px] md:pt-[60x]">
                    <?php /*
                    // If steps_link is actually a link/URL field
                    if ($steps_link):
                        if (is_array($steps_link) && isset($steps_link['url'])):
                    ?>
                            <div class="hidden md:block slide-up">
                                <a href="<?php echo esc_url($steps_link['url']); ?>"
                                    class="inline-flex items-center font-medium text-wyz-creations-guest-black-chalk! text-2xl transition-colors duration-300"
                                    target="<?php echo esc_attr($steps_link['target'] ?? '_self'); ?>">
                                    <?php echo esc_html($steps_link['title'] ?? 'Learn More'); ?>
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        <?php elseif ($steps_link): ?>
                            <!-- If it's just text -->
                            <p class="mt-4 max-w-2xl">
                                <?php echo esc_html($steps_link); ?>
                            </p>
                        <?php endif; ?>
                    <?php endif; */ ?>
                </div>

                <!-- Full Width Steps Slider -->
                <div class="relative pt-[30px] md:pt-0 pb-[30px] md:pb-[60px] md:pl-[150px]! w-full">
                    <!-- Review title inside slider -->
                    <div class="md:block top-[255px] -left-[150px] absolute -rotate-90 hiiden">
                        <?php if ($steps_heading_pt2): ?>
                            <h2 class="mb-0! font-semibold! text-[36px] md:text-[100px] leading-0">
                                <!-- <?php // echo esc_html($steps_heading_pt1); 
                                        ?> -->
                                <span class="text-wyzc-brown"><?php echo esc_html($steps_heading_pt2); ?></span>
                            </h2>
                        <?php endif; ?>
                    </div>

                    <div class="half-slide-right mb-0 steps-slider">
                        <?php
                        $has_content = false;

                        foreach ($step_groups as $step_group):
                            // Get all fields from the step group
                            $step_data = get_field($step_group);

                            if ($step_data && !empty($step_data)):
                                $has_content = true;

                                // Extract step data using your exact field names
                                $step_image = $step_data['step_image'] ?? '';
                                $step_title = $step_data['step_title'] ?? '';
                                $step_content = $step_data['step_content'] ?? '';
                        ?>
                                <div class="step-slider-item">
                                    <div class="group block h-full">
                                        <div class="relative flex flex-col justify-between md:gap-1 bg-wyz-creations-guest-light-gray shadow p-5 md:p-14 rounded-[10px] h-full min-h-80 md:min-h-[480px] overflow-hidden text-wyzc-brown">
                                            <i class="-right-12 -bottom-3 fa-quote-left absolute opacity-10 text-[150px] text-wyzc-brown md:text-[200px] fa-solid"></i>


                                            <!-- Title & Content Overlay - Slides up on Hover -->
                                            <div class="flex items-center p-0">
                                                <div class="w-full">
                                                    <div class="steps-content">



                                                        <?php if ($step_content): ?>
                                                            <div class="font-normal [&_p]:text-[40px] text-center">
                                                                <?php echo wp_kses_post($step_content); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Image/Icon Area -->
                                            <div class="flex flex-col justify-center items-center gap-4 align-middle">
                                                <?php if ($step_title): ?>
                                                    <h3 class="font-light text-wyzc-brown text-2xl">
                                                        <?php echo esc_html($step_title); ?>
                                                    </h3>
                                                <?php endif; ?>
                                                <div class="relative h-full overflow-hidden">
                                                    <?php
                                                    if ($step_image):
                                                        // Handle ACF image field (could be array, ID, or URL)
                                                        if (is_array($step_image) && isset($step_image['url'])):
                                                            // ACF image array
                                                            $image_url = $step_image['url'];
                                                            $image_alt = $step_image['alt'] ?? ($step_title ?: 'Step image');
                                                        elseif (is_numeric($step_image)):
                                                            // Attachment ID
                                                            $image_url = wp_get_attachment_image_url($step_image, 'large');
                                                            $image_alt = get_post_meta($step_image, '_wp_attachment_image_alt', true) ?: ($step_title ?: 'Step image');
                                                        else:
                                                            // URL string
                                                            $image_url = $step_image;
                                                            $image_alt = $step_title ?: 'Step image';
                                                        endif;
                                                    ?>
                                                        <img src="<?php echo esc_url($image_url); ?>"
                                                            alt="<?php echo esc_attr($image_alt); ?>"
                                                            class="rounded-full w-12 h-12" />
                                                    <?php endif; ?>
                                                </div>

                                            </div>



                                        </div>
                                    </div>
                                </div>
                            <?php
                            endif;
                        endforeach;

                        if (!$has_content):
                            ?>
                            <div class="col-span-full py-8 text-center">
                                <p class="inline-block bg-black/50 p-4 rounded-lg font-dm-sans text-white style-md">
                                    No steps content found. Please add content to your step groups.
                                </p>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>

                <?php /*
                // If steps_link is actually a link/URL field
                if ($steps_link):
                    // Check if it's an ACF link array
                    if (is_array($steps_link) && isset($steps_link['url'])):
                ?>
                        <div class="md:hidden block">
                            <a href="<?php echo esc_url($steps_link['url']); ?>"
                                class="inline-flex items-center px-5 pt-0 pb-12 font-medium text-white! text-2xl transition-colors duration-300 no-underline!"
                                target="<?php echo esc_attr($steps_link['target'] ?? '_self'); ?>">
                                <?php echo esc_html($steps_link['title'] ?? 'Learn More'); ?>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    <?php elseif ($steps_link): ?>
                 
                        <p class="mt-4 max-w-2xl">
                            <?php echo esc_html($steps_link); ?>
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