<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" /> 

<?php
	option_tree_plugin_check();

	facebook_app_key();
?>

<title><?php
	//Yoast SEO Plugin
	if (defined('WPSEO_VERSION')) {
		wp_title('');
	} else {
		//The blog name.
		bloginfo( 'name' );

		//Print the <title> tag based on what is being viewed.
		wp_title( '|', true, 'left' );
	
		//Blog description for the home or front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			echo " | $site_description";
		}
	}
?>
</title>
<?php 
	/*load translation files*/
	load_theme_textdomain('ozy_frontend', get_template_directory() . '/translate'); 
?>
<script type="text/javascript">
	var $WP_ROOT_URL = "<?php echo home_url() ?>";
</script>
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0' />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() ?>/style.css" />
<!--[if IE]>
<style type="text/css">.social-share-buttons-wrapper li span { padding-top:4px; height:24px; } input[type=text].wpcf7-form-control.wpcf7-quiz { width:50% !important; }</style>
<![endif]-->
<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() ?>/css/ltie9.css" />
<![endif]-->
<?php
	global $myhelper;
	$myhelper->persistant_menu();

	option_loader();

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
	
	<?php
		/* Render audio player if available */
		$myhelper->bottom_audio_player();
		
		/* Page / Layout model */
		$ozy_page_model = ""; $layout_model_tmp_arr = get_post_meta(get_the_ID(), 'ozy_page_model'); $ozy_page_model = "";
		if( isset($layout_model_tmp_arr[0]) && trim($layout_model_tmp_arr[0]) != "" ) :
			$ozy_page_model = $layout_model_tmp_arr[0] === "wide" ? "wide" : "full";
		else :
			$ozy_page_model = ot_get_option("ic_general_layout_style") === "wide" ? "wide" : "full";
		endif;

		/*Background Slider / Video Shows*/
		$interactive_bg_type = ot_get_option('ic_site_background_stuff');
		//supersized slide show
		if($interactive_bg_type=='supersized') { $myhelper->fullscreen_slide_show(); }
		//youtube video
		else if($interactive_bg_type=='youtube') { $myhelper->fullscreen_youtube_video_show(); }
		//self hosted video
		else if($interactive_bg_type=='video') { $myhelper->fullscreen_video_show(); }
		//call the functions with the parameter to check single page check
		else{ $myhelper->fullscreen_slide_show(false, $interactive_bg_type); $myhelper->fullscreen_youtube_video_show(false, $interactive_bg_type); $myhelper->fullscreen_video_show(false, $interactive_bg_type); }
   	?>    
    
    <div class="<?php echo $ozy_page_model; ?>_cont" id="container-wrapper">

    <!--header-->
    <header id="first-header">
    
        <div id="header-wrapper-div" class="container">

            <!--logo-->
            <div id="logo" class="cfnt">
                <?php
                $logo 			= ot_get_option('ic_logo_image');
				$logo_retina 	= ot_get_option('ic_logo_image_retina');
                if( $logo ) :
                    echo '<a href="' . home_url() .'">';
					echo '<img src="' . $logo . '" alt="' . get_bloginfo( 'name' ) . '" class="retina" ' . ($logo_retina ? ' data-retina-img="' . $logo_retina . '"' : '') . ' title="' . get_bloginfo( 'name' ) . '"/>';
					echo '</a>';
				else:
					echo '<h1><a href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a></h1>' . PHP_EOL;
					echo '<h2>' . get_bloginfo( 'description' ) . '</h2>' . PHP_EOL;
                endif;
                ?>
            </div>
            <!--/logo-->

            <!--social buttons & small menu-->
            <div id="header-top-menu" class="span6">
            	<div>
				<?php
                    global $myhelper;
	                social_share_search_buttons(); /*call to generate social buttons*/
                    $myhelper->single_level_menu(); /*call to generate simple menu*/
                ?>
            	</div>
            </div>
            <!--/social buttons & small menu-->            
        </div>

		<?php if(function_exists('woo_commerce_top_bar') && ot_get_option('ic_woo_bar_enabled') !== '-1') woo_commerce_top_bar(); ?>
        
    </header>
    <!--/header-->

    <!--top navigation menu-->
	<div id="menu-wrapper" class="navbar navbar-inverse navbar-static-top">
		<div class="navbar-inner">
			<div class="container">
                               
	            <div class="nav-collapse collapse">
					<?php
                        wp_nav_menu( array(
                            'theme_location'=> 'header-menu',
                            'container'		=> false,
                            'depth'			=> 0,
                            'menu_id'		=> 'top_menu',
                            'menu'			=> ( has_nav_menu( 'header-menu' )  ? '' : 'header-menu' ),
                            'menu_class'	=> 'nav',
                            'walker' 		=> new BootstrapNavMenuWalker()
                        ) );
						
						//search box enabled/disabled check
						if(ot_get_option("ic_skin_header_search_box_is_enabled") != "-1") :
                    ?>
                    <form action="<?php echo home_url(); ?>/" id="navbar-search-form" class="pull-right">
                        <div id="navbar-search-wrapper"><input type="text" name="s" data-open="0" placeholder="<?php echo get_search_query() == '' ? __('Search', 'ozy_frontend') : get_search_query() ?>" class="span2"/><span class="icon-search">&nbsp;</span></div>
                    </form>
                    <?php
						endif;
					?>
                </div>
                
            	<!--mobile nav-->
                <div class="select-menu">
                    <a href="#"><i class="icon-reorder"></i>&nbsp;&nbsp;<?php _e("NAVIGATION MENU", "ozy_frontend") ?></a>
                </div>
                <!--/mobile nav-->                
            </div>
		</div>
	</div>
    <!--/top navigation menu-->

    <!--full width slider-->
    <?php 
		if(have_posts() && is_page()) :
			include_once("include/incl.full.width.slider.php");
		endif;
    ?>	
    <!--/full width slider-->

    <div id="body-wrapper">
		<?php include_once('include/incl.page.heading.php'); ?>
        <div class="container">        
 