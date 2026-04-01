<?php

/**
 * Template Name: Help Template
 * Description: Full-width template that uses only free ACF fields
 */



get_header(); ?>

<!-- Hero Banner -->
<?php get_template_part('parts/hero-banner'); ?>


<!-- FAQs section -->
<?php get_template_part('parts/faqs');
?>



<div id="linkme-panel">
    <button id="close-linkme" aria-label="Close menu">✕</button>

    <div class="linkme-content">
        <h2 class="mb-2 text-lg">Subscribe</h2>
        <h3 class="mb-6 text-wyz-creations-guest-light-gray text-xl">Get 15% OFF your first order!</h3>
        <ul class="mb-6 ml-4! list-disc list-outside list">
            <li>Be notified first about new T-shirt drops</li>
            <li>Receive exclusive discounts and promo codes</li>
            <li>Chance to win a FREE T-shirt every month</li>

        </ul>
        <?php echo do_shortcode('[contact-form-7 id="36580a5" title="Subscribe"]'); ?>
    </div>
</div>

<?php get_footer(); ?>