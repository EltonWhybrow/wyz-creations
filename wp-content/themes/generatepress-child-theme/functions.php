<?php

/**
 * wyz-creations guest Child Theme functions and definitions
 */

// Enqueue Google Fonts
// add_action('wp_enqueue_scripts', 'wyzcreations_load_google_fonts', 5);
// function wyzcreations_load_google_fonts()
// {
//     wp_enqueue_style(
//         'wyz-creations-google-fonts',
//         'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Work+Sans:wght@700&display=swap',
//         array(),
//         null
//     );
// }

// Enqueue Tailwind CSS compiled file
add_action('wp_enqueue_scripts', 'wyzcreations_enqueue_tailwind', 998);
function wyzcreations_enqueue_tailwind()
{
    wp_enqueue_style(
        'wyz-creations-tailwind',
        get_stylesheet_directory_uri() . '/assets/css/wyz-creations-styles.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/css/wyz-creations-styles.css')
    );
}

// Enqueue wyz-creations js
add_action('wp_enqueue_scripts', 'wyzcreations_enqueue_scripts');
function wyzcreations_enqueue_scripts()
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
        'wyz-creations-main-js',
        get_stylesheet_directory_uri() . '/assets/js/wyz-creations-main.min.js', // npm run build to re minify latest
        array('jquery', 'slick-js'), // Important: slick-js as dependency
        $theme_version,
        true
    );

    // Localize script for PHP variables
    wp_localize_script('wyz-creations-main-js', 'wyzcreations_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'home_url' => home_url('/'),
    ));

    wp_enqueue_script('animations-init', get_stylesheet_directory_uri() . '/assets/js/animations.js', ['gsap', 'gsap-scrolltrigger', 'wyz-creations-main-js'], null, true);
    // Load your main JS file

}

// Remove entry title from My Account (woocommerce)
// add_action('template_redirect', 'remove_my_account_entry_title');
// function remove_my_account_entry_title()
// {
//     if (function_exists('is_account_page') && is_account_page()) {
//         // Remove default WooCommerce title
//         remove_action('woocommerce_before_main_content', 'woocommerce_page_title', 20);

//         // Remove theme's title if it uses the_title()
//         add_filter('the_title', function ($title, $id) {
//             $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
//             if ($id == $myaccount_page_id && in_the_loop()) {
//                 return '';
//             }
//             return $title;
//         }, 10, 2);
//     }
// }

// Remove default GeneratePress footer
add_action('after_setup_theme', function () {
    remove_action('generate_footer', 'generate_construct_footer');
    remove_action('generate_footer', 'generate_footer_bar', 15);
});

// Add our custom footer instead
add_action('generate_footer', 'my_custom_footer');
function my_custom_footer()
{

    if (wp_doing_ajax()) return;

    if (is_page_template('templates/linkme.php')) {
        get_template_part('parts/linkme-footer');
        return;
    }

    get_template_part('custom-footer');
}

// Register footer menus
function mytheme_register_menus()
{
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wyz-creations-guest-child-theme'),
        'footer-menu' => __('Footer Menu', 'wyz-creations-guest-child-theme'),
        'footer-widesign' => __('Footer Menu WideSign', 'wyz-creations-guest-child-theme')
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


add_filter('woocommerce_ajax_variation_threshold', '__return_false');

//  Custom Walker for Mobile Menu -->
class Mobile_Menu_Walker extends Walker_Nav_Menu
{
    // START SUBMENU
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu pl-4 mt-2 space-y-2\">\n";
    }

    // END SUBMENU
    function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= "</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);

        $output .= '<li class="relative">';

        $attributes  = !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="block px-4 py-3 text-gray-800 hover:text-blue-600"';

        $output .= '<a' . $attributes . '>';
        $output .= esc_html($item->title);
        $output .= '</a>';

        // Optional: toggle button
        if ($has_children) {
            $output .= '<button class="top-4 right-4 absolute submenu-toggle">
                <i class="fa-solid fa-chevron-down"></i>
            </button>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }
}
// End of Mobile Menu Walker

class Desktop_Mega_Menu_Walker extends Walker_Nav_Menu
{
    // Start a new level (submenu)
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);

        if ($depth === 0) {
            // Full-width mega menu container
            $output .= "\n$indent<ul class=\"absolute top-full left-0 w-screen bg-white hidden group-hover:block z-50 shadow-lg\">\n";
        } else {
            // Nested submenus (column items)
            $output .= "\n$indent<ul class=\"pl-4 space-y-2\">\n";
        }
    }

    // Start a menu item
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $has_children = in_array('menu-item-has-children', $item->classes);

        // Top-level items
        if ($depth === 0) {
            $output .= '<li class="group relative">'; // Removed px-4 to align submenu to viewport

            $output .= '<a href="' . esc_url($item->url) . '" 
                class="flex items-center gap-1 px-6 py-3 font-medium text-gray-800 hover:text-blue-600">'; // padding for clickable area

            $output .= esc_html($item->title);

            if ($has_children) {
                $output .= '<i class="ml-1 text-xs fa fa-chevron-down"></i>';
            }

            $output .= '</a>';
        }

        // Sub-items (columns)
        elseif ($depth === 1) {
            $output .= '<li class="group mb-3">';

            $output .= '<a href="' . esc_url($item->url) . '" 
                class="block py-1 font-semibold text-gray-900 hover:text-blue-600">';

            $output .= esc_html($item->title);
            $output .= '</a>';
        }

        // Third-level items
        else {
            $output .= '<li>';

            $output .= '<a href="' . esc_url($item->url) . '" 
                class="block py-1 text-gray-600 hover:text-blue-600">';

            $output .= esc_html($item->title);
            $output .= '</a>';
        }
    }

    // End a menu item
    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }

    // End a level (submenu)
    function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= "</ul>\n";
    }
}

// SVG support
function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

// remove all generatepress css so i can have full control with tailwind
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('generate-style');
    wp_deregister_style('generate-style'); // important
}, 999);

// CUSTOM TEXT FOR SPECIFIC PRODUCTS
// Add custom input field on product page
// dd custom input field on specific products only

// add_action('woocommerce_before_add_to_cart_button', 'wyz_add_custom_text_field');
// function wyz_add_custom_text_field()
// {

//     // Target product IDs
//     $allowed_products = array(1805); // ← replace with your actual product IDs

//     global $product;

//     if (! is_a($product, 'WC_Product')) return;

//     // Only show on allowed products
//     if (! in_array($product->get_id(), $allowed_products)) return;

//     echo '<div class="block mb-2 wyz-custom-text-field">
//         <label for="custom_text">Enter custom date (max 4 characters):</label>
//         <input 
//             type="text" 
//             id="custom_text" 
//             name="custom_text" 
//             placeholder="TEXT" 
//             maxlength="4"
//             pattern="[A-Za-z0-9]{1,4}"
//             required
//         >
//     </div>';
// }

// add_filter('woocommerce_add_cart_item_data', 'wyz_save_custom_text_to_cart', 10, 2);
// function wyz_save_custom_text_to_cart($cart_item_data, $product_id)
// {
//     if (isset($_POST['custom_text'])) {
//         $cart_item_data['custom_text'] = sanitize_text_field($_POST['custom_text']);
//     }
//     return $cart_item_data;
// }

// add_filter('woocommerce_get_item_data', 'wyz_display_custom_text_cart', 10, 2);
// function wyz_display_custom_text_cart($item_data, $cart_item)
// {
//     if (isset($cart_item['custom_text'])) {
//         $item_data[] = array(
//             'name' => 'Custom Year',
//             'value' => wc_clean($cart_item['custom_text']),
//         );
//     }
//     return $item_data;
// }

// add_action('woocommerce_checkout_create_order_line_item', 'wyz_save_custom_text_to_order', 10, 4);
// function wyz_save_custom_text_to_order($item, $cart_item_key, $values, $order)
// {
//     if (isset($values['custom_text'])) {
//         $item->add_meta_data('Custom Text', $values['custom_text'], true);
//     }
// }

// function wyz_render_category_grid()
// {

//     $categories = get_terms([
//         'taxonomy' => 'product_cat',
//         'hide_empty' => true,
//     ]);

//     if (empty($categories) || is_wp_error($categories)) return '';

//     ob_start();

//     echo '<div class="gap-6 grid grid-cols-2 md:grid-cols-4">';

//     foreach ($categories as $cat) {

//         $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
//         $image = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';

//         echo '
//         <a href="' . esc_url(get_term_link($cat)) . '" 
//            class="group block bg-white shadow hover:shadow-xl rounded-2xl overflow-hidden transition-all">

//             <div class="bg-gray-100 aspect-square overflow-hidden">
//                 ' . ($image ? '<img src="' . esc_url($image) . '" class="w-full h-full object-cover group-hover:scale-110 transition-transform">' : '') . '
//             </div>

//             <div class="p-3 font-semibold text-center tracking-wide">
//                 ' . esc_html($cat->name) . '
//             </div>
//         </a>';
//     }

//     echo '</div>';

//     return ob_get_clean();
// }

// add_shortcode('wyz_categories', 'wyz_render_category_grid');


// google reviews //
add_action('woocommerce_thankyou', 'add_google_reviews_optin');

function add_google_reviews_optin($order_id)
{
    if (!$order_id) return;

    $order = wc_get_order($order_id);

    // REQUIRED VALUES
    $merchant_id = 5721454439;
    $order_id_js = $order->get_id();
    $email = $order->get_billing_email();
    $country = $order->get_billing_country();

    // Estimated delivery date (adjust logic as needed)
    $delivery_date = date('Y-m-d', strtotime('+5 days'));

    // OPTIONAL: products with GTIN (if stored)
    // $products = [];

    // foreach ($order->get_items() as $item) {
    //     $product = $item->get_product();

    //     if ($product) {
    //         $gtin = $product->get_meta('gtin'); // or '_gtin', depends on setup

    //         if ($gtin) {
    //             $products[] = ['gtin' => $gtin];
    //         }
    //     }
    // }
?>

    <script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>

    <script>
        window.renderOptIn = function() {
            window.gapi.load('surveyoptin', function() {
                window.gapi.surveyoptin.render({
                    merchant_id: "<?php echo esc_js($merchant_id); ?>",
                    order_id: "<?php echo esc_js($order_id_js); ?>",
                    email: "<?php echo esc_js($email); ?>",
                    delivery_country: "<?php echo esc_js($country); ?>",
                    estimated_delivery_date: "<?php echo esc_js($delivery_date); ?>",

                });
            });
        }
    </script>

<?php
}






class Add_Submenu_Toggle_Walker extends Walker_Nav_Menu
{

    // Start submenu level (ul)
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $level = $depth + 1; // Start counting from 1 (more readable)
        $output .= "\n<ul class=\"sub-menu sub-menu-level-{$level}\">\n";
    }

    // Start menu item (li + a)
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $level = $depth + 1;

        // Base classes (shared across all levels)
        $li_classes = [
            'menu-item',
            'lg:static',
            'relative',
            'group',
            "menu-level-{$level}", // Depth-specific class
        ];

        // Merge with WordPress-generated classes
        $li_classes = array_merge($li_classes, $classes);

        // Depth-specific styles
        if ($depth === 0) {
            $li_classes[] = 'py-4 lg:p-3'; // Level 1
        } else if ($depth === 1) {
            $li_classes[] = 'px-0 '; // Level 2 (indent)
        } else if ($depth >= 2) {
            $li_classes[] = 'px-0 pl-0'; // Level 3+ (further indent)
        }

        $output .= sprintf(
            '<li class="%s">',
            implode(' ', array_filter($li_classes)) // Remove empty values
        );

        // Link (all levels)
        $output .= sprintf(
            '<a href="%s" class="inline-block %s">%s</a>',
            esc_url($item->url),
            $depth > 0 ? 'text-base' : 'text-base', // Smaller text for submenus
            esc_html($item->title)
        );

        // Toggle button (if has children)
        if ($has_children) {
            $output .= sprintf(
                '<button class="lg:hidden right-0 absolute h-[70px] cursor-pointer submenu-toggle %s">
          <i class="fa-solid fa-chevron-down %s"></i>
        </button>',
                $depth > 0 ? 'top-0 px-3 pt-2 pb-3' : 'top-0 px-3 pt-4 pb-2', // Adjust position per level
                $depth > 0 ? 'text-md' : 'text-md' // Icon size
            );
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }
}

// Use the custom walker in your menu
function add_submenu_toggle($args)
{
    // Add the custom walker only to your main menu, adjust location as needed
    if ($args['theme_location'] == 'primary') {
        $args['walker'] = new Add_Submenu_Toggle_Walker();
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'add_submenu_toggle');


// FOOTER MENU WALKER (simpler, 2-level only)
class Mega_Menu_Walker extends Walker_Nav_Menu
{

    function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '<ul class="space-y-2 mt-3 font-semibold text-sm">';
        }
    }

    function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</ul>';
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {

        if ($depth === 0) {
            // Column wrapper + header
            $output .= '<div class="col-span-1">';
            $output .= '<h3 class="mb-6 font-bold text-base">' . esc_html($item->title) . '</h3>';
        } else {
            // Child links
            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '" class="text-wyz-creations-guest-black-chalk/60 hover:text-wyz-creations-guest-black-chalk">';
            $output .= esc_html($item->title);
            $output .= '</a></li>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</div>';
        }
    }
}

// favourite code
function favourites_scripts()
{
    wp_enqueue_script(
        'favourites-js',
        get_stylesheet_directory_uri() . '/assets/js/favourites.js',
        [],
        null,
        true
    );

    // Pass data to JS
    wp_localize_script('favourites-js', 'favourites_ajax', [
        'ajax_url'   => admin_url('admin-ajax.php'),
        'favourites' => is_user_logged_in()
            ? get_user_meta(get_current_user_id(), 'favourites', true)
            : (isset($_COOKIE['favourites'])
                ? json_decode(stripslashes($_COOKIE['favourites']), true)
                : [])
    ]);
}
add_action('wp_enqueue_scripts', 'favourites_scripts');

add_action('wp_ajax_toggle_favourite', 'toggle_favourite');
add_action('wp_ajax_nopriv_toggle_favourite', 'toggle_favourite');

function toggle_favourite()
{
    $product_id = intval($_POST['product_id']);

    // Logged-in users → user meta
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $favourites = get_user_meta($user_id, 'favourites', true);

        if (!is_array($favourites)) $favourites = [];

        if (in_array($product_id, $favourites)) {
            $favourites = array_diff($favourites, [$product_id]);
            $status = 'removed';
        } else {
            $favourites[] = $product_id;
            $status = 'added';
        }

        update_user_meta($user_id, 'favourites', $favourites);
    }
    // Guests → cookies
    else {
        $favourites = isset($_COOKIE['favourites'])
            ? json_decode(stripslashes($_COOKIE['favourites']), true)
            : [];

        if (!is_array($favourites)) $favourites = [];

        if (in_array($product_id, $favourites)) {
            $favourites = array_diff($favourites, [$product_id]);
            $status = 'removed';
        } else {
            $favourites[] = $product_id;
            $status = 'added';
        }

        setcookie('favourites', json_encode(array_values($favourites)), time() + 86400 * 30, '/');
    }

    wp_send_json([
        'status' => $status,
        'favourites' => array_values($favourites)
    ]);
}


// debug template being used for product category pages
add_action('template_include', function ($template) {
    if (is_product_category()) {
        echo '<!-- Template being used: ' . $template . ' -->';
    }
    return $template;
});

// override cart buttons
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_after_shop_loop_item', function () {
    global $product;

    echo '<a href="' . esc_url($product->add_to_cart_url()) . '" 
        data-quantity="1"
        class="wyz-btn btn-sm tertiary"
        data-product_id="' . esc_attr($product->get_id()) . '"
        data-product_sku="' . esc_attr($product->get_sku()) . '"
        aria-label="' . esc_attr($product->add_to_cart_description()) . '"
        rel="nofollow">'
        . esc_html($product->add_to_cart_text()) .
        '</a>';
}, 10);


// Load specific template parts at bottom of specific pages
add_action('generate_before_footer', function () {
    if (is_page(['returns-refunds', 'privacy-policy', 'new-products', 'favourites', 'contact-us', 'product-advice']) && (!function_exists('is_woocommerce') || !is_woocommerce())) {
        get_template_part('parts/call-to-action');
    }
});



add_action('generate_before_footer', function () {
    if (is_page(['subscribe', 'delivery', 'promo-codes']) && (!function_exists('is_woocommerce') || !is_woocommerce())) {
        get_template_part('parts/socials');
        get_template_part('parts/best-sellers');
    }
});

add_action('generate_before_footer', function () {

    if (
        (is_page('help') || is_home()) &&
        (!function_exists('is_woocommerce') || !is_woocommerce())
    ) {

        // ALWAYS resolve correct page ID explicitly
        if (is_home()) {
            $page_id = get_option('page_for_posts'); // NEWS PAGE
        } else {
            $page_id = get_queried_object_id(); // safer than get_the_ID()
        }

        set_query_var('cta_page_id', $page_id);

        get_template_part('parts/socials');
        get_template_part('parts/call-to-action');
    }
});

// Remove "Additional Information" tab from single product pages
add_filter('woocommerce_product_tabs', 'custom_woocommerce_product_tabs', 98);

function custom_woocommerce_product_tabs($tabs)
{

    // Rename Description tab
    if (isset($tabs['description'])) {
        $tabs['description']['title'] = 'Description';
    }

    // Rename Additional Information tab
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = 'More Info';
    }

    // Rename Reviews tab
    if (isset($tabs['reviews'])) {
        $tabs['reviews']['title'] = 'Reviews';
    }

    return $tabs;
}

// add rss image to feed
function rss_add_media_namespace()
{
    echo 'xmlns:media="http://search.yahoo.com/mrss/"';
}
add_action('rss2_ns', 'rss_add_media_namespace');

function rss_post_thumbnail_enclosure()
{
    global $post;

    if (has_post_thumbnail($post->ID)) {
        $attachment_id = get_post_thumbnail_id($post->ID);
        $image = wp_get_attachment_image_src($attachment_id, 'medium');
        $mime = get_post_mime_type($attachment_id);
        $file_path = get_attached_file($attachment_id);
        $file_size = file_exists($file_path) ? filesize($file_path) : 0;

        if ($image) {
            // Standard enclosure
            echo '<enclosure url="' . esc_url($image[0]) . '" length="' . $file_size . '" type="' . esc_attr($mime) . '" />';

            // media:content tag — Buffer prefers this
            echo '<media:content url="' . esc_url($image[0]) . '" medium="image" type="' . esc_attr($mime) . '" width="' . $image[1] . '" height="' . $image[2] . '" />';
        }
    }
}

add_action('rss2_item', 'rss_post_thumbnail_enclosure');
