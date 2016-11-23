<?php		
					echo '<fieldset class="divider"><legend class="cfnt">';
					if ( is_search() ) {
						printf(__('Search results for "%1$s"'), get_search_query());
					} elseif ( is_tag() ) {
						printf(__('Posts tagged "%1$s"'), single_tag_title('', false));
					} elseif ( is_author() ) {
					   	global $author;
					  	$userdata = get_userdata($author);
						printf(__('Articles posted by %1$s'), $userdata->display_name);						
					}
					echo "&nbsp;&nbsp;</legend></fieldset>";
					
					?>
					<?php 
					if (have_posts()) : 
						while (have_posts()) : the_post();
							$is_home_arr = array();
							$is_home_arr = get_post_meta($post->ID, "ic_is_homepage");
							if($is_home_arr[0] != "1"):
					?>                	
                    <div class="post" id="post-<?php the_ID(); ?>">
                    <h5><?php the_title(); ?></h5>
                        <div class="entry">
							<p><a href="<?php the_permalink() ?>"><?php _e('<p>Read the rest of this page &raquo;</p>','ozy_frontend') ?></a></p>							
                            <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:','ozy_frontend').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                        </div>
                    </div>
                    <?php 
							endif;
						endwhile; 
					endif; 
					?>
                    
                	<fieldset class="divider"><legend class="cfnt"><?php _e("Category Archive", "ozy_frontend") ?>&nbsp;&nbsp;</legend></fieldset>
                    <!--category archive-->
                    <ul class="no-style-ul">
                    <?php
                    $catQuery = $wpdb->get_results("SELECT * FROM $wpdb->terms AS wterms INNER JOIN $wpdb->term_taxonomy AS wtaxonomy ON ( wterms.term_id = wtaxonomy.term_id ) WHERE wtaxonomy.taxonomy = 'category' AND wtaxonomy.parent = 0 AND wtaxonomy.count > 0");
                
                    $catCounter = 0;
                
                    foreach ($catQuery as $category) {
                
                        $catLink = get_category_link($category->term_id);
                
                        echo '<li><h5><span class="icon-down-circle2"></span><a href="'.$catLink.'" title="'.$category->name.'">'.$category->name.'</a></h5>';
                            echo '<ul class="page-list-menu">';
                
                            query_posts('cat='.$category->term_id.'&showposts=5');?>
                
                            <?php while (have_posts()) : the_post(); ?>
                                <li><span class="icon-star"></span><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                            <?php endwhile; ?>
                
                                <li><span class="icon-right-dir"></span><a href="<?php echo $catLink; ?>" title="<?php echo $category->name; ?>" class="more-category"><?php _e('More','ozy_frontend') ?> <strong><?php echo $category->name; ?></strong></a></li>
                            </ul>
                        </li>
                        <?php }	?>
                    </ul>