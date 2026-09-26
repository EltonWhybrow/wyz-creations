<?php

$rich_text_content = get_sub_field('rich_text_content');

if (!$rich_text_content) {
    return;
}
?>

<section id="rich-text" class="px-5 lg:px-20 py-[50px] md:py-[80px] rich-text">
    <div class="mx-auto max-w-4xl rich-text-content">
        <?php echo apply_filters('the_content', $rich_text_content); ?>
    </div>
</section>
