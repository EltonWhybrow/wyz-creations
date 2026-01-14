<?php
$action_title = get_field('action_title');
$action_subtitle = get_field('action_subtitle');
$action_bg_image = get_field('action_bg_image');
$action_link = get_field('action_link');

// Define the group names
$step_groups = array('step_1', 'step_2', 'step_3', 'step_4');
?>

<div class="relative overflow-hidden section steps-slider-module"
    <?php if ($action_bg_image && is_array($action_bg_image) && isset($action_bg_image['url'])): ?>
    style="background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url('<?php echo esc_url($action_bg_image['url']); ?>') 0% 50% / cover no-repeat;"
    <?php endif; ?>>
    <!-- Optional: Overlay for better text readability -->
    <div class="z-0 absolute inset-0 bg-black/20"></div>


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative">
        <div class="w-full">
            <div class="w-full">

                <!-- Content Section -->
                <div class="flex flex-col justify-center items-center px-10 md:px-[10vw] py-[50px] md:py-[120px] text-center">
                    <?php if ($action_title): ?>
                        <h2 class="mx-auto mb-0! font-semibold! text-[36px]! text-[var(--color-truvi-guest-white)] md:text-[64px]! leading-9! md:leading-[60px]!">
                            <?php echo esc_html($action_title); ?>
                        </h2>
                        <p class="mt-4 text-[var(--color-truvi-guest-white)] text-xl">
                            <?php echo esc_html($action_subtitle); ?>
                        </p>
                    <?php endif; ?>



                    <?php if ($action_link) : ?>
                        <div class="slide-up">
                            <a
                                href="<?php echo esc_url($action_link['url']); ?>"
                                target="<?php echo esc_attr($action_link['target']); ?>"
                                class="mx-auto w-full transition-all duration-300 truvi-btn secondary">
                                <?php echo esc_html($action_link['title']); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>


            </div>
        </div>
    </div>
</div>