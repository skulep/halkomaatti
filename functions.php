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
    if ($resource !== 'order') {
        return $payload;
	}
	//We do not need all these fields. Unset can remove them
	unset($payload['_links']);
	unset($payload['billing']);
	unset($payload['shipping']);
	unset($payload['shipping_lines']);
	unset($payload['tax_lines']);
	unset($payload['refunds']);
	unset($payload['fee_lines']);
	//unset($payload['line_items']); //this one is actually needed
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
	unset($payload['date_created']);  //not sure if needed. will add it for clarity reasons
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


	//Get order data and create it

	$items = $payload['line_items'];
	$orders_array = [];
	
	foreach ($items as $key=>$item) {

		//Get categories using item ID
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
				//check if category exists. hopefully it will be in order :D :gun:
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

	unset($payload['line_items']); //Removing this at the very end since it is not needed anymore
    return $payload;
}
//Edits the 'order created' webhook. This will be sent to Firebase
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

function custom_firebase_scripts_function()
{
 	wp_enqueue_script('custom_firebase', get_template_directory_uri() . '/js/custom_firebase.js', array('firebase_app', 'firebase_auth', 'firebase_database', 'firebase_firestore', 'firebase'), '1.0.0', true);
	wp_script_add_data('custom_firebase', 'type', 'module');

	//Testing adding secret.js too.
	//wp_enqueue_script('secret-js', get_template_directory_uri() . '/js/secret.js',array(),'1.0.0',true);
	//wp_script_add_data('secret-js', 'type', 'module');
}
add_action('wp_enqueue_scripts', 'custom_firebase_scripts_function');


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
