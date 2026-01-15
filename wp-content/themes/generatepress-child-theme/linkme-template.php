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

<?php get_footer(); ?>