<?php
global $post, $myhelper;

get_header(); 

wp_register_style( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js_composer/prettyphoto/css/prettyPhoto.css' );
wp_enqueue_style( 'prettyphoto');
wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'));
wp_enqueue_script( 'wpb_composer_front_js', get_template_directory_uri() . '/vc/js_composer/assets/js_composer_front.js', array('jquery'));
wp_register_style( 'js_composer_front', get_template_directory_uri() . '/vc/js_composer/assets/css/js_composer_front.css' );
wp_enqueue_style( 'js_composer_front' );
?>

<div class="container">

	<div class="row">
<?php
	
	$SIDE_BAR_ID 	= get_option_tree('ic_default_sidebar_id_blog');
	$SIDE_BAR_TYPE 	= get_option_tree('ic_default_sidebar_layout_blog');

	//is sidebar active on this page?
	$is_sidebar_active = is_sidebar_active($SIDE_BAR_ID, $SIDE_BAR_TYPE);	

	locate_template('functions/layout-objects.php', true, true);

	$ozyBlog = new OzyBlog;
	
	if($is_sidebar_active === "true") : 
		echo '<div class="span8 ozy-page-content ' . ( $SIDE_BAR_TYPE === 'left-sidebar' ? ' pull-right' : '' ) . '">' . PHP_EOL;
	else:
		echo '<div class="span12 ozy-page-content">' . PHP_EOL;
	endif;
	
	echo $ozyBlog->blogListingClassic();
	
	echo '</div>' . PHP_EOL;
	
	sidebar_render($SIDE_BAR_TYPE, $SIDE_BAR_ID);

?>
	</div>
    
</div>

<?php
get_footer(); 	
?>