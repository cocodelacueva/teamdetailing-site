!function($) {
    $('#wpb-elements-list-modal .select_an_icon').click(function(e) {
        e.preventDefault();
		popupwindow("../wp-content/themes/ewa/scripts/icon-select.html", "Icon Selector", 460, 380);
    });
}(window.jQuery);

jQuery(".type-icon-select-box").live("click", function(e){
	e.preventDefault();
	popupwindow("../wp-content/themes/ewa/scripts/icon-select.html?r=" + jQuery(this).attr("id"), "Icon Selector", 460, 380);
});

function popupwindow(url, title, w, h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}