<?php
$our_mission_image = get_field('our_mission_image');
$our_mission_title = get_field('our_mission_title');
$our_mission_sub_title = get_field('our_mission_sub_title');
$our_mission_content = get_field('our_mission_content');

?>

<section class="our-mission flex flex-col-reverse md:flex-row relative items-center justify-center overflow-hidden mx-auto py-[60px] px-5 md:py-40 gap-[30px] md:gap-28 md:px-[10vw] md:mx-5!">

    <div class="our-mission-content flex flex-col gap-5 flex-1 relative z-10 container mx-auto md:pt-[100px] md:pb-[150px]">
        <?php if ($our_mission_title) : ?>
            <h1 class="slide-up md:px-0! pt-2.5! mb-0!">
                <?php echo esc_html($our_mission_title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($our_mission_sub_title) : ?>
            <p class="text-[24px] leading-6! md:text-2xl  font-semibold text-[var(--color-truvi-guest-dark-gray)] mb-0! md:px-0! mx-auto! slide-up">
                <?php echo esc_html($our_mission_sub_title); ?>
            </p>
        <?php endif; ?>

        <?php if ($our_mission_content) : ?>
            <div class="text-[18px] leading-normal! lg:text-2xl my-0! slide-up max-w-4xl mx-auto text-left">
                <?php echo wp_kses_post($our_mission_content); ?>
            </div>
        <?php endif; ?>

    </div>

    <?php if ($our_mission_image) : ?>
        <div
            class="my-2 flex-1 w-full md:w-auto overflow-hidden rounded-[35px]">
            <img src="<?php echo esc_url($our_mission_image['url']); ?>" alt="" class="w-full h-[290px]! md:h-[587px]! object-cover" loading="lazy">
        </div>
    <?php endif; ?>

</section>