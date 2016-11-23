	<?php
	
	global $myhelper;
	
	if(have_posts() && !is_home()) : 

		global $post; 

		global $OZY_WOOCOMMERCE_ENABLED;

		global $ozy_post_id;

		$ozy_post_id = get_the_ID();
		
		if($OZY_WOOCOMMERCE_ENABLED) {
			if(is_shop() || is_product_category()) {
				$ozy_post_id = woocommerce_get_page_id('shop');									
			}
		}

		$current_post_type = get_post_type( get_the_ID() );
		
		$is_bread_crumbs_enabled = "";
		if( (int)$myhelper->read_meta_data ( get_post_meta($ozy_post_id,'ozy_generic_title_options_is_enabled') ) !== -1 )
			$is_bread_crumbs_enabled = (string)$myhelper->read_meta_data ( get_post_meta($ozy_post_id,'ozy_generic_title_options_breadcrumbs_enabled') );

		$is_bread_crumbs_enabled = $is_bread_crumbs_enabled !== "" ? $is_bread_crumbs_enabled : ot_get_option("ic_skin_page_heading_breadcrumbs_enabled");
		
		
		if($current_post_type !== 'product') the_post();

   		//Page Heading
   	 	if( (int)$myhelper->read_meta_data ( get_post_meta($ozy_post_id, 'ozy_page_title_is_enabled') ) !== -1 ) :
			
        	$header_style = "";
			
	       	if( (int)$myhelper->read_meta_data ( get_post_meta($ozy_post_id,'ozy_generic_title_options_is_enabled') ) !== -1 )
            	$header_style = "page-heading-" . (string)$myhelper->read_meta_data ( get_post_meta($ozy_post_id, 'ozy_generic_title_options_style') );
    ?>		
        <!--page heading-->
        <div class="<?php echo trim($header_style) !=='' ? $header_style : ot_get_option("ic_skin_page_heading_style"); ?>" id="page-heading">
            
            <div class="container">
            
                <div class="row">
                    <!--title & subtitle-->
                    <div class="span<?php echo $is_bread_crumbs_enabled === "yes" ? "9" : "12"; ?>">
                        <?php
                            
							if(is_search()) {
								
								echo "<h1>" . __("Search Results", "ozy_frontend") . "</h1>";
							
							} else if (is_category()) { 
							
								echo "<h1>" . __("Archive : Category", "ozy_frontend") . "</h1>";
							
							} else if (is_tag()) { 
							
								echo "<h1>" . __("Archive : Tag", "ozy_frontend") . "</h1>";

							} else if (is_author()) { 
							
								echo "<h1>" . __("Archive : Author", "ozy_frontend") . "</h1>";
								
							} else if (is_day()) { 
							
								echo "<h1>" . __("Archive : Day", "ozy_frontend") . "</h1>";
														
							} else if (is_year()) { 
							
								echo "<h1>" . __("Archive : Year", "ozy_frontend") . "</h1>";
														
							} else if (is_month()) { 
							
								echo "<h1>" . __("Archive : Month", "ozy_frontend") . "</h1>";
								
							} else if (function_exists('is_bbpress') && is_bbpress()) {

								if(function_exists('bbp_forum_title')) { 
									echo "<h1>";
									bbp_forum_title(); 
									echo "</h1>";
								} else {
									echo "<h1>" . __("Forums", "ozy_frontend") . "</h1>";
								}								
														
							} else {
								
								//Title & Sub title
								$title = $myhelper->read_meta_data ( get_post_meta($ozy_post_id, 'ozy_generic_super_title'), -1 );
								echo "<h1>" . ($title ? $title : get_the_title($ozy_post_id)) . "</h1>";
								
								if((int)$myhelper->read_meta_data ( get_post_meta($ozy_post_id, 'ozy_page_sub_title_is_enabled') ) !== -1 ) :
									$sub_title = $myhelper->read_meta_data ( get_post_meta($ozy_post_id, 'ozy_page_sub_title'), -1 );
									if(trim($sub_title) != "") echo "<h2>" . $sub_title . "</h2>";
								endif;
								
							}
                        ?>
                    </div>
                    <!--/title & subtitle-->
                    
                    <?php
					if($current_post_type == 'post' || $current_post_type == 'page') :

    	                if($is_bread_crumbs_enabled === "yes") : 
                    ?>
	                    <!--bread crumbs-->
    	                <div class="span3" id="bread-crumbs-menu">
        	                <?php 
								if (function_exists('wp_bac_breadcrumb')) wp_bac_breadcrumb();
							?>
            	        </div>
                	    <!--/bread crumbs-->
                    <?php 
						endif;

					elseif($current_post_type === 'product'): //woocommerce check
						woocommerce_breadcrumb(); //woocommerce breadcrumb menu
						
					endif; 
					
                    ?>
                </div>
            
            </div>
                
        </div>
        <!--/page heading-->
    <?php
		else:
			$myhelper->set_footer_style( "#body-wrapper { padding-top:40px; }" );
    	endif;
	else:		
		$myhelper->set_footer_style( "#body-wrapper { padding-top:40px; }" );
	endif;
	
	?>