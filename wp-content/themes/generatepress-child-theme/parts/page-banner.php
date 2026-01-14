<?php
$page_banner_image = get_field('page_banner_image');
$page_banner_title = get_field('page_banner_title');
$page_banner_sub_title = get_field('page_banner_sub_title');
$page_banner_button_link = get_field('page_banner_button_link');
?>

<section class="relative justify-center items-center mx-auto overflow-hidden page-banner">



    <!-- Main Content Container -->
    <div class="z-10 relative mx-auto px-5! py-[30px] md:pt-[100px] md:pb-[150px] text-center page-banner-content container">
        <?php if ($page_banner_title) : ?>
            <h1 class="mb-2.5! px-4! md:px-0! pt-2.5! slide-up">
                <?php echo esc_html($page_banner_title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($page_banner_sub_title) : ?>
            <p class="mx-auto! mb-3 px-5! md:px-0! md:max-w-[700px]! max-w-4xl text-[18px] lg:text-2xl text-center leading-normal! slide-up">
                <?php echo esc_html($page_banner_sub_title); ?>
            </p>
        <?php endif; ?>

        <!-- Button desktop -->
        <?php if ($page_banner_button_link) : ?>
            <div class="mt-8 slide-up">
                <a
                    href="<?php echo esc_url($page_banner_button_link['url']); ?>"
                    target="<?php echo esc_attr($page_banner_button_link['target']); ?>"
                    class="mx-auto w-fit transition-all duration-300 wyz-btn primary">
                    <?php echo esc_html($page_banner_button_link['title']); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>

    <?php if ($page_banner_image) : ?>
        <div
            class="my-2 h-[315px] md:h-[435px] overflow-hidden">
            <img src="<?php echo esc_url($page_banner_image['url']); ?>" alt="" class="w-full h-full! object-cover" loading="lazy">
        </div>
    <?php endif; ?>

</section>