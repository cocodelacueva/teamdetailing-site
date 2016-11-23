<?php
	if( (int)$myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_full_width_slider_type') ) !== -1 ) :
		
		$full_slider_alias  = $myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_full_width_slider_alias') );
		
			switch ( $myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_full_width_slider_type') ) ) {
				case "revo":
					$full_slider_alias  = $myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_full_width_slider_alias_revo') );
					if($full_slider_alias) {
						echo do_shortcode("<div id='slideshow' class='wpb_content_element'>[rev_slider $full_slider_alias]</div>");
					}
					break;
				case "layer":
					$full_slider_alias  = $myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_full_width_slider_alias_layer') );
					if($full_slider_alias) {
						echo do_shortcode("<div id='slideshow' class='wpb_content_element'>[layerslider id='$full_slider_alias']</div>");
					}
					break;
				case "cute":
					$full_slider_alias  = $myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_full_width_slider_alias_cute') );
					if($full_slider_alias)
						echo do_shortcode("<div id='slideshow' class='wpb_content_element'>[cuteslider id='$full_slider_alias']</div>");
					break;
				case "shortcode":
					if($full_slider_alias)
						echo do_shortcode($full_slider_alias);
					break;
				case "ios":
					
					wp_enqueue_script('jquery-iosslider', get_template_directory_uri().'/scripts/ios-slider/jquery.iosslider.min.js', array('jquery') );
					wp_enqueue_script('jquery-iosslider-common', get_template_directory_uri().'/scripts/ios-slider/common.js', array('jquery') );
					wp_register_style('jquery-iosslider', get_template_directory_uri().'/scripts/ios-slider/common.css');
					wp_enqueue_style('jquery-iosslider');
					
					$slides = get_post_meta(get_the_ID(), "ozy_full_width_slider_list");
					
					if(isset($slides[0]) && count($slides[0]) > 0) : 

						echo "
						<div class='iosSlider-container'>
							<div class = 'iosSlider'>
								<div class = 'slider'>";

						$first_image_height = ""; $first_image_width = "";
						foreach($slides[0] as $slide) :
							
							if($first_image_height === "") {
								list($width, $height, $type, $attr) = getimagesize( $slide["image"] );										
								$first_image_height = $height;
								$first_image_width = $width;
							}
															
							echo "
									<div class = 'item'>
										<img src='" . $slide["image"] . "' />";
							
							echo "
										<div class='iosSliderOverlayContainer fromright'>";
							
							if($slide["caption"])
								echo "
										<div class='iosSliderCaption'>" . $slide["caption"] . "</div>";

							if($slide["description"])
								echo "
										<div class='iosSliderDescription'>" . $slide["description"] . "</div>";
							
							echo "</div>
							</div>";
						
						endforeach;

						echo "
								</div>
								<div class = 'prevContainer'>
									<div class = 'ios-prev'>Prev slide</div>
								</div>
								<div class = 'nextContainer'>
									<div class = 'ios-next'>Next slide</div>
								</div>
								<div class = 'selectorsBlock'>
									<div class = 'selectors'>";

						$first = "first selected";
						foreach($slides[0] as $slide) :											
							echo "<div class = 'item $first'></div>";
							$first = "";
						endforeach;
						
						echo "
									</div>
								</div>
							</div>
						</div>";							
						
						global $myhelper;
						
						if((int)$first_image_width > 0 && (int)$first_image_height>0)
							$myhelper->set_footer_style( ".iosSlider-container{ padding: 0 0 " . ((int)(($first_image_height / ((int)$first_image_width))*100)) . "% 0; } .iosSlider-container .selectorsBlock .selectors { width: " . (count($slides[0]) * 19) . "px ;}" );

						
					endif;
												
					break;							
			}

	endif;
?>