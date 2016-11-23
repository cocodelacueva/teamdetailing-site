<?php
//WooCommerce support
add_theme_support( 'woocommerce' );

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action('init', 'woo_install_theme', 1);
function woo_install_theme() {
	update_option( 'woocommerce_thumbnail_image_width', '90' );
	update_option( 'woocommerce_thumbnail_image_height', '90' );
	update_option( 'woocommerce_single_image_width', '300' );
	update_option( 'woocommerce_single_image_height', '300' );
	update_option( 'woocommerce_catalog_image_width', '277' );
	update_option( 'woocommerce_catalog_image_height', '277' );
}

//Disable WooCommerce default styles 
define('WOOCOMMERCE_USE_CSS', false);

//ozythemes woocommerce style
function wp_enqueue_woocommerce_style(){
    wp_register_style( 'woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'woocommerce' );
	}
		
	//Set products per page
	$ic_woo_item_count = ot_get_option('ic_woo_item_count') > 0 ? ot_get_option('ic_woo_item_count') : 12;
	add_filter( 'loop_shop_per_page', create_function( '$cols', "return $ic_woo_item_count;" ), 20 );	
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );

//Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {
	woocommerce_related_products(3, 3); // Display 3 products in rows of 3
}

//Set products per row
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return (int)ot_get_option('ic_woo_column_count') > 0 ? ot_get_option('ic_woo_column_count') : 4 ;
	}
}

//Disable AJAX Add to cart button
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart'); // remove that ajaxified Add To Cart button that automatically adds 1 item to the cart.

//WooCommerce top bar
function woo_commerce_top_bar($st = '<div id="woocommerce-top-bar"><div class="container"><div class="row">', $et = '</div></div></div>') {

	global $woocommerce;
	
	echo '<!--woocommerce top bar-->' . PHP_EOL;
	
	echo $st;
	
	//My Account link
	echo "<div class='woocommerce-top-myaccount span6'>\n";
		if ( is_user_logged_in() ) {
			echo '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" title="' . __('My Account','ozy_frontend') . '">' . __('My Account','ozy_frontend') . '</a>' . PHP_EOL;
		} else {
			echo '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" title="' . __('Login','ozy_frontend') . '">'. __('Login','ozy_frontend') . '</a>' . PHP_EOL;
			echo '&nbsp;/&nbsp;';
			echo '<a href="' . get_bloginfo('wpurl'). '/wp-login.php?action=register" title="' . __('Register','ozy_frontend') . '">'. __('Register','ozy_frontend') . '</a>' . PHP_EOL;
		}
	echo "</div>\n";

	//Basket
	echo "<div class='woocommerce-top-items span6 pull-right'>\n";
		echo '<a class="cart-contents" href="' . $woocommerce->cart->get_cart_url() . '" title="' . __('View your shopping cart', 'ozy_frontend') . '">' . $woocommerce->cart->get_cart_total() . '<span>' . sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count) . '</span></a>' . PHP_EOL;
		
		//Checkout button & Cart Icon
		if (sizeof($woocommerce->cart->cart_contents)>0) :
			echo '<a href="' . $woocommerce->cart->get_checkout_url() . '" title="' . __('Checkout','ozy_frontend') . '" class="woocommerce-shopping-cart-button"><i class="icon-shopping-cart">&nbsp;</i></a>' . PHP_EOL;
		else :
			echo '<a href="' . get_permalink(woocommerce_get_page_id( 'shop' )) . '" class="woocommerce-shopping-cart-button"><i class="icon-shopping-cart">&nbsp;</i></a>' . PHP_EOL;
		endif;
	
	echo "</div>\n";
    
	echo $et;
	
	echo '<!--/woocommerce top bar-->' . PHP_EOL;
}
?>