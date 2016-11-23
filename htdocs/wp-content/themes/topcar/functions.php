<?php
define( 'OZY_BASE_DIR', get_template_directory() . '/' );
define( 'OZY_BASE_URL', get_template_directory_uri() . '/' );
define( 'OZY_HOME_URL', home_url() . '/' );
define( 'OZY_THEME_VERSION', '1.8' );

global $OZY_WOOCOMMERCE_ENABLED; $OZY_WOOCOMMERCE_ENABLED = false;

//Load Text Domain
function crucial_setup(){
    load_theme_textdomain('ozy_frontend', get_template_directory() . '/translate');
}
add_action('after_setup_theme', 'crucial_setup');

//Visual Composer Initialization
$dir = dirname(__FILE__) . '/vc/';
 
$composer_settings = array(
    'APP_ROOT'      => $dir . '/js_composer',
    'WP_ROOT'       => dirname( dirname( dirname( dirname($dir ) ) ) ). '/',
    'APP_DIR'       => basename( $dir ) . '/js_composer/',
    'CONFIG'        => $dir . '/js_composer/config/',
    'ASSETS_DIR'    => 'assets/',
    'COMPOSER'      => $dir . '/js_composer/composer/',
    'COMPOSER_LIB'  => $dir . '/js_composer/composer/lib/',
    'SHORTCODES_LIB'  => $dir . '/js_composer/composer/lib/shortcodes/',
 
    /* for which content types Visual Composer should be enabled by default */
    'default_post_types' => array('page', 'post', 'ozy_portfolio')
);
require_once locate_template('/vc/js_composer/js_composer.php');
 
$wpVC_setup->init($composer_settings);

//Remove unneccasary Visual Composer components
wpb_remove("vc_widget_sidebar");
wpb_remove("vc_text_separator");

//Remove inline styles from tagcloud widget
function xf_tag_cloud($tag_string){
   return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}
add_filter('wp_generate_tag_cloud', 'xf_tag_cloud',10,3);

//Widgets
require_once ( get_template_directory() . '/functions/widgets.php' );

//Shortcodes
require_once ( get_template_directory() . '/functions/shortcodes.php' );

//Helper Class
include_once ( get_template_directory() . '/functions/helper.php' );
$myhelper = new myHelper;

//TGM - Automatic plugin activation
include( OZY_BASE_DIR . 'functions/tgm-plugin-activation.php' );

//Options Tree Plugin
add_filter( 'ot_show_pages', '__return_false' ); //set 'ot_show_pages' filter to false before publishing.
add_filter( 'ot_theme_mode', '__return_true' ); //set 'ot_theme_mode' filter to true.
include_once( OZY_BASE_DIR . 'option-tree/ot-loader.php' );

//Check woocommerce support
if ( class_exists( 'woocommerce' ) ) {
	global $OZY_WOOCOMMERCE_ENABLED;
	$OZY_WOOCOMMERCE_ENABLED = true;
	include_once("functions/woocommerce.php");
}

//Try to get current language code from WPML plugin if enabled
if(defined("ICL_LANGUAGE_CODE") && ICL_LANGUAGE_CODE != 'en')
	$myhelper->wpml_current_language = ICL_LANGUAGE_CODE;

//Sidebars. *REMINDER*load after WPML language check _____^
include( OZY_BASE_DIR . 'functions/sidebar.php' );

//Custom Functions
include( OZY_BASE_DIR . 'functions/custom-functions.php' );

//Post Types
include( OZY_BASE_DIR . 'functions/custom-post-types.php' );

//Meta Boxes
include_once( OZY_BASE_DIR . 'functions/meta-boxes.php' );

//Google Fonts
include_once( OZY_BASE_DIR . 'functions/admin/google.font.list.php' );

//Define available social networks
global $AVAILABLE_SOCIAL_NETWORKS;
$AVAILABLE_SOCIAL_NETWORKS = array("blogger", "bebo", "deviantart", "dribble", "facebook", "flickr", "google", "behance", "linkedin", "rss", "skype", "myspace", "stumbleupon", "tumblr", "twitter", "vimeo", "wordpress", "yahoo", "youtube", "pinterest", "instagram");

//Disable admin bar for all 
//show_admin_bar(false);

/* ---------------------------------------------------------------------- */
/*	Required/recommended plugins
/* ---------------------------------------------------------------------- */
function ozy_framework_register_required_plugins() {

	$plugins = array(

		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false
		),array(
			'name'     => 'WordPress Importer',
			'slug'     => 'wordpress-importer',
			'required' => false
		),array(
			'name'     => 'MailChimp List Subscribe Form',
			'slug'     => 'mailchimp',
			'required' => false
		),array(
			'name'     => 'Widget Data - Setting Import/Export Plugin',
			'slug'     => 'widget-settings-importexport',
			'required' => false
		)
	);

	$config = array(
		'domain'       		=> 'ozy_framework',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       	=> __( 'Install Required Plugins', 'ozy_framework' ),
			'menu_title'                       	=> __( 'Install Plugins', 'ozy_framework' ),
			'installing'                       	=> __( 'Installing Plugin: %s', 'ozy_framework' ), // %1$s = plugin name
			'oops'                             	=> __( 'Something went wrong with the plugin API.', 'ozy_framework' ),
			'notice_can_install_required'     	=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'	=> _n_noop( 'This theme recommends the following plugin for the perfect results: %1$s.', 'This theme recommends the following plugins for the perfect results: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  			=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    	=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'	=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 			=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 				=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 				=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  	=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  	=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           	=> __( 'Return to Required Plugins Installer', 'ozy_framework' ),
			'plugin_activated'                 	=> __( 'Plugin activated successfully.', 'ozy_framework' ),
			'complete' 							=> __( 'All plugins installed and activated successfully. %s', 'ozy_framework' ), // %1$s = dashboard link
			'nag_type'							=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}
add_action('tgmpa_register', 'ozy_framework_register_required_plugins');

//Add Buttons To The Visual Editor
function dh_enable_more_buttons($buttons) {
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'charmap';
	return $buttons;
}
add_filter( 'mce_buttons_3', 'dh_enable_more_buttons' );

// Add custom text sizes in the font size drop down list of the rich text editor (TinyMCE) in WordPress
// $initArray is a variable of type array that contains all default TinyMCE parameters.
// Value 'theme_advanced_font_sizes' needs to be added, if an overwrite to the default font sizes in the list, is needed.
function customize_text_sizes($initArray){
   	$initArray['theme_advanced_font_sizes'] = "10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px,21px,22px,23px,24px,25px,26px,27px,28px,29px,30px,32px,48px,60px,72px,84px,96px,108px,120px";
   	return $initArray;
}
add_filter('tiny_mce_before_init', 'customize_text_sizes');

//Load theme default options for once
function load_option_tree_dummy_data_first_time() {
	//version check for new options
	if(get_option("opt_iworks_version") != OZY_THEME_VERSION) {
		$settings_str = read_option_file( "ot_settings.v" . OZY_THEME_VERSION );
		$settings = ( isset( $settings_str ) && !empty($settings_str) ) ? unserialize( base64_decode( $settings_str ) ) : '';
		$settings_str = NULL;
		if ( is_array( $settings ) ) {
			update_option( 'option_tree_settings', $settings );
		}
		delete_option("opt_iworks_version");
		add_option("opt_iworks_version", OZY_THEME_VERSION);
	}
	
	if(get_option("opt_options_are_loaded") === "yes")
		return false;
	
	//LAYOUTS
	$layout_str = read_option_file( "ot_layouts" );
	$layouts = ( isset( $layout_str ) && !empty($layout_str) ) ? unserialize( base64_decode( $layout_str ) ) : '';
	$layout_str = NULL;
	if ( is_array( $layouts ) ) {
		
		/* validate options */
		if ( is_array( $settings ) ) {
			foreach( $layouts as $key => $value ) {
				if ( $key == 'active_layout' )
					continue;

				$options = unserialize( base64_decode( $value ) );
				foreach( $settings['settings'] as $setting ) {
					if ( isset( $options[$setting['id']] ) ) {
						$content = ot_stripslashes( $options[$setting['id']] );
						$options[$setting['id']] = ot_validate_setting( $content, $setting['type'], "" );
					}
				}
				$layouts[$key] = base64_encode( serialize( $options ) ); 
			}
		}        
        /* update the option tree array */
        if ( isset( $layouts['active_layout'] ) ) {
			update_option( 'option_tree', unserialize( base64_decode( $layouts[$layouts['active_layout']] ) ) );
        }
        /* update the option tree layouts array */
        update_option( 'option_tree_layouts', $layouts );		
	}
	//save for later
	delete_option("opt_options_are_loaded");	
	add_option("opt_options_are_loaded", "yes");
}

function read_option_file($file) {
	$file = OZY_BASE_DIR . "inc/" . $file . ".txt";
	if( file_exists( $file ) ) {
		return file_get_contents( $file );
	}else{
		return "";
	}	
	return "";
}
if (is_admin()) add_action( 'init', 'load_option_tree_dummy_data_first_time' );

//To enable font upload, adding file mime types
function custom_upload_mimes ( $existing_mimes=array() ) {
	// add your extension to the array
	$existing_mimes['eot'] 	= 'application/vnd.ms-fontobject';
	$existing_mimes['ttf'] 	= 'application/octet-stream';
	$existing_mimes['woff'] = 'application/x-woff';
	$existing_mimes['svg'] 	= 'image/svg+xml';
	
	return $existing_mimes;
}
add_filter('upload_mimes', 'custom_upload_mimes');

function scriptloader() {

	global $myhelper;
	$ie9 = ielt9();

	/*favicon and ios icon*/
	if(trim(get_option_tree("ic_favicon"))) {
		printf("<link rel='shortcut icon' href='%s'/>\r\n", trim(get_option_tree("ic_favicon")));
		if(!$ie9)
			printf("<link rel='apple-touch-icon' href='%s'/>\r\n", trim(get_option_tree("ic_favicon")));
	}
	
	if(!$ie9) {	
		/*iphone retina app icon*/
		if(trim(get_option_tree("ic_favicon_iphone")))
			printf("<link rel='apple-touch-icon' sizes='114x114' href='%s' />\r\n", trim(get_option_tree("ic_favicon_iphone")));
	
		/*ipad retina app icon*/
		if(trim(get_option_tree("ic_favicon_ipad"))) {
			printf("<link rel='apple-touch-icon' sizes='144x144' href='%s' />\r\n", trim(get_option_tree("ic_favicon_ipad")));
			printf("<meta name='msapplication-TileImage' content='%s' />\r\n", trim(get_option_tree("ic_favicon_ipad")));	//windows 8	
		}
			
		/*startup image for ios*/
		if(trim(get_option_tree("apple_touch_startup_image")))
			printf("<link rel='apple-touch-startup-image' href='%s'>\r\n", trim(get_option_tree("apple_touch_startup_image")));
	}
	
	if (!is_admin() && !is_login_page()) {
		
		/*typeicon*/	
		wp_register_style('font-awesome-css', get_template_directory_uri().'/font-awesome/css/font-awesome.css');
		wp_enqueue_style( 'font-awesome-css');	
	
		if(ielt9()) {
			wp_register_style('font-awesome-css-ie7', get_template_directory_uri().'/font-awesome/css/font-awesome-ie7.min.css');
			wp_enqueue_style( 'font-awesome-css-ie7');
			wp_register_style('font-social', get_template_directory_uri().'/font-social/stylesheet-ie7.css');
		} else {
			wp_register_style('font-social', get_template_directory_uri().'/font-social/stylesheet.css');
			
			/*jquery mobile menu - dont load for IE8 or lower versions*/	
			wp_enqueue_script('jquery-mobile-menu', get_template_directory_uri().'/scripts/mobile-menu/jquery.accordion.js', array('jquery'), null, true );
			wp_register_style('jquery-mobile-menu-css', get_template_directory_uri().'/scripts/mobile-menu/style.css');
			wp_enqueue_style('jquery-mobile-menu-css');
		}
		wp_enqueue_style( 'font-social');

		//wp_enqueue_script('jquery'); disabled to call jquery library into desired place (head or footer)
		$add_jquery_to_footer = ot_get_option('ic_general_jquery_placement') !== 'head' ? true : false;
		wp_enqueue_script('jquery','/wp-includes/js/jquery/jquery.js','', null, $add_jquery_to_footer);
		
		/*check, if user like to make top level bootstrap menu items clickable*/
		if(ot_get_option('ic_skin_menu_first_level_clickable') !== '-1')
			wp_enqueue_script('bootstrap-menu-fix', get_template_directory_uri().'/scripts/bootstrap-menu-fix.js', array('jquery'), null, true );	
		
		wp_enqueue_script('jquery-easing', get_template_directory_uri().'/scripts/jquery/jquery.easing.1.3.js', array('jquery'), null, true );
		
		/*tip tip tooltip*/
		wp_enqueue_script('jquery-tiptip', get_template_directory_uri().'/scripts/jquery/tiptip.js', array('jquery'), null, true );
		wp_register_style('jquery-tiptip-css', get_template_directory_uri().'/css/tiptip.css');
		wp_enqueue_style( 'jquery-tiptip-css');
		
		/*autocomplete plugin currently used on search text boxes*/
		wp_enqueue_script('autocomplete', get_bloginfo('template_directory').'/scripts/autocomplete/jquery.autocomplete.min.js', array('jquery'), null, true );		
		
		wp_enqueue_script('bootstrap', get_template_directory_uri().'/scripts/bootstrap.min.js', array('jquery'), null, true );

		if(!$ie9) {
			wp_enqueue_script('parallax', get_template_directory_uri().'/scripts/jquery/parallax.js', array('jquery'), null, true );
			wp_enqueue_script('jqfloat', get_template_directory_uri().'/scripts/jquery/jqfloat.min.js', array('jquery'), null, true );
			wp_enqueue_script('jquery-rotate', get_template_directory_uri().'/scripts/jquery/jquery.rotate.js', array('jquery'), null, true );
		}
		
		/*comment reply*/
		wp_enqueue_script('comment-reply');

		/*main script file*/		
		wp_enqueue_script('ewa', get_template_directory_uri().'/scripts/ewa.js', array('jquery'), null, true );

		/*extra script*/
		if(ot_get_option('ic_add_on_script_location') === 'head' && trim(ot_get_option('ic_add_on_script') !== ''))
		{
			echo '<script type="text/javascript">' . PHP_EOL . '/* <![CDATA[ */' . PHP_EOL . ot_get_option('ic_add_on_script') . PHP_EOL . '/* ]]> */' . PHP_EOL . '</script>' . PHP_EOL;
		}
		else if(ot_get_option('ic_add_on_script_location') === 'after-body' && trim(ot_get_option('ic_add_on_script') !== ''))
		{			
			$myhelper->set_footer_script( ot_get_option('ic_add_on_script') );
		}

		/*selectvizr & html5shim libraries*/
		if($ie9) {
			wp_enqueue_script('selectivizr', get_template_directory_uri().'/scripts/selectivizr-min.js', array('jquery'), null, false );	
			wp_enqueue_script('html5shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array('jquery'), null, false );	
		}
		
		/*if bbpress enabled, load necessary css to fix it*/
		if($myhelper->ozy_is_plugin_active("bbpress/bbpress.php")) {
			wp_register_style('ozy-bbpress', get_template_directory_uri().'/css/bbpress.css');
			wp_enqueue_style('ozy-bbpress');
		}
    }
	
	if(is_admin() && !is_login_page()){
		wp_enqueue_script('javascript-admin', get_template_directory_uri().'/scripts/javascript-admin.js', array('jquery') );
		wp_register_style('jquery-admin-css', get_template_directory_uri().'/css/admin.css');
		wp_enqueue_style( 'jquery-admin-css');
	}
}
add_action('wp_print_scripts', 'scriptloader', 99);

//In order to make Supersized slider work, we have to print init script after footer
function ozy_print_wp_footer_scripts() {
	global $myhelper;
	$myhelper->get_footer_script();
}

add_action("wp_footer", "ozy_print_wp_footer_scripts", 100);

//Set admin scripts
function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
}

//Set admin styles
function my_admin_styles() {
	wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

//enable shortcodes in the widgets
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

//enable post formats
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio') );

//add menu support
add_theme_support( 'menus' );

function register_my_menus() {
	register_nav_menus(
		array( 'header-menu' => __( 'Home Header Menu' ), 'top-menu' => __( 'Top Small Menu' ) ) 
	); 
}

add_action( 'init', 'register_my_menus' );

//This is a very important filter to get ride of serious bug that menu disappears on the category listing pages
function query_post_type($query) {
	if(is_category()) return; /*absolute solution,otherwise menu disappear*/

	if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) 
	{
		$post_type = get_query_var('post_type');
		if($post_type)
			$post_type = $post_type;
		else
			$post_type = array('post','ozy_portfolio', 'product', 'product_variation'); // replace cpt to your custom post type
		
		$query->set('post_type',$post_type);

		return $query;
	}
}
add_filter('pre_get_posts', 'query_post_type');

//set post featured size image
if ( function_exists( 'set_post_thumbnail_size' ) ) {
	set_post_thumbnail_size( 260, 230, true ); // W x H, hard crop
}

//set content width
if ( ! isset( $content_width ) ) $content_width = 920;

/*feed link support for header*/
add_theme_support( 'automatic-feed-links' );

/*featured image support*/
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'ozy_portfolio', 'ozy_team', 'ozy_clients', 'product', 'product_variation') );

/*add image sizes*/
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'post-thumb', 1170, 9999, false ); // 1170 pixels wide (and unlimited height)
}

//Filter for google font list
function filter_google_font_list( $array, $field_id ) {
	/* only run the filter on select with a field ID of ic_google_font */
	if ( $field_id == 'ic_google_font' || $field_id == 'ic_skin_quote_font' ) {
		global $google_webfonts;
		$array = array();
		foreach ($google_webfonts as $web_font_name) {
			array_push($array, array("label"=>preg_replace('/:.*/','', $web_font_name), "value"=>$web_font_name));
		}  
	}

	return $array; 	
}
add_filter( 'ot_populated_select_items', 'filter_google_font_list', 10, 2 );

//Add google fonts into typography options where wanted
function filter_ot_recognized_font_families( $array, $field_id ) {
	/* only run the filter when the field ID is my_google_fonts_headings */
	$font_box_arr = array('ic_skin_menu_font', 'ic_skin_dropdown_font', 'ic_content_font', 'ic_h1_font', 'ic_h2_font', 'ic_h3_font', 'ic_h4_font', 'ic_h5_font', 'ic_h6_font', 'ic_skin_page_heading_big_title_font', 'ic_skin_page_heading_sub_title_font', 'ic_skin_page_heading_breadcrumbs_font', 'ic_skin_bottom_widget_bar_heading_font', 'ic_skin_bottom_widget_bar_content_font', 'ic_skin_bottom_widget_bar_link_font', 'ic_skin_highlighted_font', 'ic_skin_footer_text_font', 'ic_skin_footer_link_font', 'ic_skin_component_title_typography', 'ic_skin_component_content_font', 'ic_skin_component_link_font', 'ic_skin_button_font', 'ic_skin_text_splitter_font', 'ic_skin_quote_font', 'ic_skin_quote_link_font', 'ic_content_link_font', 'ic_skin_progress_bar_font', 'ic_skin_blog_title_font', 'ic_skin_blog_text_font', 'ic_skin_sidebar_heading_font', 'ic_skin_sidebar_content_font', 'ic_skin_sidebar_link_font', 'ic_skin_comment_font', 'ic_skin_comment_link_typography', 'ic_skin_portfolio_title_font', 'ic_skin_quote_button_font', 'ozy_generic_title_options_big_title_font', 'ozy_generic_title_options_sub_title_font', 'ozy_generic_title_options_sub_title_font', 'ozy_generic_title_options_breadcrumbs_font', 'ic_woo_title_typography', 'ic_woo_add_to_cart_typography', 'ic_woo_price_tag_typography', 'ic_woo_price_typography', 'ic_woo_top_bar_typography', 'ic_skin_header_menu_font', 'ic_skin_forms_text_options', 'ic_skin_text_logo_h1_typography', 'ic_skin_text_logo_h2_typography');
	if ( in_array($field_id, $font_box_arr) ) {
		$array = array(
			'arial'    => 'Arial',
			'georgia'     => 'Georgia',
			'helvetica'    => 'Helvetica',
			'palatino'    => 'Palatino',
			'tahoma'    => 'Tahoma',
			'times'    => '"Times New Roman", sans-serif',
			'trebuchet ms'    => 'Trebuchet MS',
			'verdana'    => 'Verdana',
			'-nothing-' => '------GOOGLE FONTS------'
		);
		
		if((int)ot_get_option("ic_skin_custom_font_is_enabled") != -1)
			$array["-customfont-"] = " ** Custom Font : " . ot_get_option("ic_skin_custom_font_name");
		
		global $google_webfonts;
		foreach ($google_webfonts as $web_font_name) 
		{
			$array[(preg_replace('/:.*/','', $web_font_name))] = $web_font_name;
		}
	}
	return $array;
}
add_filter( 'ot_recognized_font_families', 'filter_ot_recognized_font_families', 10, 2 );

//CSS loader
global $dynamic_css_content; $dynamic_css_content = NULL;
function option_loader() {
	global $post, $myhelper;
	wp_register_style('ozy-main', home_url('?ozy_action=main_css&amp;ver=' . OZY_THEME_VERSION . '&amp;ozy_post_id=' . $post->ID));
	wp_enqueue_style('ozy-main');
	
	ozy_dynamic_css_loader($post->ID, false);	
	$myhelper->render_google_fonts();
	//global $dynamic_css_content; $dynamic_css_content = NULL;
}

add_action( 'wp_print_styles', 'option_loader' );

function ozy_early_request_handler() {
	if (isset($_GET['ozy_action'])) {
		switch ($_GET['ozy_action']) {
			case 'main_css':
				header("Content-type: text/css");
				ozy_dynamic_css_loader((isset($_GET["ozy_post_id"]) ? $_GET["ozy_post_id"] : 0), true);
				exit;
		}
	}
}
add_action('init', 'ozy_early_request_handler', 0);

function ozy_dynamic_css_loader($_POST_ID, $echo = true) { //$_POST_ID, 

	global $dynamic_css_content;
	if($dynamic_css_content != NULL && $echo) {
		echo $dynamic_css_content;
		return $dynamic_css_content = NULL;
	}
	
	global $myhelper;
	
	ob_start();
	
	/***********************CUSTOM UPLOADED FONT**********************/
	if( ot_get_option("ic_skin_custom_font_is_enabled") === "1") 
	{
		$c = "";
		echo "\n@font-face{\n";
		echo "	font-family: '" . ot_get_option("ic_skin_custom_font_name")  . "';\n";
		echo "	src: ";
		if(ot_get_option("ic_skin_custom_font_eot") != "")
			echo "	url('" . ot_get_option("ic_skin_custom_font_eot") . "');\n";
		if(ot_get_option("ic_skin_custom_font_eot") != "")
			echo "	src: url('" . ot_get_option("ic_skin_custom_font_eot") . "?#iefix') format('embedded-opentype')\n"; $c=",";
		if(ot_get_option("ic_skin_custom_font_woff") != "")
			echo "	$c url('" . ot_get_option("ic_skin_custom_font_woff") . "') format('woff')\n"; $c=",";
		if(ot_get_option("ic_skin_custom_font_ttf") != "")
			echo "	$c url('" . ot_get_option("ic_skin_custom_font_ttf") . "') format('truetype')\n"; $c=",";
		if(ot_get_option("ic_skin_custom_font_svg") != "")
			echo "	$c url('" . ot_get_option("ic_skin_custom_font_svg") . "') format('svg')\n";			

		echo ";}\n";

	}
	/***********************CUSTOM UPLOADED FONT END**********************/

	/***********************TEXT LOGO START**********************/
	if(trim(ot_get_option('ic_logo_image')) == "") {
		echo $myhelper->arr_to_font_style("#logo>h1>a", ot_get_option("ic_skin_text_logo_h1_typography"));
		echo $myhelper->arr_to_font_style("#logo>h2", ot_get_option("ic_skin_text_logo_h2_typography"));
	}
	/***********************TEXT LOGO START**********************/

	/***********************HEADER START**********************/
	echo $myhelper->arr_to_background_style("#first-header", ot_get_option("ic_skin_header_bg"), false);
	echo "#header-top-menu > div { border-top-color: " . ot_get_option("ic_skin_header_border_color") . "; }\n";
	echo $myhelper->arr_to_font_style( "#top-small-menu>li,#top-small-menu>li>a", ot_get_option("ic_skin_header_menu_font", array()) , false );	
	/***********************HEADER END**********************/
	
	/***********************PRIMARY MENU START**********************/
	echo $myhelper->arr_to_font_style( ".select-menu>a, #top_menu>li>a", ot_get_option("ic_skin_menu_font", array()) , false, "" );//, array("line-height")
	
	echo ".select-menu li a { color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_dropdown_font", array()), "font-color") . "; font-family: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_dropdown_font", array()), "font-family") . "; }";
		
	echo ".select-menu li a:hover, .select-menu li.current_page_item>a, .select-menu li.active>a { color: " . ot_get_option("ic_skin_menu_active_hover_color") . "; }";	

	echo $myhelper->arr_to_background_style("#top_menu>li:hover, #top_menu>li.current_page_parent, #top_menu>li.current_page_ancestor", ot_get_option("ic_skin_menu_active_background"), false);
	echo "#top_menu>li:hover>a, #top_menu>li.current_page_parent>a, #top_menu>li.current_page_ancestor>a{ color:" . ot_get_option("ic_skin_menu_active_hover_color") . " ;}\n";
	
	echo $myhelper->arr_to_background_style("#menu-wrapper", ot_get_option("ic_skin_menu_background"), false);
	
	echo $myhelper->arr_to_font_style( "#top_menu>li>ul li>a", ot_get_option("ic_skin_dropdown_font", array()) , false );	
	echo "#top_menu>li>ul li:hover>a{ color:" . ot_get_option("ic_skin_menu_color") . " ;}\n";
	echo $myhelper->arr_to_background_style("#top_menu>li>ul li>a", ot_get_option("ic_skin_menu_dropdown_background"), false);
	echo $myhelper->arr_to_background_style("#top_menu>li>ul li:hover>a, #top_menu>li>ul li.current_page_item>a", ot_get_option("ic_skin_menu_dropdown_bg_color_active"), false);
	
	echo "#menu-wrapper #top_menu .menu-pipe { color :" . ot_get_option("ic_skin_menu_seperator_color") . " ;}\n";
	echo "#top_menu>li:hover>a, #top_menu>li.current_page_parent>a, #top_menu>li.current_page_ancestor>a, #top_menu>li ul, #top_menu>li.current_page_item>a { border-bottom:4px solid " . ot_get_option("ic_skin_menu_bottom_border_color") . "; }\n"; //dropdown menu bottom border
	
	echo "#menu-wrapper .container { min-height: " . (ot_get_option("ic_skin_menu_height")-4) . "px; }\n"; //height of the menu bar
	echo "#navbar-search-form input[type='text'] { min-height: " . ot_get_option("ic_skin_menu_height") . "px; }\n"; //height of the search bar
	echo "#menu-wrapper #top_menu>li, #menu-wrapper #top_menu>li>a, #menu-wrapper #top_menu .menu-pipe { line-height: " . (ot_get_option("ic_skin_menu_height")-4) . "px; }\n"; //height of the menu bar	
	/***********************PRIMARY MENU END**********************/

	/***********************BODY START**********************/
	$tmp_arr = $myhelper->read_meta_data ( get_post_meta($_POST_ID, 'ozy_generic_background_is_enabled') );
	//echo "*****************$tmp_arr********************";
	if(isset($tmp_arr[0])  && (int)$tmp_arr[0] == 1 ) {
		$bg_arr = get_post_meta($_POST_ID, 'ozy_generic_background_options');
		if( isset($bg_arr[0]) ) { 
			echo $myhelper->arr_to_background_style("body", $bg_arr[0], false);
		}
	}else{
		echo $myhelper->arr_to_background_style("body", ot_get_option("ic_page_background_template"), false);
	}
	
	echo $myhelper->arr_to_font_style( "#body-wrapper .ozy-page-content, .pp_description", ot_get_option("ic_content_font", array()) , false ); //pp_description belongs to pretty photo window
	echo $myhelper->arr_to_font_style( "#body-wrapper .ozy-page-content a", ot_get_option("ic_content_link_font", array()) , false );
	
	echo "#body-wrapper .ozy-page-content hr { background-color : " . ot_get_option("ic_skin_body_separator_color") . ";}\n";
	
	echo $myhelper->arr_to_font_style( "#body-wrapper h1", ot_get_option("ic_h1_font", array()) , false );
	echo $myhelper->arr_to_font_style( "#body-wrapper h2", ot_get_option("ic_h2_font", array()) , false );		
	echo $myhelper->arr_to_font_style( "#body-wrapper h3", ot_get_option("ic_h3_font", array()) , false );		
	echo $myhelper->arr_to_font_style( "#body-wrapper h4", ot_get_option("ic_h4_font", array()) , false );		
	echo $myhelper->arr_to_font_style( "#body-wrapper h5", ot_get_option("ic_h5_font", array()) , false );		
	echo $myhelper->arr_to_font_style( "#body-wrapper h6", ot_get_option("ic_h6_font", array()) , false );

	//check if clear the container option whether enabled or not
	$layout_model_tmp_arr = get_post_meta($_POST_ID, 'ozy_page_clear_container_bg');
	if( !isset($layout_model_tmp_arr[0]) || $layout_model_tmp_arr[0] != '1' ) {
		echo $myhelper->arr_to_background_style("#container-wrapper", ot_get_option("ic_skin_page_bg"), false, "", ot_get_option("ic_skin_page_bg_color_opacity") ); 
	}
	/***********************BODY END**********************/
	
	/***********************PAGE HEADING START**********************/
	$tmp_arr = $myhelper->read_meta_data ( get_post_meta($_POST_ID, 'ozy_page_title_is_enabled') );
	
	//if((isset($tmp_arr[0]) && $tmp_arr[0] !== -1)) {
	if((isset($tmp_arr[0]) && (int)$tmp_arr[0] !== -1) || !$tmp_arr) {		

		//are we going to use custom header options?
		$tmp_arr = $myhelper->read_meta_data ( get_post_meta($_POST_ID, 'ozy_generic_title_options_is_enabled') );
		
		//echo "**********************************";
		if(isset($tmp_arr[0])  && (int)$tmp_arr[0] == 1  ) { //&& get_post_type( $post->ID ) === 'page'	

			$tmp_arr = get_post_meta($_POST_ID, 'ozy_generic_title_options_big_title_font');
			if( isset($tmp_arr[0]) && !$myhelper->is_font_typography_empty($tmp_arr[0]) ) {
				echo $myhelper->arr_to_font_style( "#page-heading h1", $tmp_arr[0] , false, "!important" );
			}else{ //or use generic
				echo $myhelper->arr_to_font_style( "#page-heading h1", ot_get_option("ic_skin_page_heading_big_title_font", array()) , false, "!important" );
			}

			$tmp_arr = get_post_meta($_POST_ID, 'ozy_generic_title_options_sub_title_font');
			if( isset($tmp_arr[0]) && !$myhelper->is_font_typography_empty($tmp_arr[0]) ) {
				echo $myhelper->arr_to_font_style( "#page-heading h2", $tmp_arr[0] , false, "!important" );
			}else{ //or use generic
				echo $myhelper->arr_to_font_style( "#page-heading h2", ot_get_option("ic_skin_page_heading_sub_title_font", array()) , false, "!important" );			
			}

			$tmp_arr = get_post_meta($_POST_ID, 'ozy_generic_title_options_breadcrumbs_font');
			if( isset($tmp_arr[0]) && !$myhelper->is_font_typography_empty($tmp_arr[0]) ) {
				echo $myhelper->arr_to_font_style( "#page-heading #bread-crumbs-menu *", $tmp_arr[0] , false, "!important" );
			}else{ //or use generic
				echo $myhelper->arr_to_font_style( "#page-heading #bread-crumbs-menu *", ot_get_option("ic_skin_page_heading_breadcrumbs_font", array()) , false );
			}

			$tmp_arr = get_post_meta($_POST_ID, 'ozy_generic_title_options_background');
			if( isset($tmp_arr[0]) )
				echo $myhelper->arr_to_background_style("#page-heading", $tmp_arr[0], false);
			
			$use_margin = get_post_meta($_POST_ID, 'ozy_generic_title_options_margin');
			if(isset($use_margin[0]))
				echo "#page-heading { padding: " . $use_margin[0] . "px 0 " . $use_margin[0] . "px 0 !important; }\n";
			
			//title positioning & coloring
			$tmp_arr = get_post_meta($_POST_ID, 'ozy_generic_title_options_background');
			$use_padding = get_post_meta($_POST_ID, 'ozy_generic_title_options_use_padding');
			if(isset($tmp_arr[0]) && ($tmp_arr[0]["background-color"] != "" || $tmp_arr[0]["background-image"] != "")) {
				if(isset($use_padding[0]) && $use_padding[0] === "yes") {
					$title_margin = "margin-left:20px;";
					echo "#page-heading #bread-crumbs-menu>div { padding:10px 20px 0 0; }\n"; //padding:10px 10px 0 0;
				}else{
					$title_margin = "";
					echo "#page-heading { margin-bottom: 0 !important; }\n";			
				}
				
				$tmp_arr = get_post_meta($_POST_ID, 'ozy_generic_title_options_big_title_background');
				if( isset($tmp_arr[0]) )
					echo "#page-heading h1 { background-color: " . $tmp_arr[0] . "; padding:5px 10px 5px 10px; $title_margin display: inline-block; }\n";

				$tmp_arr = get_post_meta($_POST_ID, 'ozy_generic_title_options_sub_title_background');
				if( isset($tmp_arr[0]) )
					echo "#page-heading h2 { background-color: " . $tmp_arr[0] . "; padding:5px 10px 5px 10px; $title_margin display: table; }\n";
				
			} else {
				if(isset($use_padding[0]) && $use_padding[0] === "yes") {
					echo "#page-heading h1, #page-heading h2 { padding:0 0 10px 10px; }\n";
					echo "#page-heading #bread-crumbs-menu>div { padding:10px 20px 0 0; }\n"; //padding:10px 10px 0 0;
				}else{
					echo "#page-heading { margin-bottom:0 !important; }\n";		
				}
			}
		//generic options from theme options
		} else {

			echo $myhelper->arr_to_font_style( "#page-heading h1", ot_get_option("ic_skin_page_heading_big_title_font", array()) , false, "!important" );
			echo $myhelper->arr_to_font_style( "#page-heading h2", ot_get_option("ic_skin_page_heading_sub_title_font", array()) , false, "!important" );
			echo $myhelper->arr_to_font_style( "#page-heading #bread-crumbs-menu *", ot_get_option("ic_skin_page_heading_breadcrumbs_font", array()) , false );
	
			echo $myhelper->arr_to_background_style("#page-heading", ot_get_option("ic_skin_page_heading_background"), false);
			
			echo "#page-heading { padding: " . ot_get_option("ic_skin_page_heading_margin") . "px 0 " . ot_get_option("ic_skin_page_heading_margin") . "px 0 !important; }\n";
			
			//title positioning & coloring			
			if(ot_get_option("ic_skin_page_heading_big_title_background")) {
				
				if(ot_get_option("ic_skin_page_heading_use_padding") === "yes") {
					$title_margin = "margin-left:20px;";
					echo "#page-heading #bread-crumbs-menu>div { padding:10px 20px 0 0; }\n"; //padding:10px 10px 0 0;
				}else{
					$title_margin = "";
					echo "#page-heading { margin-bottom: 0 !important; }\n";			
				}
				
				echo "#page-heading h1 { background-color: " . ot_get_option("ic_skin_page_heading_big_title_background") . "; padding:5px 10px 5px 10px; $title_margin display: inline-block; }\n";
				
				if(ot_get_option("ic_skin_page_heading_sub_title_color"))
					echo "#page-heading h2 { background-color: " . ot_get_option("ic_skin_page_heading_sub_title_color") . "; padding:5px 10px 5px 10px; $title_margin display: table; }\n";
				
			} else {
				if(ot_get_option("ic_skin_page_heading_use_padding") === "yes") {
					echo "#page-heading h1, #page-heading h2 { padding:0 0 10px 10px; }\n";
					echo "#page-heading #bread-crumbs-menu>div { padding:10px 20px 0 0; }\n"; //padding:10px 10px 0 0;
				}else{
					echo "#page-heading { margin-bottom:0 !important; }\n";		
				}
			}			
		}		
	}
	/***********************PAGE HEADING END**********************/
	
	/***********************BOOTSTRAP**********************/
	echo ".table-striped tbody > tr:nth-child(odd) > td, .table-striped tbody > tr:nth-child(odd) > th { background-color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_component_alternative_background"), "background-color") . "; }\n";
	echo ".table th, .table td, .table tbody + tbody, .table-bordered, .table-bordered th, .table-bordered td  { border-color: " . ot_get_option("ic_skin_body_separator_color") . "; }\n";
	/***********************BOOTSTRAP END**********************/
	
	/***********************BOTTOM WIDGET BAR START**********************/
	if(ot_get_option("ic_skin_bottom_widget_bar_enabled") === "yes") {
		echo "#bottom-widget-wrapper { border-top:" . ot_get_option("ic_sking_bottom_widget_bar_border_size") . "px solid " . ot_get_option("ic_sking_bottom_widget_bar_border_color") . "; border-bottom:" . ot_get_option("ic_sking_bottom_widget_bar_border_size") . "px solid " . ot_get_option("ic_sking_bottom_widget_bar_border_color") . "; }";
		echo $myhelper->arr_to_background_style("#bottom-widget-wrapper", ot_get_option("ic_sking_bottom_widget_bar_background"), false);
		echo $myhelper->arr_to_font_style( "#bottom-widget-wrapper section>.h6-wrapper>h6", ot_get_option("ic_skin_bottom_widget_bar_heading_font", array()) , false );
		echo $myhelper->arr_to_font_style( "#bottom-widget-wrapper section", ot_get_option("ic_skin_bottom_widget_bar_content_font", array()) , false );
		echo $myhelper->arr_to_font_style( "#bottom-widget-wrapper section a", ot_get_option("ic_skin_bottom_widget_bar_link_font", array()) , false, "!important" );
		echo "#bottom-widget-wrapper section>.h6-wrapper>h6 { background-color: " . ot_get_option("ic_sking_bottom_widget_bar_border_color") . " ; }\n";
	}
	/***********************BOTTOM WIDGET BAR END**********************/
	
	/***********************FOOTER BAR**********************/
	echo $myhelper->arr_to_background_style("#footer-wrapper", ot_get_option("ic_skin_footer_bg"), false);
	echo $myhelper->arr_to_font_style( "#footer-wrapper section", ot_get_option("ic_skin_footer_text_font", array()) , false );
	echo $myhelper->arr_to_font_style( "#footer-wrapper section a", ot_get_option("ic_skin_footer_link_font", array()) , false );
	/***********************FOOTER BAR END**********************/
	
	/***********************HIGHLIGHTED**********************/
	echo ".iosSlider-container .selectorsBlock .selectors .selected, #tiptip_content { background-color : " .  ot_get_option("ic_skin_highlighted_bg") . " !important; }\n";
	echo "#tiptip_holder.tip_top #tiptip_arrow_inner  { border-top-color : " .  ot_get_option("ic_skin_highlighted_bg") . " !important; }\n";
	echo "#tiptip_holder.tip_bottom #tiptip_arrow_inner { border-bottom-color : " .  ot_get_option("ic_skin_highlighted_bg") . " !important; }\n";		
	echo $myhelper->arr_to_font_style( "#tiptip_content", ot_get_option("ic_skin_highlighted_font", array()) , false );
	
	echo ".wpb_call_to_action { border-left : 4px solid " .  ot_get_option("ic_skin_highlighted_bg") . " !important; }\n";	
	/***********************HIGHLIGHTED END**********************/
	
	/***********************AUTOCOMPLETE SEARCH LIST**********************/
	echo $myhelper->arr_to_background_style(".ac_results", ot_get_option("ic_skin_component_background"), false, "", "", "", "!important");
	echo $myhelper->arr_to_font_style( ".ac_results ul li", ot_get_option("ic_skin_component_link_font", array()) , false, "", array("line-height") );	
	/***********************AUTOCOMPLETE SEARCH LIST END**********************/	
	
	/***********************COMPONENTS**********************/	
	echo $myhelper->arr_to_font_style( ".teaser_grid_container h2.post-title a.link_title", ot_get_option("ic_h2_font", array()) , false, "!important" ); /*keep teaser grid title style with page*/
	
	echo $myhelper->arr_to_font_style( ".ui-tabs-nav li a, .ui-accordion-header a", ot_get_option("ic_skin_component_title_typography", array()) , false, "!important" );
	echo ".ui-tabs-nav li:hover a, .ui-tabs-nav li.ui-tabs-active a, .ui-accordion-header:hover a, .ui-accordion-header-active a { color : ". ot_get_option("ic_skin_component_title_hover_color") . " !important ;}\n";
	echo $myhelper->arr_to_background_style(".ui-tabs-nav li, .ui-accordion-header", ot_get_option("ic_skin_component_background"), false, "", "", "", "!important");
	
	echo $myhelper->arr_to_background_style(".ozy-testimonial-slider li .entry-content, .wpb_tab, .ui-accordion-content, .ui-tabs .ui-tabs-nav li.ui-tabs-active", ot_get_option("ic_skin_component_alternative_background"), false, "", "", "", "!important");
	echo $myhelper->arr_to_font_style( ".wpb_tab .wpb_content_element *, .ozy-testimonial-slider li .entry-content p, .ozy-testimonial-slider li .entry-content p *, .wpb_tab p *, .ui-accordion-content *, .wpb_call_to_action h2", ot_get_option("ic_skin_component_content_font", array()) , false, "!important" );
	echo $myhelper->arr_to_font_style( ".ozy-testimonial-slider li .entry-content a, .wpb_tab a, .ui-accordion-content a", ot_get_option("ic_skin_component_link_font", array()) , false, "!important" );
	
	//we need same background color for the arrow of speech bubble with alternative component backgrorund color
	$compoenent_alternative_background_color = ot_get_option("ic_skin_component_alternative_background");
	if(isset($compoenent_alternative_background_color["background-color"]) && $compoenent_alternative_background_color["background-color"] != "")
		echo ".ozy-testimonial-slider li .entry-content:after { border-top-color: ". $compoenent_alternative_background_color["background-color"] ."; }\n";
	
	echo $myhelper->arr_to_background_style(".wpb_call_to_action, blockquote, q", ot_get_option("ic_skin_quote_background"), false, "", "", "", "!important");	
	echo $myhelper->arr_to_font_style( ".wpb_call_to_action h2, blockquote, q", ot_get_option("ic_skin_quote_font", array()) , false, "!important" );
	echo $myhelper->arr_to_font_style( ".wpb_call_to_action a, blockquote a, q a", ot_get_option("ic_skin_quote_link_font", array()) , false, "!important" );

	/*layer slider*/
	$add_on_css = ""; $add_on_css_hover = "";
	if($myhelper->ozy_is_plugin_active("LayerSlider/layerslider.php")) {
		$add_on_css 		= ".ls-nav-prev, .ls-nav-next,";
		$add_on_css_hover 	= ".ls-nav-prev:hover, .ls-nav-next:hover,";
	}
	
	/*revolution slider*/
	if($myhelper->ozy_is_plugin_active("revslider/revslider.php")) {
		$add_on_css 		.= ".rev_slider_wrapper .tp-leftarrow, .rev_slider_wrapper .tp-rightarrow,";
		$add_on_css_hover 	.= ".rev_slider_wrapper .tp-leftarrow:hover, .rev_slider_wrapper .tp-rightarrow:hover,";
	}
	
	/*revolution slider*/
	if($myhelper->ozy_is_plugin_active("CuteSlider/cuteslider.php")) {
		$add_on_css 		.= ".br-next, .br-previous,";
		$add_on_css_hover 	.= ".br-next:hover, .br-previous:hover,";
	}
	
	/*slider & carousel navigation arrows*/
	echo $myhelper->arr_to_background_style($add_on_css . ".view_project_link_button, #post-navigation a, .iosSlider-container .prevContainer .ios-prev,.iosSlider-container .nextContainer .ios-next,.nivo-nextNav,.nivo-prevNav,.social-share-buttons-wrapper li span, .flex-direction-nav .flex-next, .flex-direction-nav .flex-prev, .wpb_carousel .prev, .wpb_carousel .next", ot_get_option("ic_skin_button_background"), false, "", "", "", "!important");
	echo $myhelper->arr_to_background_style($add_on_css_hover . ".view_project_link_button:hover, #post-navigation a:hover, .iosSlider-container .prevContainer .ios-prev:hover,.iosSlider-container .nextContainer .ios-next:hover,.nivo-nextNav:hover,.nivo-prevNav:hover,.social-share-buttons-wrapper li:hover span, .flex-direction-nav .flex-next:hover, .flex-direction-nav .flex-prev:hover, .wpb_carousel .prev:hover, .wpb_carousel .next:hover", ot_get_option("ic_skin_button_hover_background"), false, "", "", "", "!important");
	
	/*buttons*/
	echo $myhelper->arr_to_background_style("#backToTop, .sidebar-widget .tagcloud a, .paging-wrapper>a,#commentform #submit, .ozy-page-content input[type=button],.ozy-page-content input[type=submit],.ozy-page-content input[type=reset],.ozy-page-content button:not(.wpb_button), .wpb_carousel .prev, .wpb_carousel .next, .wpb_button.wpb_ozy_auto", ot_get_option("ic_skin_button_background"), false, "", "", "", "");
	echo $myhelper->arr_to_background_style("#backToTop:hover, .sidebar-widget .tagcloud a:hover, .paging-wrapper>a:hover,.paging-wrapper>a.current,#commentform #submit:hover, .ozy-page-content  input[type=button]:hover,.ozy-page-content  input[type=submit]:hover,.ozy-page-content input[type=reset]:hover,.ozy-page-content button:not(.wpb_button):hover, .wpb_carousel .prev:hover, .wpb_carousel .next:hover, .wpb_button.wpb_ozy_auto:hover", ot_get_option("ic_skin_button_hover_background"), false, "", "", "", "");
	echo $myhelper->arr_to_font_style("#commentform #submit,.ozy-page-content input[type=button],.ozy-page-content input[type=submit],.ozy-page-content input[type=reset],.ozy-page-content button:not(.wpb_button), .sidebar-widget .tagcloud a, .wpb_carousel .prev, .wpb_carousel .next, .wpb_carousel .prev, .wpb_button.wpb_ozy_auto, .shortcode-btn.wpb_button_a span", ot_get_option("ic_skin_button_font", array()) , false, "!important");
	
	/*social icons font settings*/	
	echo $myhelper->arr_to_font_style(".social-share-buttons-wrapper li span", ot_get_option("ic_skin_button_font", array()) , false, "", array("font-size", "line-height", "font-family", "text-decoration"));
	
	echo $myhelper->arr_to_font_style(".wpb_call_to_action .wpb_button_a .wpb_button.wpb_ozy_auto", ot_get_option("ic_skin_quote_button_font", array()) , false, "!important");	

	/*custom for portfolio details page*/
	if(get_post_type( $_POST_ID ) == 'ozy_portfolio')
		echo $myhelper->arr_to_font_style(".view_project_link_button", ot_get_option("ic_skin_button_font", array()) , false, "!important", array("font-family", "font-size", "line-height", "text-decoration"));
	
	echo $myhelper->arr_to_font_style(".paging-wrapper>a", ot_get_option("ic_skin_button_font", array()) , false, "!important", array("line-height"));		
	
	echo $myhelper->arr_to_background_style(".title-with-icon>span, .title-with-icon>a>span, .dropcap-rectangle, .dropcap-rounded", ot_get_option("ic_skin_button_background"), false, "", 50, "", "");	
	echo $myhelper->arr_to_background_style(".title-with-icon-wrapper:hover>.title-with-icon>span, .title-with-icon-wrapper:hover>.title-with-icon>a>span", ot_get_option("ic_skin_button_hover_background"), false, "", 50, "", "");	
	echo ".title-with-icon:hover>span, .title-with-icon>span, .title-with-icon:hover>a>span, .title-with-icon>a>span { color : " . $myhelper->get_value_from_array(ot_get_option("ic_skin_button_font"), "font-color") . " !important; }\n";

	/*table & definition list*/
	echo "#body-wrapper table td, #body-wrapper dl { border-color: " . ot_get_option("ic_skin_body_separator_color") . " !important; }\r\n";

	/*separator*/
	echo "fieldset.ozy-content-divider { border-top:1px solid " . ot_get_option("ic_skin_text_splitter_border") . " !important; }\n";
	echo ".ozy-border-wrapper,.ozy-border-box>div .wpb_wrapper { border: 1px solid " . ot_get_option("ic_skin_text_splitter_border") . " !important; padding: 20px; }";
	echo $myhelper->arr_to_font_style( "fieldset.ozy-content-divider legend", ot_get_option("ic_skin_text_splitter_font", array()) , false, "!important" );	
	
	echo ".wpb_separator, .vc_text_separator { border-bottom-color: " . ot_get_option("ic_skin_text_splitter_border") . " !important; }\n";
	echo $myhelper->arr_to_font_style( ".vc_text_separator div", ot_get_option("ic_skin_text_splitter_font", array()) , false, "!important" );	
	
	echo $myhelper->arr_to_background_style(".progress-bar>div", ot_get_option("ic_skin_progress_bar_top_background"), false, "", "", "", "!important");
	echo $myhelper->arr_to_background_style(".progress-bar", ot_get_option("ic_skin_progress_bar_bottom_background"), false, "", "", "", "!important");
	echo $myhelper->arr_to_font_style( ".progress-bar>div", ot_get_option("ic_skin_progress_bar_font", array()) , false, "!important" );	
	
	echo ".wpb_twitter_widget.big-tweet a { color: ".ot_get_option("ic_skin_default_alternative_link_color")." !important; }\n";
	
	echo ".title-with-icon span, .dropcap-rectangle { border-bottom : 1px solid " .  ot_get_option("ic_skin_highlighted_bg") . " !important; }\n";
	
	/*pricing table*/
	if($myhelper->ozy_is_plugin_active("pricetable/pricetable.php")) {	
		echo ".pricing-table .pricing-table-column+.pricetable-featured .pricing-price { color:" . ot_get_option("ic_skin_highlighted_bg") . " !important; }\n";
		
		echo ".pricing-table li,.pricing-table .pricing-table-column:first-child, .pricing-table .pricing-table-column { border-color: " . ot_get_option("ic_skin_body_separator_color") . " !important;}\n";
		
		echo ".pricing-table .pricing-table-column+.pricetable-featured, .pricing-table .pricing-table-column.pricetable-featured:first-child { border:4px solid " . ot_get_option("ic_skin_highlighted_bg") . " !important; }\n";
	}
	/***********************COMPONENTS END**********************/
	
	/***********************FORMS**********************/
	$form_extra_css = "form input[type=number],form input[type=text], form input[type=password], form input[type=file], form input[type=color],form input[type=date],form input[type=datetime],form input[type=datetime-local],form input[type=email],form input[type=month],form input[type=number],form input[type=range],form input[type=search],form input[type=tel],form input[type=time],form input[type=url],form input[type=week], form select, form textarea,"; $form_extra_css_background = "form input[type=number],form input[type=text], form input[type=password], form input[type=file], form select, form textarea,"; $form_extra_css_focus = "form input[type=number]:focus,form input[type=text]:focus, form input[type=password]:focus, form input[type=file]:focus,form input[type=color]:focus,form input[type=date],form input[type=datetime]:focus,form input[type=datetime-local]:focus,form input[type=email]:focus,form input[type=month]:focus,form input[type=number]:focus,form input[type=range]:focus,form input[type=search]:focus,form input[type=tel]:focus,form input[type=time]:focus,form input[type=url]:focus,form input[type=week]:focus, form select:focus, form textarea:focus,";
	$form_button_bg = array(); $form_button_bg_hover = array();
	
	//is contact-form-7 plugin installed?
	if($myhelper->ozy_is_plugin_active("contact-form-7/wp-contact-form-7.php")) {
		$form_extra_css 			.= ".wpcf7-form input[type=text],.wpcf7-form input[type=color],.wpcf7-form input[type=date],.wpcf7-form input[type=datetime],.wpcf7-form input[type=datetime-local],.wpcf7-form input[type=email],.wpcf7-form input[type=month],.wpcf7-form input[type=number],.wpcf7-form input[type=range],.wpcf7-form input[type=search],.wpcf7-form input[type=tel],.wpcf7-form input[type=time],.wpcf7-form input[type=url],.wpcf7-form input[type=week], .wpcf7-form select, .wpcf7-form textarea, ";
		$form_extra_css_background	.= ".wpcf7-form input[type=text],.wpcf7-form input[type=color],.wpcf7-form input[type=date],.wpcf7-form input[type=datetime],.wpcf7-form input[type=datetime-local],.wpcf7-form input[type=email],.wpcf7-form input[type=month],.wpcf7-form input[type=number],.wpcf7-form input[type=range],.wpcf7-form input[type=search],.wpcf7-form input[type=tel],.wpcf7-form input[type=time],.wpcf7-form input[type=url],.wpcf7-form input[type=week], .wpcf7-form select, .wpcf7-form textarea, ";
		$form_extra_css_focus		.= ".wpcf7-form input[type=text]:focus,.wpcf7-form input[type=color]:focus,.wpcf7-form input[type=date]:focus,.wpcf7-form input[type=datetime]:focus,.wpcf7-form input[type=datetime-local]:focus,.wpcf7-form input[type=email]:focus,.wpcf7-form input[type=month]:focus,.wpcf7-form input[type=number]:focus,.wpcf7-form input[type=range]:focus,.wpcf7-form input[type=search]:focus,.wpcf7-form input[type=tel]:focus,.wpcf7-form input[type=time]:focus,.wpcf7-form input[type=url]:focus,.wpcf7-form input[type=week], .wpcf7-form select:focus,	.wpcf7-form textarea:focus, ";
		array_push($form_button_bg, ".wpcf7-submit");
		array_push($form_button_bg_hover, ".wpcf7-submit:hover");
	}

	//is mailchimp plugin installed?
	if($myhelper->ozy_is_plugin_active("mailchimp/mailchimp.php")) {
		$form_extra_css 			.= "#mc_signup_form input[type=text], #mc_signup_form select, #mc_signup_form textarea, ";
		$form_extra_css_background	.= "#mc_signup_form input[type=text], #mc_signup_form select, #mc_signup_form textarea, ";
		$form_extra_css_focus		.= "#mc_signup_form input[type=text]:focus, #mc_signup_form select:focus,	#mc_signup_form textarea:focus, ";			
		array_push($form_button_bg, "#mc_signup_submit");
		array_push($form_button_bg_hover, "#mc_signup_submit:hover");
	}
	
	$form_button_bg 		= join(",", $form_button_bg);
	$form_button_bg_hover 	= join(",", $form_button_bg_hover);
	
	if($form_button_bg != "")
		echo $myhelper->arr_to_background_style($form_button_bg, ot_get_option("ic_skin_button_background"), false, "", "", "", "");
	
	if($form_button_bg_hover != "")
		echo $myhelper->arr_to_background_style($form_button_bg_hover, ot_get_option("ic_skin_button_hover_background"), false, "", "", "", "");

	if($form_button_bg != "")
		echo $myhelper->arr_to_font_style($form_button_bg, ot_get_option("ic_skin_button_font", array()) , false, "!important");		
	
	echo $myhelper->arr_to_font_style($form_extra_css . ".sidebar-widget input[type=text], .sidebar-widget input[type=password], .sidebar-widget select, .sidebar-widget textarea, #commentform input[type=text], #commentform textarea", ot_get_option("ic_skin_forms_text_options", array()) , false, "!important" );
	
	echo $myhelper->arr_to_background_style($form_extra_css_background . ".sidebar-widget input[type=text], .sidebar-widget input[type=password], .sidebar-widget select, .sidebar-widget textarea, #commentform input[type=text], #commentform textarea", ot_get_option("ic_skin_forms_background"), false, "", "", "", "!important");		
	
	if(ot_get_option("ic_skin_forms_border_color") != '') :
		echo $form_extra_css_focus . ".sidebar-widget input[type=text]:focus, .sidebar-widget input[type=password]:focus, .sidebar-widget select:focus, 			.sidebar-widget textarea:focus, #commentform input[type=text]:focus, #commentform textarea:focus { border:1px solid " . ot_get_option("ic_skin_forms_border_color") . " !important ; box-shadow:0 0 10px " . ot_get_option("ic_skin_forms_border_color") . " !important;}\n";
		
		echo $form_extra_css . ".sidebar-widget input[type=text], .sidebar-widget input[type=password], .sidebar-widget select, .sidebar-widget textarea, #commentform input[type=text], #commentform textarea { border:1px solid " . ot_get_option("ic_skin_forms_border_color") . " !important ; }\n";			
	endif;
	/***********************FORMS END**********************/
	
	/***********************BLOG**********************/
	echo ".highlight-bg { background-color: " . ot_get_option("ic_skin_highlighted_bg") . "; }\n";
	echo ".blog-post-title:first-letter, .portfolio-listing .info-box h4:first-letter { border-bottom: 1px solid " . ot_get_option("ic_skin_highlighted_bg") . "; padding-bottom:5px; }\n";
	
	echo $myhelper->arr_to_background_style(".generic-button, .generic-button-alt:hover", ot_get_option("ic_skin_button_background"), false, "", "", "", "");
	echo $myhelper->arr_to_background_style(".generic-button:hover, .generic-button-alt", ot_get_option("ic_skin_button_hover_background"), false, "", "", "", "");
	echo $myhelper->arr_to_font_style(".generic-button, .generic-button-alt *", ot_get_option("ic_skin_button_font", array()) , false, "");
	
	echo $myhelper->arr_to_background_style(".classic-blog-listing-item", ot_get_option("ic_skin_blog_section_background"), false, "", ot_get_option("ic_skin_blog_section_background_opacity"), "", "");
	//echo $myhelper->arr_to_font_style(".blog-details-part .blog-post-title, .blog-details-part .blog-post-title a", ot_get_option("ic_skin_blog_title_font", array()) , false, "!important");
	echo $myhelper->arr_to_font_style(".blog-details-part .blog-post-title, .blog-details-part .blog-post-title a", ot_get_option("ic_skin_blog_title_font", array()) , false, "!important", array(), array(), 12);
	echo ".blog-details-part .blog-post-title a:hover { color: " . ot_get_option("ic_skin_default_alternative_link_color") . " !important; }\n";
	echo $myhelper->arr_to_font_style(".blog-details-part", ot_get_option("ic_skin_blog_text_font", array()) , false);

	echo ".blog-info-bar-details .label, .blog-info-footer-bar span { color: " . ot_get_option("ic_skin_blog_label_color") . "; }\n";
	/***********************BLOG END**********************/

	/***********************BLOG COMMENTS**********************/	
	echo $myhelper->arr_to_background_style(".author-box,.comment-body", ot_get_option("ic_skin_comment_background"), false, "", ot_get_option("ic_skin_comment_background_opacity"), "", "");
	echo $myhelper->arr_to_font_style(".author-box,.comment-body", ot_get_option("ic_skin_comment_font", array()) , false, "!important");
	echo $myhelper->arr_to_font_style(".author-box a,.comment-body a,.comment .reply .icon-comment", ot_get_option("ic_skin_comment_link_typography", array()) , false, "!important");
	/***********************BLOG COMMENTS END**********************/
	
	/***********************PORTFOLIO**********************/
	echo $myhelper->arr_to_font_style(".post-portfolio-title .post-title, .post-portfolio-title .post-title a", ot_get_option("ic_skin_portfolio_title_font", array()) , false, "!important");
	echo ".post-portfolio-icons .icon-plus, .post-portfolio-icons .icon-search, .grid_layout-portfolio li:hover .post-portfolio-title .category-label { background-color:".ot_get_option("ic_skin_portfolio_link_button_background")." !important; color:".ot_get_option("ic_skin_portfolio_link_button_color")." !important; }\n";
	echo ".post-portfolio-title .category-label { color:".ot_get_option("ic_skin_portfolio_link_button_color")." !important; }\n";	
	
	echo ".categories_filter { border-bottom : 1px solid " . ot_get_option("ic_skin_body_separator_color") . " ; border-top : 1px solid ".ot_get_option("ic_skin_body_separator_color")." ;}";
	
	echo ".categories_filter li:not(.active) a { color:" . ot_get_option("ic_skin_default_alternative_link_color") . " !important;}\n";
	
	echo ".grid_layout-portfolio-classic .post-portfolio-title { background-color: " . ot_get_option("ic_skin_portfolio_category_label_background") . " ; }\n";
	/***********************PORTFOLIO END**********************/
	
	/***********************SIDEBAR**********************/
	echo $myhelper->arr_to_font_style(".sidebar-generic .sidebar-widget", ot_get_option("ic_skin_sidebar_content_font", array()) , false, "");//!important
	echo $myhelper->arr_to_font_style(".sidebar-generic .sidebar-widget a", ot_get_option("ic_skin_sidebar_link_font", array()) , false, "");//!important
	echo $myhelper->arr_to_font_style(".sidebar-generic .sidebar-widget h6", ot_get_option("ic_skin_sidebar_heading_font", array()) , false, "!important");
	echo $myhelper->arr_to_background_style(".sidebar-generic .sidebar-widget", ot_get_option("ic_skin_sidebar_background"), false, "", ot_get_option("ic_skin_sidebar_opacity"), "", "");
	echo ".sidebar-generic .sidebar-widget h6 { border-bottom: 1px solid " . ot_get_option("ic_skin_sidebar_separator_color") . " ; }\n";
	echo "section.sidebar-widget ul.menu>li, section.sidebar-widget ul.menu>li:last-child { border-color: " . ot_get_option("ic_skin_sidebar_separator_color") . " !important; }\n";
	/***********************SIDEBAR END**********************/

	//Text Highlight Color
	echo "::-moz-selection { background: " . ot_get_option("ic_skin_highlighted_bg") . "; color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_highlighted_font"), "font-color") . "; text-shadow: none; }\n";
	echo "::selection { background: " . ot_get_option("ic_skin_highlighted_bg") . "; color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_highlighted_font"), "font-color") . "; text-shadow: none; }\n";

	/*search box*/
	echo $myhelper->arr_to_font_style( "#navbar-search-wrapper span", ot_get_option("ic_skin_dropdown_font", array()) , false, "", array("font-size", "font-style", "font-variant", "font-weight", "letter-spacing", "font-family", "text-decoration", "text-transform", "line-height"), array( "line-height"=> ot_get_option("ic_skin_menu_height") . "px") );
	echo "#navbar-search-form input.open[type=text] { background-color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_menu_dropdown_bg_color_active"), "background-color") . " !important; }\n";
	
	echo $myhelper->arr_to_font_style( "#navbar-search-form input.open[type=text]", ot_get_option("ic_skin_menu_font", array()) , false, "!important", array("line-height", "font-size", "font-family"), array( "background-color"=> ot_get_option("ic_skin_header_search_box_open_background")));

	/***********************WOOCOMMERCE**********************/
	global $OZY_WOOCOMMERCE_ENABLED;
	if($OZY_WOOCOMMERCE_ENABLED) {
		/*buttons*/
		echo $myhelper->arr_to_background_style(".product-quantity .quantity input[type=button], div.woocommerce .button, #woocommerce-top-bar .woocommerce-shopping-cart-button:hover, .woocommerce-pagination>ul>li>a, .product form button, .product form input[type=button]", ot_get_option("ic_skin_button_background"), false, "", "", "", "");
		echo $myhelper->arr_to_background_style(".product-quantity .quantity input[type=button]:hover, div.woocommerce .button:hover, #woocommerce-top-bar .woocommerce-shopping-cart-button, .woocommerce-pagination>ul>li>a:hover, .woocommerce-pagination>ul>li>span.current, .product form button:hover, .product form input:hover[type=button]", ot_get_option("ic_skin_button_hover_background"), false, "", "", "", "");
		echo $myhelper->arr_to_font_style(".product-quantity .quantity input[type=button], div.woocommerce .button, #woocommerce-top-bar .woocommerce-shopping-cart-button, .product form button, .product form input[type=button]", ot_get_option("ic_skin_button_font", array()) , false, "");
		echo $myhelper->arr_to_font_style(".woocommerce-pagination>ul>li>a, .woocommerce-pagination>ul>li>span.current", ot_get_option("ic_skin_button_font", array()) , false, "!important", array("line-height"));
				
		/*breadcrumbs*/
		echo $myhelper->arr_to_font_style( ".woocommerce-breadcrumb, .woocommerce-breadcrumb *", ot_get_option("ic_skin_page_heading_breadcrumbs_font", array()) , false );
		
		/*border colors*/
		echo ".product>.images>.thumbnails img { border-color:" . ot_get_option("ic_skin_body_separator_color") . "; }\r\n";
		
		/*tabs*/
		echo $myhelper->arr_to_font_style( ".woocommerce-tabs ul li a", ot_get_option("ic_skin_component_title_typography", array()) , false, "!important" );
		echo ".woocommerce-tabs ul li:hover a, .woocommerce-tabs ul li.active:hover a, .woocommerce-tabs ul li.active a { color : ". ot_get_option("ic_skin_component_title_hover_color") . " !important ;}\n";
		echo $myhelper->arr_to_background_style(".woocommerce-tabs>ul>li", ot_get_option("ic_skin_component_background"), false, "", "", "", "!important");
		
		echo $myhelper->arr_to_background_style(".woocommerce-tabs .panel, .woocommerce-tabs ul li:hover, .woocommerce-tabs ul li.active", ot_get_option("ic_skin_component_alternative_background"), false, "", "", "", "!important");
		
		/*comments*/
		echo ".product .woocommerce-tabs #comments ol.commentlist li { border-bottom: 1px solid " . ot_get_option("ic_skin_body_separator_color") . ";}\r\n";
		
		/*stars*/
		if(trim(ot_get_option('ic_woo_star_color')))
			echo "ul.products .star-rating>span { color: " . ot_get_option("ic_woo_star_color") . "; }\r\n";
			
		/*product listing*/
		echo $myhelper->arr_to_font_style( "ul.products li a h3, ul.products li a", ot_get_option("ic_woo_title_typography", array()) , false, "!important" );
		echo $myhelper->arr_to_font_style( "ul.products li a span.price", ot_get_option("ic_woo_price_tag_typography", array()) , false, "!important" );
		echo $myhelper->arr_to_font_style( "ul.products li a.button", ot_get_option("ic_woo_add_to_cart_typography", array()) , false, "!important" );
		
		/*product details*/
		echo $myhelper->arr_to_font_style( ".product .summary .price *", ot_get_option("ic_woo_price_typography", array()) , false, "!important" );
		
		/*top bar*/
		echo $myhelper->arr_to_background_style("#woocommerce-top-bar", ot_get_option("ic_woo_top_bar_background"), false, "", "", "", "");
		echo $myhelper->arr_to_font_style( "#woocommerce-top-bar .cart-contents, #woocommerce-top-bar .cart-contents span, #woocommerce-top-bar .woocommerce-top-myaccount a", ot_get_option("ic_woo_top_bar_typography", array()) , false, "" );
		
		/*widgets*/
		echo "ul.product_list_widget li>span, ul.product_list_widget li del, ul.product_list_widget li ins { border: 1px solid " . ot_get_option("ic_skin_sidebar_separator_color") . " ; }\r\n";
		
		/*chzn-single*/
		echo $myhelper->arr_to_font_style(".chzn-single,.chzn-single>div>b,.chzn-drop", ot_get_option("ic_skin_forms_text_options", array()) , false, "!important" );
		
		echo $myhelper->arr_to_background_style(".chzn-single,.chzn-drop", ot_get_option("ic_skin_forms_background"), false, "", "", "", "!important");		
		
		if(ot_get_option("ic_skin_forms_border_color") != '') :
			echo ".chzn-single:focus { border:1px solid " . ot_get_option("ic_skin_forms_border_color") . " !important ; box-shadow:0 0 10px " . ot_get_option("ic_skin_forms_border_color") . " !important;}\n";
			echo ".chzn-single { border:1px solid " . ot_get_option("ic_skin_forms_border_color") . " !important ; }\n";			
		endif;
	}
	/***********************WOOCOMMERCE END******************/
	
	/***********************BBPRESS**************************/
	if($myhelper->ozy_is_plugin_active("bbpress/bbpress.php")) {
		echo $myhelper->arr_to_font_style( "#bbpress-forums fieldset.bbp-form legend", ot_get_option("ic_h3_font", array()) , false );
	}
	/***********************BBPRESS END**********************/
	
	/***********************EXTRA STYLE**********************/
	if(trim(ot_get_option('ic_add_on_style')) != '')
		echo ot_get_option('ic_add_on_style') . PHP_EOL;
	/***********************EXTRA STYLE END******************/	

	$dynamic_css_content =  ob_get_clean();
		
	if($echo) 
		echo $dynamic_css_content;
}


//Social network button link maker
function social_networks( $site, $username, $title, $target = "_self", $tooltip_pos = "below" ) {	
	$link_to_profile = '';

	switch( $site ) {
		case 'blogger':
			$link_to_profile = 'http://' . $username . '.blogspot.com';
			break;

		case 'bebo':
			$link_to_profile = 'http://www.bebo.com/' . $username;
			break;
		
		case 'deviantart':
			$link_to_profile = 'http://' . $username . '.deviantart.com';
			break;
		
		case 'dribbble':
			$link_to_profile = 'http://dribbble.com/' . $username;
			break;
		
		case 'facebook':
			$link_to_profile = 'http://www.facebook.com/' . $username;
			break;
		
		case 'flickr':
			$link_to_profile = 'http://www.flickr.com/photos/' . $username;
			break;
		
		case 'google':
			$link_to_profile = 'https://plus.google.com/' . $username;
			break;
					
		case 'behance':
			$link_to_profile = 'http://www.behance.com/' . $username;
			break;			
		
		case 'linkedin':
			$link_to_profile = 'http://www.linkedin.com/' . $username;
			break;

		case 'rss':
			$link_to_profile = $username;
			break;		
		
		case 'skype':
			$target = "_self";
			$link_to_profile = "skype:".$username."?call";
			break;
		
		case 'myspace':
			$link_to_profile = 'http://www.myspace.com/' . $username;
			break;		
		
		case 'stumbleupon':
			$link_to_profile = 'http://www.stumbleupon.com/stumbler/' . $username;
			break;

		case 'tumblr':
			$link_to_profile = 'http://' . $username . '.tumblr.com/';
			break;
		
		case 'twitter':
			$link_to_profile = 'http://www.twitter.com/' . $username;
			break;
		
		case 'vimeo':
			$link_to_profile = 'http://www.vimeo.com/' . $username;
			break;
		
		case 'wordpress':
			$link_to_profile = 'http://' . $username . '.wordpress.com/';
			break;
		
		case 'yahoo':
			$link_to_profile = 'http://pulse.yahoo.com/' . $username;
			break;
		
		case 'youtube':
			$link_to_profile = 'http://youtube.com/user/' . $username;
			break;
			
		case 'pinterest':
			$link_to_profile = 'http://pinterest.com/' . $username;
			break;

		case 'instagram':
			$link_to_profile = 'http://instagram.com/' . $username;
			break;			
		default:
			break;
	}

	echo '<a href="' . $link_to_profile . '" alt="' . $site . '" target="' . $target . '" ><span class="tooltip_' . $tooltip_pos . ' social-icon-font sif-' . $site . '" title="' . $title . '"></span></a>';		
}

/*breadcrumbs menu*/
/***********************************************************************
* @Author: Boutros AbiChedid 
* @Date:   February 14, 2011
* @Copyright: Boutros AbiChedid (http://bacsoftwareconsulting.com/)
* @Licence: Feel free to use it and modify it to your needs but keep the 
* Author's credit. This code is provided 'as is' without any warranties.
* @Function Name:  wp_bac_breadcrumb()
* @Version:  1.0 -- Tested up to WordPress version 3.1.2
* @Description: WordPress Breadcrumb navigation function. Adding a 
* breadcrumb trail to the theme without a plugin.
* This code does not support multi-page split numbering, attachments,
* custom post types and custom taxonomies.
***********************************************************************/
 
function wp_bac_breadcrumb() {   
    //Variable (symbol >> encoded) and can be styled separately.
    //Use >> for different level categories (parent >> child >> grandchild)
            $delimiter = '<span class="delimiter"> / </span>'; 
    //Use bullets for same level categories ( parent . parent )
    $delimiter1 = '<span class="delimiter1">, </span>';
     
    //text link for the 'Home' page
            $main = __('Home', 'ozy_frontend');  
    //Display only the first 30 characters of the post title.
            $maxLength= 30;
     
    //variable for archived year 
    $arc_year = get_the_time('Y'); 
    //variable for archived month 
    $arc_month = get_the_time('F'); 
    //variables for archived day number + full
    $arc_day = get_the_time('d');
    $arc_day_full = get_the_time('l');  
     
    //variable for the URL for the Year
    $url_year = get_year_link($arc_year);
    //variable for the URL for the Month    
    $url_month = get_month_link($arc_year,$arc_month);
 
    /*is_front_page(): If the front of the site is displayed, whether it is posts or a Page. This is true 
    when the main blog page is being displayed and the 'Settings > Reading ->Front page displays' 
    is set to "Your latest posts", or when 'Settings > Reading ->Front page displays' is set to 
    "A static page" and the "Front Page" value is the current Page being displayed. In this case 
    no need to add breadcrumb navigation. is_home() is a subset of is_front_page() */
     
    //Check if NOT the front page (whether your latest posts or a static page) is displayed. Then add breadcrumb trail.
    if (!is_front_page()) {         
        //If Breadcrump exists, wrap it up in a div container for styling. 
        //You need to define the breadcrumb class in CSS file.
        echo '<div class="breadcrumb">';
         
        //global WordPress variable $post. Needed to display multi-page navigations. 
        global $post, $cat;         
        //A safe way of getting values for a named option from the options database table. 
        $homeLink = get_option('home'); //same as: $homeLink = get_bloginfo('url');
        //If you don't like "You are here:", just remove it.
        echo '<a href="' . $homeLink . '">' . $main . '</a>' . $delimiter;    
         
        //Display breadcrumb for single post
        if (is_single()) { //check if any single post is being displayed.           
            //Returns an array of objects, one object for each category assigned to the post.
            //This code does not work well (wrong delimiters) if a single post is listed 
            //at the same time in a top category AND in a sub-category. But this is highly unlikely.
            $category = get_the_category();
            $num_cat = count($category); //counts the number of categories the post is listed in.
             
            //If you have a single post assigned to one category.
            //If you don't set a post to a category, WordPress will assign it a default category.
            if ($num_cat <=1 && isset($category[0]))  //I put less or equal than 1 just in case the variable is not set (a catch all).
            {
                echo get_category_parents($category[0],  true,' ' . $delimiter . ' ');
                //Display the full post title.
                echo ' ' . get_the_title(); 
            }
            //then the post is listed in more than 1 category.  
            else { 
                //Put bullets between categories, since they are at the same level in the hierarchy.
                echo the_category( $delimiter1, 'multiple'); 
                    //Display partial post title, in order to save space.
                    if (strlen(get_the_title()) >= $maxLength) { //If the title is long, then don't display it all.
                        echo ' ' . $delimiter . trim(substr(get_the_title(), 0, $maxLength)) . ' ...';
                    }                         
                    else { //the title is short, display all post title.
                        echo ' ' . $delimiter . get_the_title(); 
                    } 
            }           
        } 
        //Display breadcrumb for category and sub-category archive
        elseif (is_category()) { //Check if Category archive page is being displayed.
            //returns the category title for the current page. 
            //If it is a subcategory, it will display the full path to the subcategory. 
            //Returns the parent categories of the current category with links separated by '»'
            echo __('Archive Category:', 'ozy_frontend') . ' "' . get_category_parents($cat, true,' ' . $delimiter . ' ') . '"' ;
        }       
        //Display breadcrumb for tag archive        
        elseif ( is_tag() ) { //Check if a Tag archive page is being displayed.
            //returns the current tag title for the current page. 
            echo __('Posts Tagged:', 'ozy_frontend') . ' "' . single_tag_title("", false) . '"';
        }        
        //Display breadcrumb for calendar (day, month, year) archive
        elseif ( is_day()) { //Check if the page is a date (day) based archive page.
            echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . ' ';
            echo '<a href="' . $url_month . '">' . $arc_month . '</a> ' . $delimiter . $arc_day . ' (' . $arc_day_full . ')';
        } 
        elseif ( is_month() ) {  //Check if the page is a date (month) based archive page.
            echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . $arc_month;
        } 
        elseif ( is_year() ) {  //Check if the page is a date (year) based archive page.
            echo $arc_year;
        }       
        //Display breadcrumb for search result page
        elseif ( is_search() ) {  //Check if search result page archive is being displayed. 
            echo __('Search Results for:', 'ozy_frontend') . ' "' . get_search_query() . '"';
        }       
        //Display breadcrumb for top-level pages (top-level menu)
        elseif ( is_page() && !$post->post_parent ) { //Check if this is a top Level page being displayed.
            echo get_the_title();
        }           
        //Display breadcrumb trail for multi-level subpages (multi-level submenus)
        elseif ( is_page() && $post->post_parent ) {  //Check if this is a subpage (submenu) being displayed.
            //get the ancestor of the current page/post_id, with the numeric ID 
            //of the current post as the argument. 
            //get_post_ancestors() returns an indexed array containing the list of all the parent categories.                
            $post_array = get_post_ancestors($post);
             
            //Sorts in descending order by key, since the array is from top category to bottom.
            krsort($post_array); 
             
            //Loop through every post id which we pass as an argument to the get_post() function. 
            //$post_ids contains a lot of info about the post, but we only need the title. 
            foreach($post_array as $key=>$postid){
                //returns the object $post_ids
                $post_ids = get_post($postid);
                //returns the name of the currently created objects 
                $title = $post_ids->post_title; 
                //Create the permalink of $post_ids
                echo '<a href="' . get_permalink($post_ids) . '">' . $title . '</a>' . $delimiter;
            }
            the_title(); //returns the title of the current page.               
        }           
        //Display breadcrumb for author archive   
        elseif ( is_author() ) {//Check if an Author archive page is being displayed.
            global $author;
            //returns the user's data, where it can be retrieved using member variables. 
            $user_info = get_userdata($author);
            echo  __('Archived Article(s) by Author: ', 'ozy_frontend') . $user_info->display_name ;
        }       
        //Display breadcrumb for 404 Error 
        elseif ( is_404() ) {//checks if 404 error is being displayed 
            echo  __('Error 404 - Not Found.', 'ozy_frontend');
        }       
        else {
            //All other cases that I missed. No Breadcrumb trail.
        }
       echo '</div>';     
    }   
}

/** 
* A pagination function 
* @param integer $range: The range of the slider, works best with even numbers 
* Used WP functions: 
* get_pagenum_link($i) - creates the link, e.g. http://site.com/page/4 
* previous_posts_link('<span class="prev">&nbsp;</span>'); - returns the Previous page link 
* next_posts_link('<span class="next">&nbsp;</span>'); - returns the Next page link 
*/  
function get_pagination($before='',$after='',$range = 4) {  
	
	// output variable
	$output = "";
	
  	// $paged - number of the current page  
	global $paged, $wp_query; 
  	// How much pages do we have?  
  	if ( !isset($max_page) ) {  
		$max_page = $wp_query->max_num_pages;  
  	}  
	// We need the pagination only if there are more than 1 page  
	if($max_page > 1){
	
		$output .= $before;
		
		if(!$paged){  
			$paged = 1;  
		}  
		// On the first page, don't put the First page link  
		if($paged != 1){  
			$output .= ' <a href=' . get_pagenum_link(1) . '><span class="first">&nbsp;</span></a>';  		  
		}  
		// To the previous page  
		$output .= get_previous_posts_link('<span class="next">&nbsp;</span>');  
		// We need the sliding effect only if there are more pages than is the sliding range  
		if($max_page > $range){  
			// When closer to the beginning  
			if($paged < $range){  
				for($i = 1; $i <= ($range + 1); $i++){  
					$output .= "<a href='" . get_pagenum_link($i) ."'";  
					if($i==$paged) $output .= "class='current'";  
					$output .= ">$i</a>";  
				}  
			}  
			// When closer to the end  
			elseif($paged >= ($max_page - ceil(($range/2)))){  
				for($i = $max_page - $range; $i <= $max_page; $i++){  
				$output .= "<a href='" . get_pagenum_link($i) ."'";  
				if($i==$paged) $output .= " class='current'";  
				$output .= ">$i</a>";  
			}  
		}  
		// Somewhere in the middle  
		elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){  
			for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){  
				$output .= "<a href='" . get_pagenum_link($i) ."'";  
				if($i==$paged) $output .= " class='current'";  
				$output .= ">$i</a>";  
			}  
		}  
	}  
	// Less pages than the range, no sliding effect needed  
	else{  
	  	for($i = 1; $i <= $max_page; $i++){  
			$output .= "<a href='" . get_pagenum_link($i) ."'";  
			if($i==$paged) $output .= " class='current'";  
			$output .= ">$i</a>";  
	  	}  
	}  
	// Next page  
	$output .= get_next_posts_link('<span class="prev">&nbsp;</span>');  
	// On the last page, don't put the Last page link  
	if($paged != $max_page){  
		$output .= ' <a href=' . get_pagenum_link($max_page) . '><span class="last">&nbsp;</span></a>';  
	}  

	$output .= $after;
	} 

	return $output;
}

// Retrieve the post slug
function the_slug($echo=true, $strip=true, $slug=""){
	$slug = ($slug === '' ? basename(get_permalink()) : $slug);
	do_action('before_slug', $slug);
	$slug = apply_filters('slug_filter', $slug);
	if($strip && strpos($slug,"=") > -1) { $slug = explode("=",$slug); $slug = $slug[1]; } //added, because slug not returning alone on custom post types
	if( $echo ) echo $slug;
	do_action('after_slug', $slug);
	return $slug;
}

//Renders social and share bars which located at top-right of the every page
function social_share_search_buttons($tooltip_pos = "below") {
	echo "	<ul class=\"social-share-buttons-wrapper\">\n";	
	//Social Buttons
	if(ot_get_option("ic_social_share_is_enabled") === "1"):
		$networks = ot_get_option('ic_social_networks');
		
		if(is_array($networks)) {
			$target = ot_get_option("ic_social_share_target_window");
			foreach($networks as $network) :			
				echo '<li class="' . $network['ic_social_networks_network'] . '">';
				social_networks($network['ic_social_networks_network'], $network['ic_social_networks_username'], $network['title'], $target, $tooltip_pos);
				echo '</li>' . PHP_EOL;			
			endforeach;
		}
	endif;
	echo "	</ul>\n";
}

//IF lt IE9
function ielt9() {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($ua, "compatible; MSIE 7.0;") || strpos($ua, "compatible; MSIE 8.0;"))
		return true;
	else
		return false;
}

//Theme Options > Extras having issue with CSS coding, to prevent it following function generated
function filter_textarea_simple_wpautop_style_box( $content, $field_id ) {
	if ( $field_id == 'ic_add_on_style' )
		return false;
	
	return $content;
}
add_filter( 'ot_wpautop', 'filter_textarea_simple_wpautop_style_box', 10, 2 );


//Filter for adding networks name into network select box
function filter_social_networks_select_box( $array, $field_id ) {
	global $AVAILABLE_SOCIAL_NETWORKS;	
	if(strpos($field_id, 'ic_social_networks_ic_social_networks_network')>-1) {
		foreach($AVAILABLE_SOCIAL_NETWORKS as $network) {
			array_push($array, array("value" => $network, "label" => $network));
		}
	}  
	return $array;
}
add_filter( 'ot_populated_select_items', 'filter_social_networks_select_box', 10, 2 );

//AJAX Search
function SearchFilter($query) {
    // If 's' request variable is set but empty
    if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
        $query->is_search = true;
        $query->is_home = false;
    }
    return $query;
}

add_filter('pre_get_posts','SearchFilter');

function ajax_search_box() {
	if (isset($_GET["q"])) 
	{	
		$q = $_GET["q"];		
		
		global $wpdb;
		
		$q = mysql_real_escape_string($q);
	
		$query = array(
			'post_status' => 'publish',
			'order' => 'DESC',
			's' => $q
		);
	
		$get_posts = new WP_Query;
		$posts = $get_posts->query( $query );
	
		// Check if any posts were found.
		if ( ! $get_posts->post_count )
			die();
	
		//Create an array with the results
		foreach ( $posts as $post )
			echo $post->post_title . "|" . $post->ID . "\n";
	}	
	die();
}
// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_ajax_search_box', 'ajax_search_box' ); 
add_action( 'wp_ajax_ajax_search_box', 'ajax_search_box' ); 

//heart like call
function ajax_favorite_like() {
	
	$id = isset($_GET["vote_post_id"]) ? ($_GET["vote_post_id"]) : 0;
	
	if((int)$id <= 0) die( 'Invalid Operation' );
	
	$like_count = (int)get_post_meta((int)$id, "ozy_post_like_count", true);
	
	update_post_meta((int)$id, "ozy_post_like_count", $like_count + 1);
	
	echo $like_count + 1;

	exit();

}
// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_ajax_favorite_like', 'ajax_favorite_like' ); 
add_action( 'wp_ajax_ajax_favorite_like', 'ajax_favorite_like' ); 

/*twitter stuff*/
function ajax_twitter_json() {
	
	if(ot_get_option("ic_twitter_consumer_key") !== '' 
	&& ot_get_option("ic_twitter_consumer_secret_key")  !== '' 
	&& ot_get_option("ic_twitter_access_token_key") !== '' 
	&& ot_get_option("ic_twitter_access_token_secret_key") !=='' ) {

		session_start();
		
		require_once("functions/twitter/twitteroauth.php"); //Path to twitteroauth library
		
		if(isset($_GET["screen_name"]) && $_GET["screen_name"])
			$twitteruser = htmlspecialchars($_GET["screen_name"], ENT_QUOTES);
		else
			$twitteruser = "twitter";
			
		if(isset($_GET["count"]) && $_GET["count"])
			$notweets = htmlspecialchars($_GET["count"], ENT_QUOTES);
		else
			$notweets = 10;
			
		$consumerkey = ot_get_option("ic_twitter_consumer_key"); //"w5mbHmvUSUn5msdmKTBQtg";
		$consumersecret = ot_get_option("ic_twitter_consumer_secret_key"); //"YufXBKmX3vkOfmQafzjcKgX47SO3d9DPuj67vaREr2s";
		$accesstoken = ot_get_option("ic_twitter_access_token_key"); //"436101643-1y35h3qnhzgiTNOsG3t4rV7Ku0FIIsRPABJorUW1";
		$accesstokensecret = ot_get_option("ic_twitter_access_token_secret_key"); //"ox9zuMNYsztTrePfNpMJxgky1yvzqAOUw97J3582oRg";
		 
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		  return $connection;
		}
		  
		$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		 
		$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
		 
		echo json_encode($tweets);

	}else{
		echo "Unknown confugiration";
	}
	exit();	

}
// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_ajax_twitter_json', 'ajax_twitter_json' ); 
add_action( 'wp_ajax_ajax_twitter_json', 'ajax_twitter_json' );

//read count process
function read_count_process($id) {	
	if((int)$id <= 0) die( 'Invalid Operation' );	
	$read_count = (int)get_post_meta((int)$id, "ozy_post_read_count", true);	
	update_post_meta((int)$id, "ozy_post_read_count", $read_count + 1);
}

//used in single.php, author.php, category.php, tag.php
function go_for_page($sname, $post_id, $stored_page_name) {
	$_SESSION[$sname] = $post_id;
	$blog_page_id = ot_get_option($stored_page_name);
	if((int)$blog_page_id > 0) {
		$blog_page = get_post( $blog_page_id );
		if($blog_page != NULL) {
			//header("location:" . home_url() . "/#!/" . $blog_page->post_name);
			
			global $wp_query;
			
			print_r($wp_query);
			
			echo $blog_page->post_name;
		}
	}	
}

/**
 * Extended Walker class for use with the
 * Twitter Bootstrap toolkit Dropdown menus in Wordpress.
 * Edited to support n-levels submenu.
 * @author johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
 */
class BootstrapNavMenuWalker extends Walker_Nav_Menu {
 
	/*function start_lvl( &$output, $depth ) {
		$indent = str_repeat( "\t", $depth );
		$submenu = ($depth > 0) ? ' sub-menu' : '';
		$output	   .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
	}*/

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
 
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) 
	{
		if (!is_object($args))
			return false;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
 
		$li_attributes = '';
		$class_names = $value = '';
 
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		// managing divider: add divider class to an element to get a divider before it.
		$divider_class_position = array_search('divider', $classes);
		if($divider_class_position !== false){
			$output .= "<li class=\"divider\"></li>\n";
			unset($classes[$divider_class_position]);
		}
		
		$classes[] = ($args->has_children) ? 'dropdown' : '';
		$classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
		$classes[] = 'menu-item-' . $item->ID;
		if($depth && $args->has_children){
			$classes[] = 'dropdown-submenu';
		}
		
		// icon check. if any class name starting with "icon-" we consider that one as a type icon class
		$ic = 0; $type_icon_class = "";
		foreach ($classes as $c){
			if (strpos($c, 'icon-') > -1){
				unset($classes[$ic]); $type_icon_class = '<i class="' . esc_attr($c) . '">&nbsp;</i>'; break;
			}
			$ic++;
		}
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		if($depth === 0 && $output !== '') $output .= '<li class="menu-pipe">|</li>'; //ozy themes note : We have added empty li item for first level menu elements to style them as we like.
		 
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
 
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ($args->has_children) 	    ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
 
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>' . $type_icon_class;
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';//$item_output .= ($depth == 0 && $args->has_children) ? ' <b class="caret"></b></a>' : '</a>'; //ozy themes note: we have disabled the down arrows for menu items with children, cos no necessary in EWA
		$item_output .= $args->after;
 
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
 
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		//v($element);
		if ( !$element )
			return;
 
		$id_field = $this->db_fields['id'];
 
		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);
 
		$id = $element->$id_field;
 
		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
 
			foreach( $children_elements[ $id ] as $child ){
 
				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}
 
		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}
 
		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
}

/*sidebar render*/
function sidebar_render($SIDE_BAR_TYPE, $SIDE_BAR_ID) {
	global $myhelper;
	
	$post = get_post( $SIDE_BAR_ID );

	if(isset($post->post_name)) {
		
		$SIDE_BAR_ID = "dynamicsidebar" . $post->post_name;
		
		echo "<div class='" . $SIDE_BAR_TYPE . " span4'>"; 
			echo '
			<!--sidebar-->
			<aside class="sidebar-generic">' . PHP_EOL;
				if( !function_exists('dynamic_sidebar') || !dynamic_sidebar( $SIDE_BAR_ID . $myhelper->wpml_current_language ) ) : endif;
			echo '
			</aside>
			<!--/sidebar-->' . PHP_EOL;		
		echo "</div>\r\n";
	}
}

/*sidebar check*/
function is_sidebar_active($SIDE_BAR_ID, $SIDE_BAR_TYPE) {
	if($SIDE_BAR_TYPE == '' || $SIDE_BAR_TYPE == "full-sidebar" || $SIDE_BAR_ID == '')
		return "false";
	else if(($SIDE_BAR_TYPE == 'left-sidebar' || $SIDE_BAR_TYPE == 'right-sidebar') && ($SIDE_BAR_TYPE != '' || $SIDE_BAR_TYPE != "full-sidebar"))
		return "true";
	
	return "false";
}

////////////////////////////////////////////////////////////////////////////
//if no option tree plugin installed									  //
////////////////////////////////////////////////////////////////////////////
function option_tree_plugin_check() {
	if ( !function_exists( 'ot_get_option' ) ) { 
		header("location:" . get_template_directory_uri() . "/plugin_required.php"); 
		exit();
	}
}

////////////////////////////////////////////////////////////////////////////
//facebook app key														  //
////////////////////////////////////////////////////////////////////////////
function facebook_app_key() {
	if(ot_get_option('ic_facebook_comment_enabled') != '-1') {
		echo '<meta property="fb:app_id" content="' . ot_get_option('ic_facebook_app_id') . '" />' . PHP_EOL;
	}
}

////////////////////////////////////////////////////////////////////////////
//this action required to make blog listing work on frontpage			  //
////////////////////////////////////////////////////////////////////////////
function modify_query($query) {
	if($query->is_main_query() && 
	($query->get( 'page_id' ) === get_option( 'page_on_front' ) || 
	$query->get( 'page_id' ) === get_option( 'show_on_front' ))) 
	{
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		$query->set('paged',$paged);
	}
}

add_action('pre_get_posts', 'modify_query');

////////////////////////////////////////////////////////////////////////////
//to make search also search on titles too								  //
////////////////////////////////////////////////////////////////////////////
function wpse18703_posts_where( $where, &$wp_query )
{
    global $wpdb;
    if ( $wpse18703_title = $wp_query->get( 'wpse18703_title' ) ) {
        $where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $wpse18703_title ) ) . '%\' or ' . $wpdb->posts . '.post_content LIKE \'%' . esc_sql( like_escape( $wpse18703_title ) ) . '%\') ';
		//$wpdb->prepare( ' AND ({$wpdb->posts}.post_title LIKE %s ', esc_sql( '%'.like_escape( trim( $term ) ).'%' ) );
    }
    return $where;
}
add_filter( 'posts_where', 'wpse18703_posts_where', 10, 2 );
?>