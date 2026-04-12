<?php

$page_id = get_query_var('cta_page_id');

// HARD fallback (important)
if (!$page_id) {
    $page_id = get_queried_object_id();
}



$action_title = get_field('action_title', $page_id);
$action_subtitle = get_field('action_subtitle', $page_id);
$action_bg_image = get_field('action_bg_image', $page_id);
$action_link = get_field('action_link', $page_id);

// Define the group names
$step_groups = array('step_1', 'step_2', 'step_3', 'step_4');
?>

<?php
$bg_url = '';

if (is_array($action_bg_image) && isset($action_bg_image['url'])) {
    $bg_url = $action_bg_image['url'];
} elseif (is_string($action_bg_image)) {
    $bg_url = $action_bg_image; // already a URL
} elseif (is_numeric($action_bg_image)) {
    $bg_url = wp_get_attachment_image_url($action_bg_image, 'full');
}
?>

<div class="relative overflow-hidden" id="call-to-action"
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
                <?php if ($action_title): ?>
                    <h2 class="mx-auto mb-0! font-semibold! text-[36px]! text-wyz-guest-white md:text-[64px]! leading-9! md:leading-[60px]!">
                        <?php echo esc_html($action_title); ?>
                    </h2>
                    <p class="mt-4 text-wyz-guest-white text-xl">
                        <?php echo esc_html($action_subtitle); ?>
                    </p>
                <?php endif; ?>



                <?php if ($action_link) : ?>
                    <div class="slide-up">
                        <a
                            href="<?php echo esc_url($action_link['url']); ?>"
                            target="<?php echo esc_attr($action_link['target']); ?>"
                            class="mx-auto w-full transition-all duration-300 wyz-btn btn-lg secondary">
                            <?php echo esc_html($action_link['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>



        </div>
    </div>
</div>