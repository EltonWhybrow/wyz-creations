<?php

/**
 * Displayed when no products are found matching the current query.
 *
 * Based on the WooCommerce core template (loop/no-products-found.php),
 * swapping WooCommerce's own icon font for a Font Awesome icon (matching
 * the heart/basket icons in the header) and styling the notice to match
 * the theme instead of WooCommerce's default blue.
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-no-products-found">
    <div class="woocommerce-info" role="alert">
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        <?php esc_html_e('No products were found matching your selection.', 'woocommerce'); ?>
    </div>
</div>
