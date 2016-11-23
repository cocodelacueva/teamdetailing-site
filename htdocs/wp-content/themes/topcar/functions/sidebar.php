<?php
	function load_sidebars() {
		
		global $myhelper;
	
		//Default Sidebars
		register_sidebar(array(
			'name'=>'Bottom Widgets (not footer)' . $myhelper->wpml_current_language,
			'id'=>"bottom-widgetbar" . $myhelper->wpml_current_language,
			'before_widget'=>'<section class="' . $myhelper->get_class_by_column_count(0, 'ic_sking_bottom_widget_bar_column_count') . ' sidebar-widget">',
			'after_widget'=>'</section>',
			'before_title'=>'<div class="h6-wrapper"><h6>',
			'after_title'=>'</h6></div>'
		));
	
		//Default Sidebars
		register_sidebar(array(
			'name'=>'Footer (Copyright etc...)' . $myhelper->wpml_current_language,
			'id'=>"footer-sidebar" . $myhelper->wpml_current_language,
			'before_widget'=>'<section class="span6 sidebar-widget footer-sidebar">',
			'after_widget'=>'</section>',
			'before_title'=>'<h6>',
			'after_title'=>'</h6>'
		));
	
		//we need to define this class to arrange footer bar
		$myhelper->set_footer_style( "#bottom-widget-wrapper section:nth-child(" . ot_get_option("ic_sking_bottom_widget_bar_column_count") . "n+1) { clear:both; }" );
		
		//Load user generated sidebars
		
		$args = array( 'post_type' => 'ozy_sidebars', 'posts_per_page' => 200);
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
			$post = get_post( get_the_ID() );
			register_sidebar(array(
				'name'=> get_the_title() . $myhelper->wpml_current_language,
				'id'=> 'dynamicsidebar' . $post->post_name . $myhelper->wpml_current_language,
				'before_widget'=>'<section class="sidebar-widget">',
				'after_widget'=>'</section>',
				'before_title'=>'<h6>',
				'after_title'=>'</h6>'
			));
		
		endwhile; wp_reset_postdata(); 
		
	}	
	//add_action('after_setup_theme', 'load_dynamic_sidebars');	
	add_action('init', 'load_sidebars');	

?>