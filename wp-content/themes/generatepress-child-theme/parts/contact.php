<?php
$contact_image = get_field('contact_image');
$contact_title = get_field('contact_title');
$contact_content = get_field('contact_content');
$contact_link = get_field('contact_link');
$contact_info = get_field('contact_info');

?>

<section class="px-5 lg:px-60 py-2 md:pt-[120px] contact-us">

    <div class="relative flex md:flex-row flex-col justify-center items-center gap-[30px] md:gap-28 pb-[50px] md:pb-[120px]">
        <div class="flex flex-col flex-1 mx-auto md:text-left text-center contact-us-content">
            <?php if ($contact_title) : ?>
                <h1 class="mb-2.5! md:px-0! pt-2.5! slide-up">
                    <?php echo esc_html($contact_title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($contact_content) : ?>
                <div class="mx-auto my-0! max-w-4xl text-[18px] lg:text-2xl leading-normal! slide-up">
                    <?php echo wp_kses_post($contact_content); ?>
                </div>
            <?php endif; ?>

            <?php if ($contact_link) : ?>
                <div class="mt-5 slide-up">
                    <a
                        href="<?php echo esc_url($contact_link['url']); ?>"
                        target="<?php echo esc_attr($contact_link['target']); ?>"
                        class="md:w-fit transition-all duration-300 wyz-btn tertiary">
                        <?php echo esc_html($contact_link['title']); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>

        <?php if ($contact_image) : ?>
            <div
                class="flex-1 my-2 rounded-[35px] w-full md:w-auto overflow-hidden scale-hover">
                <img src="<?php echo esc_url($contact_image['url']); ?>" alt="" class="w-full h-60! md:h-[430px]! object-cover" loading="lazy">
            </div>
        <?php endif; ?>
    </div>

    <?php
    if ($contact_info):
    ?>


        <div class="flex md:flex-row flex-col justify-center gap-5 my-[50px] md:text-left text-center align-middle">


            <div class="w-full">
                <h3 class="my-5 mb-2.5! font-medium md:font-semibold text-[28px]! md:text-[32px]!">
                    <?php echo esc_html($contact_info['phone_label']); ?>
                </h3>
                <p class="text-[24px]">
                    <?php echo esc_html($contact_info['phone_data']); ?>
                </p>
            </div>




            <div class="w-full">
                <h3 class="my-5 mb-2.5! font-semibold text-[28px]! md:text-[32px]!">
                    <?php echo esc_html($contact_info['email_label']); ?>
                </h3>
                <p class="text-[24px]">
                    <a href="mailto:<?php echo esc_attr($contact_info['email_data']); ?>"
                        class="hover:text-blue-400 transition-colors duration-300">
                        <?php echo esc_html($contact_info['email_data']); ?>
                    </a>
                </p>
            </div>




            <div class="w-full">
                <h3 class="my-5 mb-2.5! font-semibold text-[28px]! md:text-[32px]!">
                    <?php echo esc_html($contact_info['response_time_label']); ?>
                </h3>
                <p class="text-[24px]">
                    <?php echo esc_html($contact_info['response_time_data']); ?>
                </p>
            </div>




        </div>

    <?php endif; ?>

</section>