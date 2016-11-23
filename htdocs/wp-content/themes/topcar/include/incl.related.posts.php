<?php
	$orig_post = $post;
	
	global $post;
	
	$categories = get_the_category($post->ID);
	
	if ($categories) {
		$category_ids = array();
		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	
		$args=array(
			'category__in' => $category_ids,
			'post__not_in' => array($post->ID),
			'post_type' => 'post',
			'posts_per_page'=>5, // Number of related posts to display.			
			'ignore_sticky_posts'=>1,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => '_thumbnail_id',
				)
			)			
		);
	
		$my_query = new wp_query( $args );
				
		$o = "";
		if($my_query->found_posts >0 ) {
			
			echo '<br class="clearfix"/>';
			
			echo '<h2 class="wpb_heading">' .  __('Related Posts', 'ozy_frontend') . '</h2>' . PHP_EOL;
			while( $my_query->have_posts() ) {
				$my_query->the_post();
								
				if ( has_post_thumbnail() ) :
					$o .= '[vc_accordion_tab title="' . esc_attr(get_the_title()) . '"][vc_column_text el_position="first last"]<div class="related-post">';
					$o .= get_the_post_thumbnail(get_the_ID() ,array(150, 150) );
					$o .= get_the_excerpt();
					$o .= '<p><br class="clearfix"/><a href="' . get_permalink() . '" class="wpb_button_a"><span class="generic-button wpb_button wpb_ozy_auto">'. __('READ MORE →', 'ozy_frontend') . '</span></a></p>';
					$o .= '</div>[/vc_column_text][/vc_accordion_tab]';
				endif;			
			}
		}
		
		echo do_shortcode('[vc_row el_position="first last"][vc_column][vc_accordion el_position="first"]' . $o . '[/vc_accordion][/vc_column][/vc_row]');
	
	}
	
	$post = $orig_post;
	
	wp_reset_query();
?>