<?php
get_header(); 

global $post, $ozy_post_id, $myhelper;

$ozy_post_id = woocommerce_get_page_id( 'shop' ); //shop page id

?>

<div class="container">

	<div class="row">
<?php

	$SIDE_BAR_ID 	= $myhelper->read_meta_data ( get_post_meta($ozy_post_id, 'ozy_generic_sidebars'));
	$SIDE_BAR_TYPE 	= $myhelper->read_meta_data ( get_post_meta($ozy_post_id, 'ozy_generic_layout_options'));

	//is sidebar active on this page?
	$is_sidebar_active = is_sidebar_active($SIDE_BAR_ID, $SIDE_BAR_TYPE);	
	
	if($is_sidebar_active === "true") {

		echo '	<div class="span8 ozy-page-content' . ( $SIDE_BAR_TYPE === 'left-sidebar' ? ' pull-right' : '' ) . '">' . PHP_EOL;
			woocommerce_content();
		echo '	</div>' . PHP_EOL;
		
		sidebar_render($SIDE_BAR_TYPE, $SIDE_BAR_ID);

	} else {

		echo '<div class="span12 ozy-page-content">' . PHP_EOL;
		
		woocommerce_content();
		
		echo '</div>' . PHP_EOL;

	}

?>
	</div>
    
</div>
<?php
get_footer(); 	
?>