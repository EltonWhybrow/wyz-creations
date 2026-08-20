<?php

/**
 * Flexible Content "Sections" field for pages using the default page
 * template.
 *
 * The field group itself (all layouts and their sub_fields) is no longer
 * registered here in PHP — it's defined in acf-json/group_home_page_builder.json
 * and auto-loaded by ACF (see the acf/settings/load_json + save_json filters
 * in functions.php), which makes it fully editable in wp-admin: add, remove,
 * or reorder fields on any layout, including nested repeaters/flexible
 * content, and ACF writes the change straight back to that JSON file.
 *
 * This file just keeps the small PHP helpers other template files still
 * need at render time.
 */

// layout name => parts/{slug}.php to render. Must stay in sync with the
// layout names in acf-json/group_home_page_builder.json.
function wyzcreations_home_builder_layouts()
{
    return [
        'hero_banner'       => 'hero-banner',
        'category_upsell'   => 'category-upsell',
        'trusted_companies' => 'trusted-companies',
        'stats'             => 'stats',
        'best_sellers'      => 'best-sellers',
        'faqs'              => 'faqs',
        'socials'           => 'socials',
        'call_to_action'    => 'call-to-action',
        'feedback'          => 'feedback',
        'category_cta'      => 'category-cta',
        'promotion_offers'  => 'promotion-offers',
        'contact'           => 'contact',
    ];
}

// Reads a field from the current flexible-content row when called inside
// the Page Builder loop; falls back to the page-level field of the same
// name otherwise. Needed only by layouts whose part file is also rendered
// directly outside the builder (e.g. hero-banner.php via promo-template.php).
function wyzcreations_builder_field($field_name)
{
    if (get_row_layout()) {
        return get_sub_field($field_name);
    }
    return get_field($field_name);
}
