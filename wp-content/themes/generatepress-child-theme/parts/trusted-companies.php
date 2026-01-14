<?php
$title = get_field('trusted_title');
$logos = [];
for ($i = 1; $i <= 4; $i++) {
    $logos[$i] = get_field("company_logo_$i");
}
?>

<div class="mx-14 py-10 md:py-[50px]">
    <?php if ($title) : ?>
        <div class="relative mb-8 text-center">

            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-(--color-truvi-guest-dark-gray)"></div>
            </div>

            <span class="relative inline-block bg-[var(--color-wyz-guest-white)] px-2 md:px-10 text-(--color-truvi-guest-black-chalk) text-base md:text-xl font-semibold md:font-normal">
                <?php echo esc_html($title); ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
        <?php foreach ($logos as $index => $logo) : ?>
            <?php if ($logo) : ?>
                <div class="flex justify-center items-center">
                    <img
                        src="<?php echo esc_url($logo['url']); ?>"
                        alt="<?php echo esc_attr($logo['alt']); ?>"
                        class="opacity-80 hover:opacity-100 w-auto h-8 md:h-10 object-contain transition-opacity"
                        loading="lazy" />
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>