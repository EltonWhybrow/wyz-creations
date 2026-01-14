<?php

/**
 * Truvi guest Child Theme functions and definitions
 */

// Enqueue Google Fonts
add_action('wp_enqueue_scripts', 'truvi_load_google_fonts', 5);
function truvi_load_google_fonts()
{
    wp_enqueue_style(
        'truvi-google-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Work+Sans:wght@700&display=swap',
        array(),
        null
    );
}

// Enqueue Tailwind CSS compiled file
add_action('wp_enqueue_scripts', 'truvi_enqueue_tailwind', 20);
function truvi_enqueue_tailwind()
{
    wp_enqueue_style(
        'truvi-tailwind',
        get_stylesheet_directory_uri() . '/assets/css/truvi-styles.css', // compiled file
        array('generate-style'),
        filemtime(get_stylesheet_directory() . '/assets/css/truvi-styles.css')
    );
}

// Enqueue truvi js
add_action('wp_enqueue_scripts', 'truvi_enqueue_scripts');
function truvi_enqueue_scripts()
{
    // Get theme version
    $theme_version = wp_get_theme()->get('Version');

    // Load Slick Carousel from CDN
    wp_enqueue_style(
        'slick-css',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css',
        array(),
        '1.9.0'
    );

    wp_enqueue_style(
        'slick-theme-css',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css',
        array('slick-css'),
        '1.9.0'
    );

    wp_enqueue_script(
        'slick-js',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
        array('jquery'),
        '1.9.0',
        true
    );

    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css', array(), '7.0.1'); // Adjust version/path as needed


    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], null, true);
    // ScrollTrigger (optional, for “animate when scrolled into view”)
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], null, true);
    // Animations init script
    wp_enqueue_script(
        'truvi-main-js',
        get_stylesheet_directory_uri() . '/assets/js/truvi-main.min.js', // npm run build to re minify latest
        array('jquery', 'slick-js'), // Important: slick-js as dependency
        $theme_version,
        true
    );

    // Localize script for PHP variables
    wp_localize_script('truvi-main-js', 'truvi_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'home_url' => home_url('/'),
    ));

    wp_enqueue_script('animations-init', get_stylesheet_directory_uri() . '/assets/js/animations.js', ['gsap', 'gsap-scrolltrigger', 'truvi-main-js'], null, true);
    // Load your main JS file

}

// Remove entry title from My Account (woocommerce)
add_action('template_redirect', 'remove_my_account_entry_title');
function remove_my_account_entry_title()
{
    if (function_exists('is_account_page') && is_account_page()) {
        // Remove default WooCommerce title
        remove_action('woocommerce_before_main_content', 'woocommerce_page_title', 20);

        // Remove theme's title if it uses the_title()
        add_filter('the_title', function ($title, $id) {
            $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
            if ($id == $myaccount_page_id && in_the_loop()) {
                return '';
            }
            return $title;
        }, 10, 2);
    }
}

// Remove default GeneratePress footer
add_action('after_setup_theme', function () {
    remove_action('generate_footer', 'generate_construct_footer');
    remove_action('generate_footer', 'generate_footer_bar', 15);
});

// Add our custom footer instead
add_action('generate_footer', 'my_custom_footer');
function my_custom_footer()
{
    get_template_part('custom-footer');
}

// Register footer menus
function mytheme_register_menus()
{
    register_nav_menus(array(
        'footer-services' => __('Footer Menu Services', 'truvi-guest-child-theme'),
        'footer-support' => __('Footer Menu Support', 'truvi-guest-child-theme'),
        'footer-company' => __('Footer Menu Company', 'truvi-guest-child-theme')
    ));
}
add_action('init', 'mytheme_register_menus');

// Enable AJAX add to cart on single product pages (even older WC versions)
add_filter('woocommerce_add_to_cart_redirect', '__return_false');

// Remove sidebar from ALL pages, posts, archives – everything
add_filter('generate_sidebar_layout', 'tu_remove_sidebar_everywhere');
function tu_remove_sidebar_everywhere($layout)
{
    return 'no-sidebar'; // Forces full-width, no sidebar anywhere
}

// Reset so i have full control with tailwind
add_filter('generate_container_width', '__return_false'); // removes the 1200px max-width
add_filter('generate_blog_columns', '__return_false'); // removes masonry grid limits too


//  Custom Walker for Mobile Menu -->
class Mobile_Menu_Walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="block py-3 px-4 text-gray-800 hover:text-blue-600 hover:bg-gray-50 rounded-lg transition-colors"';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
// End of Mobile Menu Walker

// SVG support
function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');
