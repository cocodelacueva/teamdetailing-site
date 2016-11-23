jQuery(document).ready(function($) {

	jQuery("label[for='ozy_full_width_slider_list']").parents("div.format-settings").hide();

	pickWpImageButtons();
	
	checkMetaBoxStates();
	
	/*option tree menu re styled*/
	jQuery("a[href^='#section_ic_skin']").each(function(index, element) {
		jQuery(this).html( jQuery(this).html().replace("Skin - ", "") );
		jQuery(this).parent().addClass("skin-menu");
    });
	
	var obj = jQuery("a[href^='#section_ic_skin']:first");
	var skin_index = obj.parent().index();
	obj.parent().parent().find("li:eq("+skin_index+")").before("<li id='tab_skin_options'><a href='#' onclick='void(0);'>Skin Options</a></li>");
	
	/*this will add click and select option to menu item classes*/
	jQuery(document).find('input.edit-menu-item-classes').live('click', function(e) {
		e.preventDefault();
		ozyPopupwindow("../wp-content/themes/ewa/scripts/icon-select.html?r=" + jQuery(this).attr("id"), "Icon Selector", 460, 380);
    });
});

function ozyPopupwindow(url, title, w, h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function checkMetaBoxStates() {
	objVisibilityChanger("#ozy_page_title_is_enabled", "ozy_generic_super_title");
	objVisibilityChanger("#ozy_page_sub_title_is_enabled", "ozy_page_sub_title");
	
	objVisibilityChanger("#ozy_generic_background_is_enabled", "ozy_generic_background_options");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_background");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_use_padding");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_margin");	
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_big_title_font");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_big_title_background");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_sub_title_font");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_sub_title_background");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_breadcrumbs_enabled");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_breadcrumbs_font");
	objVisibilityChanger("#ozy_generic_title_options_is_enabled", "ozy_generic_title_options_style");
	
	//objVisibilityChanger("#ozy_full_width_slider_type", "#ozy_full_width_slider_alias");
	
	jQuery("#ozy_full_width_slider_type").change(function(e) {
		var _val = jQuery(this).val();
		
		jQuery("#ozy_full_width_slider_alias_revo, #ozy_full_width_slider_alias_layer, #ozy_full_width_slider_alias_cute, #ozy_full_width_slider_alias").parent().parent().parent().parent().hide();
		
		jQuery("#ozy_full_width_slider_alias_shortcode").parent().parent().parent().hide();		
		
		jQuery("label[for='ozy_full_width_slider_list']").parents("div.format-settings").hide();
		
		switch(_val) {
			case "revo":
				jQuery("#ozy_full_width_slider_alias_revo").parent().parent().parent().parent().show();
				break;
			case "layer":
				jQuery("#ozy_full_width_slider_alias_layer").parent().parent().parent().parent().show();
				break;
			case "cute":
				jQuery("#ozy_full_width_slider_alias_cute").parent().parent().parent().parent().show();
				break;
			case "shortcode":
				jQuery("#ozy_full_width_slider_alias_shortcode").parent().parent().parent().show();
				break;				
			/*case "nivo":
				jQuery("label[for='ozy_full_width_slider_list']").parents("div.format-settings").show();
				break;
			case "flex":
				jQuery("label[for='ozy_full_width_slider_list']").parents("div.format-settings").show();
				break;*/
			case "ios":
				jQuery("label[for='ozy_full_width_slider_list']").parents("div.format-settings").show();
				break;				
		}
		
	}).change();
}

function objVisibilityChanger2(obj1, obj2, level, expected_value) {
	jQuery(obj1).change(function(e) {
		var t = jQuery(obj2).parent().parent().parent();
		if(level==4) t = t.parent(); //background panels are deeper
		if(level==5) t = t.parent().parent(); //background panels are deeper
        if( !jQuery.inArray( jQuery(this).val(), expected_value ) ) {
			t.hide();
		}else{
			t.show();
		}
		
		if(obj1 === "#ozy_full_width_slider_type") {
			if(jQuery.inArray( jQuery(this).val(), custom_sliders )) {
				t.hide();				
				jQuery("label[for='ozy_full_width_slider_list']").parents("div.format-settings").show();
			}else{
				jQuery("label[for='ozy_full_width_slider_list']").parents("div.format-settings").hide();
			}
		}
		
    }).change();	
}

function objVisibilityChanger(obj1, obj2, level) {
	jQuery(obj1).change(function(e) {
		var t = jQuery("label[for='" + obj2 + "']").parents("div.format-settings"); //jQuery(obj2).parent().parent().parent();
		//if(level==4) t = t.parent(); //background panels are deeper
		//if(level==5) t = t.parent().parent(); //background panels are deeper
        if(jQuery(this).val() == "-1") {
			t.hide();
		}else{
			t.show();
		}		
		/*var t = jQuery(obj2).parent().parent().parent();
		if(level==4) t = t.parent(); //background panels are deeper
		if(level==5) t = t.parent().parent(); //background panels are deeper
        if(jQuery(this).val() == "-1") {
			t.hide();
		}else{
			t.show();
		}*/		
    }).change();	
}


function pickWpImageButtons(){

	jQuery(".pick_wp_image").each(function(index, element) {		
		jQuery(this).click(function(){	
	
			var storeSendToEditor = window.send_to_editor; //store current function
		
			window.send_to_editor = function(html) { var imgurl = jQuery('img',html).attr('src');imgurl = (typeof(imgurl)==='undefined'?jQuery(html).attr('href'):imgurl) ; try{ jQuery("#"+formfield+"_img").attr("src",imgurl) ; jQuery("#"+formfield+".use-this-one-with-id").val(imgurl); }catch(e){}finally{ window.send_to_editor = storeSendToEditor; /*restore current function*/ }; tb_remove();}			
			
			formfield = jQuery(this).attr("data-target");			
			tb_show('', 'media-upload.php?type=file&TB_iframe=true');  
			return false; 
		});		        
    });
	
	jQuery(".remove_wp_image").each(function(index, element) {		
		jQuery(this).click(function(){			
			var fld = jQuery(this).attr("data-target");
			jQuery("#"+fld+".use-this-one-with-id").val('');
			jQuery("#"+fld+"_img").attr('src','');	
			return false; 			
		});		        
    });	
	
}

function fillTheBoxes() {
	var current = jQuery("#ic_homepage_bgimages").val();	
	if(current=='') return;
	
	var current_arr = new Array();
	current_arr = current.split("||");
	
	for(var i=0;i<current_arr.length;i++){
		var row_arr = current_arr[i].toString().split("|");	
		if(row_arr.length == 3){
			jQuery("#background_layer_"+i).val(row_arr[0]);
			jQuery("#background_layer_position_"+i).val(row_arr[1]);
			jQuery("#background_layer_repeat_"+i).val(row_arr[2]);			
		}
	}	
}