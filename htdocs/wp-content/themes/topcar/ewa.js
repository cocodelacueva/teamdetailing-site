var is_browser_ie8 = false;

jQuery(window).load(function() {
	//Retina image replacement
	if (window.devicePixelRatio > 1) {
		var $images = jQuery("img.retina[data-retina-img]");
		$images.each(function(index, element) {
            jQuery(element).attr('width', jQuery(this).width()).attr( "src", jQuery(element).attr("data-retina-img") );
        });
	}
});

jQuery(document).ready(function($) {

	//Looks like Safari on Windows	
	var ua = navigator.userAgent.toLowerCase();
	if (ua.indexOf("safari/") !== -1 && ua.indexOf("windows") !== -1 && ua.indexOf("chrome") === -1) {
		$(".title-with-icon>h1,.title-with-icon>h2,.title-with-icon>h3,.title-with-icon>h4,.title-with-icon>h5,.title-with-icon>h6").css("display", "inline");
	}
	
	//if (jQuery.browser.msie  && parseInt(jQuery.browser.version, 10) <= 8) {	
	if (navigator.userAgent.match(/msie/i) && parseInt(jQuery.browser.version, 10) <= 8) {
		is_browser_ie8 = true;
	}

	//IE7 and 8 stuff
	if (!$.support.leadingWhitespace) {
		jQuery(document).ready(function($) {
			equalHeight($("#bottom-widget-wrapper>.container>.row>.sidebar-widget"));
		});
	}
  
	//Searchbox auto complete function
	$("input[name='s']").autocomplete($WP_ROOT_URL + '/wp-admin/admin-ajax.php?action=ajax_search_box' , {
		width: 260,
		selectFirst: false
	});	
	
	//firefox and IE iframe issue fix (youtube like)
	$('iframe').each(function() {
		if($(this).attr("src") !== undefined) {
			var url = $(this).attr("src");			
			if ($(this).attr("src").indexOf("?") > 0) {
				$(this).attr({
				  "src" : url + "&wmode=transparent",
				  "wmode" : "Opaque"
				});
			} else {
				$(this).attr({
				  "src" : url + "?wmode=transparent",
				  "wmode" : "Opaque"
				});
			}
		}
	});	

	/*************************slider animations******************************/

	//mouse sensitive parallax effect
	if (typeof(Parallax) !== 'undefined') {
		if($('#slideshow').length>0) {
			new Parallax({
				container: '#slideshow',
				layers: [
					{ selector: '.layer1', ratio: 0.050 },
					{ selector: '.layer2', ratio: 0.030 },
					{ selector: '.layer3', ratio: 0.008 },
					{ selector: '.layer4', ratio: 0.005 },
					{ selector: '.layer5', ratio: 0.015 },
					{ selector: '.layer6', ratio: 0.010 }
				]
			});
		}
	
		if($('.rev_slider_wrapper').length>0) {
			new Parallax({
				container: '.rev_slider_wrapper',
				layers: [
					{ selector: '.layer1', ratio: 0.050 },
					{ selector: '.layer2', ratio: 0.030 },
					{ selector: '.layer3', ratio: 0.008 },
					{ selector: '.layer4', ratio: 0.005 },
					{ selector: '.layer5', ratio: 0.015 },
					{ selector: '.layer6', ratio: 0.010 }
				]
			});
		}
	}
	
	//Moving Box
	$(".move-me-up").hover(
		function () {
			$(this).stop().animate({"margin-top" : "-30px"}, 600, "easeInOutExpo");
		},
		function () {
			$(this).stop().animate({"margin-top" : "0px"}, 600, "easeInOutExpo");
		}
	);		
	
	//jQFloat floating effects
	if (jQuery().jqFloat) {
		
		if($('.small-float').length>0) {
			$('.small-float>img').jqFloat({ width:10, height:30, speed:1000 });
		}
	
		if($('.medium-float').length>0) {
			$('.medium-float>img').jqFloat({ width:10, height:60, speed:1000 });
		}
			
		if($('.large-float').length>0) {
			$('.large-float>img').jqFloat({ width:10, height:90, speed:1000 });
		}
						
		if($('.small-bounce').length>0) {
			$('.small-bounce>img').jqFloat({ width:0, height:10, speed:1000	});	
		}
	
		if($('.medium-bounce').length>0) {
			$('.medium-bounce>img').jqFloat({ width:0, height:20, speed:1000 });
		}
	
		if($('.large-bounce').length>0) {
			$('.large-bounce>img').jqFloat({ width:0, height:30, speed:1000	});
		}
	}

	if (jQuery().ozyRotate) {
		/*ROTATE RIGHT*/
		if($('.rotate-right-01').length>0) {
			$('.rotate-right-01').ozyRotate( { degree : 0, rotateStep : 0.1 } );
		}
	
		if($('.rotate-right-02').length>0) {
			$('.rotate-right-02').ozyRotate( { degree : 0, rotateStep : 0.2 } );
		}
			
		if($('.rotate-right-03').length>0) {
			$('.rotate-right-03').ozyRotate( { degree : 0, rotateStep : 0.3 } );
		}
			
		if($('.rotate-right-04').length>0) {
			$('.rotate-right-04').ozyRotate( { degree : 0, rotateStep : 0.4 } );
		}
	
		if($('.rotate-right-05').length>0) {
			$('.rotate-right-05').ozyRotate( { degree : 0, rotateStep : 0.5 } );
		}
		
		if($('.rotate-right-1').length>0) {
			$('.rotate-right-1').ozyRotate( { degree : 0, rotateStep : 1 } );
		}
	
		if($('.rotate-right-2').length>0) {
			$('.rotate-right-2').ozyRotate( { degree : 0, rotateStep : 2 } );
		}
	
		if($('.rotate-right-3').length>0) {
			$('.rotate-right-3').ozyRotate( { degree : 0, rotateStep : 3 } );
		}
	
		if($('.rotate-right-4').length>0) {
			$('.rotate-right-4').ozyRotate( { degree : 0, rotateStep : 4 } );
		}
	
		if($('.rotate-right-5').length>0) {
			$('.rotate-right-5').ozyRotate( { degree : 0, rotateStep : 5 } );
		}
	
		/*ROTATE LEFT*/
		if($('.rotate-left-01').length>0) {
			$('.rotate-left-01').ozyRotate( { degree : 0, rotateStep : -0.1 } );
		}
	
		if($('.rotate-left-02').length>0) {
			$('.rotate-left-02').ozyRotate( { degree : 0, rotateStep : -0.2 } );
		}
	
		if($('.rotate-left-03').length>0) {
			$('.rotate-left-03').ozyRotate( { degree : 0, rotateStep : -0.3 } );
		}
	
		if($('.rotate-left-04').length>0) {
			$('.rotate-left-04').ozyRotate( { degree : 0, rotateStep : -0.4 } );
		}
	
		if($('.rotate-left-05').length>0) {
			$('.rotate-left-05').ozyRotate( { degree : 0, rotateStep : -0.5 } );
		}
		
		if($('.rotate-left-1').length>0) {
			$('.rotate-left-1').ozyRotate( { degree : 0, rotateStep : -1 } );
		}
	
		if($('.rotate-left-2').length>0) {
			$('.rotate-left-2').ozyRotate( { degree : 0, rotateStep : -2 } );
		}
	
		if($('.rotate-left-3').length>0) {
			$('.rotate-left-3').ozyRotate( { degree : 0, rotateStep : -3 } );
		}
	
		if($('.rotate-left-4').length>0) {
			$('.rotate-left-4').ozyRotate( { degree : 0, rotateStep : -4 } );
		}
	
		if($('.rotate-left-5').length>0) {
			$('.rotate-left-5').ozyRotate( { degree : 0, rotateStep : -5 } );
		}
		
		/*******************************************************/
			
		$('.rotate-right').ozyRotate( { degree : 0, rotateStep : 5 } );
		$('.rotate-left').ozyRotate( { degree : 0, rotateStep : -0.5 } );
	}
	
	/*jQuery Mobile menu*/
	if(!is_browser_ie8) 
	{
		if($('#top_menu').length > 0) 
		{	
			var $mobile_menu = jQuery( '<ul id="mobile-only-menu">' + $('#top_menu').html().split('<li class="menu-pipe">|</li>').join('') + '</ul>' );
			$mobile_menu.find('*').removeAttributes(['id', 'class', 'data-toggle']);
			$($mobile_menu).find('li').each(function(index, element) 
			{
                if($(element).has('ul').length > 0) {					
					$(this).find('a:first').append('<i class="icon-open-close-menu-item"></i>');//$(this).find('a:first').attr("href", "#").append('<i class="icon-angle-right"></i>');
				}
            });
			
			$('.select-menu').append( $mobile_menu );
			$('#mobile-only-menu').accordionOzy().hide();
			$('.select-menu>a').click(function(e) { $('#mobile-only-menu').slideToggle('fast', 'easeInOutExpo'); e.preventDefault(); return false; });
		}	
	}
				
	/*Hover Simulation for Mobile Devices*/
	if (navigator.userAgent.match(/Android/i) ||
		 navigator.userAgent.match(/webOS/i) ||
		 navigator.userAgent.match(/iPhone/i) ||
		 navigator.userAgent.match(/iPad/i) ||
		 navigator.userAgent.match(/iPod/i) ||
		 navigator.userAgent.match(/BlackBerry/) || 
		 navigator.userAgent.match(/Windows Phone/i) || 
		 navigator.userAgent.match(/ZuneWP7/i)) 
	{
		$("a").each(function() {
			$(this).live("touchstart", function(){ $(this).addClass("hover"); });
			$(this).live("touchend"	, function(){ $(this).removeClass("hover"); });
		});
		
		$('#backToTop').remove(); //hide back to top button for mobile devices
	} else {
		/*back to top button*/
		$(window).scroll(function() {
			if($(this).scrollTop() !== 0) {
				$('#backToTop').fadeIn();	
			} else {
				$('#backToTop').fadeOut();
			}
		});
	
		$('#backToTop').click(function() {
			$('body,html').animate({scrollTop:0},800);
		});		
	}
	
	$(function(){
		$(".tooltip_below, .product>.images>.thumbnails>a").tipTip({maxWidth: "auto", edgeOffset: 10, defaultPosition: "bottom", delay: 1});
		$(".tooltip_above, .related-posts-carousel li a, .ozy-gallery-wrapper > div > div > a").tipTip({maxWidth: "auto", edgeOffset: 10, defaultPosition: "top", delay: 1});
	});
	
	//voting handler
	jQuery(".icon-heart").live("click", function() {
		var id = jQuery(this).attr("id");
		ajax_favorite_like(id, 'like', 'blog', this);
	});
	
	//add twitter icon to custom tweetbox
	$(".wpb_twitter_widget.big-tweet>div:first-child").before('<div class="icon-twitter"></div>');
	
	//navbar search
	var t = "#navbar-search-form input[type=text]";
	$("#navbar-search-wrapper span").click(function() {
		if( parseInt($(t).attr("data-open"), 0) === 0 ) {
			$(this).removeClass("icon-search").addClass("icon-remove-circle").fadeIn("slow");
			$(t).attr("data-open", "1").css("visibility", "visible").addClass("open").animate({"max-width" : "100%"}, 100, "swing", function(){ $(this).focus(); });
		}else{
			$(this).removeClass("icon-remove-circle").addClass("icon-search").fadeIn("slow");
			$(t).attr("data-open", "0").animate({"max-width" : "0px"}, 100, "swing", function() { $(this).removeClass("open").css("visibility", "hidden"); } );
		}
    });

});

//to voting content
function ajax_favorite_like(post_id, _post_type, _vote_type, $obj) {

	if( !check_favorite_like_cookie( post_id ) ) { //check, if there is no id in cookie
	
		jQuery.ajax({
			url: $WP_ROOT_URL + "/wp-admin/admin-ajax.php",
			data: { action: 'ajax_favorite_like', vote_post_id: post_id, vote_post_type: _post_type, vote_type: _vote_type },
			cache: false,
			success: function(data) {
				//not integer returned, so error message
				if( parseInt(data,0) > 0 ){
					write_favorite_like_cookie(post_id);
					jQuery($obj).next("span").html(data);
				} else {
					alert(data);
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown){  
				alert(errorThrown); 
			}  
		});
	
	}
	
}

//cookie checker for voting system
function check_favorite_like_cookie(post_id){
	var str = getCookieValue( "post_id" );
	if(str.indexOf("[" + post_id + "]") > -1) {
		return true;
	}
	
	return false;
}

//cokie writer for voting system
function write_favorite_like_cookie(post_id)
{
	var now = new Date();
	now.setMonth( now.getYear() + 1 ); 
	post_id = "[" + post_id + "]," + getCookieValue("post_id");
	document.cookie="post_id=" + post_id + "; expires=" + now.toGMTString() + "; path=/; ";
}

//read cookie
function getCookieValue(key)
{
    var currentcookie = document.cookie;
    if (currentcookie.length > 0)
    {
        var firstidx = currentcookie.indexOf(key + "=");
        if (firstidx !== -1)
        {
            firstidx = firstidx + key.length + 1;
            var lastidx = currentcookie.indexOf(";", firstidx);
            if (lastidx === -1)
            {
                lastidx = currentcookie.length;
            }
            return unescape(currentcookie.substring(firstidx, lastidx));
        }
    }
    return "";
}

//equal height
function equalHeight(group) {
	var tallest = 0;
	group.each(function() {
		var thisHeight = jQuery(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.height(tallest);
}

//remove multiple attributes from elements at once
jQuery.fn.removeAttributes = function(only, except) {
    if (only) {
        only = jQuery.map(only, function(item) {
            return item.toString().toLowerCase();
        });
    }
	
    if (except) {
        except = jQuery.map(except, function(item) {
            return item.toString().toLowerCase();
        });
        if (only) {
            only = jQuery.grep(only, function(item) {
                return jQuery.inArray(item, except) === -1;
            });
        }
    }
	
    return this.each(function() {
        var attributes;
        if(!only){
            attributes = jQuery.map(this.attributes, function(item) {
                return item.name.toString().toLowerCase();
            });
             if (except) {
                attributes = jQuery.grep(attributes, function(item) {
                    return jQuery.inArray(item, except) === -1;
                });
            }
        } else {
            attributes = only;
        }      
        var handle = jQuery(this);
        jQuery.each(attributes, function(index, item) {
            handle.removeAttr(item);
        });
    });
};

//How to remove the hash from window.location with JavaScript without page refresh?
function removeHash() { 
    var scrollV, scrollH, loc = window.location;
    if ("pushState" in history)
        history.pushState("", document.title, loc.pathname + loc.search);
    else {
        // Prevent scrolling by storing the page's current scroll offset
        scrollV = document.body.scrollTop;
        scrollH = document.body.scrollLeft;

        loc.hash = "";

        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scrollV;
        document.body.scrollLeft = scrollH;
    }
}
