<?php
$we_discovered_title = get_field('we_discovered_title');
$we_discovered_subtitle = get_field('we_discovered_subtitle');

// Store all discoveries in an array for easy looping
$discovery_items = [];

// Get and process each discovery group
for ($i = 1; $i <= 4; $i++) {
    $discovery_group = get_field("discovery_{$i}");

    if ($discovery_group && (isset($discovery_group['title']) || isset($discovery_group['content']))) {
        $discovery_items[] = [
            'title' => $discovery_group['title'] ?? '',
            'content' => $discovery_group['content'] ?? ''
        ];
    }
}


?>

<section class="mx-5 px-0 md:px-[10vw] py-10 md:py-[120px]">

    <!-- Main Heading -->
    <div class="mb-0 md:mb-16 text-center discovered-heading">
        <h1 class="text-[36px]! leading-9! md:leading-16 md:text-[64px]! font-semibold! text-(--color-wyz-creations-guest-black-chalk) mb-2.5!">
            <?php echo esc_html($we_discovered_title); ?>
        </h1>
        <p class="mx-auto! mb-[30px]! max-w-3xl text-[18px] md:text-[24px]">
            <?php echo esc_html($we_discovered_subtitle); ?>
        </p>
    </div>

    <div class="mx-auto md:pb-16 container">
        <?php if (!empty($discovery_items)) : ?>
            <div class="gap-5 grid grid-cols-1 md:grid-cols-2">
                <?php foreach ($discovery_items as $index => $item) : ?>
                    <?php if (!empty($item['title']) || !empty($item['content'])) : ?>
                        <div class="flex flex-col bg-[var(--color-wyz-creations-guest-light-gray)] shadow-md p-6 md:p-10 border border-[var(--color-wyz-creations-guest-med-gray)] rounded-2xl h-full">

                            <div class="py-2">
                                (icon?)
                            </div>
                            <div class="flex-1">
                                <?php if (!empty($item['title'])) : ?>
                                    <h3 class="mb-2.5! font-medium! text-[28px]! md:text-[32px]!">
                                        <?php echo esc_html($item['title']); ?>
                                    </h3>
                                <?php endif; ?>
                            </div>


                            <?php if (!empty($item['content'])) : ?>
                                <div class="flex-grow text-[20px]!">
                                    <?php echo wp_kses_post($item['content']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>




</section>