<?php
//Initialize the meta boxes. 
add_action( 'admin_init', 'ozy_custom_meta_boxes' );

function ozy_custom_meta_boxes() {
	global $myhelper;
	
	//Post Options
	$ozy_post_meta_box = array(
	'id'        => 'ozy_post_meta_box',
	'title'     => 'Post Options',
	'desc'      => '',
	'pages'     => array( 'post' ),
	'context'   => 'normal',
	'priority'  => 'high',
	'fields'    => 
		array(
			array(
				'id'          => 'ozy_page_title_is_enabled',
				'label'       => 'Show Page Title ',
				'desc'        => 'Show / Hide Page Title (Super Title).',
				'std'         => '1',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),		
			array(
				'id'          => 'ozy_generic_super_title',
				'label'       => 'Super Title',
				'desc'        => 'Title over the page\'s content. Leave blank to use post title.',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),
			array(
				'id'          => 'ozy_generic_layout_options',
				'label'       => 'Layout',
				'desc'        => 'Default layout is No Sidebar, unless changed on Theme Options ',
				'std'         => ( ot_get_option('ic_default_sidebar_layout_blog') != '' ? ot_get_option('ic_default_sidebar_layout_blog') : '' ),
				'type'        => 'radio-image',
				'class'       => '',
				'choices'     => array()
			),
			array(
				'id'          => 'ozy_generic_sidebars',
				'label'       => 'Sidebar',
				'desc'        => 'This option only available for the layouts which have sidebar(s). Choose nothing to use default one.',
				'std'         => ( ot_get_option('ic_default_sidebar_id_blog') !='' ? ot_get_option('ic_default_sidebar_id_blog') : '' ),
				'post_type'   => 'ozy_sidebars',
				'type'        => 'custom-post-type-select',
				'class'       => '',
				'choices'     => array()
			),
			array(
				'id'          => 'ozy_is_related_posts_enabled',
				'label'       => 'Related Posts ',
				'desc'        => 'Show / Hide Related posts.',
				'std'         => '1',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"1","label"=>"ON"), array("value"=>"-1","label"=>"OFF")),
			),			
			array(
				'id'          => 'ozy_generic_background_is_enabled',
				'label'       => 'Custom Page Background',
				'desc'        => '',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),			
			array(
				'id'          => 'ozy_generic_background_options',
				'label'       => 'Page Background',
				'desc'        => 'You can specify different background options for each page. If enabled predifened/user defined options will be ignored',
				'std'         => '',
				'type'        => 'background',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_is_enabled',
				'label'       => 'Custom Page Header Options',
				'desc'        => '',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),			
			array(
				'id'          => 'ozy_generic_title_options_style',
				'label'       => 'Page Header Style',
				'desc'        => 'Select generic type for your page headings. Fluid / Short styles available.',
				'std'         => (ot_get_option('ic_skin_page_heading_style')),
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"short","label"=>"Short"), array("value"=>"fluid","label"=>"Fluid"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_background',
				'label'       => 'Page Header Background',
				'desc'        => 'You can specify different title background options for each page. If enabled predifened/user defined options will be ignored',
				'std'         => (ot_get_option('ic_skin_page_heading_background')),
				'type'        => 'background',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_use_padding',
				'label'       => 'Page Header Use Padding',
				'desc'        => 'We strongly recommend to use when you set background options.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"yes","label"=>"yes"), array("value"=>"no","label"=>"no"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_margin',
				'label'       => 'Page Header Top - Bottom Margin',
				'desc'        => 'Top and Bottom margin of the title.',
				'std'         => ot_get_option('ic_skin_page_heading_margin'),
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"0","label"=>"0px"), array("value"=>"10","label"=>"10px"), array("value"=>"20","label"=>"20px"), array("value"=>"30","label"=>"30px"), array("value"=>"40","label"=>"40px"), array("value"=>"50","label"=>"50px"), array("value"=>"60","label"=>"60px"), array("value"=>"70","label"=>"70px"), array("value"=>"80","label"=>"80px"), array("value"=>"90","label"=>"90px"), array("value"=>"100","label"=>"100px"), array("value"=>"110","label"=>"110px"), array("value"=>"120","label"=>"120px"), array("value"=>"130","label"=>"130px"), array("value"=>"140","label"=>"140px"), array("value"=>"150","label"=>"150px"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_big_title_font',
				'label'       => 'Page Header Big Title Typography',
				'desc'        => 'Typography options for the title.',
				'std'         => (ot_get_option('ic_skin_page_heading_big_title_font')),
				'type'        => 'typography',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_big_title_background',
				'label'       => 'Page Header Big Title Background Color',
				'desc'        => 'Title background color',
				'std'         => ot_get_option('ic_skin_page_heading_big_title_background'),
				'type'        => 'colorpicker',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_sub_title_font',
				'label'       => 'Page Header Sub Title Typography',
				'desc'        => 'Typography options for the sub title.',
				'std'         => (ot_get_option('ic_skin_page_heading_sub_title_font')),
				'type'        => 'typography',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_sub_title_background',
				'label'       => 'Page Header Sub Title Background Color',
				'desc'        => 'Sub title background color',
				'std'         => ot_get_option('ic_skin_page_heading_sub_title_color'),
				'type'        => 'colorpicker',
				'class'       => '',
				'choices'     => array()
			)
		)
	);
	
	//Page specific Options
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
	$available_sliders = array(array("value"=>"-1","label"=>"-disabled-"), array("value"=>"shortcode","label"=>"Render my shortcode"), array("value"=>"ios" , "label"=>"iOs Slider"));

	$layersldr_alias = array();
	if(is_plugin_active("LayerSlider/layerslider.php")):
		global $wpdb;
		global $table_prefix;
		$layersldr = $wpdb->get_results( "SELECT ID FROM " . $table_prefix . "layerslider" );
		if ($layersldr) {
			foreach ( $layersldr as $layersldr_slide ) {
			  array_push($layersldr_alias, array("value" => $layersldr_slide->ID, "label" => __("Layer Slider ", "ozy_admin") . $layersldr_slide->ID));	  
			}
			array_push($available_sliders, array("value"=>"layer","label"=>"Layer Slider"));
		}
	endif;

	$cutesldr_alias = array();
	if(is_plugin_active("CuteSlider/cuteslider.php")):
		global $wpdb;
		global $table_prefix;
		$cutesldr = $wpdb->get_results( "SELECT ID FROM " . $table_prefix . "cuteslider" );
		if ($cutesldr) {
			foreach ( $cutesldr as $cutesldr_slide ) {
			  array_push($cutesldr_alias, array("value" => $cutesldr_slide->ID, "label" => __("Cute Slider ", "ozy_admin") . $cutesldr_slide->ID));	  
			}
			array_push($available_sliders, array("value"=>"cute","label"=>"Cute Slider"));
		}
	endif;	

	$revsldr_alias = array();
	if(is_plugin_active("revslider/revslider.php")):
		global $wpdb;
		global $table_prefix;
		$revsldr = $wpdb->get_results( "SELECT ID, title, alias FROM " . $table_prefix . "revslider_sliders ");
		if ($revsldr) {
			foreach ( $revsldr as $revsldr_slide ) {
			  array_push($revsldr_alias, array("value" => $revsldr_slide->alias, "label" => $revsldr_slide->title));	  
			}
			array_push($available_sliders, array("value"=>"revo","label"=>"Revolution Slider"));
		}
	endif;
	
	
	$ozy_page_meta_box = array(
	'id'        => 'ozy_page_meta_box',
	'title'     => 'Page Options',
	'desc'      => '',
	'pages'     => array( 'page' ),
	'context'   => 'normal',
	'priority'  => 'high',
	'fields'    => 
		array(
			array(
				'id'          => 'ozy_full_width_slider_type',
				'label'       => 'Full Width Slider Type',
				'desc'        => 'Please select type of your slider. <ul><li>- Revolution Slider : Enter Revolution Slider alias name into box below</li><li>- Layer Slider : Enter Layer Slider ID# into box below</li><li>- Cute Slider : Enter Cute Slider ID# into box below</li><li>- iOs Slider : Simply upload your images</li><li>- Render My Shortcode : Enter any shortcode below and it will be rendered. Example : [yet-another-slider id=1]</li></ul>',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => $available_sliders
			),
			array(
				'id'          => 'ozy_full_width_slider_alias_shortcode',
				'label'       => 'Shortcode',
				'desc'        => 'Instructions are listed above.',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),			
			array(
				'id'          => 'ozy_full_width_slider_alias_revo',
				'label'       => 'Revolution Slider',
				'desc'        => 'Instructions are listed above.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => $revsldr_alias
			),
			array(
				'id'          => 'ozy_full_width_slider_alias_layer',
				'label'       => 'Layer Slider',
				'desc'        => 'Instructions are listed above.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => $layersldr_alias
			),
			array(
				'id'          => 'ozy_full_width_slider_alias_cute',
				'label'       => 'Cute Slider',
				'desc'        => 'Instructions are listed above.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => $cutesldr_alias
			),
			array(
				'id'          => 'ozy_full_width_slider_list',
				'label'       => 'Manage slider\'s content here',
				'desc'        => 'Manage your slides here',
				'std'         => '',
				'type'        => 'list-item',
				'class'       => '',
				'choices'     => '',
				'settings'	  => array(
									array(
										'dontmerge' => 'dontmerge', //this parameter will help to not mergin our settings, so we can get rid of the title box. see ot-functions-admin.php around line number 2879
										'id'        => 'image',
										'label'     => __( 'Image', 'option-tree' ),
										'desc'      => '',
										'std'       => '',
										'type'      => 'upload',
										'rows'      => '',
										'class'     => '',
										'post_type' => '',
										'choices'   => array()
								  	),
									array(
										'id'          => 'caption',
										'label'       => __( 'Caption', 'option-tree' ),
										'desc'        => 'Caption text on the slide when available.',
										'std'         => '',
										'type'        => 'text',
										'class'       => '',
										'choices'     => ''
									),
									array(
										'id'          => 'description',
										'label'       => __( 'Description', 'option-tree' ),
										'desc'        => 'Description text on the slide when available.',
										'std'         => '',
										'type'        => 'text',
										'class'       => '',
										'choices'     => ''
									)
								)
			),			
			array(
				'id'          => 'ozy_page_model',
				'label'       => 'Page Model',
				'desc'        => 'Select layout model for this page',
				'std'         => '',//ot_get_option('ic_general_layout_style'),
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"", "label"=>"-leave as is-"), array("value"=>"wide", "label"=>"Boxed"), array("value"=>"full", "label"=>"Wide")),
			),			
			array(
				'id'          => 'ozy_page_clear_container_bg',
				'label'       => 'Clear Container Background (not page body)',
				'desc'        => 'If you are customizing this page, and site wide you are using Boxed page model, and you are going to use Wide page model on this page, better to enable this option. Not required to modify.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"", "label"=>"-leave as is-"), array("value"=>"1", "label"=>"enabled"), array("value"=>"-1", "label"=>"disabled")),
			),			
			array(
				'id'          => 'ozy_page_title_is_enabled',
				'label'       => 'Show Page Title',
				'desc'        => 'Show Page title at the top of the page (below the main navigation menu). Disable for front page layouts.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"1","label"=>"ON"), array("value"=>"-1","label"=>"OFF")),
			),
			array(
				'id'          => 'ozy_generic_super_title',
				'label'       => 'Page Header / Title',
				'desc'        => 'Title over the page\'s content. Leave blank to use post title.',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),				
			array(
				'id'          => 'ozy_page_sub_title_is_enabled',
				'label'       => 'Show Page Header / Sub Title',
				'desc'        => 'Show Page Sub title at the bottom of the title.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),
			array(
				'id'          => 'ozy_page_sub_title',
				'label'       => 'Sub Title',
				'desc'        => 'Page Sub title at the bottom of the title. Leave blank to auto hide or use the option above. Disable for front page layouts.',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),
			array(
				'id'          => 'ozy_generic_layout_options',
				'label'       => 'Layout',
				'desc'        => 'Default layout is No Sidebar, unless changed on Theme Options ',
				'std'         => ( ot_get_option('ic_default_sidebar_layout_page') != '' ? ot_get_option('ic_default_sidebar_layout_page') : '' ),
				'type'        => 'radio-image',
				'class'       => '',
				'choices'     => array()
			),
			array(
				'id'          => 'ozy_generic_sidebars',
				'label'       => 'Sidebar',
				'desc'        => 'This option only available for the layouts which have sidebar(s). Choose nothing to use default one.',
				'std'         => ( ot_get_option('ic_default_sidebar_id_page') !='' ? ot_get_option('ic_default_sidebar_id_page') : '' ),
				'post_type'   => 'ozy_sidebars',
				'type'        => 'custom-post-type-select',
				'class'       => '',
				'choices'     => array()/*,
				'settings'	  => array('-use_slug_instead_of_id-')*/
			),			
			array(
				'id'          => 'ozy_generic_background_is_enabled',
				'label'       => 'Custom Page Background',
				'desc'        => '',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),			
			array(
				'id'          => 'ozy_generic_background_options',
				'label'       => 'Page Background',
				'desc'        => 'You can specify different background options for each page. If enabled predifened/user defined options will be ignored',
				'std'         => '',
				'type'        => 'background',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_is_enabled',
				'label'       => 'Custom Page Header Options',
				'desc'        => '',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),			
			array(
				'id'          => 'ozy_generic_title_options_style',
				'label'       => 'Page Header Style',
				'desc'        => 'Select generic type for your page headings. Fluid / Short styles available.',
				'std'         => (ot_get_option('ic_skin_page_heading_style')),
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"short","label"=>"Short"), array("value"=>"fluid","label"=>"Fluid"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_background',
				'label'       => 'Page Header Background',
				'desc'        => 'You can specify different title background options for each page. If enabled predifened/user defined options will be ignored',
				'std'         => (ot_get_option('ic_skin_page_heading_background')),
				'type'        => 'background',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_use_padding',
				'label'       => 'Page Header Use Padding',
				'desc'        => 'We strongly recommend to use when you set background options.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"yes","label"=>"yes"), array("value"=>"no","label"=>"no"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_margin',
				'label'       => 'Page Header Top - Bottom Margin',
				'desc'        => 'Top and Bottom margin of the title.',
				'std'         => ot_get_option('ic_skin_page_heading_margin'),
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"0","label"=>"0px"), array("value"=>"10","label"=>"10px"), array("value"=>"20","label"=>"20px"), array("value"=>"30","label"=>"30px"), array("value"=>"40","label"=>"40px"), array("value"=>"50","label"=>"50px"), array("value"=>"60","label"=>"60px"), array("value"=>"70","label"=>"70px"), array("value"=>"80","label"=>"80px"), array("value"=>"90","label"=>"90px"), array("value"=>"100","label"=>"100px"), array("value"=>"110","label"=>"110px"), array("value"=>"120","label"=>"120px"), array("value"=>"130","label"=>"130px"), array("value"=>"140","label"=>"140px"), array("value"=>"150","label"=>"150px"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_big_title_font',
				'label'       => 'Page Header Big Title Typography',
				'desc'        => 'Typography options for the title.',
				'std'         => (ot_get_option('ic_skin_page_heading_big_title_font')),
				'type'        => 'typography',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_big_title_background',
				'label'       => 'Page Header Big Title Background Color',
				'desc'        => 'Title background color',
				'std'         => ot_get_option('ic_skin_page_heading_big_title_background'),
				'type'        => 'colorpicker',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_sub_title_font',
				'label'       => 'Page Header Sub Title Typography',
				'desc'        => 'Typography options for the sub title.',
				'std'         => (ot_get_option('ic_skin_page_heading_sub_title_font')),
				'type'        => 'typography',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_sub_title_background',
				'label'       => 'Page Header Sub Title Background Color',
				'desc'        => 'Sub title background color',
				'std'         => ot_get_option('ic_skin_page_heading_sub_title_color'),
				'type'        => 'colorpicker',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_breadcrumbs_enabled',
				'label'       => 'Page Header Bread Crumbs Enabled',
				'desc'        => 'Enable / Disable Bread Crumbs menu',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"yes","label"=>"yes"), array("value"=>"no","label"=>"no"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_breadcrumbs_font',
				'label'       => 'Page Header Bread Crumbs Typography',
				'desc'        => 'Typography options for Bread Crumbs menu.',
				'std'         => (ot_get_option('ic_skin_page_heading_breadcrumbs_font')),
				'type'        => 'typography',
				'class'       => '',
				'choices'     => array()
			)
			
		)
	);
	
	//Post / Portfolio Like & Favorite Options
	$ozy_like_favorite_meta_box = array(
	'id'        => 'ozy_like_favorite_meta_box',
	'title'     => 'Like &amp; Favorites',
	'desc'      => '',
	'pages'     => array( 'post', 'ozy_portfolio' ),
	'context'   => 'normal',
	'priority'  => 'high',
	'fields'    => 
		array(
			array(
				'id'          => 'ozy_post_like_count',
				'label'       => 'Like Count',
				'desc'        => 'Set any startup number to display as "Like Count".',
				'std'         => '0',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),
			array(
				'id'          => 'ozy_post_read_count',
				'label'       => 'Read Count',
				'desc'        => 'Set any startup number to display as "Reading Count".',
				'std'         => '0',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			)						
		)
	);	

	//Clients
	$ozy_clients_meta_box = array(
	'id'        => 'ozy_clients_meta_box',
	'title'     => 'Client Information',
	'desc'      => '',
	'pages'     => array( 'ozy_clients' ),
	'context'   => 'normal',
	'priority'  => 'high',
	'fields'    => 
		array(
			array(
				'id'          => 'ozy_client_short_information',
				'label'       => 'Short Information',
				'desc'        => 'Name or some very short description',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),
			array(
				'id'          => 'ozy_client_url',
				'label'       => 'Client URL',
				'desc'        => 'Website URL or E-Mail (mailto:mail@domain.com)',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			)			
		)
	);
	
	ot_register_meta_box( $ozy_clients_meta_box );	

	ot_register_meta_box( $ozy_page_meta_box );
	
	ot_register_meta_box( $ozy_post_meta_box );	

	ot_register_meta_box( $ozy_like_favorite_meta_box );

	//Portfolio Options	
	$ozy_portfolio_meta_box = array(
	'id'        => 'ozy_portfolio_meta_box',
	'title'     => 'Portfolio Options',
	'desc'      => '',
	'pages'     => array( 'ozy_portfolio' ),
	'context'   => 'normal',
	'priority'  => 'high',
	'fields'    => 
		array(
			array(
				'id'          => 'ozy_page_title_is_enabled',
				'label'       => 'Show Page Title',
				'desc'        => 'Show Page title at the top of the page (below the main navigation menu). Disable for front page layouts.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"1","label"=>"ON"), array("value"=>"-1","label"=>"OFF")),
			),
			array(
				'id'          => 'ozy_generic_super_title',
				'label'       => 'Page Title',
				'desc'        => 'Title over the page\'s content. Leave blank to use post title.',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),		
			array(
				'id'          => 'ozy_page_sub_title_is_enabled',
				'label'       => 'Show Page Sub Title',
				'desc'        => 'Show Page Sub title at the bottom of the title.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),
			array(
				'id'          => 'ozy_page_sub_title',
				'label'       => 'Sub Title',
				'desc'        => 'Page Sub title at the bottom of the title. Leave blank to auto hide or use the option above. Disable for front page layouts.',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),
			array(
				'id'          => '_p_video',
				'label'       => 'Thumbnail Video',
				'desc'        => 'YouTube/Vimeo video url.',
				'std'         => '',
				'type'        => 'text',
				'class'       => '',
				'choices'     => ''
			),
			array(
				'id'          => 'ozy_generic_layout_options',
				'label'       => 'Layout',
				'desc'        => 'Default layout is No Sidebar, unless changed on Theme Options ',
				'std'         => ( ot_get_option('ic_default_sidebar_layout_portfolio') != '' ? ot_get_option('ic_default_sidebar_layout_portfolio') : '' ),
				'type'        => 'radio-image',
				'class'       => '',
				'choices'     => array()
			),
			array(
				'id'          => 'ozy_generic_sidebars',
				'label'       => 'Sidebar',
				'desc'        => 'This option only available for the layouts which have sidebar(s). Choose nothing to use default one.',
				'std'         => ( ot_get_option('ic_default_sidebar_id_portfolio') !='' ? ot_get_option('ic_default_sidebar_id_portfolio') : '' ),
				'post_type'   => 'ozy_sidebars',
				'type'        => 'custom-post-type-select',
				'class'       => '',
				'choices'     => array()
			),
			array(
				'id'          => 'ozy_is_related_posts_enabled',
				'label'       => 'Related Posts ',
				'desc'        => 'Show / Hide Related posts.',
				'std'         => '1',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"1","label"=>"ON"), array("value"=>"-1","label"=>"OFF")),
			),			
			array(
				'id'          => 'ozy_generic_background_is_enabled',
				'label'       => 'Custom Page Background',
				'desc'        => '',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),			
			array(
				'id'          => 'ozy_generic_background_options',
				'label'       => 'Page Background',
				'desc'        => 'You can specify different background options for each page. If enabled predifened/user defined options will be ignored',
				'std'         => '',
				'type'        => 'background',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_is_enabled',
				'label'       => 'Custom Page Header Options',
				'desc'        => '',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"-1","label"=>"OFF"), array("value"=>"1","label"=>"ON")),
			),			
			array(
				'id'          => 'ozy_generic_title_options_style',
				'label'       => 'Page Header Style',
				'desc'        => 'Select generic type for your page headings. Fluid / Short styles available.',
				'std'         => (ot_get_option('ic_skin_page_heading_style')),
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"short","label"=>"Short"), array("value"=>"fluid","label"=>"Fluid"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_background',
				'label'       => 'Page Header Background',
				'desc'        => 'You can specify different title background options for each page. If enabled predifened/user defined options will be ignored',
				'std'         => (ot_get_option('ic_skin_page_heading_background')),
				'type'        => 'background',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_use_padding',
				'label'       => 'Page Header Use Padding',
				'desc'        => 'We strongly recommend to use when you set background options.',
				'std'         => '',
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"yes","label"=>"yes"), array("value"=>"no","label"=>"no"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_margin',
				'label'       => 'Page Header Top - Bottom Margin',
				'desc'        => 'Top and Bottom margin of the title.',
				'std'         => ot_get_option('ic_skin_page_heading_margin'),
				'type'        => 'select',
				'class'       => '',
				'choices'     => array(array("value"=>"0","label"=>"0px"), array("value"=>"10","label"=>"10px"), array("value"=>"20","label"=>"20px"), array("value"=>"30","label"=>"30px"), array("value"=>"40","label"=>"40px"), array("value"=>"50","label"=>"50px"), array("value"=>"60","label"=>"60px"), array("value"=>"70","label"=>"70px"), array("value"=>"80","label"=>"80px"), array("value"=>"90","label"=>"90px"), array("value"=>"100","label"=>"100px"), array("value"=>"110","label"=>"110px"), array("value"=>"120","label"=>"120px"), array("value"=>"130","label"=>"130px"), array("value"=>"140","label"=>"140px"), array("value"=>"150","label"=>"150px"))
			),			
			array(
				'id'          => 'ozy_generic_title_options_big_title_font',
				'label'       => 'Page Header Big Title Typography',
				'desc'        => 'Typography options for the title.',
				'std'         => (ot_get_option('ic_skin_page_heading_big_title_font')),
				'type'        => 'typography',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_big_title_background',
				'label'       => 'Page Header Big Title Background Color',
				'desc'        => 'Title background color',
				'std'         => ot_get_option('ic_skin_page_heading_big_title_background'),
				'type'        => 'colorpicker',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_sub_title_font',
				'label'       => 'Page Header Sub Title Typography',
				'desc'        => 'Typography options for the sub title.',
				'std'         => (ot_get_option('ic_skin_page_heading_sub_title_font')),
				'type'        => 'typography',
				'class'       => '',
				'choices'     => array()
			),			
			array(
				'id'          => 'ozy_generic_title_options_sub_title_background',
				'label'       => 'Page Header Sub Title Background Color',
				'desc'        => 'Sub title background color',
				'std'         => ot_get_option('ic_skin_page_heading_sub_title_color'),
				'type'        => 'colorpicker',
				'class'       => '',
				'choices'     => array()
			)
		)
	);
	
	ot_register_meta_box( $ozy_portfolio_meta_box );
}

function ozy_filter_layout_options( $array, $field_id ) {

  /* only run the filter where the field ID is ozy_blog_layout_options */
  if ( $field_id == 'ozy_generic_layout_options' 
  || $field_id == 'ozy_portfolio_layout_options' 
  || $field_id == 'ic_default_sidebar_layout_page'
  || $field_id == 'ic_default_sidebar_layout_blog'
  || $field_id == 'ic_default_sidebar_layout_portfolio'
  || $field_id == 'ic_skin_sidebar_layout_bbpress' ) {
    $array = array(
      array(
        'value'   => 'left-sidebar',
        'label'   => __( 'Left Sidebar', 'option-tree' ),
        'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
      ),
      array(
        'value'   => 'right-sidebar',
        'label'   => __( 'Right Sidebar', 'option-tree' ),
        'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
      ),
      array(
        'value'   => 'full-sidebar',
        'label'   => __( 'Full Width', 'option-tree' ),
        'src'     => OT_URL . '/assets/images/layout/full-width.png'
      )	  
    );
  }
  
  return $array;
  
}
add_filter( 'ot_radio_images', 'ozy_filter_layout_options', 10, 2 );

?>