<?php

/**
 * Template Name: Link Me Template
 * Description: Full-width template that uses only free ACF fields
 */

get_header('home'); ?>
<!-- // 'home' -->

<!-- Hero Banner -->
<?php //get_template_part('parts/hero-banner'); 
?>

<!-- Trusted Companies section -->
<?php //get_template_part('parts/trusted-companies'); 
?>

<!-- Things go wrong section -->
<?php //get_template_part('parts/things-go-wrong'); 
?>

<!-- Stats section -->
<?php //get_template_part('parts/stats'); 
?>

<!-- Steps section -->
<?php //get_template_part('parts/steps'); 
?>

<!-- Ready to go section -->
<?php //get_template_part('parts/ready-to-go'); 
?>

<!-- Trusted Travelers section -->
<?php //get_template_part('parts/trusted-travelers'); 
?>

<?php
while (have_posts()) :
    the_post();
?>
    <div class="page-content">
        <?php the_content(); ?>
    </div>
<?php
endwhile;
?>

<?php
$cta_one = get_field('linksection');
$cta_two = get_field('linksection_2');
$cta_three = get_field('linksection_3');
$cta_four = get_field('linksection_4');
$cta_five = get_field('linksection_5');
?>


<?php

get_template_part('parts/action-links', null, [
    'title'    => $cta_five['action_title'] ?? '',
    'subtitle' => $cta_five['action_subtitle'] ?? '',
    'image'    => $cta_five['action_bg_image'] ?? null,
    'link'     => $cta_five['action_link'] ?? null,
]);

get_template_part('parts/action-links', null, [
    'title'    => $cta_one['action_title'] ?? '',
    'subtitle' => $cta_one['action_subtitle'] ?? '',
    'image'    => $cta_one['action_bg_image'] ?? null,
    'link'     => $cta_one['action_link'] ?? null,
]);

get_template_part('parts/action-links', null, [
    'title'    => $cta_two['action_title'] ?? '',
    'subtitle' => $cta_two['action_subtitle'] ?? '',
    'image'    => $cta_two['action_bg_image'] ?? null,
    'link'     => $cta_two['action_link'] ?? null,
]);


get_template_part('parts/action-links', null, [
    'title'    => $cta_three['action_title'] ?? '',
    'subtitle' => $cta_three['action_subtitle'] ?? '',
    'image'    => $cta_three['action_bg_image'] ?? null,
    'link'     => $cta_three['action_link'] ?? null,
]);

get_template_part('parts/action-links', null, [
    'title'    => $cta_four['action_title'] ?? '',
    'subtitle' => $cta_four['action_subtitle'] ?? '',
    'image'    => $cta_four['action_bg_image'] ?? null,
    'link'     => $cta_four['action_link'] ?? null,
]);



?>

<?php //get_template_part('parts/call-to-action'); 
?>

<!-- FAQs section -->
<?php //get_template_part('parts/faqs'); 
?>

<!-- Call to Action section -->
<?php //get_template_part('parts/call-to-action'); 
?>

<div id="linkme-panel">
    <button id="close-linkme" aria-label="Close menu">✕</button>

    <div class="linkme-content">
        <!-- YOUR MENU / CONTENT HERE -->
        <h2 class="!mb-0">Subscribe</h2>
        <ul class="!mb-6 ml-0! list-inside list">
            <li>Get notified first about new T-shirt drops</li>
            <li>Receive exclusive discounts and promo codes not shared publicly</li>
            <li>Chance to win a FREE T-shirt every month</li>

        </ul>
        <?php // echo do_shortcode('[contact-form-7 id="36580a5" title="Subscribe"]'); 
        ?>
    </div>
</div>

<div id="widesign-panel">
    <button id="close-widesign" aria-label="Close menu">✕</button>

    <div class="linkme-content">

        <h2 class="!mb-0">Claim a FREE Website</h2>
        <h3 class="!mt-0 !mb-4 font-normal text-base!">
            Here at <a class="text-white! undeline!" href="https://widesign.co.uk" target="_blank" rel="noopener noreferrer" referrerpolicy="no-referrer">Widesign</a>, we love helping businesses with their digital journey, which is why we offer a free website to get you started.
        </h3>
        <ul class="!mb-6 ml-4! list-inside list">
            <li>View info and a short video on what you get</li>
            <li>Get yourself in the queue early</li>
            <li>Lock in early access before spots fill up</li>

        </ul>
        <?php // echo do_shortcode('[contact-form-7 id="6173ea3" title="FREE_Site_Widesign"]');
        ?>
    </div>
</div>

<?php // get_footer(); 
?>