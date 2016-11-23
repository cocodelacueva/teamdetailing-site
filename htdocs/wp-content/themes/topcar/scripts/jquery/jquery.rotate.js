(function($){				   
	jQuery.fn.extend({

		ozyRotate: function(options) {
			
			//Defaults options are set
			var defaults = {  
				degree: 0,
				rotateStep : 1 
			};  
			
			var options = $.extend(defaults, options);  
			
			return this.each(function() {   
			
				//jQuery(this).css("border", options.border);
				var timer, degree = options.degree, $rota = $(this);
				
				//function rotateCSS3() {
					// timeout increase degrees:
					timer = window.setInterval(function() {
						degree = degree + options.rotateStep;
						
						$rota.css({ transform: 'rotate(' + degree + 'deg)' });
						//console.log(degree);
					},25);
				//}			
			
			});

		}

	});
})(jQuery);