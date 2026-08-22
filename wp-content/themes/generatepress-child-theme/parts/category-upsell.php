<?php
?>

<section id="show-me">

    <div class="mx-auto p-1">
        <div class="items-stretch gap-1 grid grid-cols-1 lg:grid-cols-2">

            <!-- Cards -->

            <?php if (have_rows('category_upsell_repeater')) : ?>
                <?php while (have_rows('category_upsell_repeater')) : the_row();
                    $upsell_title = get_sub_field('upsell_title');
                    $upsell_content = get_sub_field('upsell_content');
                    $upsell_image = get_sub_field('upsell_image');
                    $upsell_link = get_sub_field('upsell_link');

                    $bg_image_url = $upsell_image ? wp_get_attachment_image_url($upsell_image, 'large') : '';
                ?>

                    <div
                        class="group flex flex-col flex-1 bg-cover bg-no-repeat bg-center info-card"
                        <?php if ($bg_image_url) : ?>
                        style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"
                        <?php endif; ?>>

                        <?php if ($upsell_link) : ?>
                            <a
                                href="<?php echo esc_url($upsell_link['url']); ?>"
                                class="top-0 left-0 absolute max-lg:bg-wyz-creations-guest-black-chalk-50 group-hover:bg-wyz-creations-guest-black-chalk-50 w-full h-full transition-colors duration-300 ease-in-out">

                            </a>
                        <?php endif; ?>


                        <div class="mt-auto">
                            <?php if ($upsell_content) : ?>
                                <div class="relative info-card-text">
                                    <?php echo wp_kses_post($upsell_content); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($upsell_title) : ?>
                                <h3 class="font-semibold text-[40px] text-wyz-creations-guest-black-chalk max-lg:text-wyz-guest-white group-hover:text-wyz-guest-white leading-10 transition-colors duration-400 ease-in-out stagger-words">

                                    <?php echo esc_html($upsell_title); ?>
                                </h3>
                            <?php endif; ?>


                            <!-- CTA button -->
                            <?php if ($upsell_link) : ?>

                                <a
                                    href="<?php echo esc_url($upsell_link['url']); ?>"
                                    target="<?php echo esc_attr($upsell_link['target']); ?>"
                                    class="group relative wyz-btn btn-sm primary">
                                    <?php echo esc_html($upsell_link['title']); ?>
                                </a>

                            <?php endif; ?>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php endif; ?>
        </div>




    </div>
</section>
