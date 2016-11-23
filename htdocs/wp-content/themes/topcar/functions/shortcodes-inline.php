<?php
//Bootstrap Badge & Label
function ozy_badge_label( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type'  => 'label',
		'style' => ''
	), $atts ) );
	
	return '<span class="' . esc_attr($type) .' ' . esc_attr($type) . '-' . esc_attr($style) . '">' . do_shortcode($content) . '</span>';
}

add_shortcode('badge-label', 'ozy_badge_label');

//Flickr Badge (Not available on visual composer)
function ozy_shortcode_flickr_badge($atts, $content=NULL) {
	//Here's our defaults
	$query_atts = shortcode_atts(array(
		'count' => '20', 
		'display' => 'random', 
		'source' => 'user', 
		'size' => 's', 
		'user' => '', 
		'layout' => 'h', 
		'tag' => '', 
		'group' => '', 
		'set' => ''
	), $atts);

	return sprintf( '<div class="flickr-badge-wrapper"><h3>%s</h3><script src="http://www.flickr.com/badge_code_v2.gne?%s" type="text/javascript"></script></div>', $content, http_build_query( $query_atts ) );
}

add_shortcode('flickr_badge', 'ozy_shortcode_flickr_badge');

//Highlighted
function ozy_shortcode_highlight_text( $atts, $content = null ) {
	global $myhelper;
	
	$style = ".highlight-text { background-color: " . ot_get_option("ic_skin_highlighted_bg") . "; }\n";
	$style.= $myhelper->arr_to_font_style( ".highlight-text", $myhelper->get_value_from_array(ot_get_option("ic_skin_highlighted_font"), "font-color") , false, "" );
	
	$myhelper->set_footer_style( $style );
	
	return '<span class="highlight-text">' . do_shortcode($content) . '</span>';
}

add_shortcode('highlight-text', 'ozy_shortcode_highlight_text');

//Typeicon
function ozy_shortcode_typeicon( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'icon'  => '',
		'size' => '12'
	), $atts ) );

	return '<span class="' . esc_attr($icon) . '" style="font-size:' . esc_attr($size) . 'px !important; line-height: '.((int)esc_attr($size)+10).'px;">&nbsp;</span>';

}
add_shortcode('typeicon', 'ozy_shortcode_typeicon');

//Lightbox
function ozy_shortcode_quote_lightbox( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'type'  => 'prettyphoto',
		'full'  => '',
		'title' => '',
		'group' => ''
	), $atts ) );

	return '<a class="' . esc_attr($type) . '" href="' . esc_attr($full) . '" title="' . esc_attr($title) . '" rel="' . esc_attr($group) . '">' . $content . '</a>';

}
add_shortcode('lightbox', 'ozy_shortcode_quote_lightbox');

//List
function ozy_shortcode_list( $atts, $content = null ) {
   	extract( shortcode_atts( array(
    	  'icon' => '',
		  'list_style' => ''
      	), $atts )
	);
	
	$content = do_shortcode($content);
	
	$content_arr = explode("\n", $content);
	
	$icon = trim($icon) !== '' ? '<span class="' . $icon . '">&nbsp;</span>&nbsp;' : '';
	
	$content = '';
	foreach($content_arr as $c) {
		$content.='<li>' . $icon . $c . '</li>';
	}
	
    return '<ul ' . (esc_attr($list_style) ? 'class="list-style-type-classic list-' . esc_attr($list_style) . '"' : '') . '>' . $content . '</ul>';
}
add_shortcode( 'list', 'ozy_shortcode_list' );

//Dropcap
function ozy_shortcode_dropcap( $atts, $content = null ) {
   	extract( shortcode_atts( array(
    	  'type' => 'rectangle',
		  'size' => '22'
      	), $atts ) 
	);
    return '<div class="dropcap dropcap-' . esc_attr($type) . '" style="font-size:' . esc_attr($size) . 'px !important; line-height: '.((int)esc_attr($size)+10).'px; width: '.((int)esc_attr($size)+10).'px; height: '.((int)esc_attr($size)+10).'px;">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'dropcap', 'ozy_shortcode_dropcap' );

//Button
function ozy_shortcode_button( $atts, $content = null ) {
   	extract( shortcode_atts( array(
    	  'url' => '',
		  'size' => '',
		  'icon' => '',
		  'target' => '_self',
		  'lightbox' => 'false',
		  'lightbox_group' => ''
      	), $atts ) 
	);
	
/*	wp_register_style('js_composer_front', get_template_directory_uri().'/vc/js_composer/assets/css/js_composer_front.css');
	wp_enqueue_style( 'js_composer_front');	*/
	
	//The following lines usually called by visual composer but none of them are used here, 
	if($lightbox === 'true') {
		wp_register_style( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js_composer/prettyphoto/css/prettyPhoto.css' );
		wp_enqueue_style( 'prettyphoto');
		wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'));
	}
	wp_enqueue_script( 'wpb_composer_front_js', get_template_directory_uri() . '/vc/js_composer/assets/js_composer_front.js', array('jquery'));	
	
    return '<a href="' . esc_attr($url) . '" class="shortcode-btn wpb_button_a" title="' . esc_attr($content) . '" target="' . esc_attr($target) . '" ' . ($lightbox === 'true' ? 'class="prettyphoto" rel="prettyPhoto' . ($lightbox_group != '' ? '[' . $lightbox_group . ']' : '') : '') . '"><span class="wpb_button wpb_ozy_auto ' . esc_attr($size) . '">' . ( $icon !== '' ? '<i class="' . esc_attr($icon) . '">&nbsp;</i>' : '' ) . do_shortcode($content) . '</span></a>';
}
add_shortcode( 'button', 'ozy_shortcode_button' );
?>