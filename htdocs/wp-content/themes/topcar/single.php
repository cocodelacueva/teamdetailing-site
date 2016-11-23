<?php
	$post = $wp_query->post;
	if(get_post_type( $post->ID ) == 'ozy_portfolio') 
	{
		include(TEMPLATEPATH . '/single_portfolio.php');
	} 
	else if(get_post_type( $post->ID ) == 'ozy_news') 
	{
		include(TEMPLATEPATH . '/single_news.php');
	} 
	else 
	{
		include(TEMPLATEPATH . '/single_blog.php');
	}
?>