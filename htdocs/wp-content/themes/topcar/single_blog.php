<?php
get_header(); 
	
//The following lines usually called by visual composer but none of them are used here, 
wp_register_style( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js_composer/prettyphoto/css/prettyPhoto.css' );
wp_enqueue_style( 'prettyphoto');
wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/vc/js_composer/assets/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'));
wp_enqueue_script( 'wpb_composer_front_js', get_template_directory_uri() . '/vc/js_composer/assets/js_composer_front.js', array('jquery'));

global $post, $myhelper;

$SIDE_BAR_ID 	= $myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_generic_sidebars'));
$SIDE_BAR_TYPE 	= $myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_generic_layout_options'));

//is sidebar active on this page?
$is_sidebar_active = is_sidebar_active($SIDE_BAR_ID, $SIDE_BAR_TYPE);	
	
global $more; // Declare global $more (before the loop).
	
read_count_process(get_the_ID()); //post read counter +1

?>
    <div class="container">

    	<div class="row">
    	
        <?php
		if($is_sidebar_active === "true") {
			echo '<div class="span8 ozy-page-content' . ( $SIDE_BAR_TYPE === 'left-sidebar' ? ' pull-right' : '' ) . '">' . PHP_EOL;
		}else{
			echo '<div class="span12 ozy-page-content">' . PHP_EOL;
		}
		?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
          
            <?php
				
				$title_extra_class = "alone";
				
                switch(get_post_format()) {
                    
                    case "video":
                        $video = $myhelper->video_object_from_url($myhelper->catch_that_video(), "100%", "480px","","");
                        if($video != '')
                            echo $video;
                        
						$title_extra_class = "";
                        break;
						                
                    case "gallery":
						$img_ids = array(); $img_ids_str = "";
						$gallery_arr = get_children( array('post_parent' => get_the_ID(), 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
						foreach ($gallery_arr as $item)
							array_push($img_ids, $item->ID);
						
						$img_ids_str = implode(",", $img_ids);
						
						echo do_shortcode('[vc_gallery type="flexslider_fade" interval="10" onclick="link_image" img_size="post-thumb" images="' . $img_ids_str . '" custom_links_target="_self" el_position="first last"]');                        
						$title_extra_class = "";
                        break;						
                
                    default:
                        $thumb_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); //thumb image by featured image
                        $large_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); //large image by featured image
                        if(is_array($thumb_image) && count($thumb_image) > 0) {
                            echo '<div class="blog-big-photo">' . PHP_EOL;
                            echo '	<a href="' . $large_image[0] . '" title="' . get_the_title() . '" class="prettyphoto" rel="prettyPhoto">' . PHP_EOL;
                            echo '		<img src="' . $thumb_image[0] . '" width="100%" alt="" class="blog-featured-big-photo" />' . PHP_EOL;
                            echo '		<span><div class="generic-button icon-zoom-in"></div></span>' . PHP_EOL;
                            echo '	</a>' . PHP_EOL;
                            echo '</div>' . PHP_EOL;
							
							$title_extra_class = "";
                        }
						
                        break;
                }
	
                $more = 1;
                                                
                $like_count = (int)$myhelper->read_meta_data ( get_post_meta(get_the_ID(),'ozy_post_like_count') );
                $comment_count = get_comments_number();
                $post_date = get_the_date(ot_get_option("ic_blog_date_format"));
                
                echo '<div class="blog-info-bar-details">';
                echo 	'<span class="post-date">' . $post_date . '</span>';
                echo 	'<span>&nbsp;&nbsp;' . __('by ','ozy_frontend');
                the_author_posts_link();
                echo 	'</span>';
                echo 	'&nbsp;&nbsp;<span class="icon-comment">&nbsp;</span>' . $comment_count . '&nbsp;&nbsp;';
                echo 	'<span class="icon-heart" id="' . get_the_ID() . '">&nbsp;</span><span>' . $like_count . '</span>';
                echo '</div>' . PHP_EOL;
                
				//get content
                the_content(''); 
				
            ?>      

            <div class="tag-bar icon-tag"><?php the_tags('',', '); ?></div>
        
        </article>
        
        <?php
			//related posts
			if((int)$myhelper->read_meta_data ( get_post_meta(get_the_ID(), 'ozy_is_related_posts_enabled')) !== -1)
				get_template_part("include/incl.related.posts");
		?>
       
        <!--the author-->
        <?php                    
        // If a user has filled out their decscription show a bio on their entries
        if ( get_the_author_meta('description') ) : 
        ?>
        <h2 id="authort-box-title"><?php _e('About The Author', 'ozy_frontend') ?></h2>

        <section class="author-box">
            <div>
                <?php echo get_avatar( get_the_author_meta('ID'), 88 ); ?>                                
                <p>
                    <?php echo get_the_author_meta('description'); ?>
                    <br />
                    <span><?php _e('View all posts by ', 'ozy_frontend'); the_author_posts_link(); ?></span>
                </p>
            </div>
        </section>

        <!--/the author-->           
    	<?php		
			wp_reset_query();
		endif;	
		
		//Comment Form
		if(ot_get_option('ic_facebook_comment_enabled') === '1') {
		?>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/<?php echo ot_get_option('ic_facebook_comment_default_lang'); ?>/all.js#xfbml=1&appId=<?php echo ot_get_option('ic_facebook_app_id'); ?>";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <h2 id="comments-title"><fb:comments-count href=http://example.com/></fb:comments-count> <?php _e('thoughts on this post', 'ozy_frontend'); ?></h2>
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="1170" data-num-posts="<?php echo ot_get_option('ic_facebook_comment_post_count'); ?>" data-colorscheme="<?php echo ot_get_option('ic_facebook_comment_color_scheme'); ?>"></div>            
		<?php
		} else {
			global $withcomments;
			$withcomments = true;
			comments_template();
		}

		echo '</div>' . PHP_EOL;

		if($is_sidebar_active === "true")
			sidebar_render($SIDE_BAR_TYPE, $SIDE_BAR_ID);			
	
	?>
    	</div>
    </div>
<?php
get_footer(); 	
?>