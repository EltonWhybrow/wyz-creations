<?php

// Audience targeting — admins always see everything for preview
$audience = get_sub_field('uk_eu_only') ?: 'everywhere';
if ($audience !== 'everywhere' && !current_user_can('manage_options')) {
    $uk_eu = ['AT','BE','BG','HR','CY','CZ','DK','EE','FI','FR','DE','GR','HU',
              'IE','IT','LV','LT','LU','MT','NL','PL','PT','RO','SK','SI','ES','SE','GB'];
    $country = '';
    $is_local = str_ends_with($_SERVER['HTTP_HOST'] ?? '', '.local');
    if ($is_local && isset($_GET['test_country'])) {
        $country = strtoupper(sanitize_text_field($_GET['test_country']));
    } elseif (class_exists('WC_Geolocation')) {
        $location = WC_Geolocation::geolocate_ip();
        $country  = $location['country'] ?? '';
    }
    if ($country) {
        $in_uk_eu = in_array($country, $uk_eu, true);
        if ($audience === 'uk_eu_only' && !$in_uk_eu) return;
        if ($audience === 'rest_of_world' && $in_uk_eu) return;
    }
}

$action_title          = get_sub_field('action_title');
$action_subtitle       = get_sub_field('action_subtitle');
$action_bg_image       = get_sub_field('action_bg_image');
$action_bg_image_mobile = get_sub_field('action_bg_image_mobile');
$overlay_opacity       = get_sub_field('overlay_opacity');
$action_link = get_sub_field('action_link');
$action_text_align = strtolower(get_sub_field('action_text_align') ?: 'center');
$overlay_alpha = round(max(0, min(100, (int) ($overlay_opacity !== false && $overlay_opacity !== '' ? $overlay_opacity : 40))) / 100, 2);

$align_classes = [
    'left'   => 'items-start text-left',
    'center' => 'items-center text-center',
    'right'  => 'items-end text-right',
];
$align_class = $align_classes[$action_text_align] ?? $align_classes['center'];
?>

<?php
$bg_id        = is_array($action_bg_image) ? ($action_bg_image['id'] ?? 0) : (int) $action_bg_image;
$bg_mobile_id = is_array($action_bg_image_mobile) ? ($action_bg_image_mobile['id'] ?? 0) : 0;
?>

<div class="relative overflow-hidden skip-lazy" id="call-to-action">
    <?php if ($bg_id) : ?>
        <div class="z-0 absolute inset-0 overflow-hidden">
            <?php if ($bg_mobile_id) :
                $mobile_src    = wp_get_attachment_image_url($bg_mobile_id, 'full');
                $mobile_srcset = wp_get_attachment_image_srcset($bg_mobile_id, 'full');
            ?>
                <picture class="absolute inset-0 w-full h-full">
                    <source media="(max-width: 767px)" srcset="<?php echo esc_attr($mobile_srcset ?: $mobile_src); ?>" sizes="100vw">
                    <?php echo wp_get_attachment_image($bg_id, 'full', false, [
                        'class'   => 'absolute inset-0 w-full h-full object-cover',
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'sizes'   => '100vw',
                        'alt'     => '',
                    ]); ?>
                </picture>
            <?php else : ?>
                <?php echo wp_get_attachment_image($bg_id, 'full', false, [
                    'class'   => 'absolute inset-0 w-full h-full object-cover',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                    'sizes'   => '100vw',
                    'alt'     => '',
                ]); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="z-0 absolute inset-0" style="background: rgba(0,0,0,<?php echo $overlay_alpha; ?>);"></div>


    <!-- Content Container (everything on top) -->
    <div class="z-10 relative">
        <div class="pb-1 w-full">


            <!-- Content Section -->
            <div class="flex flex-col justify-center <?php echo esc_attr($align_class); ?> px-10 md:px-[10vw] py-[50px] md:py-[210px]">
                <?php if ($action_title): ?>
                    <h2 class="mb-0! font-semibold! text-[36px]! text-wyz-guest-white md:text-[64px]! leading-9! md:leading-[60px]!">
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