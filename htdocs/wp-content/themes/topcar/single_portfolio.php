<?php
get_header(); 

//The following lines usually called by visual composer but none of them are used here, 
if((int)$myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_is_related_posts_enabled')) === -1) :
	wp_register_style( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js_composer/prettyphoto/css/prettyPhoto.css' );
	wp_enqueue_style( 'prettyphoto');
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'));
	wp_enqueue_script( 'wpb_composer_front_js', get_template_directory_uri() . '/vc/js_composer/assets/js_composer_front.js', array('jquery'));	
endif;

global $post, $myhelper;
?>

<div class="container">

	<div class="row">
<?php
	
	$SIDE_BAR_ID 	= $myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_generic_sidebars'));
	$SIDE_BAR_TYPE 	= $myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_generic_layout_options'));

	$is_sidebar_active = is_sidebar_active($SIDE_BAR_ID, $SIDE_BAR_TYPE);	
	
	if($is_sidebar_active === "true") : 
		echo '<div class="span8 ozy-page-content' . ( $SIDE_BAR_TYPE === 'left-sidebar' ? ' pull-right' : '' ) . '">' . PHP_EOL;
			the_content();
	else:
		echo '<div class="span12 ozy-page-content">' . PHP_EOL;
		the_content();
	endif;

	//related posts
	if((int)$myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_is_related_posts_enabled')) !== -1)
		get_template_part("include/incl.related.portfolio.posts");
	
	echo '</div>' . PHP_EOL;
	
	if($is_sidebar_active === "true")
		sidebar_render($SIDE_BAR_TYPE, $SIDE_BAR_ID);
	
?>
	</div>
    
</div>
<?php
get_footer(); 	
?>