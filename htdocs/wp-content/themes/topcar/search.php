<?php
global $post, $myhelper;

//try to find the page selected search page id
$search_page_id 	= ot_get_option("ic_search_page_id");
if((int)$search_page_id > 0 && get_page($search_page_id)) {
	$SIDE_BAR_ID 	= $myhelper->read_meta_data ( get_post_meta($search_page_id, 'ozy_generic_sidebars'));
	$SIDE_BAR_TYPE 	= $myhelper->read_meta_data ( get_post_meta($search_page_id, 'ozy_generic_layout_options'));		
	$search_page_post = get_post($search_page_id);
} else { //or use default one
	$SIDE_BAR_ID 	= get_option_tree('ic_default_sidebar_id_page');
	$SIDE_BAR_TYPE 	= get_option_tree('ic_default_sidebar_layout_page');
}

get_header(); 

wp_register_style( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js_composer/prettyphoto/css/prettyPhoto.css' );
wp_enqueue_style( 'prettyphoto');
wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'));
wp_enqueue_script( 'wpb_composer_front_js', get_template_directory_uri() . '/vc/js_composer/assets/js_composer_front.js', array('jquery'));	

?>

<div class="container">

	<div class="row">
<?php

	//is sidebar active on this page?
	$is_sidebar_active = is_sidebar_active($SIDE_BAR_ID, $SIDE_BAR_TYPE);	

	locate_template('functions/layout-objects.php', true, true);
	
	$ozySearch = new OzySearchPage;
	
	if($is_sidebar_active === "true") : 
		
		echo '<div class="span8 ozy-page-content ' . ( $SIDE_BAR_TYPE === 'left-sidebar' ? ' pull-right' : '' ) . '">' . PHP_EOL;
		
	else:
		
		echo '<div class="span12 ozy-page-content">' . PHP_EOL;
		
	endif;
	
	if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ) :
		
		if(isset($search_page_post->post_content)) {
			echo do_shortcode($search_page_post->post_content);
		}
		
		echo $ozySearch->ozySearchPageListing();
		
	else:

		_e("<h4>No result(s) found.</h4>", "ozy_frontend");

		get_search_form();

	endif;

	echo '</div>' . PHP_EOL;
	
	sidebar_render($SIDE_BAR_TYPE, $SIDE_BAR_ID);

?>
	</div>
    
</div>
<?php

//endif;

get_footer(); 	
?>