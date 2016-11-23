/*progresss bar animation*/
jQuery(document).ready(function($) {
	$(".progress-bar>div").each(function(index, element) {
		$(this).animate( { width : ($(this).attr("data-width") + "%") }, 2000, "easeInOutExpo");
	});
});