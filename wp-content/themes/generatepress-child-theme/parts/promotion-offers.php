<?php if (have_rows('promos_and_offers')) : ?>

    <div class="mx-auto my-10">
        <div class="gap-2 grid md:grid-cols-2">

            <?php while (have_rows('promos_and_offers')) : the_row(); ?>

                <?php if (get_row_layout() === 'offer_block') :

                    $action_link     = get_sub_field('offer_link');
                    $action_bg_image = get_sub_field('offer_bg_image');
                    $action_title    = get_sub_field('offer_title');
                    $action_subtitle    = get_sub_field('offer_subtitle');
                ?>

                    <div class="relative overflow-hidden section steps-slider-module"
                        <?php if (!empty($action_bg_image['url'])) : ?>
                        style="background: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.75)), url('<?php echo esc_url($action_bg_image['url']); ?>') center/cover no-repeat;"
                        <?php endif; ?>>

                        <div class="z-0 absolute inset-0 bg-black/20"></div>

                        <div class="z-10 relative">
                            <div class="flex flex-col justify-center items-center px-4 py-16 min-h-[400px] text-center">

                                <?php if ($action_title) : ?>
                                    <h3 class="mb-6 font-bold text-white text-2xl md:text-3xl">
                                        <?php echo esc_html($action_title); ?>
                                    </h3>
                                    <p class="mt-4 text-wyz-guest-white text-xl">
                                        <?php echo esc_html($action_subtitle); ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($action_link) :
                                    $url    = $action_link['url'] ?? '';
                                    $title  = $action_link['title'] ?? '';
                                    $target = $action_link['target'] ?? '_self';
                                ?>

                                    <a href="<?php echo esc_url($url); ?>"
                                        target="<?php echo esc_attr($target); ?>"
                                        class="wyz-btn btn-lg secondary">
                                        <?php echo esc_html($title); ?>
                                    </a>

                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            <?php endwhile; ?>

        </div>
    </div>

<?php endif; ?>