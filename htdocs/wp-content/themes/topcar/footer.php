            
		</div>
		
	</div>
    
	<?php
    global $myhelper;
	if(ot_get_option("ic_skin_bottom_widget_bar_enabled") === "yes") : 
	?>    
    <!--bottom widget bar-->
    <footer id="bottom-widget-wrapper">
    	<div class="container">
            <div class="row">
                <?php 
                    /* Widgetized sidebar */
                    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("bottom-widgetbar" . $myhelper->wpml_current_language) ) : ?><?php endif; ?>
            </div>
		</div>
    </footer>
    <!--/bottom widget bar-->    
	<?php
	endif;
	?>
    
    <!--footer-->
    <footer id="footer-wrapper">
	    <div class="container">
    	    <div class="row">
        	    <?php 
            	    /* Widgetized sidebar */
                	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("footer-sidebar" . $myhelper->wpml_current_language) ) : ?><?php endif; ?>
	        </div>
    	</div>
    </footer>
    <!--/footer-->

	</div>
    
    <!--back to top button-->
	<div id="backToTop"><?php _e('Back to Top', 'ozy_frontend'); ?></div>
	
	<?php
        /* Render here dynamically creates css & scripts */
        $myhelper->get_footer_style(); 
		
        wp_footer();
    ?>
</body>
</html>