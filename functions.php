<?php
/**
 * Halko functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Halko
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function halko_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Halko, use a find and replace
		* to change 'halko' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'halko', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'halko' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'halko_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'halko_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function halko_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'halko_content_width', 640 );
}
add_action( 'after_setup_theme', 'halko_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function halko_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'halko' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'halko' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'halko_widgets_init' );

/**
 * Enqueue scripts and styles. Includes custom sCSS + JS
 */
function halko_scripts() {
	wp_enqueue_style( 'halko-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'halko-main', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style( 'bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css' );
	wp_enqueue_script( 'jquery-min', 'https://code.jquery.com/jquery-3.7.1.min.js', array(), '3.7.1', true);
	wp_enqueue_script( 'popper-js', 'https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js', array(), '1.14.7', true);
	wp_enqueue_script( 'bootstrap-min-js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js', array(), '4.3.1', true);

	wp_style_add_data( 'halko-style', 'rtl', 'replace' );

	wp_enqueue_script( 'halko-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'halko_scripts' );

//Adding custom fonts

function enqueue_custom_fonts() {
	if(!is_admin()) {
		wp_register_style('roboto_condensed', 'https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap');
		wp_register_style('roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');
		wp_enqueue_style( 'roboto_condensed');
		wp_enqueue_style( 'roboto');
		
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_fonts');

//Adding custom JS
function get_custom_script() {
	wp_register_script('customscripts', get_stylesheet_directory_uri().'/js/customscripts.js', array(), '1.0.0', true);
	wp_enqueue_script( 'customscripts' );
}
add_action( 'wp_enqueue_scripts', 'get_custom_script' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

//Adds gutenberg block support
function enqueue_block_editor_assets() {
    // Enqueue block editor script
    wp_enqueue_script(
        'my-theme-editor', // Handle
        get_template_directory_uri() . '/assets/js/editor.js', // Script URL
        array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'), // Dependencies
        filemtime(get_template_directory() . '/assets/js/editor.js'), // Version
        true // In footer
    );

    // Enqueue block editor styles
    wp_enqueue_style(
        'my-theme-editor', // Handle
        get_template_directory_uri() . '/assets/css/editor.css', // Stylesheet URL
        array('wp-edit-blocks'), // Dependencies
        filemtime(get_template_directory() . '/assets/css/editor.css') // Version
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_block_editor_assets');



function custom_webhook_payload($payload, $resource, $resource_id, $event) {
    // Check if the resource is 'order'
    if ($resource !== 'order') {
        return $payload;
    }

    // Get the order by ID
    $order = wc_get_order($resource_id);

    // Check if the order exists
    if (!$order) {
        return false; // Exit if the order does not exist
    }

    // Check if the order is already processed to prevent duplicate processing
    if ($order->get_meta('_webhook_processed') === 'yes') {
        return false; // Exit if the webhook has already been processed for this order
    }

    // Check if the order is 'completed'
    if ($order->get_status() !== 'completed') {
        return false; // Exit without returning the payload if the order is not completed
    }

    // Mark the order as processed for webhook
    $order->update_meta_data('_webhook_processed', 'yes');
    $order->save(); // Save the order with the new meta data

    // We do not need all these fields. Unset can remove them
    unset($payload['_links']);
    unset($payload['billing']);
    unset($payload['shipping']);
    unset($payload['shipping_lines']);
    unset($payload['tax_lines']);
    unset($payload['refunds']);
    unset($payload['fee_lines']);
    // unset($payload['line_items']); //this one is(was) actually needed
    unset($payload['meta_data']);
    unset($payload['cart_hash']);
    unset($payload['cart_tax']);
    unset($payload['coupon_lines']);
    unset($payload['created_via']);
    unset($payload['currency']);
    unset($payload['currency_symbol']);
    unset($payload['customer_id']);
    unset($payload['customer_ip_address']);
    unset($payload['customer_note']);
    unset($payload['customer_user_agent']);

    unset($payload['date_completed']);
    unset($payload['date_completed_gmt']);
    unset($payload['date_created']); //(can) add this for clarity reasons. Firebase creates a date field once it's been processed with the function
    unset($payload['date_created_gmt']);
    unset($payload['date_modified']);
    unset($payload['date_modified_gmt']);
    unset($payload['date_paid']);
    unset($payload['date_paid_gmt']);

    unset($payload['discount_tax']);
    unset($payload['discount_total']);

    unset($payload['id']);
    unset($payload['is_editable']);
    unset($payload['needs_payment']);
    unset($payload['needs_processing']);
    unset($payload['number']);
    unset($payload['order_key']);
    unset($payload['parent_id']);
    unset($payload['payment_method']);
    unset($payload['payment_method_title']);
    unset($payload['payment_url']);
    unset($payload['prices_include_tax']);
    unset($payload['shipping_tax']);
    unset($payload['shipping_total']);
    unset($payload['status']);
    unset($payload['total']);
    unset($payload['total_tax']);
    unset($payload['transaction_id']);
    unset($payload['version']);

    // Get order data and create it
    $items = $payload['line_items'];
    $orders_array = [];
    
    foreach ($items as $key => $item) {
        // Get categories using item ID
        $product = wc_get_product($item['product_id']);
        $categories = [];
        $category_ids = $product->get_category_ids();
    
        // Get categories in proper order -> Main-, then subcategory
        foreach ($category_ids as $category_id) {
            $category_hierarchy = [];
            $current_category_id = $category_id;
            while ($current_category_id !== 0) {
                $category = get_term($current_category_id, 'product_cat');
                $category_hierarchy[] = $category->name;
                $current_category_id = $category->parent;
            }

            // Reverse the array to get the main category first
            $category_hierarchy = array_reverse($category_hierarchy);
            foreach ($category_hierarchy as $cat) {
                // Check if category exists. hopefully it will be in order :D :gun:
                if (!in_array($cat, $categories)) {
                    $categories[] = $cat;
                }
            }
        }

        $item_data = [
            'name' => $item['name'],
            'id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'categories' => $categories
        ];

        $orders_array[] = $item_data;
    }

    $payload['orders'] = $orders_array;

    unset($payload['line_items']); // Removing this at the very end since it is not needed anymore
    return $payload;
}

// Edits the 'order created' webhook. This will be sent to Firebase
add_filter('woocommerce_webhook_payload', 'custom_webhook_payload', 10, 4);



function halkomaatti_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 150,
        'single_image_width'    => 300,

        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );
}
add_action( 'after_setup_theme', 'halkomaatti_add_woocommerce_support' );

//woocommerce hooks
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);


function my_theme_wrapper_start() {
    echo '<section id="main">';
}

function my_theme_wrapper_end() {
    echo '</section>';
}

//Removes certain fields from checkout

function wc_remove_checkout_fields( $fields ) {

    // Billing fields

    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_first_name'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );

    // Shipping fields
    unset( $fields['shipping']['shipping_company'] );
    unset( $fields['shipping']['shipping_phone'] );
    unset( $fields['shipping']['shipping_state'] );
    unset( $fields['shipping']['shipping_first_name'] );
    unset( $fields['shipping']['shipping_last_name'] );
    unset( $fields['shipping']['shipping_address_1'] );
    unset( $fields['shipping']['shipping_address_2'] );
    unset( $fields['shipping']['shipping_city'] );
    unset( $fields['shipping']['shipping_postcode'] );

    // Order fields
    unset( $fields['order']['order_comments'] );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );



//Firebase func
//Just JS files :)
function custom_firebase_scripts_function() {
    // Register the scripts
    wp_register_script('secret', get_template_directory_uri() . '/js/secret.js', array(), null, true);
    wp_register_script('custom-firebase', get_template_directory_uri() . '/js/custom_firebase.js', array(), null, true);
	wp_register_script('toggle-admin-dropdown', get_template_directory_uri() . '/js/toggle-admin-dropdown.js', array(), null, true);

    // then enqueue the scripts
    wp_enqueue_script('secret');
    wp_enqueue_script('custom-firebase');
	wp_enqueue_script('toggle-admin-dropdown');

	wp_localize_script('custom-firebase', 'siteData', array(
        'homeUrl' => home_url()
    ));
}
add_action('wp_enqueue_scripts', 'custom_firebase_scripts_function');

//Add site_data to wp_header so it can be called instantly
function add_inline_site_data() {
    echo '<script type="text/javascript">
        var siteData = {
            homeUrl: "' . home_url() . '"
        };
    </script>';
}
add_action('wp_head', 'add_inline_site_data');


function add_module_type_attribute($tag, $handle, $src) {
    // Add type="module" to specific scripts
    if ('secret' === $handle || 'custom-firebase' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_module_type_attribute', 10, 3);


function firebase_fetch_func($atts)
{
	$a = shortcode_atts( array (
		'collectionName' => 'testData',
		'documentName' => 'Norway'
	), $atts );

    return "<div id='firebase-fetch'>DATA FROM FIREBASE</div>";
}
add_shortcode('custom_firebase', 'firebase_fetch_func');

add_shortcode('need_login', 'shortcode_needLogin');

function shortcode_needLogin() {
    if (!is_user_logged_in()) {
        auth_redirect();
    }
}

// https://stackoverflow.com/questions/52523582/allow-only-one-product-category-in-cart-at-once-in-woocommerce
// shamelessly borrowed
add_filter( 'woocommerce_add_to_cart_validation', 'only_one_product_category_allowed', 20, 3 );
function only_one_product_category_allowed( $passed, $product_id, $quantity) {

    // Getting the product categories term slugs in an array for the current product
    $term_slugs   = wp_get_post_terms( $product_id, 'product_cat', array('fields' => 'slugs') );

    // Loop through cart items
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item ){

        // Check if the product category of the current product don't match with a cart item
        if( ! has_term( $term_slugs, 'product_cat', $cart_item['product_id'] ) ){

            // Displaying a custom notice
            wc_add_notice( __('Only items from one product category are allowed in cart at once. Please review your cart and remove any products from other categories.'), 'error' );

            // Avoid add to cart
            return false; // exit
        }
    }
    return $passed;
}


//Updating cart item count using js/ajax
//Enqueuing the new JS file used exclusively for this
function enqueue_custom_scripts() {
    wp_enqueue_script( 'update-cart-count', get_template_directory_uri() . '/js/update-cart-count.js', array('jquery'), '1.0', true );

    // Localize script to pass the AJAX URL to the script
    wp_localize_script( 'update-cart-count', 'cartCountAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
}
add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );

//Updates cart whenever the item in stock value has changed
function update_cart_count_callback() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}
add_action( 'wp_ajax_update_cart_count', 'update_cart_count_callback' );
add_action( 'wp_ajax_nopriv_update_cart_count', 'update_cart_count_callback' );



//Cron function
//to mail monthly sales reports
//to admin mail account (or others)
//Checks if it's first of the month
if (!wp_next_scheduled('check_first_day_of_month_for_sales_report')) {
    wp_schedule_event(time(), 'daily', 'check_first_day_of_month_for_sales_report');
}

add_action('check_first_day_of_month_for_sales_report', 'schedule_monthly_sales_report');
 
function schedule_monthly_sales_report() {
	
    if (date('j') == 1) { // Check if today is the 1st day of the month  //Uncomment to actually make it work!!
		send_sales_report_to_admin();
    }
}

//Function to capture some sales data and send it to the admin's email address
//Only completed/successful orders, uses main categories only.
//Limiting to orders from the previous month only


function get_woocommerce_sales_by_primary_category() {
    $args = array(
        'status' => 'completed',
        'limit' => -1,
        'date_query' => array(
            'after' => date('Y-m-d', strtotime('first day of last month')),
            'before' => date('Y-m-d', strtotime('last day of last month')),
            'inclusive' => true,
        ),
    );

    $orders = wc_get_orders($args);
    $report = array();

    foreach ($orders as $order) {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $categories = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'ids'));
            foreach ($categories as $category_id) {
                $parent = get_term_by('id', $category_id, 'product_cat')->parent;
                if ($parent == 0) { // Ensure it's a primary category
                    $category_name = get_term_by('id', $category_id, 'product_cat')->name;
                    if (!isset($report[$category_name])) {
                        $report[$category_name] = array();
                    }
                    if (!isset($report[$category_name][$product->get_id()])) {
                        $report[$category_name][$product->get_id()] = array(
                            'product_name' => $product->get_name(),
                            'quantity' => 0,
                            'total' => 0
                        );
                    }
                    $report[$category_name][$product->get_id()]['quantity'] += $item->get_quantity();
                    $report[$category_name][$product->get_id()]['total'] += $item->get_total();
                    break; // Stop after the first primary category
                }
            }
        }
    }

    return $report;
}



//add_action('send_monthly_sales_report', 'send_sales_report_to_admin');

//Create and send a monthly sales report to admin's email
function send_sales_report_to_admin() {
	$report = get_woocommerce_sales_by_primary_category();

    $message = "Monthly Sales Report\n\n";
    $message .= date('1.m.Y', strtotime('first day of last month')) . " - " . date('t.m.Y', strtotime('last day of last month')) . "\n\n";

    foreach ($report as $category_name => $products) {
        $message .= "Category Name: $category_name\n";
        $category_total = 0;
        foreach ($products as $product) {
            $message .= "Product: " . $product['product_name'] . " - Units Sold: " . $product['quantity'] . "\n";
            $message .= "Item Sales Total: " . number_format($product['total'], 2) . "kr\n\n";
            $category_total += $product['total'];
        }
        $message .= "Net Total for $category_name: " . number_format($category_total, 2) . "kr\n\n";
    }
	//$message .= "End of report. In case if you feel like data is missing - please make sure all orders created have been marked as 'completed';
	
    $admin_email = get_option('admin_email');
	$subject = "Monthly Sales Report:  " . date('1.m.Y', strtotime('first day of last month')) . " - " . date('t.m.Y', strtotime('last day of last month'));
	wp_mail($admin_email, $subject, $message);
}


// Automatically make processed orders into complete. Otherwise it'd have to be manually done :()
//These are required for the monthly report
add_action( 'woocommerce_order_status_processing', 'custom_autocomplete_order' );
function custom_autocomplete_order( $order_id ) {
	if ( ! $order_id ) {
		return;
	}
	$order = wc_get_order( $order_id );
	$order->update_status( 'completed' );
}


//Make sure these are unchecked by default
add_filter( 'woocommerce_terms_is_checked_default', '__return_false' );
add_filter( 'woocommerce_legal_terms_is_checked_default', '__return_false' );

//Require the checkbox at checkout to be checked
add_action( 'woocommerce_checkout_process', 'custom_legal_terms_validation' );
function custom_legal_terms_validation() {
    if ( ! isset( $_POST['legal_terms'] ) ) {
        wc_add_notice( __( 'You must accept the legal terms to proceed.', 'woocommerce' ), 'error' );
    }
}

add_action( 'woocommerce_checkout_update_order_meta', 'custom_legal_terms_update_order_meta' );
function custom_legal_terms_update_order_meta( $order_id ) {
    if ( isset( $_POST['legal_terms'] ) ) {
        update_post_meta( $order_id, '_legal_terms', sanitize_text_field( $_POST['legal_terms'] ) );
    }
}

// Disables pointless plugins on listed pages. Disable function if page is not functioning as required.
function disable_unused_plugins_on_pages($plugins) {
    // Array requires page ID or slug. Plugins are to be disabled on these pages. /wp-admin/edit.php?post_type=page
    $pages_to_skip = array(
        'customer-info',
        'home',
        'privacy-policy',
        'legal'
    );

    if (is_page($pages_to_skip)) {
        // Insert plugin to disable. The path be found in AsuraHosting file manager. example; /wp-content/plugins/integrate-firebase/init.php
        // Chosen file(s) should have fields for plugin name, description and so on.
        $plugin_to_disable = 'integrate-firebase/init.php';

        //Remove plugin from list of plugins
        $plugins = array_diff($plugins, array($plugin_to_disable));
    }
    return $plugins;
}
add_filter('set_active_plugins', 'disable_unused_plugins_on_pages');