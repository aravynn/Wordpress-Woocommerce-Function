<?php
/**
 * MEP Brothers 2019 Theme Functions. 
 *
 * @package MEPBrothers
 * @since 1.19.0
 */



	function mepbrothers_2019_enqueue_scripts() {
		
		global $post_id;
		
		wp_enqueue_style( 'mepbro-main-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'mepbro-mobile-style', get_template_directory_uri() . '/css/mobile.css', array('mepbro-main-style'), null, 'screen and (max-width: 500px)' );
		
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array() );
		
		$theswitch = get_page_template_slug( $post_id );
		
		if(is_product()){
			$theswitch = 'Product';
		} elseif ( is_product_category() ){
			$theswitch = 'Category';
		} elseif ( is_search() ){
			$theswitch = 'Search';
		} elseif ( is_shop() ) {
			$theswitch = 'Shop';
		}
		
		
		switch($theswitch){
			
			case 'main-page.php':	
				wp_enqueue_script( 'mepbro-main-javascript',  get_template_directory_uri() . '/js/main-page.js', array('jquery'), null, true );
			
				break;
			case 'Shop':
			case 'Search':
			case 'Category':
				wp_enqueue_style( 'mepbro-product-style', get_template_directory_uri() . '/css/category.css', array('mepbro-main-style') );
				wp_enqueue_script( 'mepbro-generic-javascript',  get_template_directory_uri() . '/js/scripts.js', array('jquery') );
			
				break;
			case 'Product':	
			default:
				//echo 'This is loading by default';
				wp_enqueue_style( 'mepbro-product-style', get_template_directory_uri() . '/css/product.css', array('mepbro-main-style') );
				wp_enqueue_script( 'mepbro-generic-javascript',  get_template_directory_uri() . '/js/scripts.js', array('jquery') );
				
				break;
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'mepbrothers_2019_enqueue_scripts' );


	
	register_nav_menus(
			array(
				'header-main-menu' => __( 'Header Menu' ),
				'header-hose-fittings-menu' => __( 'Hose Fittings Header' ),
				'header-spill-response-menu' => __( 'Spill Response Header' ),
				'header-dust-fume-menu' => __( 'Dust Fume Extraction Header' ),
				'header-valves-pumps-menu' => __( 'Valves Pumps Pressure Header' ),
				'header-rubber-gaskets-menu' => __( 'Rubber Gaskets Header' ),
				'header-industrial-supply-menu' => __( 'Industrial Supply Header' )
			)
		);
function arphabet_widgets_init() {	
	register_sidebar( 
		array(
			'name' => __( 'Header Cart', 'smallenvelop' ),
			'id' => 'cart_widget',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		) 
	);
	
	register_sidebar( 
		array(
			'name' => __( 'Main Email', 'smallenvelop' ),
			'id' => 'main_email_widget',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		) 
	);
	
	register_sidebar( 
		array(
			'name' => __( 'Main blog', 'smallenvelop' ),
			'id' => 'main_blog_widget',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<div id="bloghead"><h4>',
			'after_title' => '<a href="/blog/" class="mainlink blue right">See All Posts</a></div>',
		) 
	);
	
}
add_action( 'widgets_init', 'arphabet_widgets_init' );	


/**
 *
 * Contact Form 7 Specific code
 *
 *
 *
 */
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

    return $content;
});



/**
 *
 *
 * Woocommerce Specific code below. 
 *
 */

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

// remove review and additional tabs
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
    function wcs_woo_remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    unset($tabs['additional_information']);
    return $tabs;
}

//Reposition WooCommerce breadcrumb 
function woocommerce_remove_breadcrumb(){
remove_action( 
    'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}
add_action(
    'woocommerce_before_main_content', 'woocommerce_remove_breadcrumb'
);


// code to alter layout of hooks for product details.

add_action( 'woocommerce_before_single_product', 'cspl_change_single_product_layout' );
function cspl_change_single_product_layout() {
    // Disable the hooks so that their order can be changed.
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );
}


// always show variations prices
function ssp_always_show_variation_prices($show, $parent, $variation) {
	return true;
}
add_filter( 'woocommerce_show_variation_price', 'ssp_always_show_variation_prices', 99, 3);

// remove "can be backordered"
add_filter( 'woocommerce_get_availability_text', 'filter_product_availability_text', 10, 2 );
function filter_product_availability_text( $availability, $product ) {

    if( $product->backorders_require_notification() ) {
        $availability = str_replace('(can be backordered)', '', $availability);
    }
    return $availability;
}



function woocommerce_template_loop_product_link_open() {
      //  global $product;

      //  $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

      //  echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
    }

function woocommerce_template_loop_product_link_close() {
      //  echo '</a>';
    }

// override title for loop related products.
function woocommerce_template_loop_product_title() {
        echo '<h5 class="woocommerce-loop-product__title">' . get_the_title() . '</h5>';
}

// override image thumbnail for loop related products. 
function woocommerce_template_loop_product_thumbnail() {
       global $product;
       
        echo '<div class="flexbox">' . $product->get_image( 'full' ) . '</div>'; // WPCS: XSS ok.
}

// override subcategory thumbnail
	function woocommerce_subcategory_thumbnail( $category ) {
        $small_thumbnail_size = 'full';
        $dimensions           = wc_get_image_size( $small_thumbnail_size );
        $thumbnail_id         = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );

        if ( $thumbnail_id ) {
            $image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
            $image        = $image[0];
            $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
            $image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;
        } else {
            $image        = wc_placeholder_img_src();
            $image_srcset = false;
            $image_sizes  = false;
        }

        if ( $image ) {
            // Prevent esc_url from breaking spaces in urls for image embeds.
            // Ref: https://core.trac.wordpress.org/ticket/23605.
            $image = str_replace( ' ', '%20', $image );

            // Add responsive image markup if available.
            if ( $image_srcset && $image_sizes ) {
                echo '<div class="flexbox"><img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" /></div>';
            } else {
                echo '<div class="flexbox"><img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" /></div>';
            }
        }
    }
    
// override cat title 
	function woocommerce_template_loop_category_title( $category ) {

       echo '<strong>' . esc_html( $category->name ) . '</strong>';
       
    }
    
    
// Add PO to checkout

/**
 * Add custom field to the checkout page
 */

add_action('woocommerce_after_order_notes', 'custom_checkout_field');

function custom_checkout_field($checkout) {
	//echo '<div id="custom_checkout_field"><h5>' . __('New Heading') . '</h5>';
	
	woocommerce_form_field(
		'po_number', 
		array(
			'type' => 'text',
			'class' => array(
			'my-field-class form-row-wide'
		) ,
		'label' => __('Purchase Order Number') ,
		'placeholder' => __('Add your PO number if required for this order') ,
		) ,
		$checkout->get_value('po_number')); //custom_field_name
	
	//echo '</div>';
}    
    
/**
 * Update the value given in custom field
 */

add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');

function custom_checkout_field_update_order_meta($order_id) {
	if (!empty($_POST['po_number'])) {
		update_post_meta($order_id, 'po_number', sanitize_text_field($_POST['po_number']));
	}
}				


/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	echo 'po_number: ' . get_post_meta( $order->get_id(), 'po_number', true );
}


/** 
 * Disable Payment type for non-logged in users ***************************************************************!!!!!!!!!!!!!!!!!***!*!
 */

function wdm_disable_cod( $available_gateways ) {

//check whether the avaiable payment gateways have Cash on delivery and user is not logged in or he is a user with role customer
    if ( get_field('user_allowed_net_terms', 'user_' . get_current_user_id()) != 'Yes' || ! is_user_logged_in() ) {

        //remove the cash on delivery payment gateway from the available gateways.
 		unset($available_gateways['cod']);
     }
     
     return $available_gateways;
}

add_filter('woocommerce_available_payment_gateways', 'wdm_disable_cod', 99, 1);

/**
 *
 * PRICE CHANGE CODE. TO AUTOMATICALLY OVERRIDE PRICE. 
 *
 *
 */

// Utility function to change the prices with a multiplier (number)
function get_price_multiplier() {
    return 1; // x2 for testing
}

function get_price_by_sku($sku){
	// Get the price associated with a specific part number. This risks calling many times, is there a way to limit this? 
	
	// CODE ADDED HERE TO TEST IF SESSION WILL WORK.
	if(session_id() == '' || !isset($_SESSION)) {
		session_id('price_event_only');
		session_start();
		$_SESSION['price_time'] = time() + 60*60;
		$_SESSION['price_unique'] = true;
		$_SESSION['prices'] = array();
	} else {
		if(session_id() != 'price_event_only' && !isset($_SESSION['price_unique'])){
			// a session exists but not ours. run once.
			$_SESSION['price_unique'] = false;
			$_SESSION['price_time'] = time() + 60*60;
		}
		
		if($_SESSION['price_time'] < time()){
			//it is after renout time, refresh the list. 
			if($_SESSION['price_unique']){
				// we need to reset the current value. 
				session_destroy();
			} else {
				// since other events also exist, only reset our current values. 
				$_SESSION['prices'] = array();
				$_SESSION['price_time'] = time() + 60*60;
			}
		}
		
	}
	
	if(isset($_SESSION['prices'][$sku])){
	
		return filter_var ( $_SESSION['prices'][$sku], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	
	} else {
	
		$sku = filter_var ( $sku, FILTER_SANITIZE_STRING );
	
		$user = "username";
		$pass = "password";
		try {  
			$dbh = new PDO('mysql:host=host;dbname=database', $user, $pass);
		}  
		catch(PDOException $e) {  
			echo $e->getMessage();  
		}
		$STH = $dbh->prepare('SELECT Price FROM inventory WHERE SKU = :sku OR WebSKU = :sku LIMIT 1');
		$STH->execute(array(':sku' => $sku));
	
		$row = $STH->fetchAll();
	
		$_SESSION['prices'][$sku] = $row[0]['Price'];
	
		if($row[0]['Price'] != ''){
			return filter_var ( $row[0]['Price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		} else {
			return false;
		}
		$dbh = '';
	
	}
}

// Simple, grouped and external products
add_filter('woocommerce_product_get_price', 'custom_price', 99, 2 );
add_filter('woocommerce_product_get_regular_price', 'custom_price', 99, 2 );
// Variations
add_filter('woocommerce_product_variation_get_regular_price', 'custom_price', 99, 2 );
add_filter('woocommerce_product_variation_get_price', 'custom_price', 99, 2 );
function custom_price( $price, $product ) {
	
	 $thesku = $product->get_sku();
    
    if(isset($_SESSION['prices'][$thesku])){
    	
    	return $_SESSION['prices'][$thesku];
    
    } else {
	
		wc_delete_product_transients($product->get_id());
	
		$newprice = get_price_by_sku($thesku);
		
		$DiscountPercent = (100 - get_field('user_discount_rating', 'user_' . get_current_user_id())) / 100;
	
		if($newprice){
	
			$multiple = get_post_meta($product->get_id(), 'multiple', true);
		
			if($multiple != ''){
				$newprice = $newprice * $multiple;
			}
		
			$regprice = $newprice * $DiscountPercent;
		} else {
			$regprice = $price * get_price_multiplier() * $DiscountPercent;
		}
	
	
	
		if($price == $product->get_sale_price()){
			// This is a sale price 
			if($price < $regprice){
				$_SESSION['prices'][$thesku] = $price;
				return $price;
			} else {
				$_SESSION['prices'][$thesku] = $regprice;
				return $regprice;
			}
		} else {
			// regular price, get and return a legit price value. if no price exists, return default. 
			$_SESSION['prices'][$thesku] = $regprice;
			return $regprice;
		}
		
	}
		
}

// Variable (price range)
add_filter('woocommerce_variation_prices_price', 'custom_variable_price', 99, 3 );
add_filter('woocommerce_variation_prices_regular_price', 'custom_variable_price', 99, 3 );
function custom_variable_price( $price, $variation, $product ) {
    
    $thesku = $variation->get_sku();
    
    if(isset($_SESSION['prices'][$thesku])){
    	
    	return $_SESSION['prices'][$thesku];
    
    } else {
    
		// Delete product cached price  (if needed)
		wc_delete_product_transients($variation->get_id());
		//var_dump($product);
	
		$newprice = get_price_by_sku($thesku);
		
		$DiscountPercent = (100 - get_field('user_discount_rating', 'user_' . get_current_user_id())) / 100;
	
		if($newprice){
		
			$multiple = get_post_meta($variation->get_id(), 'multiple', true);
		
			if($multiple != ''){
				$newprice = $newprice * $multiple;
			}
		
			$regprice = $newprice * $DiscountPercent;
		} else {
			$regprice = $price * get_price_multiplier() * $DiscountPercent;
		}
	
		if($price == $variation->get_sale_price()){
			// This is a sale price 
			if($price < $regprice){
				$_SESSION['prices'][$thesku] = $price;
				return $price;
			} else {
				$_SESSION['prices'][$thesku] = $regprice;
				return $regprice;
			}
		} else {
			$_SESSION['prices'][$thesku] = $regprice;
			return $regprice;
		}
	
	}
}

// Handling price caching (see explanations at the end)
add_filter( 'woocommerce_get_variation_prices_hash', 'add_price_multiplier_to_variation_prices_hash', 99, 1 );
function add_price_multiplier_to_variation_prices_hash( $hash ) {
    $hash[] = get_price_multiplier();
    return $hash;
}

/*----------------------------------------------*\
	Woocommerce Set a $0 item to "Will Quote"
\*----------------------------------------------*/

function my_wc_custom_get_price_html( $price, $product ) {
	
	if(strpos($price, '0.00') !== false){
		return '<span class="woocommerce-Price-amount amount"> Will Quote </span>';
	} else {
		return $price;
	}
}

add_filter( 'woocommerce_get_price_html', 'my_wc_custom_get_price_html', 10, 2 );



function on_display_cart_item_price_html($html, $cart_item, $cart_item_key) {
		
	if (is_cart()) {
		$price_base = $cart_item['data']->regular_price;

			if ($price_base == 0) {
				$html = '<span class="amount">Will Quote</span>';
			} else {
			//	$html = '<span class="amount">' . wc_price($price_base) . '</span>';
			}
		}

	return $html;
}

add_filter('woocommerce_cart_item_price', 'on_display_cart_item_price_html', 100, 3);


/*-------------------------------------*\
	Woocommerce multiple custom field
\*-------------------------------------*/


// Add Variation Settings
add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );

// Save Variation Settings
add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );


/**
 * Create new fields for variations
 *
*/
function variation_settings_fields( $loop, $variation_data, $variation ) {



	// Textarea
	woocommerce_wp_textarea_input( 
		array( 
			'id'          => 'multiple[' . $variation->ID . ']', 
			'label'       => __( 'Multiple', 'woocommerce' ), 
			'placeholder' => '', 
			'description' => __( 'How many come in a standard pack?', 'woocommerce' ),
			'value'       => get_post_meta( $variation->ID, 'multiple', true ),
		)
	);


}

/**
 * Save new fields for variations
 *
*/
function save_variation_settings_fields( $post_id ) {



	// Textarea
	$textarea = $_POST['multiple'][ $post_id ];
	if( ! empty( $textarea ) ) {
		update_post_meta( $post_id, 'multiple', esc_attr( $textarea ) );
	}


}


/*-------------------------------------*\
	Woocommerce Available Message
\*-------------------------------------*/


function getStockLevels($sku){
	// Get Stocks Levels by part number. 
	
	 if(session_id() == '' || !isset($_SESSION)) {
		session_id('price_event_only');
		session_start();
		$_SESSION['price_time'] = time() + 60*60;
		$_SESSION['price_unique'] = true;
		$_SESSION['prices'] = array();
	} else {
		if(session_id() != 'price_event_only' && !isset($_SESSION['price_unique'])){
			// a session exists but not ours. run once.
			$_SESSION['price_unique'] = false;
			$_SESSION['price_time'] = time() + 60*60;
		}
		
		if($_SESSION['price_time'] < time()){
			//it is after renout time, refresh the list. 
			if($_SESSION['price_unique']){
				// we need to reset the current value. 
				session_destroy();
			} else {
				// since other events also exist, only reset our current values. 
				$_SESSION['prices'] = array();
				$_SESSION['price_time'] = time() + 60*60;
			}
		}
		
	}
	
	if(isset($_SESSION['prices'][$sku . '!inv!'])){
	
		return $_SESSION['prices'][$sku . '!inv!'];
	
	} else {
	
	
	
		$sku = filter_var ( $sku, FILTER_SANITIZE_STRING );
	
		$user = "username";
		$pass = "password";
		try {  
			$dbh = new PDO('mysql:host=hoat;dbname=database', $user, $pass);
		}  
		catch(PDOException $e) {  
			echo $e->getMessage();  
		}
		$STH = $dbh->prepare('SELECT inv, isActive FROM inventory WHERE SKU = :sku OR WebSKU = :sku LIMIT 1');
		$STH->execute(array(':sku' => $sku));
	
		$row = $STH->fetchAll();
	
		if( $row == '' ){
			// no results, return false. 
			$row = array('inv' => 0, 'isActive' => false);
		}
	
		//var_dump($row); 
		//echo '<br />';
		
		$_SESSION['prices'][$sku . '!inv!'] = array(
				filter_var ( $row[0]['inv'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
				$row[0]['isActive']);
				
				
		if($row[0]['inv'] != ''){
			return $_SESSION['prices'][$sku . '!inv!'];
		} else {
			return false;
		}
	
		$dbh = '';
	}
}



function so_42345940_backorder_message( $text, $product ){
   
   $inventory = getStockLevels($product->get_sku());
   
   if($inventory[1] == 'false'){
   	//	$product->set_backorders( 'no' );
		   	
   		update_post_meta( $product->get_id(), '_backorders', 'no' );
   	
   		return 'Out Of Stock';
   } else {
	   $stock = $inventory[0];
   
	   $multiple = get_post_meta($product->get_id(), 'multiple', true);
		
		if($multiple != ''){
			$stock = floor($stock / $multiple);
		}
	
		if($stock > 0){
			return $stock . ' Currently In Stock';
		} else {
			return 'Available To Order';
		}
	}
   
}
add_filter( 'woocommerce_get_availability_text', 'so_42345940_backorder_message', 10, 2 );


/*----------------------------------------------------------*\
	remove the register link from the wp-login.php script
\*----------------------------------------------------------*/

add_filter('option_users_can_register', function($value) {
    $script = basename(parse_url($_SERVER['SCRIPT_NAME'], PHP_URL_PATH));
 
    if ($script == 'wp-login.php') {
        $value = false;
    }
 
    return $value;
});
