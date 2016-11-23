<?php
	/*custom post types for portfolio*/
	add_action( 'init', 'create_post_types' );
	
	function create_post_types() {
		
		//Portfolio
		register_post_type( 'ozy_portfolio',
			array(
				'labels' => array(
					'name' => __( 'Portfolio', 'ozy_backoffice'),
					'singular_name' => __( 'Portfolio', 'ozy_backoffice'),
					'add_new' => 'Add Portfolio Item',
					'edit_item' => 'Edit Portfolio Item',
					'new_item' => 'New Portfolio Item',
					'view_item' => 'View Portfolio Item',
					'search_items' => 'Search Portfolio Items',
					'not_found' => 'No Portfolio Items found',
					'not_found_in_trash' => 'No Portfolio Items found in Trash'				
				),
				'can_export' => true,
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'portfolio', 'with_front' => true),
				'supports' => array('title','editor','thumbnail'),
				'menu_icon' => OZY_BASE_URL . 'images/admin/icon-portfolio.png',/*,
				'taxonomies' => array('portfolio_category') // this is IMPORTANT*/
			)
		);

		//Testimonials
		register_post_type( 'ozy_testimonials',
			array(
				'labels' => array(
					'name' => __( 'Testimonials', 'ozy_backoffice'),
					'singular_name' => __( 'Testimonial', 'ozy_backoffice'),
					'add_new' => 'Add Testimonial',
					'edit_item' => 'Edit Testimonial',
					'new_item' => 'New Testimonial Entry',
					'view_item' => 'View Testimonials',
					'search_items' => 'Search Testimonials',
					'not_found' => 'No Testimonial Items found',
					'not_found_in_trash' => 'No Testimonial Items found in Trash'				
				),
				'can_export' => true,				
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'testimonial', 'with_front' => true),
				'supports' => array('title','editor'),
				'menu_icon' => OZY_BASE_URL . 'images/admin/icon-testimonial.png'
			)
		);		
		
		//Clients
		register_post_type( 'ozy_clients',
			array(
				'labels' => array(
					'name' => __( 'Clients', 'ozy_backoffice'),
					'singular_name' => __( 'Client', 'ozy_backoffice'),
					'add_new' => 'Add New Client',
					'edit_item' => 'Edit Client',
					'new_item' => 'New Client Entry',
					'view_item' => 'View Clients',
					'search_items' => 'Search Clients',
					'not_found' => 'No Client found',
					'not_found_in_trash' => 'No Client found in Trash'				
				),
				'can_export' => true,				
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'client', 'with_front' => true),
				'supports' => array('title', 'thumbnail'),
				'taxonomies' => array(''),
				'menu_icon' => OZY_BASE_URL . 'images/admin/icon-client.png'
			)
		);				
	
		//User managaged sidebars
		register_post_type( 'ozy_sidebars',
			array(
				'labels' => array(
					'name' => __( 'Sidebars', 'ozy_backoffice'),
					'singular_name' => __( 'Sidebars', 'ozy_backoffice'),
					'add_new' => 'Add Sidebar',
					'edit_item' => 'Edit Sidebar',
					'new_item' => 'New Sidebar',
					'view_item' => 'View Sidebars',
					'search_items' => 'Search Sidebar',
					'not_found' => 'No Sidebar found',
					'not_found_in_trash' => 'No Sidebar found in Trash'				
				),
				'can_export' => true,				
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'sidebars', 'with_front' => true),
				'supports' => array('title'),
				'taxonomies' => array(''),
				'menu_icon' => OZY_BASE_URL . 'images/admin/icon-sidebars.png'
			)
		);	
	}
	
	add_action( 'init', 'create_custom_taxonomies', 0 );
	function create_custom_taxonomies()
	{
		//Portfolio Categories
		$labels = array(
			'name' => _x( 'Portfolio Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Portfolio Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Portfolio Categories', 'ozy_backoffice' ),
			'popular_items' => __( 'Popular Portfolio Categories', 'ozy_backoffice' ),
			'all_items' => __( 'All Portfolio Categories', 'ozy_backoffice' ),
			'parent_item' => __( 'Parent Portfolio Categories', 'ozy_backoffice' ),
			'parent_item_colon' => __( 'Parent Portfolio Category:', 'ozy_backoffice' ),
			'edit_item' => __( 'Edit Portfolio Category', 'ozy_backoffice' ),
			'update_item' => __( 'Update Portfolio Category', 'ozy_backoffice' ),
			'add_new_item' => __( 'Add New Portfolio Category', 'ozy_backoffice' ),
			'new_item_name' => __( 'New Portfolio Category', 'ozy_backoffice' ),
		);
		
		register_taxonomy('portfolio_category', array('ozy_portfolio'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'portfolio_category' ),
		));

	}
	
?>