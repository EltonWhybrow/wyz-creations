<?php

$page_id = get_query_var('cta_page_id');

// HARD fallback (important)
if (!$page_id) {
    $page_id = get_queried_object_id();
}



$cat_action_title = get_field('cat_action_title', $page_id);
$cat_action_subtitle = get_field('cat_action_subtitle', $page_id);
$cat_action_bg_image = get_field('cat_action_bg_image', $page_id);
$cat_action_link = get_field('cat_action_link', $page_id);

// Define the group names
$step_groups = array('step_1', 'step_2', 'step_3', 'step_4');
?>

<?php
$bg_url = '';

if (is_array($cat_action_bg_image) && isset($cat_action_bg_image['url'])) {
    $bg_url = $cat_action_bg_image['url'];
} elseif (is_string($cat_action_bg_image)) {
    $bg_url = $cat_action_bg_image; // already a URL
} elseif (is_numeric($cat_action_bg_image)) {
    $bg_url = wp_get_attachment_image_url($cat_action_bg_image, 'full');
}
?>

<div class="relative overflow-hidden skip-lazy" id="call-to-action"
    <?php if ($bg_url): ?>
    style="background: linear-gradient(rgba(0,0,0,0.30), rgba(0,0,0,0.0)), url('<?php echo esc_url($bg_url); ?>') center / cover no-repeat;"
    <?php endif; ?>>
    <!-- Optional: Overlay for better text readability -->
    <div class="z-0 absolute inset-0 bg-black/40"></div>


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative">
        <div class="pb-1 w-full">


            <!-- Content Section -->
            <div class="flex flex-col justify-center items-center px-10 md:px-[10vw] py-[50px] md:py-[175px] text-center">
                <?php if ($cat_action_title): ?>
                    <h2 class="mx-auto mb-0! font-semibold! text-[36px]! text-wyz-guest-white md:text-[64px]! leading-9! md:leading-[60px]!">
                        <?php echo esc_html($cat_action_title); ?>
                    </h2>
                    <p class="mt-4 text-wyz-guest-white text-xl">
                        <?php echo esc_html($cat_action_subtitle); ?>
                    </p>
                <?php endif; ?>



                <?php if ($cat_action_link) : ?>
                    <div class="slide-up">
                        <a
                            href="<?php echo esc_url($cat_action_link['url']); ?>"
                            target="<?php echo esc_attr($cat_action_link['target']); ?>"
                            class="mx-auto w-full transition-all duration-300 wyz-btn btn-lg secondary">
                            <?php echo esc_html($cat_action_link['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>



        </div>
    </div>
</div>