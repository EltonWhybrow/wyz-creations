<?php
$things_title = get_field('things_title');
$things_subtitle = get_field('things_subtitle');
$things_image = get_field('things_image');

$guests_protection = get_field('protection');
// Extract guests protection group
$guests_protection_title = $guests_protection['protection_title'] ?? '';
$guests_protection_content = $guests_protection['protection_content'] ?? '';
$guests_protection_icon = $guests_protection['protection_icon'] ?? '';
$guests_protection_link = $guests_protection['protection_link'] ?? '';

$guests_disruptions = get_field('disruptions');
// Extract guests disruptions group
$guests_disruptions_title = $guests_disruptions['disruptions_title'] ?? '';
$guests_disruptions_content = $guests_disruptions['disruptions_content'] ?? '';
$guests_disruptions_icon = $guests_disruptions['disruptions_icon'] ?? '';
$guests_disruptions_link = $guests_disruptions['disruptions_link'] ?? '';

$guests_issues = get_field('issues');
// Extract guests issues group
$guests_issues_title = $guests_issues['issues_title'] ?? '';
$guests_issues_content = $guests_issues['issues_content'] ?? '';
$guests_issues_icon = $guests_issues['issues_icon'] ?? '';
$guests_issues_link = $guests_issues['issues_link'] ?? '';

$guests_damage = get_field('damage');
// Extract guests damage group
$guests_damage_title = $guests_damage['damage_title'] ?? '';
$guests_damage_content = $guests_damage['damage_content'] ?? '';
$guests_damage_icon = $guests_damage['damage_icon'] ?? '';
$guests_damage_link = $guests_damage['damage_link'] ?? '';
?>

<section id="show-me">

    <!-- Main Heading -->
    <!-- <div class="mb-12 md:mb-16 text-center">
            <h1 class="text-[36px] leading-9 md:leading-16 md:text-[64px]! font-semibold! text-(--color-wyz-creations-guest-black-chalk) mb-2!">
                <?php echo esc_html($things_title); ?>
            </h1>
            <p class="!mx-auto max-w-3xl md:text-[24px] text-xl">
                <?php echo esc_html($things_subtitle); ?>
            </p>
        </div> -->

    <div class="mx-auto p-1">
        <div class="items-stretch gap-1 grid grid-cols-1 lg:grid-cols-2">

            <!-- <div class="md:hidden flex justify-center">
                <div class="relative self-stretch w-full max-w-md">
                    <img
                        src="<?php echo esc_url($things_image['url']); ?>"
                        alt="<?php echo esc_attr($things_image['alt']); ?>"
                        class="rounded-[35px] w-full h-[310px]! object-cover"
                        loading="lazy" />
                </div>
            </div> -->

            <!-- Left Cards -->

            <?php
            $bg_image_url = $guests_protection_icon ? wp_get_attachment_image_url($guests_protection_icon, 'large') : '';
            ?>

            <div
                class="group flex flex-col flex-1 bg-cover bg-no-repeat bg-center info-card"
                <?php if ($bg_image_url) : ?>
                style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"
                <?php endif; ?>>

                <?php if ($guests_protection_link) : ?>
                    <a
                        href="<?php echo esc_url($guests_protection_link['url']); ?>"
                        class="top-0 left-0 absolute group-hover:bg-wyz-creations-guest-black-chalk-50 w-full h-full transition-colors duration-300 ease-in-out">

                    </a>
                <?php endif; ?>


                <div class="mt-auto">
                    <?php if ($guests_protection_content) : ?>
                        <div class="relative info-card-text">
                            <?php echo wp_kses_post($guests_protection_content); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($guests_protection_title) : ?>
                        <h3 class="font-semibold text-[40px] text-wyz-creations-guest-black-chalk group-hover:text-wyz-guest-white leading-10 transition-colors duration-400 ease-in-out stagger-words">

                            <?php echo esc_html($guests_protection_title); ?>
                        </h3>
                    <?php endif; ?>


                    <!-- CTA button -->
                    <?php if ($guests_protection_link) : ?>

                        <a
                            href="<?php echo esc_url($guests_protection_link['url']); ?>"
                            target="<?php echo esc_attr($guests_protection_link['target']); ?>"
                            class="group relative wyz-btn btn-sm primary">
                            <?php echo esc_html($guests_protection_link['title']); ?>
                        </a>

                    <?php endif; ?>
                </div>
            </div>

            <?php
            $bg_image_url = $guests_disruptions_icon ? wp_get_attachment_image_url($guests_disruptions_icon, 'large') : '';
            ?>

            <div
                class="group flex flex-col flex-1 bg-cover bg-no-repeat bg-center info-card"
                <?php if ($bg_image_url) : ?>
                style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"
                <?php endif; ?>>

                <?php if ($guests_protection_link) : ?>
                    <a
                        href="<?php echo esc_url($guests_disruptions_link['url']); ?>"
                        class="top-0 left-0 absolute group-hover:bg-wyz-creations-guest-black-chalk-50 w-full h-full transition-colors duration-300 ease-in-out">

                    </a>
                <?php endif; ?>

                <div class="mt-auto">
                    <?php if ($guests_disruptions_content) : ?>
                        <div class="relative info-card-text">
                            <?php echo wp_kses_post($guests_disruptions_content); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($guests_disruptions_title) : ?>
                        <h3 class="font-semibold text-[40px] text-wyz-creations-guest-black-chalk group-hover:text-wyz-guest-white leading-10 transition-colors duration-400 ease-in-out stagger-words">
                            <?php echo esc_html($guests_disruptions_title); ?>
                        </h3>
                    <?php endif; ?>



                    <!-- CTA button -->
                    <?php if ($guests_disruptions_link) : ?>

                        <a
                            href="<?php echo esc_url($guests_disruptions_link['url']); ?>"
                            target="<?php echo esc_attr($guests_disruptions_link['target']); ?>"
                            class="group relative wyz-btn btn-sm primary">
                            <?php echo esc_html($guests_disruptions_link['title']); ?>
                        </a>

                    <?php endif; ?>
                </div>
            </div>
            <!-- </div>

            <div class="gap-1 grid md:grid-rows-2 h-full"> -->
            <?php
            $bg_image_url = $guests_issues_icon ? wp_get_attachment_image_url($guests_issues_icon, 'large') : '';
            ?>

            <div
                class="group flex flex-col flex-1 bg-cover bg-no-repeat bg-center info-card"
                <?php if ($bg_image_url) : ?>
                style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"
                <?php endif; ?>>

                <?php if ($guests_issues_link) : ?>
                    <a
                        href="<?php echo esc_url($guests_issues_link['url']); ?>"
                        class="top-0 left-0 absolute group-hover:bg-wyz-creations-guest-black-chalk-50 w-full h-full transition-colors duration-300 ease-in-out">

                    </a>
                <?php endif; ?>


                <div class="mt-auto">


                    <?php if ($guests_issues_content) : ?>
                        <div class="relative info-card-text">
                            <?php echo wp_kses_post($guests_issues_content); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($guests_issues_title) : ?>
                        <h3 class="font-semibold text-[40px] text-wyz-creations-guest-black-chalk group-hover:text-wyz-guest-white leading-10 transition-colors duration-400 ease-in-out stagger-words">
                            <?php echo esc_html($guests_issues_title); ?>
                        </h3>
                    <?php endif; ?>

                    <!-- CTA button -->
                    <?php if ($guests_issues_link) : ?>

                        <a
                            href="<?php echo esc_url($guests_issues_link['url']); ?>"
                            target="<?php echo esc_attr($guests_issues_link['target']); ?>"
                            class="group relative wyz-btn btn-sm primary">
                            <?php echo esc_html($guests_issues_link['title']); ?>
                        </a>

                    <?php endif; ?>
                </div>
            </div>

            <?php
            $bg_image_url = $guests_damage_icon ? wp_get_attachment_image_url($guests_damage_icon, 'large') : '';
            ?>

            <div
                class="group flex flex-col flex-1 bg-cover bg-no-repeat bg-center info-card"
                <?php if ($bg_image_url) : ?>
                style="background-image: url('<?php echo esc_url($bg_image_url); ?>');"
                <?php endif; ?>>

                <?php if ($guests_damage_link) : ?>
                    <a
                        href="<?php echo esc_url($guests_damage_link['url']); ?>"
                        class="top-0 left-0 absolute group-hover:bg-wyz-creations-guest-black-chalk-50 w-full h-full transition-colors duration-300 ease-in-out">

                    </a>
                <?php endif; ?>

                <div class="mt-auto">


                    <?php if ($guests_damage_content) : ?>
                        <div class="relative info-card-text">
                            <?php echo wp_kses_post($guests_damage_content); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($guests_damage_title) : ?>
                        <h3 class="font-semibold text-[40px] text-wyz-creations-guest-black-chalk group-hover:text-wyz-guest-white leading-10 transition-colors duration-400 ease-in-out stagger-words">
                            <?php echo esc_html($guests_damage_title); ?>
                        </h3>
                    <?php endif; ?>

                    <!-- CTA button -->
                    <?php if ($guests_damage_link) : ?>

                        <a
                            href="<?php echo esc_url($guests_damage_link['url']); ?>"
                            target="<?php echo esc_attr($guests_damage_link['target']); ?>"
                            class="group relative wyz-btn btn-sm primary">
                            <?php echo esc_html($guests_damage_link['title']); ?>
                        </a>

                    <?php endif; ?>

                </div>

            </div>
        </div>




    </div>
</section>