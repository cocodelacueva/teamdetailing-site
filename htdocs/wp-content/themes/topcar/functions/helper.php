<?php
	class myHelper{
		
		var $footer_style = '';
		var $footer_script = '';
		var $wpml_current_language = ''; //blank = default language
		var $active_google_fonts = array();
		var $not_google_fonts = array('arial', 'georgia', 'helvetica', 'palatino', 'tahoma', 'times', 'trebuchet', 'trebuchet ms', 'verdana');
		
		function myHelper(){
			//to-do
		}
		
		//http://codingrecipes.com/php-converting-youtube-and-vimeo-links-to-youtube-player-and-vimeo-player
		function ozy_remove_video_links($string) {
			$rules = array(
				'#http://(www\.)?youtube\.com/watch\?v=([^ &\n]+)(&.*?(\n|\s))?#i' => '',
				'#http://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i' => ''
			);
		 
			foreach ($rules as $link => $player)
				$string = preg_replace($link, $player, $string);
		 
			return $string;
		}		
		
		function ozy_is_plugin_active($plugin=null) {
			if( $plugin === null) return false;
			
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			return is_plugin_active($plugin);
		}
		
		function script_wrapper($script="", $add_ready=true, $echo=false) {
			$r = "<script type='text/javascript'>";		
			
			if($add_ready)
				$r.= "jQuery(document).ready(function() {\r\n";

			$r.= $script;

			if($add_ready)
				$r.= "});\r\n";
							
			$r.= "</script>\r\n";
			
			if(!$echo)
				return $r;		
			else
				echo $r;
		}
		
		function style_wrapper($style="", $echo=false) {
			$r = "<style type='text/css'>";

			$r.= $style;
							
			$r.= "</style>\r\n";
			
			if(!$echo)
				return $r;		
			else
				echo $r;
		}
		
		/*
		generates navigation menu < |#| >
		rererance page(s) : http://codex.wordpress.org/Function_Reference/get_previous_post
						  : http://wordpress.org/support/topic/howto-get-link-of-previous-and-next-post-in-category
		*/
		function ozy_post_navigation($current_page_url, $listing_page_meta_id = "ic_blog_listing_page_id", $use_center_button = true) {			
			$listing_page_url = (bool)$use_center_button ? get_permalink( ot_get_option($listing_page_meta_id) ) : "";
			$prev_page_url = isset(get_previous_post(false)->ID) > 0 ?  get_permalink(get_previous_post(false)->ID) : "";
			$next_page_url = isset(get_next_post(false)->ID) ? get_permalink(get_next_post(false)->ID) : "";
			
			$o =  '<div id="post-navigation" class="clearfix">' . PHP_EOL;
			
			if($current_page_url != $prev_page_url && $prev_page_url!='') 
				$o.= '<a href="' . $prev_page_url . '" class="nav-right" title="' . __('Previous', 'ozy_frontend') . '">' . __('Previous', 'ozy_frontend') . '</a>';
			if($listing_page_url != '') 
				$o.= '<a href="' . $listing_page_url . '" class="nav-th" title="' . __('Listing', 'ozy_frontend') . '">' . __('Listing', 'ozy_frontend') . '</a>';
			if($current_page_url != $next_page_url && $next_page_url!='') 
				$o.= '<a href="' . $next_page_url . '" class="nav-left" title="' . __('Next', 'ozy_frontend') . '">' . __('Next', 'ozy_frontend') . '</a>';
			
			$o.= '</div>' . PHP_EOL;
			
			return $o;
		}		

		/*we need to print things on ajax request responses*/
		function get_external_file_for_ajax($file, $type="script", $add_theme_path=true, $echo = true) {
			
			if($add_theme_path) $file =  OZY_BASE_URL . $file;
			
			if($type === "script") {
				$r = '<script type="text/javascript" src="' . $file . '"></script>' . PHP_EOL;

				if($echo)
					echo $r;
				else
					return $r;
					
			}else if($type === "css") {
				$r = '<link rel="stylesheet" href="' . $file . '" />' . PHP_EOL;
				if($echo)
					echo $r;
				else
					return $r;
			}
			
		}		
		
		function get_cat_slug($cat_id) {
			$cat_id = (int) $cat_id;
			$category = &get_category($cat_id);
			return $category->slug;
		}
		
		function get_post_slug($post_id) {
			$post_id = (int) $post_id;
			$post = &get_post($post_id);
			return $post->post_name;
		}
		
		
		function ajaxify_categories($ID) {
			$categories = get_the_category($ID);
			if(!empty($categories)) {

				$v = "";
				foreach ($categories as $cat) {
					echo $v . '<a href="category/' . esc_attr($cat->slug) . '/"  rel="category" data-slug="' . esc_attr($cat->slug) . '">' . $cat->name . '</a>';
					$v = ", ";
				}
			
			}
		}
		
		//returns css class name by given column count. see bootstrap.css
		function get_class_by_column_count( $columnt_count = 4, $read_option = NULL ) {
			
			if((int)$columnt_count === 0 && $read_option != NULL) {
				$column_count = ot_get_option( $read_option );				
				if((int)$column_count <= 0) return "span4";
			}
			
			switch ((int)$column_count) {
				
				case 1:
					return "span12";
					break;
				case 2:
					return "span6";
					break;
				case 3:
					return "span4";
					break;
				case 4:
					return "span3";
					break;
				case 5:
					return "span2";
					break;
				case 6:
					return "span1";
					break;
				default;
					return "span3";
					break;			
			}
		}		
		
		function get_image_attachments($page_ID, $size = "thumbnail") {			
			$r = array();			
			$args = array(
				'order'          => 'ASC',
				'post_type'      => 'attachment',
				'post_parent'    => $page_ID,
				'post_mime_type' => 'image',
				'post_status'    => null,
				'numberposts'    => -1,
			);
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ($attachments as $attachment) {
					$img = wp_get_attachment_image_src($attachment->ID, $size, false);
					array_push($r, $img[0]);//, false));
				}
			}			
			return $r;			
		}		
		
		/*search for string in the array*/
		function stristr_array( $haystack, $needle ) {			
			if ( !is_array( $haystack ) ) {			
				return false;			
			}
			
			foreach ( $haystack as $element ) {
				if ( stristr( $element, $needle ) ) {
					return $element;
				}
			}
		}		

		function activate_google_font($font_name) {
			if(!in_array($font_name, $this->active_google_fonts)) {
				array_push($this->active_google_fonts, $font_name);
			}
		}
		
		/*
		check whether typography option has set or not
		*/
		function is_font_typography_empty($option = array()) {
			if(count($option)<=0) {
				return true;
			}else{
				foreach($option as $key=>$val) {
					if(trim($val) != '') return false;
				}
				return true;
			}
			
			return false;
		}
		
		/*
		simply return font options array from option tree array
		*/
		function get_value_from_array($option = array(), $required = "") {
			if(is_array($option) && count($option) > 0 && $required !== '') {
				if(isset($option[$required])) return $option[$required];
			}
			return "";
		}
			
		/*
		converts font options array into 
		css string block
		*/
		function arr_to_font_style($target_class_name, $arr, $add_into_footer = false, $important = "", $exclude = array(), $extra_style = array(), $line_height_extra = 7 ) {
			if(!is_array($arr)) return "";
			
			$o = $target_class_name . "{\n";
			if( isset($arr["font-color"]) && trim($arr["font-color"]) != "" && (!in_array("font-color", $exclude))) $o .= "color: " . $arr["font-color"] . " $important ; ";
			if( isset($arr["font-family"]) && trim($arr["font-family"] && (!in_array("font-family", $exclude))) != "" ) {
				if(!in_array($arr["font-family"], $this->not_google_fonts)) {

					if($arr["font-family"] === "-customfont-") {
						if(!in_array("-customfont-", $this->active_google_fonts)) {						
						
							$this->activate_google_font("-customfont-");
							
							$o .= 'font-family: "' . ot_get_option("ic_skin_custom_font_name") . '" '. $important . ' ; ';
						}
						$o .= 'font-family: "' . ot_get_option("ic_skin_custom_font_name") . '" '. $important . ' ; ';
					} else {
						$this->activate_google_font($arr["font-family"]);
						$o .= 'font-family: "' . $arr["font-family"] . '" '. $important . ' ; ';
					}
				} else {
					$o .= 'font-family: "' . $arr["font-family"] . '" '. $important . ' ; ';
				}

			}
			
			if( isset($arr["font-size"]) && trim($arr["font-size"]) != "" && (!in_array("font-size", $exclude))) $o .= "font-size: " . $arr["font-size"] . " $important ; ";
			if( isset($arr["font-style"]) && trim($arr["font-style"]) != "" && (!in_array("font-style", $exclude))) $o .= "font-style: " . $arr["font-style"] . " $important ; ";
			if( isset($arr["font-variant"]) && trim($arr["font-variant"]) != "" && (!in_array("font-variant", $exclude))) $o .= "font-variant: " . $arr["font-variant"] . " $important ; ";
			if( isset($arr["font-weight"]) && trim($arr["font-weight"]) != "" && (!in_array("font-weight", $exclude))) $o .= "font-weight: " . $arr["font-weight"] . " $important ; ";
			if( isset($arr["letter-spacing"]) && trim($arr["letter-spacing"]) != "" && (!in_array("letter-spacing", $exclude))) $o .= "letter-spacing: " . $arr["letter-spacing"] . " $important ; ";
			if( isset($arr["line-height"]) && trim($arr["line-height"]) != "" && (!in_array("line-height", $exclude))) 
			{ 
				$o .= "line-height: " . $arr["line-height"] . " $important ; ";
			}
			else if( isset($arr["line-height"]) && trim($arr["line-height"]) === "" && isset($arr["font-size"]) && trim($arr["font-size"]) != "" && (!in_array("line-height", $exclude))) 
			{
				$o .= "line-height: " . ((int)$arr["font-size"]+(int)$line_height_extra) . "px $important ; ";
			}
			if( isset($arr["text-decoration"]) && trim($arr["text-decoration"]) != "" && (!in_array("text-decoration", $exclude))) $o .= "text-decoration: " . $arr["text-decoration"] . " $important ; ";
			if( isset($arr["text-transform"]) && trim($arr["text-transform"]) != "" && (!in_array("text-transform", $exclude))) $o .= "text-transform: " . $arr["text-transform"] . " $important ; ";
			
			foreach($extra_style as $k=>$v) {
				$o .= $k . ":" . $v . ";";
			}
			
			$o.= "}\n";
			
			if($add_into_footer) {
				$this->set_footer_style($o);
			}else{
				return $o;
			}			
		}
		
		/*
		converts background options array into 
		css string block
		*/
		function arr_to_background_style($target_class_name, $arr, $add_into_footer=true, $add_this_too="", $color_opacity="", $cover_sub_item_backgrounds = false, $important = "")
		{
			
			if(!is_array($arr)) return "";
			
			$o = $target_class_name . "{\n";
			if( trim($arr["background-image"]) != "" ) 		$o .= "	background-image: url(" . $arr["background-image"] . ") $important ; \n";
			if( trim($arr["background-repeat"]) != "" ) 	$o .= "	background-repeat: " . $arr["background-repeat"] . " $important ; \n";
			if( trim($arr["background-attachment"]) != "" )	$o .= "	background-attachment: " . $arr["background-attachment"] . " $important ; \n";
			if( trim($arr["background-position"]) != "" ) 	$o .= "	background-position: " . $arr["background-position"] .  "$important ; \n";
			if( trim($arr["background-color"]) != "" )
			{
				if(trim($color_opacity) == "")
				{
					$o .= "	background-color: " . $arr["background-color"] . " $important ; \n";
				}else{
					$bg_color = $this->HexToRGB( $arr["background-color"] ); 
					$o .= "	background-color: rgba(" . $bg_color["r"] . ",". $bg_color["g"] . ",". $bg_color["b"] . "," . ($color_opacity/100) . ") $important ; \n";					
					
					if(ielt9()) {
						$o .= "	*background-color: " . $arr["background-color"] . " $important ; \n"; //css fallback
						$o .= "	background-color: " . $arr["background-color"] . " $important ; \n"; //css fallback
					}
				}
			}
			$o.= $add_this_too;			
			$o.= "}\n";
			
			//Cover background of the items which located in header to make text more visible when background image used for header
			if((int)$cover_sub_item_backgrounds) {
				$o .= $target_class_name . " h1, " . $target_class_name . " li{\n";
				if( trim($arr["background-color"]) != "" )
				{
					if(trim($color_opacity) == "")
					{
						$o .= "	background-color: " . $arr["background-color"] . "; \n";
					}else{
						$bg_color = $this->HexToRGB( $arr["background-color"] ); 
						$o .= "	background-color: rgba(" . $bg_color["r"] . ",". $bg_color["g"] . ",". $bg_color["b"] . "," . ($color_opacity/100) . "); \n";					
						
						if(ielt9()) {
							$o .= "	*background-color: " . $arr["background-color"] . "; \n"; //css fallback
							$o .= "	background-color: " . $arr["background-color"] . "; \n"; //css fallback
						}
					}
				}
				$o .= "}\n";
			}

			
			if($add_into_footer) {
				$this->set_footer_style($o);
			}else{
				return $o;
			}
			
		}
		
		/*
		finds menu by id and returns single level menu structure
		*/
		/*function single_level_menu($menu_name = "top-menu", $menu_id = "top-small-menu") {
			if(has_nav_menu($menu_name)):
				if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
					$menu_arr = wp_get_nav_menu_items( $locations[$menu_name] );
					echo '<ul id="' . $menu_id . '">' . PHP_EOL;

					$this->language_selector_flags();
					
					foreach($menu_arr as $item) {
						echo '<li><a href="' . esc_attr($item->url) . '" ' . ( !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '' ) .'>' . $item->title . '</a></li><li class="pipe">|</li>' . PHP_EOL;
					}
					echo '</ul>'. PHP_EOL;
				}
			endif;
		}*/
		function single_level_menu($menu_name = "top-menu", $menu_id = "top-small-menu") {
			if(has_nav_menu($menu_name)):
				if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
					$menu_arr = wp_get_nav_menu_items( $locations[$menu_name] );
					echo '<ul id="' . $menu_id . '">' . PHP_EOL;

					$this->language_selector_flags();
					
					foreach($menu_arr as $item) {
						$classes = empty( $item->classes ) ? array() : (array) $item->classes;						
						$classes[] = 'top-menu-item-' . $item->ID;
						// icon check. if any class name starting with "icon-" we consider that one as a type icon class
						$ic = 0; $type_icon_class = "";
						foreach ($classes as $c){
							if (strpos($c, 'icon-') > -1){
								unset($classes[$ic]); $type_icon_class = '<i class="' . esc_attr($c) . '">&nbsp;</i>'; break;
							}
							$ic++;
						}						
						
						$class_names = join( ' ', $classes );
						$class_names = ' class="' . esc_attr( $class_names ) . '"';
						
						
						echo '<li ' . $class_names . '><a href="' . esc_attr($item->url) . '" ' . ( !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '' ) .'>' . $type_icon_class . $item->title . '</a></li><li class="pipe">|</li>' . PHP_EOL;
					}
					echo '</ul>'. PHP_EOL;
				}
			endif;
		}		
		
		/*
		check form wpml plugin and build language links if available
		*/
		function language_selector_flags() {
			if(function_exists("icl_get_languages") && defined("ICL_LANGUAGE_CODE")){
				$languages = icl_get_languages('skip_missing=0&orderby=code');
				if(!empty($languages)){
					foreach($languages as $l){
						echo '<li>';
						if($l['country_flag_url']){
							if(!$l['active']) echo '<a href="' . $l['url'] . '">';
							echo '<img src="' . $l['country_flag_url'] . '" height="12" alt="' . $l['language_code'] . '" width="18" />';
							if(!$l['active']) echo '</a>';
						}
						if(!$l['active']) echo '<a href="' . $l['url'] . '">';
						echo icl_disp_language($l['native_name'], '');//, $l['translated_name']);
						if(!$l['active']) echo '</a>';
						echo '</li><li class="pipe">|</li>';
					}
				}
			}
		}
				
		/*puts footer script*/
		function set_footer_script($entry) {
			$this->footer_script .= $entry;
		}
		
		/*puts footer style*/
		function set_footer_style($entry) {
			$this->footer_style .= $entry;
		}
		
		/*html outputs for the scripts*/
		function get_footer_script(){
			if(trim($this->footer_script) != ''):			
				echo '<script type="text/javascript">' . PHP_EOL;
				echo '/* <![CDATA[ */' . PHP_EOL;
				echo $this->footer_script . PHP_EOL;
				echo '/* ]]> */' . PHP_EOL;
				echo '</script>' . PHP_EOL;				
			endif;
		}
		
		/*html output for the styles*/
		function get_footer_style(){
			if(trim($this->footer_style) != ''):			
				echo '<style type="text/css">' . PHP_EOL;
				echo $this->footer_style . PHP_EOL;		
				echo '</style>' . PHP_EOL;
			endif;
		}
		
		function render_google_fonts() {			
			if(!is_array($this->active_google_fonts)) 
				return NULL;
			
			if(($key = array_search('-customfont-', $this->active_google_fonts)) !== false) {
				unset($this->active_google_fonts[$key]);
			}				
			
			global $google_font_extra_parameters;
			$google_font_extra_parameters = ot_get_option("ic_google_font_extra_parameters"); // load extra parameters from theme options
			if(!empty($google_font_extra_parameters)) {
				$google_font_extra_parameters = explode("&", $google_font_extra_parameters);
				foreach($this->active_google_fonts as $key=>$val) {
					$this->active_google_fonts[$key] = $val . $google_font_extra_parameters[0];
				}
				
				if(isset($google_font_extra_parameters[1]) && isset($this->active_google_fonts[count($this->active_google_fonts) - 1]))
					$this->active_google_fonts[count($this->active_google_fonts) - 1] = $this->active_google_fonts[count($this->active_google_fonts) - 1] . "&" . $google_font_extra_parameters[1];
			}
			/*REMOVED : not compatible with PHP 5.2. REPLACED WITH : foreach() block --> array_walk($this->active_google_fonts, function(&$value, $key) { global $google_font_extra_parameters; $value .= $google_font_extra_parameters; });*/
			
			if(count($this->active_google_fonts) > 0)
				printf("<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=%s' type='text/css' />\r\n", str_replace(' ', '+', implode("|", $this->active_google_fonts)));// . $google_font_extra_parameters
				
			$this->active_google_fonts = array();
		}
		
		/*specific date formatter for news slider*/
		function format_date_for_news_slider($d){
			$my_date = explode("-", $d);			
			return 	array($my_date[2] . "/" . $my_date[1], $my_date[0]);
		}

		/*this simple function will tell me if the given path's extension match with extension array*/
		function is_this_image_url($path = "") {
			$img_exts 	= array("png","jpg","jpeg","gif","bmp","tif","ico","cur");
			$path_exts 	= pathinfo($path, PATHINFO_EXTENSION);	
			return in_array(strtolower($path_exts), $img_exts) ? true : false;
		}
		
		function read_meta_data($arr, $key=-1) {
			if($key===-1){
				if(isset($arr[0])) {
					return $arr[0];
				}
			}else{
				if(isset($arr[0][$key])) {
					return $arr[0][$key];
				}
			}
			return NULL;
		}
		
		/*adds zero to begining if given value < 10*/
		function addzero($x){
			if((int)$x<10) return "0".$x;
			return $x;
		}
		
		/*Get the first image from the post*/
		function catch_that_image() {
			global $post, $posts;
			ob_start();
			ob_end_clean();
			if(preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)){
				return $matches[1][0];
			} else {
				return "/images/no-image.png";
			}
		}		
		
		/*Get the first video url from the post*/
		function catch_that_video() {
			global $post, $posts, $more;
			$more = 0;
			ob_start();
			ob_end_clean();
			if(preg_match_all('/<a.+href=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)) {
				return $matches[1][0];
			} else {
				return "";
			}
		}
		
		/*Get the first video url from the post*/
		function catch_that_audio() {
			global $post, $posts, $more;

			$more = 0;
			ob_start();
			ob_end_clean();
			if(preg_match_all('#<audio.*?>([\w\W]*?)<\/audio>#', do_shortcode($post->post_content), $matches)){						
				return $matches[0][0];//[1][0];
			} else {
				return "";
			}
		}
		
		function remove_tag_with_content($html) {
			$html = preg_replace('#<audio.*?>([\w\W]*?)<\/audio>#', '', $html);
			return $html;
		}
		
		/*convert hex into rgb*/
		function HexToRGB($hex) {
			$hex = str_replace("#", "", $hex); //$hex = preg_replace("#", "", $hex); //ereg_replace("#", "", $hex);
			$color = array();
			 
			if(strlen($hex) == 3) {
				$color['r'] = hexdec(substr($hex, 0, 1) . $r);
				$color['g'] = hexdec(substr($hex, 1, 1) . $g);
				$color['b'] = hexdec(substr($hex, 2, 1) . $b);
			}
			else if(strlen($hex) == 6) {
				$color['r'] = hexdec(substr($hex, 0, 2));
				$color['g'] = hexdec(substr($hex, 2, 2));
				$color['b'] = hexdec(substr($hex, 4, 2));
			}
	 
			return $color;
		}
	 
	 	/*convert rgb into hex*/
		function RGBToHex($r, $g, $b) {			
			$hex = "#";
			$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
			$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
			$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
			 
			return $hex;
		}
		
		/*clear line breaks from string*/
		function removeLineBreaks($string) {
			return preg_replace("~[\r\n]~", "",$string);
		}
		
		
		/*
		generates navigation menu < |#| >
		rererance page(s) : http://codex.wordpress.org/Function_Reference/get_previous_post
						  : http://wordpress.org/support/topic/howto-get-link-of-previous-and-next-post-in-category
		*/
		function post_top_navigation($current_page_url, $listing_page_meta_id = "ic_blog_listing_page_id", $use_center_button = true, $extra_class="") {			
			$listing_page_url = (bool)$use_center_button ? get_permalink( ot_get_option($listing_page_meta_id) ) : "";
			$prev_page_url = isset(get_previous_post(false)->ID) > 0 ?  get_permalink(get_previous_post(false)->ID) : "";
			$next_page_url = isset(get_next_post(false)->ID) ? get_permalink(get_next_post(false)->ID) : "";

			echo '<div id="blog-navigation">' . PHP_EOL;

			//left arrow
			if($current_page_url != $next_page_url && $next_page_url!='') {
				echo '<a href="' . $next_page_url . '" class="button-face-negative nav-left ' . $extra_class . '" data-id="' . ((string)get_next_post(false)->ID) . '"><span class="icon-left-open"></span></a>';
			}else{
				echo '<a href="#" class="button-face nav-left disabled"><span class="icon-left-open"></span></a>';
			}

			//middle button
			if($listing_page_url != '') 
				echo '<a href="' . $listing_page_url . '" class="button-face nav-th"><span class="icon-th"></span></a>';

			//right arrow
			if($current_page_url != $prev_page_url && $prev_page_url!='') {
				echo '<a href="' . $prev_page_url . '" class="button-face-negative nav-right ' . $extra_class . '" data-id="' . ((string)get_previous_post(false)->ID) . '"><span class="icon-right-open"></span></a>';
			}else{
				echo '<a href="#" class="button-face nav-right disabled"><span class="icon-right-open"></span></a>';
			}
			
			echo '</div>' . PHP_EOL;
		}
		
		/*process video links inside the string*/
		function video_object_from_url($href, $w="100%", $h="520px", $id="", $class="") {
			if(trim($href) == '') return '';
	
			switch($href){
				case strpos($href, "youtube.com")>-1:
					$url = parse_url($href); $query = array(); parse_str($url["query"], $query);
					return $this->video_object_builder("youtube", $query['v'], $w, $h, $id, $class);
					break;
				case strpos($href, "vimeo.com")>-1:
					$query_arr = explode("vimeo.com/", $href);
					if(!is_array($query_arr) && !count($query_arr)>=1) return '';
					return $this->video_object_builder("vimeo", $query_arr[1], $w, $h, $id, $class);
					break;
			}		
		}
		
		/*turns url into iframe video players*/
		function video_object_builder($type, $video, $w, $h, $id, $class)
		{
			$id_tag_1 = trim($id) != ''? ' id="' . $id . '" ' : '';
			$id_tag_2 = trim($id) != ''? '?api=1&amp;player_id=' . $id : '';

			switch($type){
				case "youtube":
					return '<iframe ' . $id_tag_1 . ' width="' . $w . '" ' . ( $class != '' ? 'class="' . $class . '"' : '' ) . ' height="' . $h . '" src="http://www.youtube.com/embed/' . $video . $id_tag_2 . '?wmode=opaque" frameborder="0" allowfullscreen="true"></iframe>';							
					break;
				case "vimeo":
					return '<iframe ' . $id_tag_1 . ' width="' . $w . '" ' . ( $class != '' ? 'class="' . $class . '"' : '' ) . ' height="' . $h . '" src="http://player.vimeo.com/video/' . $video . $id_tag_2 . '" frameborder="0" webkitAllowFullScreen="true" mozallowfullscreen="true" allowFullScreen="true"></iframe>';							
					break;
			}
		}
		
		/*Language dependent IDs. See : http://wpml.org/documentation/support/creating-multilingual-wordpress-themes/language-dependent-ids/*/
		function lang_page_id($id)
		{
			global $sitepress;
			if(function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
				return icl_object_id($id, 'page', false, $sitepress->get_default_language());
			} else {
				return $id;
			}
		}
		
		/*fullscreen background slideshow*/
		function fullscreen_slide_show($dcheck = true, $type = "")
		{
			$slides = ot_get_option('ic_background_slide_show_slides');
			
			if(!is_array($slides)) return false;
			
			//if selected to display on specific pages
			$visible_on_pages = ot_get_option("ic_background_slide_show_page_ids");
			if((is_array($visible_on_pages) && count($visible_on_pages)>0) && !$dcheck) {
				global $post;
				if(!in_array($this->lang_page_id($post->ID), $visible_on_pages))
					return null;
			} else if(!$dcheck && !$type != "supersized")
				return null;

			wp_register_style('super-sized-css', get_template_directory_uri() . '/scripts/supersized/supersized.css');
			wp_enqueue_style( 'super-sized-css');
			wp_enqueue_script('super-sized', get_template_directory_uri() . '/scripts/supersized/slideshow/js/supersized.3.2.7.min.js', array('jquery'), null, true );
				
			$script = 'jQuery(document).ready(function(){
				jQuery.supersized({
					slideshow : 1, autoplay:1, start_slide:1, stop_loop:0, random:0, slide_interval:' . ((int)get_option_tree('ic_background_slide_show_timer') >= 1 ? (int)get_option_tree('ic_background_slide_show_timer') : '3000') .',transition: ' . ((int)get_option_tree('ic_background_slide_show_effect_timer') >= 0 ? get_option_tree('ic_background_slide_show_effect_timer') : '1') . ', transition_speed:' . ((int)get_option_tree('ic_background_slide_show_transition_speed') >= 1 ? (int)get_option_tree('ic_background_slide_show_transition_speed') : '700') . ',new_window:1, pause_hover:0, keyboard_nav:1, performance:1, image_protect:1,
					min_width : 0,min_height:0,vertical_center:1,horizontal_center:1,fit_always:0,fit_portrait:1,fit_landscape:0,
					slide_links : "blank",thumb_links:0,thumbnail_navigation:0,
					slides : [';
					
						$virgul = "";
						foreach($slides as $slide) 
						{
							$script .= $virgul . "{image:'" . $slide["ic_background_slide_show_slides_slide"] . "', title:'', url:''}";
							$virgul = ",";
						}		
			$script .= '],
					progress_bar : 0,
					mouse_scrub : 0
				});
			});' . PHP_EOL;
					
			$this->set_footer_script($script);

		}
		
		/*fullscreen background video*/
		function fullscreen_video_show($dcheck = true, $type = "")
		{
			//if selected to display on specific pages
			$visible_on_pages = ot_get_option("ic_background_video_page_ids");
			if((is_array($visible_on_pages) && count($visible_on_pages)>0) && !$dcheck) {
				global $post;
				if(!in_array($this->lang_page_id($post->ID), $visible_on_pages))
					return null;
			} else if(!$dcheck && !$type != "video")
				return null;
				
			//mobile device dedection. videos are not getting to be played automatically so better use fallback options to prevent other issues too.
			include_once( OZY_BASE_DIR . 'functions/mobile-detect.php' );
			$mbd = new Mobile_Detect;			
			if($mbd->isMobile()) :
				$tmp_arr = $this->read_meta_data ( get_post_meta($post->ID, 'ozy_generic_background_is_enabled') );
				if(isset($tmp_arr[0])  && (int)$tmp_arr[0] == 1 ) {
					$bg_arr = get_post_meta($post->ID,'ozy_generic_background_options');
					if( isset($bg_arr[0]) ) { 
						$this->set_footer_style( $this->arr_to_background_style("body", $bg_arr[0], false, "", "", "", "!important") );
					}
				}else{
					$this->set_footer_style( "body { background: url(" . ot_get_option("ic_background_video_poster") . ") repeat; }\r\n" );
				}
				return null;
			endif;				
						
			//Is enabled and Are we on the specified page?
			wp_enqueue_script('video-background', get_template_directory_uri() . '/scripts/videobg/videobg.js', array('jquery') );
			
			$script = "
			jQuery(document).ready(function() {
				jQuery('body').prepend('<div id=\"video-background\" class=\"video-background\">');
				jQuery('body').append('</div>');
				jQuery('#video-background').videobackground({
					videoSource: ['" . ot_get_option("ic_background_video_mp4") . "', 
					'" . ot_get_option("ic_background_video_webm") . "', 
					'" . ot_get_option("ic_background_video_ogv") . "'],
					poster: '" . ot_get_option("ic_background_video_poster") . "',
					loop: true,
					resize: false
				});
			});\r\n\t";
					
			$this->set_footer_script($script);
			
			if(ot_get_option("ic_background_video_overlay_pattern") != "-1")
				$this->set_footer_style( "div.video-background>div { position:absolute; width:100%; height:100%; top:0px; left:0px; background:url(" . OZY_BASE_URL ."images/video-pattern.png) repeat fixed !important;	z-index:10; }\r\n" );			
		}
		
		/*fullscreen background video*/
		function fullscreen_youtube_video_show($dcheck = true, $type = "")
		{
			global $post;

			//if selected to display on specific pages
			$visible_on_pages = ot_get_option("ic_youtube_video_background_page_ids");
			if((is_array($visible_on_pages) && count($visible_on_pages)>0) && !$dcheck) {
				if(!in_array($this->lang_page_id($post->ID), $visible_on_pages))
					return null;
			} else if(!$dcheck && !$type != "youtube")
				return null;
			
			//mobile device dedection. videos are not getting to be played automatically so better use fallback options to prevent other issues too.
			include_once( OZY_BASE_DIR . 'functions/mobile-detect.php' );
			$mbd = new Mobile_Detect;			
			if($mbd->isMobile()) :
				$tmp_arr = $this->read_meta_data ( get_post_meta($post->ID, 'ozy_generic_background_is_enabled') );
				if(isset($tmp_arr[0])  && (int)$tmp_arr[0] == 1 ) {
					$bg_arr = get_post_meta($post->ID,'ozy_generic_background_options');
					if( isset($bg_arr[0]) ) { 
						$this->set_footer_style( $this->arr_to_background_style("body", $bg_arr[0], false, "", "", "", "!important") );
					}
				}else{
					$this->set_footer_style( $this->arr_to_background_style("body", ot_get_option("ic_youtube_video_fallback_background"), false, "", "", "", "!important") );
				}
				return null;
			endif;

			if(trim(ot_get_option('ic_youtube_video_background_video_id')) != '') :
			
				wp_enqueue_script('tubular-youtube', OZY_BASE_URL . '/scripts/jquery.tubular.1.0.js', array('jquery') );
				
				$script = "
				jQuery(document).ready(function() {
					jQuery('body').tubular({videoId:'" . trim(ot_get_option('ic_youtube_video_background_video_id')) . "', mute:" . ot_get_option('ic_youtube_video_background_sound'). ", repeat:" . ot_get_option('ic_youtube_video_background_repeat') . ", start:" . ((int)ot_get_option('ic_youtube_video_background_start')) . ", wrapperZIndex:'0'});
				});\n\r\t";
						
				$this->set_footer_script($script);
				
				if(ot_get_option("ic_youtube_video_overlay_pattern") != "-1")
					$this->set_footer_style( "#tubular-shield { background-image: url(" . OZY_BASE_URL ."images/video-pattern.png); background-attachment: fixed; position: fixed !important; }\r\n" );
				
			endif;
		}
		
		/*audio player*/
		function bottom_audio_player() {
			
			//if selected to display on specific pages
			$visible_on_pages = ot_get_option("ic_audio_page_ids");
			if(is_array($visible_on_pages) && count($visible_on_pages)>0) :
				global $post;
				if(!in_array($this->lang_page_id($post->ID), $visible_on_pages))
					return null;
			endif;			
			
			//is audio player enabled?
			if((int)ot_get_option('ic_audio_player_enabled') === -1) return;
			
			$playlist = ot_get_option('ic_audio_playlist');

			//no playlist loaded? that's it! give up!
			if(!is_array($playlist)) return;
						
			wp_enqueue_script('audio-nodebug', get_template_directory_uri() . '/scripts/audio/js/soundmanager2-nodebug-jsmin.js', array('jquery') );
			wp_enqueue_script('audio-fullwidth', get_template_directory_uri() . '/scripts/audio/js/jquery.fullwidthAudioPlayer.min.js', array('jquery') );

			wp_register_style('audio-player-css', get_template_directory_uri().'/scripts/audio/css/jquery.fullwidthAudioPlayer.css');
			wp_enqueue_style( 'audio-player-css');
		
			wp_register_style('audio-playerfull-css', get_template_directory_uri().'/scripts/audio/css/jquery.fullwidthAudioPlayer-responsive.css');
			wp_enqueue_style( 'audio-playerfull-css');

			echo '
			<div id="fap">';
			$meta_counter = 1;
			foreach($playlist as $audio) :
				echo '<a href="' . $audio['ic_audio_sound_file'] . '" title="' . $audio['title'] . '" target="" rel="' . $audio['ic_audio_cover_image'] . '" data-meta="#fap-meta-track' . $meta_counter . '"></a>';
				echo '<span id="fap-meta-track' . $meta_counter . '">' . $audio['ic_audo_meta_info'] . '</span>';
				$meta_counter++;
			endforeach;
			
			echo '
			</div>';

			$script = "
			jQuery(document).ready(function($){
				soundManager.url = '" . get_template_directory_uri() . "/scripts/audio/swf/';
				soundManager.flashVersion = 9;
				soundManager.useHTML5Audio = true;
				soundManager.debugMode = false;			
			
				$('#fap').fullwidthAudioPlayer({
					autoPlay: " . ( ot_get_option("ic_audio_player_auto_play") === "1" ? "true" : "false" ) . ",
					wrapperPosition: '" . ot_get_option("ic_audio_player_enabled") . "',
					wrapperColor: '" . ot_get_option("ic_auido_player_wrapper_color") . "',
					mainColor: '" . ot_get_option("ic_auido_player_main_color") . "',
					strokeColor: '" . ot_get_option("ic_auido_player_stroke_color") . "',
					fillColor: '" . ot_get_option("ic_auido_player_fill_color") . "',
					fillColorHover: '" . ot_get_option("ic_auido_player_fill_color_hover") . "',
					activeTrackColor: '" . ot_get_option("ic_auido_player_fill_color") . "',
					metaColor: '" . ot_get_option("ic_auido_player_meta_color") . "'
				});
			});";
					
			$this->set_footer_script($script);			
		}
		
		/*persistant menu*/
		function persistant_menu()
		{
			//Persistent navigation bar
			$persistant_menu 		= ot_get_option('ic_general_persistent_menu');
			$show_persistant_menu 	= false;
			
			if($persistant_menu === 'yes') 
				$show_persistant_menu = true;
			
			if($persistant_menu === 'yes-desktop') :
				include_once( OZY_BASE_DIR . 'functions/mobile-detect.php' );
				$detect = new Mobile_Detect;
				if (!$detect->isMobile()) $show_persistant_menu = true;
			endif;
			
			global $myhelper;
			
			if($show_persistant_menu) :

				$script = '
					function relocate_persistent_header() {
						var header_bar = jQuery("#menu-wrapper");
						if(header_bar.hasClass("floater-bar")) {
							header_bar.css("left", ((jQuery(window).width() / 2) - header_bar.width() / 2) + "px");
						}else{
							header_bar.css("left", "");
						}
					}
					
					jQuery(document).ready(function($)
					{	
						var $header_top_pos = $("#menu-wrapper").offset().top + 20;   
						function ozy_check_floating_position() {
							if ($(window).scrollTop() > $header_top_pos) {
								$("#menu-wrapper").addClass("floater-bar");
							} else {
								$("#menu-wrapper").removeClass("floater-bar");
							}
							relocate_persistent_header();
						}
						$(window).scroll(function() { ozy_check_floating_position(); });
	
						ozy_check_floating_position();
					});
					
					jQuery(window).resize(function()
					{
						relocate_persistent_header();
					});
				' . PHP_EOL;
				
				$myhelper->set_footer_script($script);

			endif;
		}

	}
?>