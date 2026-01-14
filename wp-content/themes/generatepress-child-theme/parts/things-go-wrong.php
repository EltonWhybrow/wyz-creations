<?php
$things_title = get_field('things_title');
$things_subtitle = get_field('things_subtitle');
$things_image = get_field('things_image');

$guests_protection = get_field('protection');
// Extract guests protection group
$guests_protection_title = $guests_protection['protection_title'] ?? '';
$guests_protection_content = $guests_protection['protection_content'] ?? '';
$guests_protection_icon = $guests_protection['protection_icon'] ?? '';

$guests_disruptions = get_field('disruptions');
// Extract guests disruptions group
$guests_disruptions_title = $guests_disruptions['disruptions_title'] ?? '';
$guests_disruptions_content = $guests_disruptions['disruptions_content'] ?? '';
$guests_disruptions_icon = $guests_disruptions['disruptions_icon'] ?? '';

$guests_issues = get_field('issues');
// Extract guests issues group
$guests_issues_title = $guests_issues['issues_title'] ?? '';
$guests_issues_content = $guests_issues['issues_content'] ?? '';
$guests_issues_icon = $guests_issues['issues_icon'] ?? '';

$guests_damage = get_field('damage');
// Extract guests damage group
$guests_damage_title = $guests_damage['damage_title'] ?? '';
$guests_damage_content = $guests_damage['damage_content'] ?? '';
$guests_damage_icon = $guests_damage['damage_icon'] ?? '';
?>

<section id="things-go-wrong" class="py-10 md:py-24 px-0 md:px-4">
    <div class="container mx-auto max-w-6xl">
        <!-- Main Heading -->
        <div class="text-center mb-12 md:mb-16">
            <h1 class="text-[36px] leading-9 md:leading-16 md:text-[64px]! font-semibold! text-(--color-truvi-guest-black-chalk) mb-2!">
                <?php echo esc_html($things_title); ?>
            </h1>
            <p class="text-xl md:text-[24px]  max-w-3xl !mx-auto">
                <?php echo esc_html($things_subtitle); ?>
            </p>
        </div>

        <div class="container mx-auto px-4 md:pb-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 md:gap-8 items-stretch">

                <div class="flex justify-center md:hidden ">
                    <div class="relative w-full max-w-md self-stretch">
                        <img
                            src="<?php echo esc_url($things_image['url']); ?>"
                            alt="<?php echo esc_attr($things_image['alt']); ?>"
                            class="w-full h-[310px]! object-cover rounded-[35px]"
                            loading="lazy" />
                    </div>
                </div>

                <!-- Left Cards -->
                <div class="grid md:grid-rows-2 gap-6 h-full">
                    <div class="info-card flex-1 flex flex-col">
                        <?php if ($guests_protection_icon) : ?>
                            <div class="mb-4 slide-up">
                                <?php
                                echo wp_get_attachment_image(
                                    $guests_protection_icon, // Now guaranteed to be an ID
                                    'thumbnail',
                                    false,
                                    ['class' => 'w-10 h-10 object-contain', 'loading' => 'lazy']
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="mt-auto">
                            <?php if ($guests_protection_title) : ?>
                                <h3 class="text-[28px] md:text-[32px]! font-medium! leading-8! mb-4!">
                                    <?php echo esc_html($guests_protection_title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($guests_protection_content) : ?>
                                <div class="info-card-text">
                                    <?php echo wp_kses_post($guests_protection_content); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-card flex-1 flex flex-col">
                        <?php if ($guests_disruptions_icon) : ?>
                            <div class="mb-4 slide-up">
                                <?php
                                echo wp_get_attachment_image(
                                    $guests_disruptions_icon, // Now guaranteed to be an ID
                                    'thumbnail',
                                    false,
                                    ['class' => 'w-10 h-10 object-contain', 'loading' => 'lazy']
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="mt-auto">
                            <?php if ($guests_disruptions_title) : ?>
                                <h3 class="text-[32px]! font-medium! leading-8! mb-4!">
                                    <?php echo esc_html($guests_disruptions_title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($guests_disruptions_content) : ?>
                                <div class="info-card-text">
                                    <?php echo wp_kses_post($guests_disruptions_content); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Center Image desktop -->
                <div class="md:flex items-stretch justify-center hidden "> <!-- Added items-stretch -->
                    <div class="relative w-full max-w-md self-stretch"> <!-- Added self-stretch -->
                        <img
                            src="<?php echo esc_url($things_image['url']); ?>"
                            alt="<?php echo esc_attr($things_image['alt']); ?>"
                            class="w-full h-full! object-cover rounded-[35px]"
                            loading="lazy" />
                    </div>
                </div>

                <!-- Right Cards -->
                <div class="grid md:grid-rows-2 gap-6 h-full">
                    <div class="info-card flex-1 flex flex-col">
                        <?php if ($guests_issues_icon) : ?>
                            <div class="mb-4 slide-up">
                                <?php
                                echo wp_get_attachment_image(
                                    $guests_issues_icon, // Now guaranteed to be an ID
                                    'thumbnail',
                                    false,
                                    ['class' => 'w-10 h-10 object-contain', 'loading' => 'lazy']
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="mt-auto">
                            <?php if ($guests_issues_title) : ?>
                                <h3 class="text-[32px]! font-medium! leading-8!">
                                    <?php echo esc_html($guests_issues_title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($guests_issues_content) : ?>
                                <div class="info-card-text">
                                    <?php echo wp_kses_post($guests_issues_content); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-card flex-1 flex flex-col">
                        <?php if ($guests_damage_icon) : ?>
                            <div class="mb-4 slide-up">
                                <?php
                                echo wp_get_attachment_image(
                                    $guests_damage_icon, // Now guaranteed to be an ID
                                    'thumbnail',
                                    false,
                                    ['class' => 'w-10 h-10 object-contain', 'loading' => 'lazy']
                                );
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="mt-auto">
                            <?php if ($guests_damage_title) : ?>
                                <h3 class="text-[32px]! font-medium! leading-8! mb-4!">
                                    <?php echo esc_html($guests_damage_title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($guests_damage_content) : ?>
                                <div class="info-card-text">
                                    <?php echo wp_kses_post($guests_damage_content); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</section>