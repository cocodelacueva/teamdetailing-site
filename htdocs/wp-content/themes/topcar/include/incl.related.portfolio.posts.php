<?php
	$orig_post = $post;
	
	global $post;

	$args = array(
		'post_type' 		=> 'ozy_portfolio',
		'numberposts' 		=> 3,
		'my-taxonomy-name' 	=> 'portfolio_category',
		'exclude' 			=> $post->ID,
		'orderby' 			=> 'rand',
		'meta_key' 			=> '_thumbnail_id'
	);
	
	$posts = get_posts ( $args );

	$post_ids = array();
	
	foreach($posts as $post) :
		
		array_push($post_ids, $post->ID);
		
	endforeach;

	echo do_shortcode('[vc_row el_position="last"][vc_column][vc_teaser_grid title="' . __('Related Projects', 'ozy_frontend') . '" grid_columns_count="3" grid_teasers_count="15" grid_content="teaser" grid_layout="portfolio-classic" grid_link="link_post" grid_link_target="_self" grid_template="grid" grid_layout_mode="fitrows" grid_thumb_size="large" grid_posttypes="ozy_portfolio" posts_in="' . implode(',', $post_ids) . '" el_class="" order="desc" el_position="first last"][/vc_column][/vc_row]');

	$post = $orig_post;
	
	wp_reset_query();
?>