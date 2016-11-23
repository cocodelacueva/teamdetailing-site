<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below

include_once( OZY_BASE_DIR . 'functions/shortcodes-inline.php' );

//Old twitter component for new visual composer
function ozy_vc_twitter( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'twitter_name' => 'twitter',
		'tweets_count' => 5,
		'el_class' => ''
	), $atts));

	wp_enqueue_script('jquery-twitter', get_template_directory_uri().'/scripts/jquery/jquery.tweet.js', array('jquery') );
	wp_enqueue_script('vc-twitter-init', get_template_directory_uri().'/scripts/vc/vc_twitter.js', array('jquery') );

	$output = '';

	$output .= "\n\t".'<div class="wpb_twitter_widget wpb_content_element ' . $el_class . '">';
	$output .= "\n\t\t".'<div class="wpb_wrapper">';
	//$output .= ($title != '' ) ? "\n\t\t\t".'<h2 class="wpb_heading wpb_twitter_heading">'.$title.'</h2>' : '';
	if(function_exists('wpb_widget_title')) {
		$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_twitter_heading'));
	}
	$output .= "\n\t\t\t".'<div class="tweets" data-tw_name="'.$twitter_name.'" data-tw_count="'.$tweets_count.'"></div> <p class="twitter_follow_button_wrap"><a class="wpb_follow_btn twitter_follow_button" href="http://twitter.com/'.$twitter_name.'">'.__("Follow us on twitter", "js_composer").'</a></p>';
	$output .= "\n\t\t".'</div> ';
	$output .= "\n\t".'</div> ';

	return $output;
}

if( function_exists('shortcode_exists') ) {
	if ( !shortcode_exists( 'vc_twitter' ) ) {
	
		add_shortcode( 'vc_twitter', 'ozy_vc_twitter' );
		
		wpb_map( array(
			"name"		=> __("Twitter widget", "ozy_frontend"),
			"base"		=> "vc_twitter",
			"class"		=> "wpb_vc_twitter_widget",
			"icon"		=> 'icon-wpb-balloon-twitter-left',
			"category"  => __('Social', 'js_composer'),
			"params"	=> array(
				array(
					"type" => "textfield",
					"heading" => __("Widget title", "ozy_frontend"),
					"param_name" => "title",
					"value" => "",
					"description" => __("What text use as widget title. Leave blank if no title is needed.", "ozy_frontend")
				),
				array(
					"type" => "textfield",
					"heading" => __("Twitter name", "ozy_frontend"),
					"param_name" => "twitter_name",
					"value" => "",
					"admin_label" => true,
					"description" => __("Type in twitter profile name from which load tweets.", "ozy_frontend")
				),
				array(
					"type" => "dropdown",
					"heading" => __("Tweets count", "js_composer"),
					"param_name" => "tweets_count",
					"value" => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15),
					"description" => __("How many recent tweets to load.", "ozy_frontend")
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", "ozy_frontend"),
					"param_name" => "el_class",
					"value" => "",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "ozy_frontend")
				)
			)
		) );		
	}
}

//Styled Content Box
function ozy_styled_content_box_func( $atts, $content = null) {	
   	extract( shortcode_atts( array(
		  'title' => '',
		  'font_color' => '',
		  'background_color' => '',
		  'background_color_opacity' => '',
		  'go_link' => '',
		  'go_target' => '_self',
		  'go_caption' => '',
		  'icon' => ''
      	), $atts ) 
	);
	
	$button = '';
	if(trim($go_link) !== '' && trim($go_caption) !== '') {
		$button = '<a href="' . esc_attr($go_link) . '" class="shortcode-btn wpb_button_a" title="' . esc_attr($go_caption) . '" target="' . esc_attr($go_target) . '"><span class="wpb_button margin-bottom-0 wpb_ozy_auto wpb_btn-medium" >'. ($icon ? '<i class="' . esc_attr($icon) . '">&nbsp;</i>&nbsp;' : '') . esc_attr($go_caption) . '</span></a>';
	}
	
	$padding = ''; $random_css_class = 'styled_box_' .  rand(0,10000);	
	
	global $myhelper;
	if($background_color) {
		$rgb_arr = $myhelper->HexToRGB($background_color);
		$myhelper->set_footer_style( PHP_EOL . '.' . $random_css_class . ' { background-color: ' . $background_color . '; background-color: rgba(' . $rgb_arr['r'] . ', ' . $rgb_arr['g'] . ', ' . $rgb_arr['b'] . ', ' . (((int)$background_color_opacity)/100) . '); }' . PHP_EOL . ( $font_color ? ('.' . $random_css_class . '>*, ' . $random_css_class . '>h4 { color: ' . $font_color . '; }' . PHP_EOL . '.' . $random_css_class . '>a { text-decoration: underline !important; }') : '' ) . PHP_EOL );
		$padding = 'padding-box-20';
	}
	
    return '<div class="wpb_content_element ' . $padding . ' ' . $random_css_class . '">' . ($title ? '<h4>' . $title . '</h4>' : '') . wpb_js_remove_wpautop(do_shortcode($content)) . $button . '</div>' . PHP_EOL;
}

add_shortcode( 'ozy_styled_content_box', 'ozy_styled_content_box_func' );

wpb_map( array(
   "name" => __("Styled Content Box", 'ozy_backoffice'),
   "base" => "ozy_styled_content_box",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', 'ozy_backoffice'),
   "icon" => "icon-wpb-ozy_styled_content_box",
   "params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", 'ozy_backoffice'),
			"param_name" => "title",
			"admin_label" => true,
			"value" => "",
			"description" => __("Title of the box in H4 format.", 'ozy_backoffice')
		),array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Font Color", 'ozy_backoffice'),
			"param_name" => "font_color",
			"admin_label" => false,
			"value" => "",
			"description" => __("Font color of the box. Links will be covered with underline.", 'ozy_backoffice')
      	),array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", 'ozy_backoffice'),
			"param_name" => "content",
			"value" => "",
			"description" => __("Add your content here.", "ozy_backoffice")
		),array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background Color", "ozy_backoffice"),
			"param_name" => "background_color",
			"admin_label" => false,
			"value" => "",
			"description" => __("Background color of the box. Left empty to use no color.", "ozy_backoffice")
      	),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Background Color Opacity", "ozy_backoffice"),
			"param_name" => "background_color_opacity",
			"admin_label" => false,
			"value" => "100",
			"description" => __("Background color opacity. Enter only integer between 0-100 (IE9+ and modern browsers only).", "ozy_backoffice")
      	),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link", "ozy_backoffice"),
			"param_name" => "go_link",
			"admin_label" => false,
			"value" => "",
			"description" => __("Enter full path.", "ozy_backoffice")
		),array(
			"type" => "dropdown",
			"heading" => __("Link Button Target", "ozy_backoffice"),
			"param_name" => "go_target",
			"value" => array("_self", "_blank", "_parent"),
			"admin_label" => false,
			"description" => __("Select link target window.", "ozy_backoffice")
		),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link Button Caption", "ozy_backoffice"),
			"param_name" => "go_caption",
			"admin_label" => false,
			"value" => __("Enter your title here", "ozy_backoffice"),
			"description" => __("Caption on the link button.", "ozy_backoffice")
		),array(
			"type" => "select_an_icon",
			"class" => "",
			"heading" => __("Link Button Icon", "ozy_backoffice"),
			"param_name" => "icon",
			"admin_label" => false,
			"value" => "",
			"description" => __("Select an icon for your button left blank for use no icon.", "ozy_backoffice")
		)
	)
) );

//Ozy Custom Gallery
function modify_attachment_link( $markup, $id, $size, $permalink ) {
    global $post;
    if ( ! $permalink ) {
        $markup = str_replace( '<a href', '<a class="prettyphoto" rel="prettyphoto['. $post->ID .']" href', $markup );
    }
    return $markup;
}

function ozy_gallery_func( $atts ) {
   	extract( shortcode_atts( array(
		  'caption' => '',
		  'images' => '',
		  'img_size' => 'medium'
      	), $atts ) 
	);

	add_filter( 'wp_get_attachment_link', 'modify_attachment_link', 10, 4 );

	global $myhelper;

    static $instance = 0;
	
    $instance++;
	
	$selector = "gallery-{$instance}";

	$output = '<div class="ozy-gallery-wrapper ' . $selector . '" id="' . $selector . '">' . PHP_EOL;
	
	$attachments = explode(",", $images);
	
	foreach ( $attachments as $att_id ) {
        $output .= '<div class="ozy-gallery-item"><div>' . wp_get_attachment_link(esc_attr($att_id), esc_attr($img_size), false, false) . '</div></div>';
		//$output .= '' . wp_get_attachment_link(esc_attr($att_id), esc_attr($img_size), false, false) . '';
	}
	
	$output .= '</div>' . PHP_EOL;
	
	//The following lines usually called by visual composer but none of them are used here, 
	wp_register_style( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js_composer/prettyphoto/css/prettyPhoto.css' );
	wp_enqueue_style( 'prettyphoto');
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'));
	wp_enqueue_script( 'wpb_composer_front_js', get_template_directory_uri() . '/vc/js_composer/assets/js_composer_front.js', array('jquery'));	
	
	//masonry plugin & gallery css	
	wp_register_style('shortcode.ozy.gallery', get_template_directory_uri().'/css/shortcode.ozy.gallery.css');
	wp_enqueue_style('shortcode.ozy.gallery');

	wp_enqueue_script('jquery-masonry', OZY_BASE_URL . '/scripts/masonry/jquery.masonry.min.js', array('jquery') );	

	$script = 
	'
	jQuery(document).ready(function() {
		var $container = jQuery("#' . $selector . '");
		$container.imagesLoaded( function(){
			$container.masonry({
				itemSelector : "div.ozy-gallery-item",
				gutterWidth: 20
			});
		})
	});';
	
	$myhelper->set_footer_script( $script );
	
	remove_filter( 'wp_get_attachment_link', 'modify_attachment_link' );
	
	return $output;
}

add_shortcode( 'ozy_gallery', 'ozy_gallery_func' );

wpb_map( array(
   "name" => __("Masonry Gallery", "ozy_backoffice"),
   "base" => "ozy_gallery",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_gallery",
   "params" => array(
		array(
            "type" => "attach_images",
            "heading" => __("Images", "ozy_backoffice"),
            "param_name" => "images",
            "value" => "",
            "description" => ""
        ),
        array(
            "type" => "textfield",
            "heading" => __("Image size", "ozy_backoffice"),
            "param_name" => "img_size",
            "value" => "",
            "description" => __("Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme.", "ozy_backoffice")
        )
	)
) );


//Blog Latest Headers
function blog_latest_posts_func( $atts, $content = null ) {
   	extract( shortcode_atts( array(
		  'title' => '',
    	  'item_count' => '',
		  'category_name' => '',
		  'author' => '',
		  'tag' => '',
		  'order_by' => 'date',
		  'order' => 'DESC',
		  'post_status' => 'published'
      	), $atts ) 
	);

	wp_register_style('shortcode.latest.posts', get_template_directory_uri().'/css/shortcode.latest.posts.css');
	wp_enqueue_style('shortcode.latest.posts');

	include_once("layout-objects.php");

	$ozyBlog = new OzyBlog;
	$ozyBlog->item_count 	= esc_attr($item_count);
	$ozyBlog->category_name	= $category_name;
	$ozyBlog->author 		= $author;
	$ozyBlog->tag 			= $tag;
	$ozyBlog->order_by 		= $order_by;
	$ozyBlog->order 		= $order;
	$ozyBlog->post_status 	= $post_status;

	//style registration
	global $myhelper;
	
	$style = "ul.blog-listing-latest>li div.info-bar { color: " . ot_get_option("ic_skin_default_alternative_link_color") . "; }"; //reads color setting from body>default alternative link color
	$style.= "ul.blog-listing-latest>li div.box-date>span.m { background-color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_button_background"), "background-color") . "; color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_button_font"), "font-color") . "; }"; //reads color settings from body>button
	$style.= "ul.blog-listing-latest>li div.box-date>span.d { background-color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_button_hover_background"), "background-color") . "; color: " . $myhelper->get_value_from_array(ot_get_option("ic_skin_button_font"), "font-color") . "; }";	//reads color settings from blog>comments
	
	$myhelper->set_footer_style($style);

	return '<div class="wpb_wrapper">' . ( trim($title) ? '<h2 class="wpb_heading">' . esc_attr($title) . '</h2>' : '' ) . $ozyBlog->blogListingLatest() . '</div>';
}

add_shortcode( 'blog_latest_posts', 'blog_latest_posts_func' );

wpb_map( array(
   "name" => __("Latest Blog Posts", "ozy_backoffice"),
   "base" => "blog_latest_posts",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_blog_latest_posts",
   "params" => array(
      	array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", "ozy_backoffice"),
			"param_name" => "title",
			"value" => "",
			"admin_label" => true,
			"description" => __("Component title", "ozy_backoffice")
      	),   
      	array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Post Count", "ozy_backoffice"),
			"param_name" => "item_count",
			"value" => "6",
			"admin_label" => false,
			"description" => __("How many post will be listed on one page?", "ozy_backoffice")
      	),
		array(
            "type" => "textfield",
            "heading" => __("Categories", "ozy_backoffice"),
            "param_name" => "category_name",
            "description" => __("If you want to narrow output, enter category slug names here. Display posts that have this category (and any children of that category), use category slug (NOT name). Split names with ','. More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters</a>", "ozy_backoffice")
		),
		array(
            "type" => "textfield",
            "heading" => __("Tags", "ozy_backoffice"),
            "param_name" => "tag",
            "description" => __("If you want to narrow output, enter tag slug names here. Display posts that have this tag, use tag slug (NOT name). Split names with ','. More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Author_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Author_Parameters</a>", "ozy_backoffice")
		),
		array(
            "type" => "textfield",
            "heading" => __("Author", "ozy_backoffice"),
            "param_name" => "author",
            "description" => __("If you want to narrow output, enter author slug name here. Display posts that belongs to author, use 'user_nicename' (NOT name). More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Tag_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Tag_Parameters</a>", "ozy_backoffice")
		),		
		array(
			"type" => "dropdown",
			"heading" => __("Order by", "ozy_backoffice"),
			"param_name" => "orderby",
			"value" => array( "", __("Date", "ozy_backoffice") => "date", __("ID", "ozy_backoffice") => "ID", __("Author", "ozy_backoffice") => "author", __("Title", "ozy_backoffice") => "title", __("Modified", "ozy_backoffice") => "modified", __("Random", "ozy_backoffice") => "rand", __("Comment count", "ozy_backoffice") => "comment_count", __("Menu order", "ozy_backoffice") => "menu_order" ),
			"description" => __('Select how to sort retrieved posts. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'js_composer')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order way", "ozy_backoffice"),
			"param_name" => "order",
			"value" => array( __("Descending", "ozy_backoffice") => "DESC", __("Ascending", "ozy_backoffice") => "ASC" ),
			"description" => __('Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', "ozy_backoffice")
        ),
		array(
			"type" => "dropdown",
			"heading" => __("Post Status", "ozy_backoffice"),
			"param_name" => "post_status",
			"value" => array("publish", "pending", "draft", "auto-draft", "future", "private", "inherit", "trash", "any"),
			"admin_label" => false,
			"description" => __("Show posts associated with certain status.", "ozy_backoffice")
		)
   )
) );

//Tweet Box
function ozy_tweet_box_func( $atts ) {
   	extract( shortcode_atts( array(
		  'username' => 'ozythemes',
		  'hashtag' => 'ozythemes',
		  'caption' => __('Let us know how we can help your company find better talent', 'ozy_frontend'),
		  'caption_remaining' => __('Characters Remaining', 'ozy_frontend'),
		  'placeholder' => __('Start typing...', 'ozy_frontend'),
		  'button_title' => __('Send Tweet', 'ozy_frontend')
      	), $atts ) 
	);

	wp_register_style('javascript-tweet-box-css', get_template_directory_uri().'/css/tweetbox.css');
	wp_enqueue_style( 'javascript-tweet-box-css');
	wp_enqueue_script('javascript-tweet-box', get_template_directory_uri().'/scripts/tweetbox.js', array('jquery') );

	return 
	'<div class="wpb_content_element clearfix">
		<form id="tweetUs">
			<label for="tweetText"><span class="icon-twitter"></span>&nbsp;&nbsp;' . esc_attr($caption) . '<span class="pull-right"><span id="charsRemaining">115</span> ' . esc_attr($caption_remaining) . '</span></label>
			<p><textarea maxlength="114" id="tweetText" placeholder="' . esc_attr($placeholder) . '"></textarea></p>
			<a id="sendTweet" href="https://twitter.com/intent/tweet?via=' . esc_attr($username) . '" data-via="' . esc_attr($username) . '" data-hashtag="' . esc_attr($hashtag) . '" target="_blank" class="wpb_button_a"><span class="wpb_button wpb_ozy_auto wpb_btn-large">' . esc_attr($button_title) . '</span></a>
		</form>
	</div>';
}

add_shortcode( 'ozy_tweet_box', 'ozy_tweet_box_func' );

wpb_map( array(
   "name" => __("Tweet Box", "ozy_backoffice"),
   "base" => "ozy_tweet_box",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_tweet_box",
   "params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Caption", "ozy_backoffice"),
			"param_name" => "caption",
			"admin_label" => true,
			"value" => __("Let us know how we can help your company find better talent", "ozy_backoffice"),
			"description" => __("Component caption.", "ozy_backoffice")
		),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Remaining Character Caption", "ozy_backoffice"),
			"param_name" => "caption_remaining",
			"admin_label" => false,
			"value" => __("Characters Remaining", "ozy_backoffice"),
			"description" => __("This text will be used to show how many characters left to type.", "ozy_backoffice")
		),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Box Placeholder", "ozy_backoffice"),
			"param_name" => "placeholder",
			"admin_label" => false,
			"value" => __("Start typing...", "ozy_backoffice"),
			"description" => __("Placeholder text for the Tweet box.", "ozy_backoffice")
		),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button Title", "ozy_backoffice"),
			"param_name" => "button_title",
			"admin_label" => false,
			"value" => __("Send Tweet", "ozy_backoffice"),
			"description" => __("Title of the send tweet button.", "ozy_backoffice")
		),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Username", "ozy_backoffice"),
			"param_name" => "username",
			"admin_label" => true,
			"value" => "",
			"description" => __("Twitter username.", "ozy_backoffice")
		),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Hash Tag", "ozy_backoffice"),
			"param_name" => "hashtag",
			"admin_label" => true,
			"value" => "",
			"description" => __("Hashtag for the post.", "ozy_backoffice")
		)
	)
) );

//Price Table
function ozy_price_table_func( $atts ) {
   	extract( shortcode_atts( array(
		  'price_table_id' => ''
      	), $atts ) 
	);
	return '<div class="wpb_content_element clearfix">' . do_shortcode("[price_table id='" . $price_table_id . "']") . '</div>';
}

if(is_plugin_active("pricetable/pricetable.php")):

	add_shortcode( 'ozy_price_table', 'ozy_price_table_func' );
	
	global $wpdb;
	
	$pricetbl = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'pricetable'");
	$pricetbl_ids = array();
	if ($pricetbl) {
		foreach ( $pricetbl as $pricetbl_table ) {
		  $pricetbl_ids[$pricetbl_table->post_title] = $pricetbl_table->ID;
		}
	}

	wpb_map( array(
	   "name" => __("Pricing Table", "ozy_backoffice"),
	   "base" => "ozy_price_table",
	   "class" => "",
	   "controls" => "full",
	   "category" => __('Content', "ozy_backoffice"),
	   "icon" => "icon-wpb-ozy_price_table",
	   "params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Caption", "ozy_backoffice"),
				"param_name" => "caption",
				"admin_label" => true,
				"value" => __("Enter your caption here", "ozy_backoffice"),
				"description" => __("Not usable at frontend.", "ozy_backoffice")
			),array(
				"type" => "dropdown",
				"heading" => __("Select Price Table", "ozy_backoffice"),
				"param_name" => "price_table_id",
				"value" => $pricetbl_ids,
				"admin_label" => false,
				"description" => __("Choose previously created Price Table form from the drop down list. To Create/Edit one please <a href='admin.php?page=pricetable' target='_parent'>click here</a>", "ozy_backoffice")
			)
		)
	) );

endif;

//iOs Slider
function ozy_ios_slider_func( $atts, $content=null ) {
   	extract( shortcode_atts( array(
		  'title' => '',
		  'slider_images' => ''
      	), $atts ) 
	);
	
	if(trim($slider_images) === "") return "";
	
	wp_enqueue_script('jquery-iosslider', get_template_directory_uri().'/scripts/ios-slider/jquery.iosslider.min.js', array('jquery') );
	wp_enqueue_script('jquery-iosslider-common', get_template_directory_uri().'/scripts/ios-slider/common.js', array('jquery') );
	wp_register_style('jquery-iosslider', get_template_directory_uri().'/scripts/ios-slider/common.css');
	wp_enqueue_style('jquery-iosslider');	
	
	$slides = explode(",", $slider_images);
	
	$slider_id = "iosSlider" . rand(10,10000);
	
	$o = "<div class='wpb_gallery wpb_content_element clearfix'><div id='$slider_id' class='iosSlider-container'>
				<div class = 'iosSlider'>
					<div class = 'slider'>";

	$first_image_height = ""; $first_image_width = "";
	foreach($slides as $slide) :
		$large_image = wp_get_attachment_image_src( $slide, 'full');
		//print_r($large_image);
		if(is_array($large_image) && count($large_image) > 0) {			
			if($first_image_height === "") {			
				//list($width, $height, $type, $attr) = getimagesize( $large_image[0] );
				$first_image_height = $large_image[2];
				$first_image_width 	= $large_image[1];
			}
											
			$o .= "			<div class = 'item'>
								<img src='" . $large_image[0] . "' />";
			$o .= "			</div>";
		}
	endforeach;

	$o .= "			</div>";
	$o .= "			<div class = 'prevContainer'>
						<div class = 'ios-prev'>Prev slide</div>
					</div>
					<div class = 'nextContainer'>
						<div class = 'ios-next'>Next slide</div>
					</div>
					<div class = 'selectorsBlock'>
						<div class = 'selectors'>";
						$first = "first selected";
						foreach($slides as $slide) :
							$o .= "	<div class = 'item $first'></div>"; $first = "";
						endforeach;
	
	$o .= "				</div>
					</div>
			</div>
	</div></div>";
	
	global $myhelper;
	if((int)$first_image_width > 0 && (int)$first_image_height>0)
		$myhelper->set_footer_style( "#" . $slider_id . " { padding: 0 0 " . ((int)(($first_image_height / ((int)$first_image_width))*100)) . "% 0; } .iosSlider-container .selectorsBlock .selectors { width: " . (count($slides) * 19) . "px ;}" );	
	
	return $o;

}

add_shortcode( 'ozy_ios_slider', 'ozy_ios_slider_func' );

wpb_map( array(
   "name" => __("iOs Slider", "ozy_backoffice"),
   "base" => "ozy_ios_slider",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_slider",
   "params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", "ozy_backoffice"),
			"param_name" => "title",
			"admin_label" => true,
			"value" => __(""),
			"description" => __("Not usable at frontend.", "ozy_backoffice")
		),   
		array(
			"type" => "attach_images",
			"heading" => __("Images", "ozy_backoffice"),
			"param_name" => "slider_images",
			"value" => "",
			"description" => __("Select images for your slider.", "ozy_backoffice")
		)
	)
) );

//Member
function ozy_member_box_func( $atts, $content = null ) {
   	extract( shortcode_atts( array(
		  'name' => '',
		  'role' => '',
		  'image' => '',
		  'twitter' => '',
		  'facebook' => '',
		  'pinterest' => '',
		  'github' => '',
		  'google' => '',
		  'linkedin' => '',
		  'mail' => ''
      	), $atts ) 
	);
	
	wp_register_style('member-box-css', get_template_directory_uri().'/css/shortcode.member-box.css');
	wp_enqueue_style( 'member-box-css');			
	
	global $myhelper;

	$myhelper->set_footer_style( $myhelper->arr_to_background_style(".ozy-member-box", ot_get_option("ic_skin_component_alternative_background"), false, "", "", "", "!important") );
	$myhelper->set_footer_style( $myhelper->arr_to_font_style(".ozy-member-box div *", ot_get_option("ic_skin_component_content_font", array()) , false, "") );
	//$myhelper->set_footer_style( $myhelper->arr_to_font_style( ".ozy-member-box a", ot_get_option("ic_skin_component_link_font", array()) , false, "!important" ) );
	
	//begining div
	$o = '<div class="ozy-member-box">';

	//profile image
	if($image) {
		$large_image = wp_get_attachment_image_src( $image, 'large');
		if(is_array($large_image) && count($large_image) > 0) {
			$o.= '<img src="' . $large_image[0] . '" alt="' . esc_attr($name) . '"/>';
		}
	}

	$o.= '<div>';
	
	//name
	$o.= '<h4>' . esc_attr($name) . '</h4>';

	//role
	$o.= '<h5>' . esc_attr($role) . '</h5>';
	
	//content / description
	$o.= wpb_js_remove_wpautop(do_shortcode($content));
	
	$o.= '</div>';

	//$o.= do_shortcode('<div>[ozy_content_divider]</div>');
	$o.= "<hr>";
	
	//social icons
	$o.= '<ul>';
	if($twitter)
		$o.= '<li><a href="' . esc_attr($twitter) . '" class="generic-button-alt"><span class="icon-twitter tooltip_above" title="' . __("Twitter", "ozy_backoffice") . '">&nbsp;</span></a></li>';
	if($facebook)
		$o.= '<li><a href="' . esc_attr($facebook) . '" class="generic-button-alt"><span class="icon-facebook tooltip_above" title="' . __("Facebook", "ozy_backoffice") . '">&nbsp;</span></a></li>';
	if($github)
		$o.= '<li><a href="' . esc_attr($github) . '" class="generic-button-alt"><span class="icon-github tooltip_above" title="' . __("GitHub", "ozy_backoffice") . '">&nbsp;</span></a></li>';
	if($pinterest)
		$o.= '<li><a href="' . esc_attr($pinterest) . '" class="generic-button-alt"><span class="icon-pinterest tooltip_above" title="' . __("Pinterest", "ozy_backoffice") . '">&nbsp;</span></a></li>';
	if($google)
		$o.= '<li><a href="' . esc_attr($google) . '" class="generic-button-alt"><span class="icon-google-plus tooltip_above" title="' . __("Google+", "ozy_backoffice") . '">&nbsp;</span></a></li>';
	if($linkedin)
		$o.= '<li><a href="' . esc_attr($linkedin) . '" class="generic-button-alt"><span class="icon-linkedin tooltip_above" title="' . __("LinkedIn", "ozy_backoffice") . '">&nbsp;</span></a></li>';
	if($mail)
		$o.= '<li><a href="mailto:' . esc_attr($mail) . '" class="generic-button-alt"><span class="icon-envelope tooltip_above" title="' . __("E-Mail", "ozy_backoffice") . '">&nbsp;</span></a></li>';
	$o.= '</ul><div class="clearfix"></div>';
	
	//closing div
	$o.= '</div>';
	
	return $o;
}

add_shortcode( 'ozy_member_box', 'ozy_member_box_func' );

wpb_map( array(
   "name" => __("Member Box", "ozy_backoffice"),
   "base" => "ozy_member_box",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_member_box",
   "params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Name", "ozy_backoffice"),
			"param_name" => "name",
			"admin_label" => true,
			"value" => "",
			"description" => __("Name of team member. <i>Example : John Doe</i>", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Role"),
			"param_name" => "role",
			"admin_label" => false,
			"value" => "",
			"description" => __("Role of team member. <i>Example : Senior Developer</i>", "ozy_backoffice")
		),
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Image", "ozy_backoffice"),
			"param_name" => "image",
			"admin_label" => false,
			"value" => "",
			"description" => __("Phooto/Image of team member.", "ozy_backoffice")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Description", "ozy_backoffice"),
			"param_name" => "content",
			"value" => "",
			"description" => __("Say something about your member.", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Twitter Profile", "ozy_backoffice"),
			"param_name" => "twitter",
			"admin_label" => false,
			"value" => "",
			"description" => __("Twitter profile page. <i>Example : http://twitter.com/ozythemes</i>", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Facebook Profile", "ozy_backoffice"),
			"param_name" => "facebook",
			"admin_label" => false,
			"value" => "",
			"description" => __("Facebook profile page. <i>Example : http://facebook.com/ozythemes</i>", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Pinterest Profile", "ozy_backoffice"),
			"param_name" => "pinterest",
			"admin_label" => false,
			"value" => "",
			"description" => __("Pinterest profile page. <i>Example : http://pinterest.com/ozythemes</i>", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("GitHub Profile", "ozy_backoffice"),
			"param_name" => "github",
			"admin_label" => false,
			"value" => "",
			"description" => __("GitHub profile page. <i>Example : http://github.com/ozythemes</i>", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Google Profile", "ozy_backoffice"),
			"param_name" => "google",
			"admin_label" => false,
			"value" => "",
			"description" => __("Google profile page. <i>Example : http://plus.google.com/ozythemes</i>", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("LinkedIn"),
			"param_name" => "linkedin",
			"admin_label" => false,
			"value" => "",
			"description" => __("LinkedIn profile page. <i>Example : http://linkedin.com/ozythemes</i>", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Mail Address"),
			"param_name" => "mail",
			"admin_label" => false,
			"value" => "",
			"description" => __("Mail address. <i>Example : not-really-exists@ozythemes.com</i>", "ozy_backoffice")
		)
		
	)
));

//Portfolio Details
function ozy_portfolio_details_func( $atts, $content = null ) {
   	extract( shortcode_atts( array(
		  'caption' => __('Project Description', "ozy_backoffice"),
		  'field1_caption' => __('CLIENT', "ozy_backoffice"),
		  'field2_caption' => '',
		  'field3_caption' => __('VIEW PROJECT', "ozy_backoffice"),
		  'field1_value' => '',
		  'field2_value' => '',
		  'field3_value' => '',
		  'social_buttons' => 'true'
		  
      	), $atts ) 
	);

	global $myhelper;
	global $post;

	$o = '<div class="wpb_wrapper">';
	$o.= '		<h3>' . esc_attr($caption) . '</h3>';
	$o.= do_shortcode($content . '<span class="icon-folder-open-alt font120percent">&nbsp;</span>&nbsp;' . strip_tags( get_the_term_list( $post->ID, 'portfolio_category', '', ', ', '' ) ) . '[ozy_content_divider extra_class="margin-top-30"]');
	if(trim($field1_caption) != "" && trim($field1_value)) {
		$o.= '		<h4>' . esc_attr(trim($field1_caption)) . '</h4>';
		$o.= '		<p>' . esc_attr(trim($field1_value)) . '</p>';
	}

	if(trim($field2_caption) != "" && trim($field2_value)) {
		$o.= '		<h4>' . esc_attr(trim($field2_caption)) . '</h4>';
		$o.= '		<p>' . esc_attr(trim($field2_value)) . '</p>';
	}
	
	$o.= '<br class="clearfix"/>';
	
	if(trim($field3_caption) != "" && trim($field3_value)) {
		$o.= '<a href="' . esc_attr(trim($field3_value)) . '" title="' . esc_attr(trim($field3_caption)) . '" class="view_project_link_button" target="_blank">' . esc_attr(trim($field3_caption)) . '</a>';
	}

	$o.= $myhelper->ozy_post_navigation( get_permalink($post->ID), "ic_portfolio_listing_page_id" );
	
	if($social_buttons === 'true') {
		ob_start();  
		get_template_part('include/incl.social.buttons');
		//$o.= '<br class="clearfix"/>';
		$o.= ob_get_contents();  
		ob_end_clean();  
	}
	
	$o.= '</div>';
	
	return $o;
}

add_shortcode( 'ozy_portfolio_details', 'ozy_portfolio_details_func' );

wpb_map( array(
   "name" => __("Portfolio Details", "ozy_backoffice"),
   "base" => "ozy_portfolio_details",
   "class" => "ozy_portfolio_details",
   "wrapper_class" => "clearfix",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_portfolio_details",
   "params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Caption", "ozy_backoffice"),
			"param_name" => "caption",
			"admin_label" => true,
			"value" => __("Project Description", "ozy_backoffice"),
			"description" => __("Caption of the portfolio details section.", "ozy_backoffice")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Description", "ozy_backoffice"),
			"param_name" => "content",
			"value" => __("Enter your description here", "ozy_backoffice"),
			"description" => __("Description of the portfolio item.", "ozy_backoffice")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Display Social Share Buttons", "ozy_backoffice"),
			"param_name" => "social_buttons",
			"value" => array( "true" => "true", "false" => "false"),
			"admin_label" => false,
			"description" => __("Display/Hide social share buttons after description.", "ozy_backoffice")
      	),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Field #1 Caption", "ozy_backoffice"),
			"param_name" => "field1_caption",
			"admin_label" => false,
			"value" => __("CLIENT", "ozy_backoffice"),
			"description" => __("Caption of the field #1.", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Field #1 Value", "ozy_backoffice"),
			"param_name" => "field1_value",
			"admin_label" => false,
			"value" => "",
			"description" => __("Value of the field #1.", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Field #2 Caption", "ozy_backoffice"),
			"param_name" => "field2_caption",
			"admin_label" => false,
			"value" => __("EMPTY FIELD", "ozy_backoffice"),
			"description" => __("Caption of the field #2.", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Field #2 Value", "ozy_backoffice"),
			"param_name" => "field2_value",
			"admin_label" => false,
			"value" => "",
			"description" => __("Value of the field #2.", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Caption of Link to Project", "ozy_backoffice"),
			"param_name" => "field3_caption",
			"admin_label" => false,
			"value" => __("VIEW PROJECT", "ozy_backoffice"),
			"description" => __("Caption of the project link.", "ozy_backoffice")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link of the Project", "ozy_backoffice"),
			"param_name" => "field3_value",
			"admin_label" => false,
			"value" => "",
			"description" => __("Project link.", "ozy_backoffice")
		)
	)
) );

//Clear
function ozy_clear_divider_func( $atts ) {	
   	extract( shortcode_atts( array(
		  'extra_css_class' => ''		  
      	), $atts ) 
	);
	
	return '<div class="wpb_content_element ' . esc_attr($extra_css_class) . '">&nbsp;</div>' . PHP_EOL;
}

add_shortcode( 'ozy_clear_divider', 'ozy_clear_divider_func' );

wpb_map( array(
   "name" => __("Clear Div", "ozy_backoffice"),
   "base" => "ozy_clear_divider",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_clear_div",
   "params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Label", "ozy_backoffice"),
			"param_name" => "label",
			"admin_label" => true,
			"value" => __("Enter your label here. Not usable at front side.", "ozy_backoffice"),
			"description" => __("Generates empty space betwen the objects.", "ozy_backoffice")
		),array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Extra CSS Class", "ozy_backoffice"),
			"param_name" => "extra_css_class",
			"admin_label" => true,
			"value" => __(""),
			"description" => __("Add extra CSS class here.", "ozy_backoffice")
      )
	)
) );

//Divider
function ozy_content_divider_func( $atts ) {
   	extract( shortcode_atts( array(
		  'caption' => '',
		  'extra_class' => ''
      	), $atts ) 
	);
	return '<fieldset class="ozy-content-divider wpb_content_element clearfix ' . esc_attr($extra_class) . '">' . ( trim( esc_attr( $caption ) ) ? '<legend align="center">' . esc_attr( $caption ) . '</legend>' : '' ) . '</fieldset>';
}

add_shortcode( 'ozy_content_divider', 'ozy_content_divider_func' );

wpb_map( array(
   "name" => __("Content Separator (Divider) With Caption", "ozy_backoffice"),
   "base" => "ozy_content_divider",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_divider",
   "params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Caption", "ozy_backoffice"),
			"param_name" => "caption",
			"admin_label" => true,
			"value" => __("Enter your caption here", "ozy_backoffice"),
			"description" => __("Caption of the divider.", "ozy_backoffice")
		)
	)
) );

//Icon Selector Attribute Type
function select_an_icon_settings_field($settings, $value) {
   $dependency = vc_generate_dependencies_attributes($settings);
   return '<div class="select_an_icon">'
             .'<input name="'.$settings['param_name']
             .'" id="field_'.$settings['param_name']
             .'_select" class="wpb_vc_param_value wpb-textinput '
             .$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'
             .$value.'" ' . $dependency . '/>'
         .'</div>';
}

add_shortcode_param('select_an_icon', 'select_an_icon_settings_field', get_template_directory_uri().'/scripts/icon-select.js');

//Icon Title with Content
function title_with_icon_func( $atts, $content=null ) {
   	extract( shortcode_atts( array(
    	  'icon' => '',
		  'icon_size' => 'medium',
		  'icon_position' => 'left',
		  'size' => 'h1',
		  'title' => '',
		  'icon_type' => '',
		  'icon_color' => '',
		  'go_link' => '',
		  'go_target' => '_self'
      	), $atts ) 
	);

	$a_begin = ""; $a_end = "";
	if(trim($go_link) !== '') {
		$a_begin = '<a href="' . esc_attr($go_link) . '" target="' . esc_attr($go_target) . '">';
		$a_end   = '</a>';
	}
	
	$o_icon = ($icon ? $a_begin . '<span ' . ($icon_color ? ' style="color:' . $icon_color . ' !important;"' : '') . ' class="' . $icon . ' ' . esc_attr($icon_type) . ' ' . $icon_size . ' ' . '" ></span>' . $a_end : '');
	
    return '<div class="title-with-icon-wrapper"><div class="wpb_content_element title-with-icon clearfix ' . (trim($content) !== '' ? 'margin-bottom-0 ' : '') . ($icon_position === 'top' ? 'top-style' : '') . '">' . $o_icon . '<' . $size . (!$icon ? ' class="no-icon"' : '') . '>' . $title . '</' . $size . '></div>' . (trim($content) !== '' ? '<div class="wpb_content_element clearfix">' . wpb_js_remove_wpautop(do_shortcode($content)) . '</div>' : '') . '</div>';
}

add_shortcode( 'title_with_icon', 'title_with_icon_func' );

wpb_map( array(
   "name" => __("Title With Icon", "ozy_backoffice"),
   "base" => "title_with_icon",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   'admin_enqueue_js' => array(get_template_directory_uri().'/scripts/icon-select.js'),
   "icon" => "icon-wpb-ozy_title_with_icon",
   "params" => array(
      array(
		"type" => "select_an_icon",
		"heading" => __("Icon", "ozy_backoffice"),
		"param_name" => "icon",
		"value" => '',
		"admin_label" => false,
		"description" => __("Title heading style.", "ozy_backoffice")
      ),array(
		"type" => "dropdown",
		"heading" => __("Icon Size", "ozy_backoffice"),
		"param_name" => "icon_size",
		"value" => array(__("medium", "ozy_backoffice") => "medium", __("large", "ozy_backoffice") => "large", __("xlarge", "ozy_backoffice") => "xlarge", __("xxlarge", "ozy_backoffice") => "xxlarge"),
		"admin_label" => false,
		"description" => __("Size of the Icon.", "ozy_backoffice")
      ),array(
		"type" => "dropdown",
		"heading" => __("Icon Position", "ozy_backoffice"),
		"param_name" => "icon_position",
		"value" => array(__("left", "ozy_backoffice") => "left", __("top", "ozy_backoffice") => "top"),
		"admin_label" => false,
		"description" => __("Position of the Icon.", "ozy_backoffice")
      ),array(
		"type" => "colorpicker",
		"heading" => __("Icon Alternative Color", "ozy_backoffice"),
		"param_name" => "icon_color",
		"value" => "",
		"admin_label" => false,
		"description" => __("This field is not required.", "ozy_backoffice")
      ),array(
		"type" => "dropdown",
		"heading" => __("Icon Background Type", "ozy_backoffice"),
		"param_name" => "icon_type",
		"value" => array(__("rectangle", "ozy_backoffice") => "rectangle", __("rounded", "ozy_backoffice") => "rounded", __("clear", "ozy_backoffice") => "clear"),
		"admin_label" => false,
		"description" => __("Position of the Icon.", "ozy_backoffice")
      ),array(
		"type" => "dropdown",
		"heading" => __("Heading Style", "ozy_backoffice"),
		"param_name" => "size",
		"value" => array("h1", "h2", "h3", "h4", "h5", "h6"),
		"admin_label" => false,
		"description" => __("Title heading style.", "ozy_backoffice")
      ),array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Link (on icon)", "ozy_backoffice"),
         "param_name" => "go_link",
		 "admin_label" => true,
         "value" => "",
         "description" => __("Enter full path.", "ozy_backoffice")
      ),array(
		"type" => "dropdown",
		"heading" => __("Link Target", "ozy_backoffice"),
		"param_name" => "go_target",
		"value" => array("_self", "_blank", "_parent"),
		"admin_label" => false,
		"description" => __("Select link target window.", "ozy_backoffice")
      ),array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", "ozy_backoffice"),
         "param_name" => "title",
		 "admin_label" => true,
         "value" => __("Enter your title here", "ozy_backoffice"),
         "description" => __("Content of the title.", "ozy_backoffice")
      ),array(
		"type" => "textarea_html",
		"holder" => "div",
		"class" => "",
		"heading" => __("Content", "ozy_backoffice"),
		"param_name" => "content",
		"value" => "",
		"description" => __("Type your content here.", "ozy_backoffice")
	  )
   )
) );

//Layer Slider Slider
function layer_slider_func( $atts ) {
	extract( shortcode_atts( array(
		  'slider_id' => ''
		), $atts )
	);

	if(trim($slider_id) !== "") :
		return do_shortcode("<div class='wpb_content_element'>[layerslider id='" . $slider_id . "']</div>");
	endif;
}

add_shortcode( 'layer_slider', 'layer_slider_func' );

if(is_plugin_active("LayerSlider/layerslider.php")):
	
	global $wpdb;
	
	global $table_prefix;
	
	$layersldr = $wpdb->get_results( "SELECT ID FROM " . $table_prefix . "layerslider ");
	$layersldr_alias = array();
	if ($layersldr) {
		foreach ( $layersldr as $layersldr_slide ) {
		  $layersldr_alias[$layersldr_slide->ID] = $layersldr_slide->ID;
		}
	}

	wpb_map( array(
	   "name" => __("Layer Slider"),
	   "base" => "layer_slider",
	   "class" => "",
	   "controls" => "full",
	   "category" => __('Content', "ozy_backoffice"),
	   "icon" => "icon-wpb-ozy_slider",
	   "params" => array(
			array(
				"type" => "dropdown",
				"heading" => __("Select Slider", "ozy_backoffice"),
				"param_name" => "slider_id",
				"value" => $layersldr_alias,
				"admin_label" => true,
				"description" => __("Choose previously created Layer Slider form from the drop down list. To Create/Edit one please <a href='admin.php?page=layerslider' target='_parent'>click here</a>", "ozy_backoffice")
			)		  
	   )
	) );
	
endif;

//Revolution Slider
function revolution_slider_func( $atts ) {
	extract( shortcode_atts( array(
		  'alias_name' => ''
		), $atts ) 
	);
	
	if(function_exists("putRevSlider")) :
		if(trim($alias_name) !== "") :
			return do_shortcode("<div class='wpb_content_element'>[rev_slider " . $alias_name . "]</div>");
		endif;
	endif;
			
}

add_shortcode( 'revolution_slider', 'revolution_slider_func' );

if(is_plugin_active("revslider/revslider.php")):

	global $wpdb;
	
	global $table_prefix;
		
	$revsldr = $wpdb->get_results( "SELECT ID, title, alias FROM " . $table_prefix . "revslider_sliders ");
	$revsldr_alias = array();
	if ($revsldr) {
		foreach ( $revsldr as $revsldr_slide ) {
		  $revsldr_alias[$revsldr_slide->title] = $revsldr_slide->alias;
		}
	}
	
	wpb_map( array(
	   "name" => __("Revolution Slider"),
	   "base" => "revolution_slider",
	   "class" => "",
	   "controls" => "full",
	   "category" => __('Content'),
	   "icon" => "icon-wpb-ozy_slider",
	   "params" => array(
			array(
				"type" => "dropdown",
				"heading" => __("Select Slider", "ozy_backoffice"),
				"param_name" => "alias_name",
				"value" => $revsldr_alias,
				"admin_label" => true,
				"description" => __("Choose previously created Revolution Slider form from the drop down list. To Create/Edit one please <a href='admin.php?page=revslider' target='_parent'>click here</a>", "ozy_backoffice")
			)
	   )
	) );
	
endif;

//Progress Bar
function progress_bar_func( $atts ) {
   	extract( shortcode_atts( array(
    	  'percentage' => '60',
		  'position' => 'right',
		  'title' => ''
      	), $atts ) 
	);
	
	wp_enqueue_script('progress-bar', get_template_directory_uri().'/scripts/progress_bar.js', array('jquery') );

    return '<div class="progress-bar"><div data-width="' . ((int)esc_attr($percentage) > 0 ? ((int)esc_attr($percentage)-10) : 45) . '">' . $title . ' ' . ( ($position==='left' || $position==='') ? '%' . $percentage : $percentage . '%' ) . '</div></div>';
}

add_shortcode( 'progress_bar', 'progress_bar_func' );

wpb_map( array(
   "name" => __("Progress Bar", "ozy_backoffice"),
   "base" => "progress_bar",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_progress",
   "params" => array(
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Percentage", "ozy_backoffice"),
         "param_name" => "percentage",
         "value" => "60",
		 "admin_label" => false,
         "description" => __("Percentage value of the bar over 100.", "ozy_backoffice")
      ),array(
		"type" => "dropdown",
		"heading" => __("Percentage Position", "ozy_backoffice"),
		"param_name" => "position",
		"value" => array("right", "left"),
		"admin_label" => false,
		"description" => __("Show % sign at right or left.", "ozy_backoffice")
      ),array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", "ozy_backoffice"),
         "param_name" => "title",
		 "admin_label" => true,
         "value" => __("Some content/project name goes here.", "ozy_backoffice"),
         "description" => __("Enter your content/project name.", "ozy_backoffice")
      )
   )
) );

//Blog Listing
function blog_listing_func( $atts, $content = null ) {
   	extract( shortcode_atts( array(
    	  'item_count' => '',
		  'category_name' => '',
		  'author' => '',
		  'tag' => '',
		  'order_by' => 'date',
		  'order' => 'DESC',
		  'post_status' => 'published'
      	), $atts ) 
	);

	include_once("layout-objects.php");

	$ozyBlog = new OzyBlog;
	$ozyBlog->item_count 	= esc_attr($item_count);
	$ozyBlog->category_name	= $category_name;
	$ozyBlog->author 		= $author;
	$ozyBlog->tag 			= $tag;
	$ozyBlog->order_by 		= $order_by;
	$ozyBlog->order 		= $order;
	$ozyBlog->post_status 	= $post_status;

	return $ozyBlog->blogListingClassic();
}

add_shortcode( 'blog_listing', 'blog_listing_func' );

wpb_map( array(
   "name" => __("Blog Page", "ozy_backoffice"),
   "base" => "blog_listing",
   "class" => "",
   "controls" => "full",
   "category" => __('Content', "ozy_backoffice"),
   "icon" => "icon-wpb-ozy_blog_listing",
   "params" => array(
      	array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", "ozy_backoffice"),
			"param_name" => "temp_title",
			"value" => __("Blog listing component", "ozy_backoffice"),
			"admin_label" => true,
			"description" => __("This entry will not be displayed at front side", "ozy_backoffice")
      	),   
      	array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Post Count", "ozy_backoffice"),
			"param_name" => "item_count",
			"value" => "6",
			"admin_label" => false,
			"description" => __("How many post will be listed on one page?", "ozy_backoffice")
      	),
		array(
            "type" => "textfield",
            "heading" => __("Categories", "ozy_backoffice"),
            "param_name" => "category_name",
            "description" => __("If you want to narrow output, enter category slug names here. Display posts that have this category (and any children of that category), use category slug (NOT name). Split names with ','. More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Category_Parameters</a>", "ozy_backoffice")
		),
		array(
            "type" => "textfield",
            "heading" => __("Tags", "ozy_backoffice"),
            "param_name" => "tag",
            "description" => __("If you want to narrow output, enter tag slug names here. Display posts that have this tag, use tag slug (NOT name). Split names with ','. More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Author_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Author_Parameters</a>", "ozy_backoffice")
		),
		array(
            "type" => "textfield",
            "heading" => __("Author", "ozy_backoffice"),
            "param_name" => "author",
            "description" => __("If you want to narrow output, enter author slug name here. Display posts that belongs to author, use 'user_nicename' (NOT name). More information; <a href='http://codex.wordpress.org/Class_Reference/WP_Query#Tag_Parameters' target='_blank'>http://codex.wordpress.org/Class_Reference/WP_Query#Tag_Parameters</a>", "ozy_backoffice")
		),		
		array(
			"type" => "dropdown",
			"heading" => __("Order by", "ozy_backoffice"),
			"param_name" => "orderby",
			"value" => array( "", __("Date", "ozy_backoffice") => "date", __("ID", "ozy_backoffice") => "ID", __("Author", "ozy_backoffice") => "author", __("Title", "ozy_backoffice") => "title", __("Modified", "ozy_backoffice") => "modified", __("Random", "ozy_backoffice") => "rand", __("Comment count", "ozy_backoffice") => "comment_count", __("Menu order", "ozy_backoffice") => "menu_order" ),
			"description" => __('Select how to sort retrieved posts. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'ozy_backoffice')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order way", "ozy_backoffice"),
			"param_name" => "order",
			"value" => array( __("Descending", "ozy_backoffice") => "DESC", __("Ascending", "ozy_backoffice") => "ASC" ),
			"description" => __('Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.', 'ozy_backoffice')
        ),
		array(
			"type" => "dropdown",
			"heading" => __("Post Status", "ozy_backoffice"),
			"param_name" => "post_status",
			"value" => array("publish", "pending", "draft", "auto-draft", "future", "private", "inherit", "trash", "any"),
			"admin_label" => false,
			"description" => __("Show posts associated with certain status.", "ozy_backoffice")
		)
   )
) );

//Editor Buttons
function add_shortcodes_button() {
	if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') )
		return;
	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter('mce_external_plugins', 'add_shortcodes_tinymce_plugin');
		add_filter('mce_buttons', 'register_shortcodes_button');
	}
}

add_action('init', 'add_shortcodes_button');

function register_shortcodes_button( $buttons ) {
	array_push( $buttons, '|', 'ozy_backoffice_shortcodes' );
	return $buttons;
}

function add_shortcodes_tinymce_plugin( $plugin_array ) {
	$plugin_array['ozy_backoffice_shortcodes'] = OZY_BASE_URL . 'functions/tinymce/tinymce.js';
	return $plugin_array;
}

function my_refresh_mce( $ver ) {

	$ver += 3;

	return $ver;

}
add_filter('tiny_mce_version', 'my_refresh_mce');


//Load Scripts
function ozy_load_shortcode_scripts() {
	wp_enqueue_script( 'ozy_quicktags', OZY_BASE_URL . 'functions/tinymce/quicktags.js', array('quicktags') );
	wp_enqueue_script( 'ozy_quicktags_shortcodes', OZY_BASE_URL . 'functions/tinymce/js/scripts.js', array('quicktags') );	
}

add_action('admin_print_scripts', 'ozy_load_shortcode_scripts');
?>