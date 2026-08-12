<?php
$trusted_heading = get_field('trusted_heading');
// $trusted_subheading = get_field('trusted_subheading');

// Define the group names
$trusted_groups = array('trusted_1', 'trusted_2', 'trusted_3', 'trusted_4');
?>


<div class="relative overflow-hidden section best-seller-slider-module">


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative mb-5">
        <div class="w-full">
            <div class="w-full">

                <!-- Content Section -->
                <div class="best-seller-header">
                    <?php if ($trusted_heading): ?>
                        <h2 class="mb-0! font-semibold text-[50px] text-wyz-creations-guest-black-chalk leading-9 stagger-words">
                            <?php echo esc_html($trusted_heading); ?>
                        </h2>
                        <!-- <p class="md:text-left text-center">
                            <?php //echo esc_html($trusted_subheading); 
                            ?>
                        </p> -->
                    <?php endif; ?>

                    <!-- Arrows -->
                    <div class="flex gap-3">
                        <button class="trusted-prev">
                            <i class="fa-chevron-left fa-solid"></i>
                        </button>
                        <button class="trusted-next">
                            <i class="fa-chevron-right fa-solid"></i>
                        </button>
                    </div>

                </div>

                <!-- Full Width Steps Slider -->
                <div class="pt-2 pb-1 w-full">
                    <div class="best-seller-slider">
                        <?php
                        $args = [
                            'post_type' => 'product',
                            'posts_per_page' => 21,
                            'tax_query' => [
                                [
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'slug',
                                    'terms'    => 'best-sellers',
                                ],
                            ],
                        ];

                        $products = new WP_Query($args);

                        if ($products->have_posts()) :
                            while ($products->have_posts()) : $products->the_post();
                                global $product;

                                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                $name = get_the_title();
                                $short_name = mb_strlen($name) > 20 ? mb_substr($name, 0, 20) . '…' : $name;
                                // $price = $product->get_price_html();
                                $link = get_permalink();
                        ?>
                                <div class="best-seller-slider-item">
                                    <a href="<?php echo esc_url($link); ?>" class="group block h-full">
                                        <div class="flex flex-col justify-end gap-1 p-10 h-full min-h-[480px] md:min-h-[570px] overflow-hidden transition-all duration-500"
                                            style="background: url('<?php echo esc_url($image); ?>') center/cover no-repeat;">

                                            <!-- Content -->
                                            <div class="flex items-center p-4 align-center">
                                                <div class="w-full transition-transform translate-y-2 group-hover:translate-y-0 duration-500 transform">
                                                    <div class="text-center best-seller-content">



                                                        <?php  ?>

                                                        <div
                                                            class="group relative wyz-btn btn-sm primary">
                                                            <?php echo esc_html($short_name); ?>
                                                        </div>

                                                        <?php ?>



                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <p class="text-white text-center">No products found.</p>
                        <?php endif; ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        var $slider = $('.best-seller-slider');

        $slider.each(function() {
            var $this = $(this);
            var $items = $this.find('.best-seller-slider-item');

            if ($items.length > 0) {
                $this.slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: true,
                    prevArrow: $('.trusted-prev'),
                    nextArrow: $('.trusted-next'),
                    dots: false,
                    autoplay: false,
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
                                slidesToScroll: 2,
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