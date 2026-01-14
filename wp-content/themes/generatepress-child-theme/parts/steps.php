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
    <!-- Optional: Overlay for better text readability -->
    <!-- <div class="z-0 absolute inset-0 bg-black/20"></div> -->


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative">
        <div class="w-full">
            <div class="w-full">

                <!-- Content Section -->
                <div class="flex justify-between items-end px-5 md:px-[10vw] pt-[50px] md:pt-[120px]">
                    <?php if ($steps_heading_pt1 && $steps_heading_pt2): ?>
                        <h2 class="mb-0! md:w-[480px]! font-semibold! text-[36px]! md:text-[64px]! leading-9! md:leading-[60px]!">
                            <?php echo esc_html($steps_heading_pt1); ?>
                            <span class="bg-[linear-gradient(90deg,#F97316_0%,#930D0D_100%)] bg-clip-text text-transparent"><?php echo esc_html($steps_heading_pt2); ?></span>
                        </h2>
                    <?php endif; ?>

                    <?php
                    // If steps_link is actually a link/URL field
                    if ($steps_link):
                        // Check if it's an ACF link array
                        if (is_array($steps_link) && isset($steps_link['url'])):
                    ?>
                            <div class="hidden md:block slide-up">
                                <a href="<?php echo esc_url($steps_link['url']); ?>"
                                    class="text-2xl font-medium inline-flex items-center text-(--color-truvi-guest-black-chalk)! transition-colors duration-300"
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
                    <?php endif; ?>
                </div>

                <!-- Full Width Steps Slider -->
                <div class="pt-8 pb-[30px] md:pb-[120px] md:pl-[10vw]! w-full">
                    <div class="half-slide-right mb-2 md:mb-10 lg:mb-2 steps-slider">
                        <?php
                        $has_content = false;

                        foreach ($step_groups as $step_group):
                            // Get all fields from the step group
                            $step_data = get_field($step_group);

                            if ($step_data && !empty($step_data)):
                                $has_content = true;

                                // Extract step data using your exact field names
                                $step_number = $step_data['step_number'] ?? '';
                                $step_image = $step_data['step_image'] ?? '';
                                $step_title = $step_data['step_title'] ?? '';
                                $step_content = $step_data['step_content'] ?? '';
                        ?>
                                <div class="step-slider-item">
                                    <div class="group block h-full">
                                        <div class="flex flex-col justify-between md:gap-2.5 bg-[var(--color-wyz-guest-white)] shadow p-[30px] md:p-10 rounded-[50px] h-full min-h-80 md:min-h-[480px] overflow-hidden transition-all duration-500">


                                            <!-- Step Number Badge -->
                                            <?php if ($step_number): ?>
                                                <div class=" hidden relative bg-(--color-truvi-guest-black-chalk) py-2.5 px-5 text-white rounded-[100px] w-fit md:flex items-center justify-between">
                                                    Step <?php echo esc_html($step_number); ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Image/Icon Area -->
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
                                                        class="w-auto h-[180px]! group-hover:scale-110 transition-transform duration-500" />
                                                <?php endif; ?>
                                            </div>

                                            <!-- Title & Content Overlay - Slides up on Hover -->
                                            <div class="flex items-center p-0 md:p-4">
                                                <div class="w-full transition-transform md:translate-y-4 group-hover:translate-y-0 duration-500 transform">
                                                    <div class="steps-content">

                                                        <?php if ($step_title): ?>
                                                            <h3 class="mb-1! font-medium text-[28px]">
                                                                <?php echo esc_html($step_title); ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <?php if ($step_content): ?>
                                                            <div class="font-normal md:text-[24px] text-lg">
                                                                <?php echo wp_kses_post($step_content); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
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

                <?php
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
                        <!-- If it's just text -->
                        <p class="mt-4 max-w-2xl">
                            <?php echo esc_html($steps_link); ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
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
                    autoplaySpeed: 4000,
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