<?php
$args = wp_parse_args($args, [
    'title'    => '',
    'subtitle' => '',
    'image'    => null,
    'link'     => null,
]);

$action_title    = $args['title'];
$action_subtitle = $args['subtitle'];
$action_bg_image = $args['image'];
$action_link     = $args['link'];
?>

<div class="relative overflow-hidden section steps-slider-module"
    <?php if ($action_bg_image && is_array($action_bg_image) && isset($action_bg_image['url'])): ?>
    style="background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.9)), url('<?php echo esc_url($action_bg_image['url']); ?>') 0% 50% / cover no-repeat;"
    <?php endif; ?>>
    <!-- Optional: Overlay for better text readability -->
    <div class="z-0 absolute inset-0 bg-black/20"></div>


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative">
        <div class="w-full">

            <!-- Content Section -->
            <div class="flex flex-col justify-center items-center px-4 md:px-[10vw] py-6 md:py-[120px] text-center">

                <?php if ($action_link) : ?>
                    <div class="w-full slide-up">
                        <a
                            href="<?php echo esc_url($action_link['url']); ?>"
                            target="<?php echo esc_attr($action_link['target'] ?: '_self'); ?>"

                            class="mx-auto w-full transition-all duration-300 wyz-btn secondary">
                            <?php echo esc_html($action_link['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>