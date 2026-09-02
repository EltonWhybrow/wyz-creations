<?php
$slider_heading = get_sub_field('slider_heading');
$taxonomy_term = get_sub_field('taxonomy_term');
?>

<div class="relative overflow-hidden section featured-posts-module">


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative mb-5">
        <div class="w-full">
            <div class="w-full">

                <!-- Content Section -->
                <div class="featured-posts-header">
                    <?php if ($slider_heading): ?>
                        <h2 class="mb-0! font-semibold text-[50px] text-wyz-creations-guest-black-chalk leading-9 stagger-words">
                            <?php echo esc_html($slider_heading); ?>
                        </h2>
                    <?php endif; ?>

                    <!-- Arrows -->
                    <div class="flex gap-3">
                        <button class="featured-posts-prev">
                            <i class="fa-chevron-left fa-solid"></i>
                        </button>
                        <button class="featured-posts-next">
                            <i class="fa-chevron-right fa-solid"></i>
                        </button>
                    </div>

                </div>

                <!-- Full Width Posts Slider -->
                <div class="pt-2 pb-1 w-full">
                    <div class="featured-posts-slider">
                        <?php
                        // Posts shown are those in the chosen category, plus any
                        // post marked Sticky — merged into one ID list so the
                        // query below is a plain OR of the two criteria.
                        $sticky_ids = get_option('sticky_posts');
                        $sticky_ids = is_array($sticky_ids) ? $sticky_ids : [];

                        $category_ids = [];
                        if ($taxonomy_term) {
                            $category_query = new WP_Query([
                                'post_type'      => 'post',
                                'posts_per_page' => -1,
                                'fields'         => 'ids',
                                'tax_query'      => [
                                    [
                                        'taxonomy' => 'category',
                                        'field'    => 'term_id',
                                        'terms'    => $taxonomy_term,
                                    ],
                                ],
                            ]);
                            $category_ids = $category_query->posts;
                        }

                        $post_ids = array_unique(array_merge($category_ids, $sticky_ids));

                        $args = [
                            'post_type'           => 'post',
                            'posts_per_page'      => 21,
                            'post__in'            => !empty($post_ids) ? $post_ids : [0],
                            'orderby'             => 'post__in',
                            'ignore_sticky_posts' => 1,
                        ];

                        $posts_query = new WP_Query($args);

                        if ($posts_query->have_posts()) :
                            while ($posts_query->have_posts()) : $posts_query->the_post();

                                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                $name = get_the_title();
                                $short_name = mb_strlen($name) > 20 ? mb_substr($name, 0, 20) . '…' : $name;
                                $link = get_permalink();
                        ?>
                                <div class="featured-posts-slider-item">
                                    <a href="<?php echo esc_url($link); ?>" class="group block h-full">
                                        <div class="flex flex-col justify-end gap-1 p-10 h-full min-h-[480px] md:min-h-[570px] overflow-hidden transition-all duration-500"
                                            style="background: url('<?php echo esc_url($image); ?>') center/cover no-repeat;">

                                            <!-- Content -->
                                            <div class="flex items-center p-4 align-center">
                                                <div class="w-full transition-transform translate-y-2 group-hover:translate-y-0 duration-500 transform">
                                                    <div class="text-center featured-posts-content">

                                                        <div
                                                            class="group relative wyz-btn btn-sm primary">
                                                            <?php echo esc_html($short_name); ?>
                                                        </div>

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
                            <p class="text-white text-center">No featured posts found.</p>
                        <?php endif; ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        var $slider = $('.featured-posts-slider');

        $slider.each(function() {
            var $this = $(this);
            var $items = $this.find('.featured-posts-slider-item');

            if ($items.length > 0) {
                $this.slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: true,
                    prevArrow: $this.closest('.featured-posts-module').find('.featured-posts-prev'),
                    nextArrow: $this.closest('.featured-posts-module').find('.featured-posts-next'),
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
