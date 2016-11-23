<?php
get_header(); 
global $post, $myhelper, $paged;
?>

<div class="container">

	<div class="row">
<?php

	$SIDE_BAR_ID 	= $myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_generic_sidebars'));
	$SIDE_BAR_TYPE 	= $myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_generic_layout_options'));

	//is sidebar active on this page?
	if(function_exists("is_bbpress")) {
		if(is_bbpress()) {
			$SIDE_BAR_TYPE = ot_get_option("ic_skin_sidebar_layout_bbpress");
			$SIDE_BAR_ID = ot_get_option("ic_skin_sidebar_id_bbpress");
		}
	}
	
	$is_sidebar_active = is_sidebar_active($SIDE_BAR_ID, $SIDE_BAR_TYPE);
	
	if($is_sidebar_active === "true") {

		echo '	<div class="span8 ozy-page-content' . ( $SIDE_BAR_TYPE === 'left-sidebar' ? ' pull-right' : '' ) . '">' . PHP_EOL;
			the_content();
		echo '	</div>' . PHP_EOL;
		
		sidebar_render($SIDE_BAR_TYPE, $SIDE_BAR_ID);

	} else {

		echo '<div class="span12 ozy-page-content">' . PHP_EOL;
		
		the_content();
		
		echo '</div>' . PHP_EOL;

	}

?>
	</div>
    
</div>
<?php
get_footer(); 	
?>