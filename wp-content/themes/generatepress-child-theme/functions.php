<?php

/**
 * wyz-creations guest Child Theme functions and definitions
 */

require_once get_stylesheet_directory() . '/inc/acf-page-builder.php';

// Sync the Page Builder field group with acf-json/ instead of registering
// it via PHP, so it's fully editable in wp-admin (add/remove/reorder
// fields, including inside flexible-content layouts) while still being
// version-controlled — ACF writes changes straight back to the JSON file.
add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});
add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

// ACF options page for global navigation settings
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Navigation Settings',
            'menu_title' => 'Nav Settings',
            'menu_slug'  => 'nav-settings',
            'capability' => 'manage_options',
            'position'   => 80,
            'redirect'   => false,
        ]);
    }
});

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
        filemtime(get_stylesheet_directory() . '/assets/js/wyz-creations-main.min.js'),
        true
    );

    // Localize script for PHP variables
    wp_localize_script('wyz-creations-main-js', 'wyzcreations_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'home_url' => home_url('/'),
        'shop_url' => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/'),
    ));

    wp_enqueue_script(
        'animations-init',
        get_stylesheet_directory_uri() . '/assets/js/animations.js',
        ['gsap', 'gsap-scrolltrigger', 'wyz-creations-main-js'],
        filemtime(get_stylesheet_directory() . '/assets/js/animations.js'),
        true
    );
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

// Register a zoomed/cropped image size
add_image_size('social_posts_zoom', 900, 900, true);


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

/**
 * Favourites page uses the large image size instead of woocommerce_thumbnail
 * so product images match the quality of the best-sellers slider.
 */
function wyzcreations_favs_large_thumbnail() {
    global $product;
    echo $product->get_image('large', ['class' => 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail']);
}

/**
 * Add a heart "Add to Favourites" button next to the Add to Cart button
 * on single product pages. Reuses the same .favourite-toggle JS handler.
 */
add_action('woocommerce_after_add_to_cart_button', function () {
    global $product;
    if (!$product) return;
    $product_id  = $product->get_id();
    $is_fav      = in_array($product_id, wyzcreations_get_stored_favourites());
    $heart_class = $is_fav ? 'text-red-500' : 'text-gray-300';
    ?>
    <button type="button"
            class="favourite-toggle single-product-fav-btn"
            data-product-id="<?php echo esc_attr($product_id); ?>"
            aria-label="<?php echo $is_fav ? 'Remove from favourites' : 'Add to favourites'; ?>">
        <span class="heart <?php echo $heart_class; ?>">
            <i class="fa-solid fa-heart" aria-hidden="true"></i>
        </span>
        <span class="fav-label"><?php echo $is_fav ? 'Remove from favourites' : 'Add to favourites'; ?></span>
    </button>
    <?php
});

/**
 * Single product page: move price to just before Add to Cart button,
 * and add a "Quantity" label above the quantity input.
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_before_add_to_cart_button', 'woocommerce_template_single_price', 5);

// Variable products: quantity is rendered in the variations table (template override),
// so replace the default button callback (which also outputs quantity) with one that
// outputs only the price (via hook above) + button.
remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
add_action('woocommerce_single_variation', function () {
    global $product;
    ?>
    <div class="woocommerce-variation-add-to-cart variations_button">
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>
        <button type="submit" class="single_add_to_cart_button button alt">
            <?php echo esc_html($product->single_add_to_cart_text()); ?>
        </button>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="variation_id" class="variation_id" value="0" />
        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </div>
    <?php
}, 20);

/**
 * Block Google StoreBot (Merchant Center) from triggering abandoned cart sessions.
 * The bot crawls product/cart pages using a headless browser but never submits checkout,
 * so we identify it by user-agent and prevent WooCommerce from persisting cart state.
 */
add_action('init', 'block_storebot_sessions', 1);
function block_storebot_sessions() {
    if (is_admin()) return;

    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if (stripos($ua, 'Storebot-Google') === false && stripos($ua, 'Google-InspectionTool') === false) {
        return;
    }

    add_filter('woocommerce_persistent_cart_enabled', '__return_false');
    add_action('woocommerce_before_calculate_totals', function ($cart) {
        $cart->empty_cart();
    }, 1);
}

// Enable AJAX add to cart on single product pages (even older WC versions)
add_filter('woocommerce_add_to_cart_redirect', '__return_false');

// Keep the header cart count badge in sync after AJAX add-to-cart
add_filter('woocommerce_add_to_cart_fragments', 'wyzcreations_cart_count_fragment');
function wyzcreations_cart_count_fragment($fragments)
{
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

    ob_start();
?>
    <span class="cart-count-badge<?php echo $count > 0 ? '' : ' hidden'; ?>"><?php echo esc_html($count); ?></span>
<?php
    $fragments['.cart-count-badge'] = ob_get_clean();

    return $fragments;
}

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
    protected $featured_data   = null;
    protected $featured_loaded = false;

    // Lazy-load the global featured panel data once per render
    protected function load_featured()
    {
        if ($this->featured_loaded) return;
        $this->featured_loaded = true;

        $feat_post = get_field('nav_featured_post', 'option');
        if ($feat_post) {
            $this->featured_data = [
                'post'         => $feat_post,
                'position'     => get_field('nav_featured_position', 'option') ?: 'right',
                'button_label' => get_field('nav_featured_button_label', 'option') ?: 'View more',
            ];
        }
    }

    // Start submenu level (ul)
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $level = $depth + 1; // Start counting from 1 (more readable)
        $output .= "\n<ul class=\"sub-menu sub-menu-level-{$level}\">\n";
    }

    // End submenu level — inject featured panel as last item in every level-1 mega menu
    function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $this->load_featured();

            if ($this->featured_data) {
                $post      = $this->featured_data['post'];
                $position  = $this->featured_data['position'];
                $btn_text  = $this->featured_data['button_label'];
                $permalink = get_permalink($post->ID);
                $title     = get_the_title($post);
                $img_url   = get_the_post_thumbnail_url($post->ID, 'large');
                $pos_class = 'nav-featured-panel-item--' . esc_attr($position);

                $output .= '<li class="nav-featured-panel-item ' . $pos_class . '">';
                $output .= '<div class="nav-featured-panel">';

                if ($img_url) {
                    $output .= '<a href="' . esc_url($permalink) . '" class="nav-featured-panel__image-link" tabindex="-1" aria-hidden="true">';
                    $output .= '<div class="nav-featured-panel__image">';
                    $output .= '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($title) . '" loading="lazy" />';
                    $output .= '</div></a>';
                }

                $output .= '<h3 class="nav-featured-panel__title">';
                $output .= '<a href="' . esc_url($permalink) . '">' . esc_html($title) . '</a>';
                $output .= '</h3>';

                $output .= '<a href="' . esc_url($permalink) . '" class="wyz-btn btn-sm primary nav-featured-panel__btn">';
                $output .= esc_html($btn_text);
                $output .= '</a>';

                $output .= '</div></li>';
            }
        }

        $output .= "</ul>\n";
    }

    // Start menu item (li + a)
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes      = empty($item->classes) ? array() : (array) $item->classes;
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

// Dedupes stored IDs and drops any that no longer point to a published
// product (deleted/trashed products), so counts always match what the
// favourites page can actually display.
function wyzcreations_get_valid_favourites($ids)
{
    if (!is_array($ids) || empty($ids)) return [];

    $ids = array_unique(array_map('intval', $ids));

    return array_values(array_filter($ids, function ($id) {
        return get_post_type($id) === 'product' && get_post_status($id) === 'publish';
    }));
}

function wyzcreations_get_stored_favourites()
{
    $favourites = is_user_logged_in()
        ? get_user_meta(get_current_user_id(), 'favourites', true)
        : (isset($_COOKIE['favourites'])
            ? json_decode(stripslashes($_COOKIE['favourites']), true)
            : []);

    return wyzcreations_get_valid_favourites($favourites);
}

function wyzcreations_get_favourites_count()
{
    return count(wyzcreations_get_stored_favourites());
}

function favourites_scripts()
{
    wp_enqueue_script(
        'favourites-js',
        get_stylesheet_directory_uri() . '/assets/js/favourites.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/js/favourites.js'),
        true
    );

    // Pass data to JS
    wp_localize_script('favourites-js', 'favourites_ajax', [
        'ajax_url'   => admin_url('admin-ajax.php'),
        'favourites' => wyzcreations_get_stored_favourites(),
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
        $favourites = wyzcreations_get_valid_favourites(get_user_meta($user_id, 'favourites', true));

        if (in_array($product_id, $favourites)) {
            $favourites = array_diff($favourites, [$product_id]);
            $status = 'removed';
        } else {
            $favourites[] = $product_id;
            $status = 'added';
        }

        $favourites = array_values($favourites);
        update_user_meta($user_id, 'favourites', $favourites);
    }
    // Guests → cookies
    else {
        $stored = isset($_COOKIE['favourites'])
            ? json_decode(stripslashes($_COOKIE['favourites']), true)
            : [];
        $favourites = wyzcreations_get_valid_favourites($stored);

        if (in_array($product_id, $favourites)) {
            $favourites = array_diff($favourites, [$product_id]);
            $status = 'removed';
        } else {
            $favourites[] = $product_id;
            $status = 'added';
        }

        $favourites = array_values($favourites);
        setcookie('favourites', json_encode($favourites), time() + 86400 * 30, '/');
    }

    wp_send_json([
        'status' => $status,
        'favourites' => $favourites
    ]);
}


// debug template being used for product category pages
add_action('template_include', function ($template) {
    if (is_product_category()) {
        echo '<!-- Template being used: ' . $template . ' -->';
    }
    return $template;
});

// Show the result count in brackets after the shop title instead of on its own line
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

add_filter('woocommerce_page_title', 'wyzcreations_append_result_count_to_title');
function wyzcreations_append_result_count_to_title($title)
{
    if (!wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
        return $title;
    }

    $total = wc_get_loop_prop('total');

    if (!$total) {
        return $title;
    }

    $per_page = wc_get_loop_prop('per_page');

    $count_text = 1 === (int) $total ? '1 result' : $total . ' results';

    return $title . ' <span class="shop-title-result-count">(' . esc_html($count_text) . ')</span>';
}

// Infinite scroll: 16 products per page, no pagination link
add_filter('loop_shop_per_page', function () { return 16; }, 20);
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

add_action('woocommerce_after_shop_loop', function () {
    global $wp_query;
    $max_pages = (int) $wp_query->max_num_pages;
    ?>
    <div id="shop-infinite-sentinel" class="w-full"<?php if ($max_pages > 1): ?> data-max-pages="<?php echo $max_pages; ?>"<?php endif; ?>></div>
    <div id="shop-infinite-loader" class="hidden py-10 w-full text-center">
        <span class="inline-block rounded-full w-10 h-10 animate-spin" style="border: 4px solid var(--color-wyz-creations-guest-orange); border-top-color: transparent;"></span>
    </div>
    <?php
}, 15);

add_action('wp_enqueue_scripts', function () {
    if (!is_shop() && !is_product_category() && !is_product_tag()) return;

    global $wp_query;

    $tax_data = [];
    if (is_product_category()) {
        $term     = get_queried_object();
        $tax_data = ['taxonomy' => 'product_cat', 'term' => $term->slug];
    } elseif (is_product_tag()) {
        $term     = get_queried_object();
        $tax_data = ['taxonomy' => 'product_tag', 'term' => $term->slug];
    }

    wp_localize_script('wyz-creations-main-js', 'wyz_shop_infinite', [
        'ajax_url'  => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('wyz_infinite_scroll'),
        'max_pages' => (int) $wp_query->max_num_pages,
        'tax'       => $tax_data,
        'orderby'   => isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : '',
    ]);
}, 20);

add_action('wp_ajax_wyz_infinite_products',        'wyzcreations_infinite_products_ajax');
add_action('wp_ajax_nopriv_wyz_infinite_products', 'wyzcreations_infinite_products_ajax');

function wyzcreations_infinite_products_ajax()
{
    check_ajax_referer('wyz_infinite_scroll', 'nonce');

    $page     = max(2, (int) ($_POST['page'] ?? 2));
    $per_page = 16;
    $taxonomy = sanitize_key($_POST['taxonomy'] ?? '');
    $term     = sanitize_text_field($_POST['term'] ?? '');
    $orderby  = sanitize_text_field($_POST['orderby'] ?? '');

    $args = [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'tax_query'      => [[
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => ['exclude-from-catalog'],
            'operator' => 'NOT IN',
        ]],
    ];

    if ($taxonomy && $term) {
        $args['tax_query'][] = [
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => [$term],
        ];
    }

    $default_order = get_option('woocommerce_default_catalog_orderby', 'menu_order');
    $ordering      = WC()->query->get_catalog_ordering_args($orderby ?: $default_order);
    $args          = array_merge($args, $ordering);

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        wp_send_json_success(['html' => '', 'has_more' => false]);
        return;
    }

    wc_set_loop_prop('total',        $query->found_posts);
    wc_set_loop_prop('total_pages',  $query->max_num_pages);
    wc_set_loop_prop('per_page',     $per_page);
    wc_set_loop_prop('current_page', $page);
    wc_set_loop_prop('is_paginated', true);
    wc_set_loop_prop('loop',         0);

    ob_start();
    while ($query->have_posts()) {
        $query->the_post();
        wc_get_template_part('content', 'product');
    }
    wp_reset_postdata();
    $html = ob_get_clean();

    wp_send_json_success([
        'html'     => $html,
        'has_more' => $page < $query->max_num_pages,
    ]);
}

// override cart buttons
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_after_shop_loop_item', function () {
    global $product;

    // Needs add_to_cart_button + ajax_add_to_cart so WooCommerce's own
    // add-to-cart.js intercepts the click and does it via AJAX instead
    // of a full page reload — matches the classes wc_get_template()
    // would normally add on the default loop button markup.
    $classes = ['wyz-btn', 'btn-sm', 'tertiary', 'product_type_' . $product->get_type()];

    if ($product->is_purchasable() && $product->is_in_stock()) {
        $classes[] = 'add_to_cart_button';

        if ($product->supports('ajax_add_to_cart')) {
            $classes[] = 'ajax_add_to_cart';
        }
    }

    echo '<a href="' . esc_url($product->add_to_cart_url()) . '"
        data-quantity="1"
        class="' . esc_attr(implode(' ', $classes)) . '"
        data-product_id="' . esc_attr($product->get_id()) . '"
        data-product_sku="' . esc_attr($product->get_sku()) . '"
        aria-label="' . esc_attr($product->add_to_cart_description()) . '"
        rel="nofollow">'
        . esc_html($product->add_to_cart_text()) .
        '</a>';
}, 10);


// True when the current default-template page has Page Builder rows set up.
// Used by page.php to render the builder full width instead of the normal
// sidebar-constrained content wrapper, and by content-page.php to skip the
// normal WP title/content — both fall back to normal behaviour when no
// rows are configured yet.
function wyzcreations_default_template_has_builder_rows()
{
    return is_page() && !wp_doing_ajax() && is_page_template('default') && have_rows('home_page_builder');
}

// True when the blog/posts page (Settings > Reading > "Posts page") has
// Page Builder rows set up. Used by home.php. Can't reuse
// wyzcreations_default_template_has_builder_rows() here: on the posts-page
// request is_page()/is_page_template() both return false (WordPress treats
// it as is_home(), not is_singular()), even though the page's own template
// meta is still 'default' — so this checks the page's ID directly via
// get_option('page_for_posts') instead. Only true on page 1 of the listing.
function wyzcreations_news_page_has_builder_rows()
{
    $news_page_id = (int) get_option('page_for_posts');

    return $news_page_id && !wp_doing_ajax() && !is_paged() && have_rows('home_page_builder', $news_page_id);
}

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
        $image = wp_get_attachment_image_src($attachment_id, 'social_posts_zoom');
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


// =============================================
// SHORTCODES FOR BLOG POSTS
// =============================================

// Simplest possible — just defaults
// [wyz_button]

// // Custom link and text
// [wyz_button url="/shop/funny" text="See the Funny Range"]

// // Opens in a new tab (good for external links)
// [wyz_button url="https://example.com" text="Visit Us" target="_blank"]

// // Callout box, default copy
// [wyz_callout]

// // Callout box, custom everything
// [wyz_callout heading="Fancy 25% off?" body="Subscribe and we'll fire a discount code straight to your inbox." url="/subscribe" btn_text="Claim Your 25% Off"]

/**
 * CTA Button Shortcode
 * Usage: [wyz_button]
 * Usage: [wyz_button url="/shop" text="Browse the Shop" style="secondary"]
 * Styles: primary | secondary | tertiary
 */
add_shortcode('wyz_button', function ($atts) {
    $atts = shortcode_atts([
        'url'    => '/get-in-touch',
        'text'   => 'Get in Touch',
        'style'  => 'primary',
        'target' => '_self',
    ], $atts, 'wyz_button');

    $allowed_styles = ['primary', 'secondary', 'tertiary'];
    $style = in_array($atts['style'], $allowed_styles) ? $atts['style'] : 'primary';
    $target = $atts['target'] === '_blank' ? '_blank' : '_self';
    $rel = $target === '_blank' ? ' rel="noopener noreferrer"' : '';

    return sprintf(
        '<div class="my-6 text-center wyz-shortcode-btn-wrap">
            <a href="%s" class="wyz-btn btn-lg %s" target="%s"%s>%s</a>
        </div>',
        esc_url(home_url($atts['url'])),
        esc_attr($style),
        esc_attr($target),
        $rel,
        esc_html($atts['text'])
    );
});

/**
 * Promo/Callout Box Shortcode
 * Usage: [wyz_callout]
 * Usage: [wyz_callout heading="Fancy 15% off?" body="Subscribe and get a discount code sent straight to your inbox." url="/subscribe" btn_text="Claim Your Discount"]
 * Usage: [wyz_callout image="https://example.com/photo.jpg" overlay="false"] (image accepts a URL or an attachment ID; overlay defaults to "true" and only applies when an image is set; image="none" removes the default background)
 */
add_shortcode('wyz_callout', function ($atts) {
    $atts = shortcode_atts([
        'heading'  => "Like what you're reading?",
        'body'     => 'Browse our full range of graphic tees — funny, sarcastic, retro, and everything in between.',
        'url'      => '/shop',
        'btn_text' => 'Shop Now',
        'style'    => 'primary',
        'image'    => get_stylesheet_directory_uri() . '/assets/img/blog-post-call-to-action.jpg',
        'overlay'  => 'true',
    ], $atts, 'wyz_callout');

    $allowed_styles = ['primary', 'secondary', 'tertiary'];
    $style = in_array($atts['style'], $allowed_styles) ? $atts['style'] : 'primary';

    if ('none' === $atts['image']) {
        $bg_url = '';
    } elseif (is_numeric($atts['image'])) {
        $bg_url = wp_get_attachment_image_url((int) $atts['image'], 'large');
    } else {
        $bg_url = trim($atts['image']);
    }

    $bg_markup = '';
    if ($bg_url) {
        $bg_markup = sprintf(
            '<div class="absolute inset-0 bg-cover bg-center scale-110" style="background-image:url(\'%s\');"></div>',
            esc_url($bg_url)
        );
        if (filter_var($atts['overlay'], FILTER_VALIDATE_BOOLEAN)) {
            $bg_markup .= '<div class="absolute inset-0 bg-radial from-black via-black/70 to-transparent"></div>';
        }
    }

    return sprintf(
        '<div class="relative my-8 p-10 rounded-xl overflow-hidden text-center wyz-shortcode-callout %s">
            %s
            <div class="z-10 relative %s">
                <h3 class="mb-2 font-bold text-xl">%s</h3>
                <p class="mb-4 text-base">%s</p>
                <a href="%s" class="wyz-btn btn-sm %s">%s</a>
            </div>
        </div>',
        $bg_url ? '' : 'bg-wyz-creations-guest-light-gray',
        $bg_markup,
        $bg_url ? 'text-white' : '',
        esc_html($atts['heading']),
        esc_html($atts['body']),
        esc_url(home_url($atts['url'])),
        esc_attr($style),
        esc_html($atts['btn_text'])
    );
});
/**
 * Use the WooCommerce featured image as an Open Graph image
 * on product pages, via Yoast's image-array filter (runs even
 * when Yoast hasn't found an image itself).
 */
add_filter('wpseo_add_opengraph_images', function ($image_container) {

    if (function_exists('is_product') && is_product()) {

        $thumbnail_id = get_post_thumbnail_id();

        if ($thumbnail_id) {
            $image_container->add_image_by_id($thumbnail_id);
        }
    }

    return $image_container;
});
