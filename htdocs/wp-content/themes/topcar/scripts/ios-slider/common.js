jQuery(window).load(function($) {
		
	jQuery('.iosSlider').iosSlider({
		snapToChildren: true,
		desktopClickDrag: true,
		keyboardControls: true,
		navNextSelector: jQuery('.ios-next'),
		navPrevSelector: jQuery('.ios-prev'),
		navSlideSelector: jQuery('.selectors .item'),
		onSlideComplete: slideComplete,
		onSliderLoaded: function(args){
			var otherSettings = {
				hideControls : true, // Bool, if true, the NAVIGATION ARROWS will be hidden and shown only on mouseover the slider
				hideCaptions : false  // Bool, if true, the CAPTIONS will be hidden and shown only on mouseover the slider
			}
			sliderLoaded(args, otherSettings);
		},
		onSlideChange: slideChange,
		keyboardControls: true,
		infiniteSlider: true,
		autoSlide: true
	});

});
					
function slideChange(args) {
	jQuery('.selectors .item').removeClass('selected');
	jQuery('.selectors .item:eq(' + (args.currentSlideNumber-1) + ')').addClass('selected');
}

function slideComplete(args) {
	if(!args.slideChanged) return false;
	captionEffects(args);
}

function captionEffects(args) {
	var caption = jQuery(args.sliderObject).find('.iosSliderCaption');	
	var thisCaption = jQuery(args.currentSlideObject).find('.iosSliderCaption');

	var description = jQuery(args.sliderObject).find('.iosSliderDescription');	
	var thisDescription = jQuery(args.currentSlideObject).find('.iosSliderDescription');
	
	caption.css("opacity", "0");
	description.css("opacity", "0");
		
	thisCaption.animate( { "opacity" : "1" }, 400, 'easeInOutExpo');
	thisDescription.animate( { "opacity" : "1" }, 600, 'easeInOutExpo');
}

function sliderLoaded(args, otherSettings) {
	var theSlider = args.sliderContainerObject;
	if(otherSettings.hideControls) theSlider.addClass('hideControls');
	if(otherSettings.hideCaptions) theSlider.addClass('hideCaptions');
	setTimeout(function() {
		theSlider.css('background-image','none');
	}, 1000);
	
	captionEffects(args);
	slideChange(args);
	
}