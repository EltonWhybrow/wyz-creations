<?php
$trusted_heading = get_field('trusted_heading');
$trusted_subheading = get_field('trusted_subheading');

// Define the group names
$trusted_groups = array('trusted_1', 'trusted_2', 'trusted_3', 'trusted_4');
?>


<div class="section trusted-slider-module relative overflow-hidden bg-(--color-truvi-guest-black-chalk)">


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative">
        <div class="w-full">
            <div class="w-full">

                <!-- Content Section -->
                <div class="px-5 md:px-[10vw] pt-[60px] md:pt-[120px] trusted-header">
                    <?php if ($trusted_heading && $trusted_subheading): ?>
                        <h2 class="mb-0! font-semibold! text-[36px]! text-[var(--color-wyz-guest-white)] md:text-[64px]! md:text-left text-center leading-9! md:leading-[60px]! stagger-words">
                            <?php echo esc_html($trusted_heading); ?>
                        </h2>
                        <p class="md:text-left text-center">
                            <?php echo esc_html($trusted_subheading); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Full Width Steps Slider -->
                <div class="pt-10 md:pt-8 pb-[60px] md:pb-[120px] md:pl-[10vw]! w-full">
                    <div class="mb-2 md:mb-10 lg:mb-2 trusted-slider">
                        <?php
                        $has_content = false;

                        foreach ($trusted_groups as $trusted_group):
                            // Get all fields from the step group
                            $trusted_data = get_field($trusted_group);


                            if ($trusted_data && !empty($trusted_data)):
                                $has_content = true;

                                $trusted_image = $trusted_data['trusted_image'] ?? '';
                                $trusted_name = $trusted_data['trusted_name'] ?? '';
                                $trusted_comment = $trusted_data['trusted_comment'] ?? '';
                        ?>
                                <div class="rounded-[50px] trusted-slider-item">
                                    <div class="group block h-full">
                                        <div class="flex flex-col justify-end gap-2.5 shadow p-10 rounded-[50px] h-full min-h-[480px] overflow-hidden transition-all duration-500"
                                            style="background: url('<?php echo esc_url($trusted_image['url']); ?>') 0% 0% / cover no-repeat;">

                                            <!-- Title & Content Overlay - Slides up on Hover -->
                                            <div class="flex items-center p-4">
                                                <div class="w-full transition-transform translate-y-4 group-hover:translate-y-0 duration-500 transform">
                                                    <div class="trusted-content">

                                                        <?php if ($trusted_name): ?>
                                                            <h3 class="mb-1! font-normal text-[32px]">
                                                                <?php echo esc_html($trusted_name); ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <?php if ($trusted_comment): ?>
                                                            <div class="font-normal text-[20px]">
                                                                <?php echo wp_kses_post($trusted_comment); ?>
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
</div>

<script>
    jQuery(document).ready(function($) {
        var $slider = $('.trusted-slider');

        $slider.each(function() {
            var $this = $(this);
            var $items = $this.find('.trusted-slider-item');

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