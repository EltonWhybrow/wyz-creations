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
// name otherwise. Needed only by layouts whose part file might also be
// rendered directly outside the builder from some other template.
function wyzcreations_builder_field($field_name)
{
    if (get_row_layout()) {
        return get_sub_field($field_name);
    }
    return get_field($field_name);
}

// Reads a sibling field's raw submitted value from $_POST['acf'] by
// swapping the last bracket segment of $input_name (this field's own
// key) for $sibling_key — used to check another field in the *same*
// flexible-content/repeater row during validation.
function wyzcreations_acf_sibling_raw_value($input_name, $sibling_key)
{
    preg_match_all('/\[([^\]]*)\]/', $input_name, $matches);
    $segments = $matches[1] ?? [];
    if (empty($segments)) {
        return null;
    }
    $segments[count($segments) - 1] = $sibling_key;

    $value = $_POST['acf'] ?? [];
    foreach ($segments as $segment) {
        if (!is_array($value) || !isset($value[$segment])) {
            return null;
        }
        $value = $value[$segment];
    }
    return $value;
}

// Hero Banner's image doubles as the video's poster/lazy-load
// placeholder (see parts/hero-banner.php), so require it whenever a
// video is set on the same row.
add_filter('acf/validate_value/key=field_693023eb5393e', function ($valid, $value, $field, $input_name) {
    if ($valid !== true || !empty($value)) {
        return $valid;
    }

    $video_value = wyzcreations_acf_sibling_raw_value($input_name, 'field_69c37d0ffcb1f');
    if (!empty($video_value)) {
        return __('Hero Image is required when a Video is set — it\'s used as the video\'s placeholder while it loads.', 'wyz-creations');
    }

    return $valid;
}, 10, 4);
