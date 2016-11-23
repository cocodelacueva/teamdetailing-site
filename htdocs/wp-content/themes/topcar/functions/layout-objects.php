<?php

class OzySearchPage{
	
	var $item_count;
	
	var $orderby;
	var $post_status;
	var $order;
	
	function ozySearchPageListing() {
	
		$output = "";
		
		global $myhelper, $wp_query, $paged, $more, $s;
	
		$args = array( 
			'tax_query'			=> '',
			'paged' 			=> $paged, 
			'posts_per_page' 	=> ( (int)$this->item_count <= 0 ? get_option('posts_per_page') : ((int)$this->item_count > 0 ? $this->item_count : 6) ),
			's'					=> $s,
			'wpse18703_title'	=> $s,
			'orderby'			=> ( !empty($this->orderby) ? $this->orderby : 'date' ),
			'post_status'		=> ( !empty($this->post_status) ? $this->post_status : 'publish' ),
			'order'				=> ( !empty($this->order) ? $this->order : 'DESC' )
		);

		$loop = new WP_Query( $args );
		
		$counter = 0;		

		$no_view_more_types = array("quote", "link", "aside");
	
		$script = "";
		
		$output .= '<div class="blog-listing">' . PHP_EOL;
		
		while ( $loop->have_posts() ) : $loop->the_post();
					
			$category = get_the_category();			
			
			$view_more = true;
			
			$more = 0;
						
			$title_top_padding_style = "top-padding-40"; //when posts have no image or gallery we have to add 20px padding to title make it looking good
			
			$output .=  '<article id="post-' . get_the_ID() . '" class="classic-blog-listing-item" data-id="' . get_the_ID() . '">';
			
				$format = get_post_format();
				if ( false === $format )
					$format = 'standard';
				
				$output .= '<div class="post-badge-' . $format . ' highlight-bg"></div>' . PHP_EOL;

				$post_date = get_the_date(ot_get_option("ic_blog_date_format"));
				
				//Blog content part
				$output .= '<div class="blog-details-part">' . PHP_EOL;

					$more = 0;
				
					//Check if we need to add link into title
					if( in_array( get_post_format(), $no_view_more_types)) {
						$output .= '	<h1 class="blog-post-title '.$title_top_padding_style.'">' . get_the_title() .'</h1>';						
					}else{
						$output .= '	<h1 class="blog-post-title '.$title_top_padding_style.'"><a href="' . get_permalink() . '">' . get_the_title() .'</a></h1>';				
					}
										
					//Posted On Dates & Category
					$output .= '<div class="blog-info-bar-details"><span>' . __('POSTED ON', 'ozy_frontend') . '</span>&nbsp;' . $post_date . '</div>' . PHP_EOL;					
					
					$output .= strip_shortcodes( get_the_content( __('', 'ozy_frontend') ) ); 
					
					//Read More & Like Buttons
					$output .= '<div class="blog-info-footer-bar">' . PHP_EOL;
					
						//Are you sure we need to show read more button?
						if( !in_array( get_post_format(), $no_view_more_types) ) {
							$output .=  '<a href="' . get_permalink() . '" class="wpb_button_a"><span class="wpb_button wpb_ozy_auto wpb_regularsize">' . __('READ MORE &rarr;', 'ozy_frontend') . '</span></a>' . PHP_EOL;
						}
						
					$output .= '</div>' . PHP_EOL;
									
				$output .= '</div>' . PHP_EOL;
				
			$output .= '</article>' . PHP_EOL;
				
			$counter++;
	
		endwhile;

		$output .= '</div>' . PHP_EOL;

		//call pagination
		$wp_query = null; $wp_query = $loop;		
		
		//render the pagination when available
		$output .= get_pagination('<div class="paging-wrapper blog-paging-wrapper">','</div>');
		
		return $output;
	}

}

class OzyBlog{
	
	var $item_count;
	var $category_name;
	var $tag;
	var $author;
	
	var $orderby;
	var $post_status;
	var $order;
	
	function blogListingClassic() {
	
		$output = "";
		
		global $myhelper, $wp_query, $paged, $more, $cat, $tag, $author, $monthnum, $year, $day;
		
		$args = array( 
			'tax_query'			=> '',
			'year'				=> isset($year) ? $year : '',
			'monthnum'			=> isset($monthnum) ? $monthnum: '',
			'day'				=> isset($day) ? $day: '',				
			'paged' 			=> $paged, 
			'posts_per_page' 	=> ( (int)$this->item_count <= 0 ? get_option("posts_per_page") : ((int)$this->item_count > 0 ? $this->item_count : 6) ),
			'tag' 				=> ( !empty($this->tag) ? $this->tag : $tag ),
			'author_name'		=> ( !empty($this->author) ? $this->author : NULL ),
			'category_name'		=> ( !empty($this->category_name) ? $this->category_name : NULL ),
			'cat'				=> $cat,
			'author'			=> $author,
			'orderby'			=> ( !empty($this->orderby) ? $this->orderby : 'date' ),
			'post_status'		=> ( !empty($this->post_status) ? $this->post_status : 'publish' ),
			'order'				=> ( !empty($this->order) ? $this->order : 'DESC' )
		);

		$loop = new WP_Query( $args );
		
		$counter = 0;		

		$no_view_more_types = array("quote", "link", "aside");
	
		$script = "";
		
		$output .= '<div class="blog-listing">' . PHP_EOL;
		
		while ( $loop->have_posts() ) : $loop->the_post();

			$more = 0;
		
			ob_start();
			the_content('');
			$content =  ob_get_clean();

			$category = get_the_category();			
			
			$view_more = true;
			
			$video = "";
			
			$title_top_padding_style = ""; //when posts have no image or gallery we have to add 20px padding to title make it looking good
			
			$the_post_classes = get_post_class( 'classic-blog-listing-item' );
			$the_post_class_string = '';
			foreach( $the_post_classes as $post_class ) {
				$the_post_class_string .= $post_class . ' ';
			}
			
			$output .=  '<article id="post-' . get_the_ID() . '" class="' . $the_post_class_string . '" data-id="' . get_the_ID() . '">';
			
				$format = get_post_format();
				if ( false === $format )
					$format = 'standard';
					
				if( is_sticky() )
					$format = 'sticky';
				
				$output .=  '<div class="post-badge-' . $format . ' highlight-bg"></div>' . PHP_EOL;
	
				switch($format) {
					
					case "video":
						$video = $myhelper->video_object_from_url($myhelper->catch_that_video(), "100%", "420px", "", "");

						if($video != '') $output .=  $video; 

						$title_top_padding_style = ""; //top-padding-40

						break;

					case "gallery":

						$img_ids = array(); $img_ids_str = "";
						$gallery_arr = get_children( array('post_parent' => get_the_ID(), 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
						foreach ($gallery_arr as $item)
							array_push($img_ids, $item->ID);

						$img_ids_str = implode(",", $img_ids);

						$output .= do_shortcode('[vc_gallery type="flexslider_fade" interval="10" onclick="link_image" img_size="post-thumb" images="' . $img_ids_str . '" custom_links_target="_self" el_position="first last"]');
						break;
						
					default:						
						//$thumb_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb-short'); //thumb image by featured image
						$large_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb'); //large image by featured image						
						if(is_array($large_image) && count($large_image) > 0) {
							$output .=  '<div class="blog-big-photo">' . PHP_EOL;
							$output .=  '	<a href="' . $large_image[0] . '" title="' . get_the_title() . '" class="prettyphoto" rel="prettyPhoto">' . PHP_EOL;
							$output .=  '		<img src="' . $large_image[0] . '" width="100%" alt="" class="blog-featured-big-photo" />' . PHP_EOL;
							$output .=  '		<span><div class="generic-button icon-zoom-in"></div></span>' . PHP_EOL;
							$output .=  '	</a>' . PHP_EOL;
							$output .=  '</div>' . PHP_EOL;
						}else{
							$title_top_padding_style = "top-padding-40";
						}
						break;
				}
				
				//Get Like Count, Read Count, Comment Count and Post Date						
				$like_count = (int)$myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_post_like_count') );
				$read_count = (int)$myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_post_read_count') );
				$comment_count = get_comments_number();
				$post_date = get_the_date(ot_get_option("ic_blog_date_format"));
				
				//Specific treat for some post formats
				if( $format === 'quote' || $format === 'aside') {
					$output .=  '<blockquote class="blog-blockquote">' . $content . '</blockquote>' . PHP_EOL;
					$title_top_padding_style = "";
				}
				
				//Blog content part
				$output .= '<div class="blog-details-part">' . PHP_EOL;
				
					//Check if we need to add link into title
					if( in_array( get_post_format(), $no_view_more_types)) {
						$more = 1;
						$output .= '	<h1 class="blog-post-title ' . $title_top_padding_style . '">' . get_the_title() .'</h1>';
					}else{
						$output .= '	<h1 class="blog-post-title ' . $title_top_padding_style . '"><a href="' . get_permalink() . '">' . get_the_title() .'</a></h1>';
					}
						
					//Posted On Dates & Category
					$output .= '<div class="blog-info-bar-details"><span>' . __('POSTED ON', 'ozy_frontend') . '</span>&nbsp;' . $post_date;
						$output .=  '&nbsp;<span>' . __(' - POSTED IN', 'ozy_frontend') . '</span>&nbsp;';
						//$output .= get_the_category(', ');
						$categories = get_the_category();
						$separator = ', '; $output_temp = '';
						if($categories) {
							foreach($categories as $category) {
								$output_temp .= '<a href="'.get_category_link($category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "ozy_frontend" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
							}
							$output .= trim($output_temp, $separator);
						}						

					$output .= '</div>' . PHP_EOL;					
					
					//Specific treat for some post formats
					if( $format !== 'quote' && $format !== 'aside')
						$output .= $content;
						
					//Read More & Like Buttons
					$output .= '<div class="blog-info-footer-bar">' . PHP_EOL;
					
						//Are you sure we need to show read more button?
						if( !in_array( get_post_format(), $no_view_more_types)) {
							$output .=  '<a href="' . get_permalink() . '" class="wpb_button_a"><span class="generic-button wpb_button wpb_ozy_auto">' . __('READ MORE &rarr;', 'ozy_frontend') . '</span></a>&nbsp;&nbsp;' . PHP_EOL;
							
							$output .= '<span class="icon-comments">&nbsp;</span><span>' . $comment_count . '</span>&nbsp;&nbsp;';
							
							$output .= '<span class="icon-eye-open">&nbsp;</span><span>' . $read_count . '</span>&nbsp;&nbsp;';
						}
						$output .= '<span class="icon-heart" id="' . get_the_ID() . '">&nbsp;</span><span>' . $like_count . '</span>';
						
					$output .= '</div>' . PHP_EOL;
									
				$output .= '</div>' . PHP_EOL;
				
			$output .= '</article>' . PHP_EOL;
				
			$counter++;
	
		endwhile;

		$output .= '</div>' . PHP_EOL;

		//call pagination
		$wp_query = null; $wp_query = $loop;		
		
		//render the pagination when available
		$output .= get_pagination('<div class="paging-wrapper blog-paging-wrapper">','</div>');
		
		//The following lines usually called by visual composer but none of them are used here, 
		wp_register_style( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js_composer/prettyphoto/css/prettyPhoto.css' );
		wp_enqueue_style( 'prettyphoto');
		wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'));
		wp_enqueue_script( 'wpb_composer_front_js', get_template_directory_uri() . '/vc/js_composer/assets/js_composer_front.js', array('jquery'));		
		
		return $output;
	}


	function blogListingLatest() {
	
		$output = "";
		
		global $myhelper, $wp_query, $paged, $more, $cat, $tag, $author;
	
		$args = array( 
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array('post-format-quote', 'post-format-aside'),
					'operator' => 'NOT IN'
				)
			),
			'post_type'			=> 'post',
			'paged' 			=> $paged, 
			'posts_per_page' 	=> ( (int)$this->item_count <= 0 ? get_option("posts_per_page") : ((int)$this->item_count > 0 ? $this->item_count : 6) ),
			'tag' 				=> ( !empty($this->tag) ? $this->tag : $tag ),
			'author_name'		=> ( !empty($this->author) ? $this->author : NULL ),
			'category_name'		=> ( !empty($this->category_name) ? $this->category_name : NULL ),
			'cat'				=> $cat,
			'author'			=> $author,
			'orderby'			=> ( !empty($this->orderby) ? $this->orderby : 'date' ),
			'post_status'		=> ( !empty($this->post_status) ? $this->post_status : 'publish' ),
			'order'				=> ( !empty($this->order) ? $this->order : 'DESC' )
		);

		$loop = new WP_Query( $args );
		
		$counter = 0;		

		$script = "";
		
		$output .= '<ul class="blog-listing-latest">' . PHP_EOL;
		
		while ( $loop->have_posts() ) : $loop->the_post();
		
			$output .= '<li>';
			
			$output .= '<div class="box-date"><span class="d">' . get_the_date('d') .'</span><span class="m">' . get_the_date('M') .'</span></div>' . PHP_EOL;

			$output .= '<div class="box-wrapper">' . PHP_EOL;
			
			$output .= '<h4>' . get_the_title() . '</h4>' . PHP_EOL; //<i class="icon-bell-alt"></i>&nbsp;
			
			$output .= '<div class="info-bar">(' . strip_tags(get_the_category_list(', ')) . ')&nbsp;';
			
			//get_comments_number returns only a numeric value
			$num_comments = get_comments_number(); 
			if ( comments_open() ) {
				if ( $num_comments == 0 ) {
					$comments = __('No Comments', 'ozy_frontend');
				} elseif ( $num_comments > 1 ) {
					$comments = $num_comments . __(' Comments', 'ozy_frontend');
				} else {
					$comments = __('1 Comment', 'ozy_frontend');
				}
				$output .= $comments;
			}
			
			$output .= '</div>' . PHP_EOL;

			$output .= $this->the_excerpt_max_charlength(130) . '&nbsp;&nbsp;<a href="' . get_permalink() . '">' . __('Read More &rarr;', 'ozy_frontend') . '</a>' . PHP_EOL;

			$output .= '</div>' . PHP_EOL;
			
			$output .= '</li>' . PHP_EOL;
			
		endwhile;

		$output .= '</ul>' . PHP_EOL;

		return $output;
	}

	function the_excerpt_max_charlength($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;
		$r = "";
		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				$r.= mb_substr( $subex, 0, $excut );
			} else {
				$r.= $subex;
			}
			$r.= '[...]';
		} else {
			$r.= $excerpt;
		}
		
		return $r;		
	}
}


?>