<?php
$our_mission_image = get_field('our_mission_image');
$our_mission_title = get_field('our_mission_title');
$our_mission_sub_title = get_field('our_mission_sub_title');
$our_mission_content = get_field('our_mission_content');

?>

<section class="relative flex md:flex-row flex-col-reverse justify-center items-center gap-[30px] md:gap-28 mx-auto md:mx-5! px-5 md:px-[10vw] py-[60px] md:py-40 overflow-hidden our-mission">

    <div class="z-10 relative flex flex-col flex-1 gap-5 mx-auto md:pt-[100px] md:pb-[150px] our-mission-content container">
        <?php if ($our_mission_title) : ?>
            <h1 class="mb-0! md:px-0! pt-2.5! slide-up">
                <?php echo esc_html($our_mission_title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($our_mission_sub_title) : ?>
            <p class="mx-auto! mb-0! md:px-0! font-semibold text-[24px] text-[var(--color-wyz-creations-guest-dark-gray)] md:text-2xl leading-6! slide-up">
                <?php echo esc_html($our_mission_sub_title); ?>
            </p>
        <?php endif; ?>

        <?php if ($our_mission_content) : ?>
            <div class="mx-auto my-0! max-w-4xl text-[18px] lg:text-2xl text-left leading-normal! slide-up">
                <?php echo wp_kses_post($our_mission_content); ?>
            </div>
        <?php endif; ?>

    </div>

    <?php if ($our_mission_image) : ?>
        <div
            class="flex-1 my-2 rounded-[35px] w-full md:w-auto overflow-hidden">
            <img src="<?php echo esc_url($our_mission_image['url']); ?>" alt="" class="w-full h-[290px]! md:h-[587px]! object-cover" loading="lazy">
        </div>
    <?php endif; ?>

</section>