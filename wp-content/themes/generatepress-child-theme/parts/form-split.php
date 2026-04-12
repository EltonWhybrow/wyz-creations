<?php
$contact_image = get_field('contact_image');
$contact_title = get_field('contact_title');
$contact_content = get_field('contact_content');

$contact_info = get_field('contact_info');

?>

<section class="py-2 md:pt-10">

    <div class="relative flex md:flex-row flex-col justify-center gap-5 md:gap-28 pb-[50px]">
        <div class="flex flex-col flex-1 mx-auto md:text-left text-center form-split-content">
            <?php if ($contact_title) : ?>
                <h1 class="slide-up">
                    <?php echo esc_html($contact_title); ?>
                </h1>
            <?php endif; ?>



            <?php
            $page_content = get_query_var('page_content');
            ?>

            <div class="content">
                <?php echo apply_filters('the_content', $page_content); ?>
            </div>

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
        <h2>Also...</h2>

        <div class="flex md:flex-row flex-col justify-center gap-18 my-[50px] md:text-left text-center align-middle">

            <div class="w-full">
                <h3 class="my-5 mb-2.5! font-semibold text-[20px] md:text-[24px]">
                    <?php echo esc_html($contact_info['phone_label']); ?>
                </h3>
                <p class="text-base">
                    <?php echo esc_html($contact_info['phone_data']); ?>
                </p>
            </div>


            <div class="w-full">
                <h3 class="my-5 mb-2.5! font-semibold text-[20px] md:text-[24px]">
                    <?php echo esc_html($contact_info['email_label']); ?>
                </h3>
                <p class="text-base">
                    <?php echo esc_html($contact_info['email_data']); ?>
                </p>
                </p>
            </div>


            <div class="w-full">
                <h3 class="my-5 mb-2.5! font-semibold text-[20px] md:text-[24px]">
                    <?php echo esc_html($contact_info['response_time_label']); ?>
                </h3>
                <p class="text-base">
                    <?php echo esc_html($contact_info['response_time_data']); ?>
                </p>
            </div>


        </div>

    <?php endif; ?>

</section>