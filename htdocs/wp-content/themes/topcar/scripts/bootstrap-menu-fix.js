jQuery(window).load(function() {
	//this small piece of code will make top level menu items clickable	
	jQuery("#top_menu li.dropdown > a").click(function(e) {
        e.preventDefault();
		window.location = jQuery(this).attr("href");
    });
});