<?php
$different_heading = get_field('different_heading');
$different_bg_image = get_field('different_bg_image');


// Define the group names
$different_groups = array('different_1', 'different_2', 'different_3', 'different_4');



?>

<div class="relative overflow-hidden section different-slider-module"
    <?php if ($different_bg_image && is_array($different_bg_image) && isset($different_bg_image['url'])): ?>
    style="--bg-image: url('<?php echo esc_url($different_bg_image['url']); ?>')"
    <?php endif; ?>>
    <!-- Optional: Overlay for better text readability -->
    <!-- <div class="z-0 absolute inset-0 bg-black/20"></div> -->

    <div class="z-10 relative py-[60px] md:py-[120px]">
        <div class="w-full">


            <!-- Content Section -->
            <div class="px-5 md:px-[10vw]">
                <?php if ($different_heading): ?>
                    <h2 class="mb-0! font-semibold! text-[36px]! md:text-[64px]! leading-9! md:leading-[60px]! stagger-words">
                        <?php echo esc_html($different_heading); ?>
                    </h2>
                <?php endif; ?>
            </div>

            <!-- Full Width Different Slider -->
            <div class="pt-[30px] md:pt-[60px] md:pl-[10vw]! w-full">
                <div class="mb-2 md:mb-10 lg:mb-2 different-slider">
                    <?php
                    $has_content = false;

                    foreach ($different_groups as $different_group):
                        // Get all fields from the step group
                        $different_data = get_field($different_group);

                        if ($different_data && !empty($different_data)):
                            $has_content = true;


                            // Extract step data using your exact field names
                            $different_image = $different_data['different_image'] ?? '';
                            $different_title = $different_data['different_title'] ?? '';
                            $different_content = $different_data['different_content'] ?? '';
                    ?>
                            <div class="different-slider-item">
                                <div class="group block h-full">
                                    <div class="flex flex-col justify-between md:gap-2.5 bg-[var(--color-wyz-guest-white)] shadow p-[30px] md:p-10 rounded-[50px] h-full min-h-80 md:min-h-[480px] overflow-hidden transition-all duration-500">

                                        <!-- Image/Icon Area -->
                                        <div class="relative h-full overflow-hidden">
                                            <?php
                                            if ($different_image):
                                                // Handle ACF image field (could be array, ID, or URL)
                                                if (is_array($different_image) && isset($different_image['url'])):
                                                    // ACF image array
                                                    $image_url = $different_image['url'];
                                                    $image_alt = $different_image['alt'] ?? ($different_title ?: 'Different image');
                                                elseif (is_numeric($different_image)):
                                                    // Attachment ID
                                                    $image_url = wp_get_attachment_image_url($different_image, 'large');
                                                    $image_alt = get_post_meta($different_image, '_wp_attachment_image_alt', true) ?: ($different_title ?: 'Different image');
                                                else:
                                                    // URL string
                                                    $image_url = $different_image;
                                                    $image_alt = $different_title ?: 'Different image';
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
                                                <div class="different-content">

                                                    <?php if ($different_title): ?>
                                                        <h3 class="mb-1! font-medium text-[28px]">
                                                            <?php echo esc_html($different_title); ?>
                                                        </h3>
                                                    <?php endif; ?>

                                                    <?php if ($different_content): ?>
                                                        <div class="font-normal md:text-[24px] text-lg">
                                                            <?php echo wp_kses_post($different_content); ?>
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
                            <p class="inline-block bg-black/50 p-4 rounded-lg font-dm-sans text-[var(--color-wyz-guest-white)] style-md">
                                No steps content found. Please add content to your step groups.
                            </p>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        var $slider = $('.different-slider');

        $slider.each(function() {
            var $this = $(this);
            var $items = $this.find('.different-slider-item');

            console.log('Found ' + $items.length + ' different items');

            if ($items.length > 0) {
                $this.slick({
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
                                slidesToShow: 1.5,
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
                                arrows: false,
                                centerMode: true,
                                centerPadding: '20px'
                            }
                        }
                    ]
                });
            }
        });
    });
</script>