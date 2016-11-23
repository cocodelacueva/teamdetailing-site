<?php
/*
 * My_Custom_Twitter_Widget class
 *
**/
class OzyThemesCustomSocialIconsWidget extends WP_Widget {

    function OzyThemesCustomSocialIconsWidget() {
        $widget_ops = array('classname' => 'widget_my_custom_social_icons_widget', 'description' => __( "Generates selected social icons where its placed.", 'ozy_frontend') );
        $this->WP_Widget('my-custom-social-icons-widget', __('ozythemes.com Social Icons', 'ozy_frontend'), $widget_ops);
        $this->alt_option_name = 'widget_my_custom_social_icons_widget';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
		
        $cache = wp_cache_get('widget_my_social_icons_button_widget', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }
	
        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('', 'ozy_frontend') : $instance['title'], $instance, $this->id_base);
		
		//widget begining
		echo $before_widget;
        
		if ( $title ) 
			echo $before_title . $title . $after_title; 

		echo social_share_search_buttons('above');			

		//widget ending
		echo $after_widget; 		
			
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_my_social_icons_button_widget', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] 		= strip_tags($new_instance['title']);

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_my_custom_social_icons_widget']) )
            delete_option('widget_my_custom_social_icons_widget');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_my_custom_social_icons_widget', 'widget');
    }

    function form( $instance ) {
        $title 		= isset($instance['title']) ? esc_attr($instance['title']) : '';
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ozy_backoffice'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
        <p><?php _e('Generates selected social icons where its placed.', 'ozy_backoffice'); ?></p>
<?php
    }
}


/*
 * My_Custom_Twitter_Widget class
 *
**/
class OzyThemesCustomPageMenuWidget extends WP_Widget {

    function OzyThemesCustomPageMenuWidget() {
        $widget_ops = array('classname' => 'widget_my_custom_menu_widget', 'description' => __( "Page Menu generate a page list with pages which belongs to same grand parent.", 'ozy_frontend') );
        $this->WP_Widget('my-custom-page-menu-widget', __('ozythemes.com Page Menu Widget', 'ozy_frontend'), $widget_ops);
        $this->alt_option_name = 'widget_my_custom_menu_widget';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
		
        $cache = wp_cache_get('widget_my_page_menu_list_widget', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }
	
        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('PAGES', 'ozy_frontend') : $instance['title'], $instance, $this->id_base);
		
		//widget begining
		echo $before_widget;
        
		if ( $title ) 
			echo $before_title . $title . $after_title; 
		
		wp_reset_query();
		
		global $post;
		$ancestors = get_post_ancestors($post->ID);

		if(isset($ancestors) && count($ancestors)>0) {
			
			$grand_parent = is_array($ancestors) ? end($ancestors) : 0; //get grand parent
			echo "<ul class=\"menu\">\n";
			wp_list_pages( array('child_of' => $grand_parent, 'depth' => 0, 'title_li' => '', 'echo' => 1, 'sort_column' => 'menu_order,ID', 'sort_order' => 'ASC', 'link_before' => '<span class="icon-caret-right">&nbsp;</span>') );
			echo "</ul>\n";

		}
		
		//widget ending
		echo $after_widget; 		
		
		wp_reset_postdata();
		
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_my_custom_page_menu_list_widget', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] 		= strip_tags($new_instance['title']);

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_my_custom_page_menu_widget']) )
            delete_option('widget_my_custom_page_menu_widget');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_my_custom_page_menu_list_widget', 'widget');
    }

    function form( $instance ) {
        $title 		= isset($instance['title']) ? esc_attr($instance['title']) : '';
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ozy_backoffice'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
        <p><?php _e('Generate a page list with pages which belongs to same grand parent.', 'ozy_backoffice')?></p>
<?php
    }
}


/*
 * My_Custom_Flickr_Widget class
 *
**/
class OzyThemesCustomFlickrWidget extends WP_Widget {

    function OzyThemesCustomFlickrWidget() {
        $widget_ops = array('classname' => 'widget_my_custom_flickr_widget', 'description' => __( "Flickr feeds from your username", 'ozy_frontend') );
        $this->WP_Widget('my-custom-flickr-widget', __('ozythemes.com Flickr Widget', 'ozy_frontend'), $widget_ops);
        $this->alt_option_name = 'widget_my_custom_flickr_widget';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
		
        $cache = wp_cache_get('widget_my_flickr_list_widget', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }
        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('FLICKR', 'ozy_frontend') : $instance['title'], $instance, $this->id_base);
		
		$user = $instance['user'];		
		if( empty($user) ) $user = "ozythemes";
		
        if ( !$count = (int) $instance['count'] ) { $count = 2; } else if ( $count < 1 ) { $count = 10; } else if ( $count > 15 ) { $count = 10; }	
		
		$display = $instance["display"];
		
		$source = $instance["source"];
		
		$size = $instance["size"];
		
		$layout = $instance["layout"];
		
		$tag = $instance["tag"];
		
		$group = $instance["group"];
		
		$set = $instance["set"];
		
		
		//widget begining
		echo $before_widget;
        
		if ( $title ) 
			echo $before_title . $title . $after_title; 

		//[flickr_badge count="9" display="random" source="user" size="s" user="21251150@N04" layout="h" set="72157622516717030"]
		echo do_shortcode("[flickr_badge count='$count' display='$display' source='$source' size='$size' user='$user' layout='$layout' " . (trim($tag) != "" ? " tag='$tag' " : "") . (trim($tag) != "" ? " group='$group' " : "") . (trim($tag) != "" ? " set='$set' " : "") ."]");

		//widget ending
		echo $after_widget;
		
		global $myhelper;
		$myhelper->set_footer_script( 'jQuery(".flickr-badge-wrapper a img").tipTip({maxWidth: "auto", edgeOffset: 10, defaultPosition: "top", delay: 1});' );
		
        // Reset the global $the_post as this query will have stomped on it
        //wp_reset_postdata();

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_my_custom_flickr_list_widget', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
			
        $instance['title'] 		= strip_tags($new_instance['title']);
        $instance['user'] 		= $new_instance['user'];
        $instance['count'] 		= $new_instance['count'];		
        $instance['display'] 	= $new_instance['display'];		
        $instance['source'] 	= $new_instance['source'];		
        $instance['size'] 		= $new_instance['size'];		
        $instance['layout'] 	= $new_instance['layout'];		
        $instance['tag'] 		= $new_instance['tag'];		
        $instance['group'] 		= $new_instance['group'];		
        $instance['set'] 		= $new_instance['set'];		
														
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_my_custom_flickr_widget']) )
            delete_option('widget_my_custom_flickr_widget');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_my_custom_flickr_list_widget', 'widget');
    }

    function form( $instance ) {
        $title 		= isset($instance['title']) ? esc_attr($instance['title']) : '';
		$user 		= isset($instance['user']) ? esc_attr($instance['user']) : '';
		$display 	= isset($instance['display']) ? esc_attr($instance['display']) : '';
		$source 	= isset($instance['source']) ? esc_attr($instance['source']) : '';
		$size 		= isset($instance['size']) ? esc_attr($instance['size']) : '';
		$layout 	= isset($instance['layout']) ? esc_attr($instance['layout']) : '';
		$tag 		= isset($instance['tag']) ? esc_attr($instance['tag']) : '';
		$group 		= isset($instance['group']) ? esc_attr($instance['group']) : '';		
		$set 		= isset($instance['set']) ? esc_attr($instance['set']) : '';

        if ( !isset($instance['count']) || !$count = (int) $instance['count'] )
            $count = 2;
?>
        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ozy_backoffice'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number Of Items:', 'ozy_backoffice'); ?></label>
        	<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" />
            <em>Integer 1-10</em>
        </p>        
        
        <p>
            <label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Display:', 'ozy_backoffice'); ?></label>
            <select id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>" type="text">
                <option value="random" <?php selected($display, "random", true) ?>>Random</option>
                <option value="latest" <?php selected($display, "latest", true) ?>>Latest</option>
            </select>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('source'); ?>"><?php _e('Source:', 'ozy_backoffice'); ?></label>
            <select id="<?php echo $this->get_field_id('source'); ?>" name="<?php echo $this->get_field_name('source'); ?>" type="text">
                <option value="user" <?php selected($source, "user", true) ?>>User</option>
                <option value="group" <?php selected($source, "group", true) ?>>Group</option>
                <option value="user_set" <?php selected($source, "user_set", true) ?>>User Set</option>
                <option value="all_tag" <?php selected($source, "all_tag", true) ?>>All Tag</option>
            </select>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:', 'ozy_backoffice'); ?></label>
            <select id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text">
                <option value="s" <?php selected($source, "s", true) ?>>Small Square Box</option>
                <option value="t" <?php selected($source, "t", true) ?>>Thumbnail</option>
                <option value="n" <?php selected($source, "n", true) ?>>Medium</option>
            </select>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout:', 'ozy_backoffice'); ?></label>
            <select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" type="text">
                <option value="h" <?php selected($layout, "s", true) ?>>Horizontal</option>
                <option value="v" <?php selected($layout, "t", true) ?>>Vertical</option>
                <option value="x" <?php selected($layout, "n", true) ?>>None</option>
            </select>
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('user'); ?>"><?php _e('User:', 'ozy_backoffice'); ?></label>
	        <input id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo $user; ?>" />
			<em>Available only when source selected as User or User Set. <a href="http://idgettr.com/" target="_blank">Get your Flickr User ID</a></em>
		</p>

        <p>
        	<label for="<?php echo $this->get_field_id('group'); ?>"><?php _e('Group:', 'ozy_backoffice'); ?></label>
	        <input id="<?php echo $this->get_field_id('group'); ?>" name="<?php echo $this->get_field_name('group'); ?>" type="text" value="<?php echo $group; ?>" />
            <em>Available only when source selected as Group</em>
        </p>

        <p>
        	<label for="<?php echo $this->get_field_id('set'); ?>"><?php _e('Set:', 'ozy_backoffice'); ?></label>
        	<input id="<?php echo $this->get_field_id('set'); ?>" name="<?php echo $this->get_field_name('set'); ?>" type="text" value="<?php echo $set; ?>" />
            <em>Available only when source selected as User Set</em>
        </p>

        <p>
        	<label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Tags:', 'ozy_backoffice'); ?></label>
        	<input id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo $tag; ?>" />
        	<em>Available only when source selected as Tag. Seperate easch tag with comma</em>
        </p>
<?php
    }
}


/*
 * My_Custom_Twitter_Widget class
 *
**/
class OzyThemesCustomTwitterWidget extends WP_Widget {

    function OzyThemesCustomTwitterWidget() {
        $widget_ops = array('classname' => 'widget_my_custom_twitter_widget', 'description' => __( "Twitter feeds from your username", 'ozy_frontend') );
        $this->WP_Widget('my-custom-twitter-widget', __('ozythemes.com Twitter Widget', 'ozy_frontend'), $widget_ops);
        $this->alt_option_name = 'widget_my_custom_twitter_widget';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {

		
        $cache = wp_cache_get('widget_my_twitter_list_widget', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('TWITTER', 'ozy_frontend') : $instance['title'], $instance, $this->id_base);
		
		$username = $instance['username'];		
		if( empty($username) )
			$username = "ozythemes";
		
        if ( !$count = (int) $instance['count'] )
            $count = 2;
        else if ( $count < 1 )
            $count = 1;
        else if ( $count > 15 )
            $count = 15;
		else
			$count = 2;
		
		
		//widget begining
		echo $before_widget;
        
		if ( $title ) 
			echo $before_title . $title . $after_title; 
		
		//widget body
		wp_enqueue_script('jquery-twitter', get_template_directory_uri().'/scripts/jquery/jquery.tweet.js', array('jquery') );
		wp_register_style('jquery-twitter-css', get_template_directory_uri().'/css/widget.twitter.css');
		wp_enqueue_style( 'jquery-twitter-css');		
		
		global $myhelper;

		$div_name = 'jqueryTwitterWidget' . rand(100,10000);
	
		echo '<div class="twitter-wrapper ' . $div_name . '">' . PHP_EOL;
		echo '<div id="' . $div_name . '"></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		
		//$script = 'jQuery(document).ready(function(){ JQTWEET.loadTweets("' . $username . '", "' . $count . '", "#' . $div_name . '"); })' . PHP_EOL;

		$script = '      
		jQuery(function($){
			$("#' . $div_name . '").tweet({
			  join_text: "",
			  username: "' . $username . '",
			  avatar_size: 48,
			  count: ' . $count . ',
			  loading_text: "' . __('loading tweets...','ozy_frontend') . '"
			});
      	});' . PHP_EOL;

		$myhelper->set_footer_script( $script );
		
		$myhelper->set_footer_style( "#$div_name ul { list-style:none; margin-left:0px; }\n" );
		//widget body end

		//widget ending
		echo $after_widget; 		
		
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_my_custom_twitter_list_widget', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] 		= strip_tags($new_instance['title']);
        $instance['username'] 	= $new_instance['username'];
        $instance['count'] 		= (int) $new_instance['count'];		
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_my_custom_twitter_widget']) )
            delete_option('widget_my_custom_twitter_widget');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_my_custom_twitter_list_widget', 'widget');
    }

    function form( $instance ) {
        $title 		= isset($instance['title']) ? esc_attr($instance['title']) : '';
		$username 	= isset($instance['username']) ? esc_attr($instance['username']) : '';
        if ( !isset($instance['count']) || !$count = (int) $instance['count'] )
            $count = 2;
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ozy_backoffice'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username:', 'ozy_backoffice'); ?></label>
        <input id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number Of Items:', 'ozy_backoffice'); ?></label>
        <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
<?php
    }
}

/*custom latest post widget*/

/*
 * My_Custom_Recent_Posts widget class
 *
**/
class OzyThemesCustomRecentPosts extends WP_Widget {

    function OzyThemesCustomRecentPosts() {
        $widget_ops = array('classname' => 'widget_my_custom_recent_entries', 'description' => __( "The most recent posts on your site", 'ozy_frontend') );
        $this->WP_Widget('my-custom-recent-posts', __('ozythemes.com Recent Posts', 'ozy_frontend'), $widget_ops);
        $this->alt_option_name = 'widget_my_custom_recent_entries';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
		
		wp_register_style('widget.recent-post-css', get_template_directory_uri().'/css/widget.recent-post.css');
		wp_enqueue_style( 'widget.recent-post-css');		
		
        $cache = wp_cache_get('widget_my_custom_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('RECENT POSTS', 'ozy_frontend') : $instance['title'], $instance, $this->id_base);
        if ( !$number = (int) $instance['number'] )
            $number = 10;
        else if ( $number < 1 )
            $number = 1;
        else if ( $number > 15 )
            $number = 15;

        $r = new WP_Query(array( 'orderby' => 'date', 'order' => 'DESC' , 'showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'post_type' => array('post', 'custom-post-type')));
        if ($r->have_posts()) :
?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <ul class="custom-recent-posts">
        <?php  while ($r->have_posts()) : $r->the_post(); 

				$thumb_image='';
				if ( has_post_thumbnail() ) :
					$thumb_image = get_the_post_thumbnail(get_the_ID() ,array(55,55) );//wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb');
				else:
					$thumb_image = '<img src="'. get_template_directory_uri() . '/images/55x55.png" alt="" />';
				endif;
		?>
        <li>
			<?php echo $thumb_image ?>
            <span>
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
                    <?php if ( get_the_title() ) the_title(); else the_ID(); ?>
                </a>
                <?php
                    /*$words = explode(" ",strip_tags(get_the_content()));
                    $content = implode(" ",array_splice($words,0,10));
                    echo '<p>' . $content .'...</p>';*/
                ?>
                <span class="date clearfix"><?php the_time('F j, Y'); ?></span>
        	</span>
		</li>
        <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
		
		<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_my_custom_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_my_custom_recent_entries']) )
            delete_option('widget_my_custom_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_my_custom_recent_posts', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
            $number = 5;
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ozy_backoffice'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'ozy_backoffice'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
}

/*register custom widgets*/
register_widget( 'OzyThemesCustomSocialIconsWidget' );
register_widget( 'OzyThemesCustomPageMenuWidget' );	
register_widget( 'OzyThemesCustomFlickrWidget' );
register_widget( 'OzyThemesCustomTwitterWidget' );
register_widget( 'OzyThemesCustomRecentPosts' );
?>