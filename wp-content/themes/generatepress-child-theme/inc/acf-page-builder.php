<?php

/**
 * Flexible Content "Sections" field for the Home, Categories, and default
 * page templates.
 *
 * Each layout is a thin switch for which existing parts/*.php section to
 * render and in what order. Layouts are being migrated one at a time from
 * reading page-level ACF fields via get_field() to carrying their own
 * `sub_fields`, so each row placed in the builder is independently
 * editable via get_sub_field() instead of every instance sharing one
 * page-level field group. `category_cta` is the first layout converted;
 * the rest still read from their old page-level fields until migrated.
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
        'best_sellers'      => 'best-sellers',
        'faqs'              => 'faqs',
        'socials'           => 'socials',
        'call_to_action'    => 'call-to-action',
        'feedback'          => 'feedback',
        'category_cta'      => 'category-cta',
    ];
}

// layout name => its own sub_fields (only set for layouts already migrated
// off shared page-level fields; every other layout keeps sub_fields: [])
function wyzcreations_home_builder_layout_sub_fields()
{
    return [
        'category_cta' => [
            [
                'key'   => 'field_category_cta_title',
                'label' => 'Title',
                'name'  => 'cat_action_title',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_category_cta_subtitle',
                'label' => 'Subtitle',
                'name'  => 'cat_action_subtitle',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_category_cta_bg_image',
                'label'         => 'Background Image',
                'name'          => 'cat_action_bg_image',
                'type'          => 'image',
                'return_format' => 'array',
            ],
            [
                'key'   => 'field_category_cta_link',
                'label' => 'Link',
                'name'  => 'cat_action_link',
                'type'  => 'link',
            ],
        ],
    ];
}

add_action('acf/init', function () {
    $layouts = [];
    $sub_fields_by_layout = wyzcreations_home_builder_layout_sub_fields();

    foreach (wyzcreations_home_builder_layouts() as $name => $slug) {
        $layouts[] = [
            'key'        => 'layout_' . $name,
            'name'       => $name,
            'label'      => ucwords(str_replace('_', ' ', $name)),
            'display'    => 'block',
            'sub_fields' => $sub_fields_by_layout[$name] ?? [],
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
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'default',
                ],
            ],
        ],
    ]);
});
