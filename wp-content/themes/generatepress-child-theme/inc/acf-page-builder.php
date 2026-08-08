<?php

/**
 * Flexible Content "Sections" field for the Home and Categories templates.
 *
 * Each layout is a thin switch for which existing parts/*.php section to
 * render and in what order — the sections keep reading their own content
 * from page-level ACF fields via get_field(), exactly as before, since
 * those same parts/*.php files are also reused by other page templates.
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

// layout name => parts/{slug}.php to render
function wyzcreations_home_builder_layouts()
{
    return [
        'hero_banner'       => 'hero-banner',
        'category_upsell'   => 'category-upsell',
        'trusted_companies' => 'trusted-companies',
        'stats'             => 'stats',
        'ready_to_go'       => 'ready-to-go',
        'our_mission'       => 'our-mission',
        'we_discovered'     => 'we-discovered',
        'best_sellers'      => 'best-sellers',
        'faqs'              => 'faqs',
        'socials'           => 'socials',
        'call_to_action'    => 'call-to-action',
        'feedback'          => 'feedback',
        'category_cta'      => 'category-cta',
    ];
}

add_action('acf/init', function () {
    $layouts = [];

    foreach (wyzcreations_home_builder_layouts() as $name => $slug) {
        $layouts[] = [
            'key'        => 'layout_' . $name,
            'name'       => $name,
            'label'      => ucwords(str_replace('_', ' ', $name)),
            'display'    => 'block',
            'sub_fields' => [],
            'min'        => '',
            'max'        => 1,
        ];
    }

    acf_add_local_field_group([
        'key'    => 'group_home_page_builder',
        'title'  => 'Page Builder',
        'fields' => [
            [
                'key'     => 'field_home_page_builder',
                'label'   => 'Sections',
                'name'    => 'home_page_builder',
                'type'    => 'flexible_content',
                'layouts' => $layouts,
                'button_label' => 'Add Section',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'home-template.php',
                ],
            ],
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'categories-template.php',
                ],
            ],
        ],
    ]);
});
