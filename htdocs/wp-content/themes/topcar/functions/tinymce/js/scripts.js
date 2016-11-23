(function($) {

	var shortcode = '',
		alertBoxShortcode,
		layoutShortcode;

	$('#shortcode-dropdown').live('change', function() {
		
		// Show shortcode attributes
		$('#ozy-shortcode-tr').fadeIn('fast');
		
		var $currentShortcode = $(this).val();

		// Reset everything
		$('#shortcode').empty();
		alertBoxShortcode = false;
		layoutShortcode   = false;
		
		// Button
		if( $currentShortcode === 'button-code' ) {

			ozy_backoffice_show_option('.button-code');
			shortcode = '[button <span class="red">url=""</span> icon="" size="" lightbox="" lightbox_grouo=""] [/button]';
		
		// Dropcap
		} else if( $currentShortcode === 'dropcap' ) {

			ozy_backoffice_show_option('.dropcap');
			shortcode = '[dropcap type="" size=""]...[/dropcap]';
		
		// Highlight
		} else if( $currentShortcode === 'highlight-text' ) {

			ozy_backoffice_show_option('.highlight-text');
			shortcode = '[highlight-text]...[/highlight-text]';
		
		// List
		} else if( $currentShortcode === 'list' ) {

			ozy_backoffice_show_option('.list');
			shortcode = '[list icon="" list_style=""]...[/list]';
	
		// Lightbox
		} else if( $currentShortcode === 'lightbox' ) {

			ozy_backoffice_show_option('.lightbox');
			shortcode = '[lightbox type="" <span class="red">full=""</span> title="" group=""]...[/lightbox]';
		
		// Typeicon
		} else if( $currentShortcode === 'typeicon' ) {

			ozy_backoffice_show_option('.typeicon');
			shortcode = '[typeicon icon="add-icon-name-here" size=""]';
			
		// Bootstrap Badge & Label
		} else if( $currentShortcode === 'badge_label' ) {

			ozy_backoffice_show_option('.badge_label');
			shortcode = '[badge-label type="label|badge" style="success|warning|important|info|inverse"]...[/badge-label]';

		} else {

			$('.option').hide();
			shortcode = '';

		}

		$('#shortcode').html( shortcode );

	});

	$('#insert-shortcode').live('click', function() {

		var $currentShortcode = $('#shortcode-dropdown').val();

		// Hightlight
		if( $currentShortcode === 'highlight-text' ) {

			var highlightText  = $('#highlight-text-text').val();
			
			shortcode = '[highlight-text]';
			
			if( highlightText )			
				shortcode += highlightText;

			shortcode += '[/highlight-text]';

		// Button
		} else if( $currentShortcode === 'button-code' ) {

			var buttonCodeUrl     		= $('#button-code-url').val(),
				buttonCodeIcon   		= $('#button-code-icon').val(),
				buttonCodeSize 			= $('#button-code-size').val(),
				buttonCodeContent   	= $('#button-code-content').val(),
				buttonCodeLightBox  	= $('#button-lightbox').val(),
				buttonCodeLightBoxGroup = $('#button-lightbox_group').val();

			shortcode = '[button';

			if( buttonCodeUrl )
				shortcode += ' url="' + buttonCodeUrl + '"';

			if( buttonCodeIcon )
				shortcode += ' icon="' + buttonCodeIcon + '"';
				
			if( buttonCodeSize )
				shortcode += ' size="' + buttonCodeSize + '"';
				
			if( buttonCodeLightBox )
				shortcode += ' lightbox="' + buttonCodeLightBox + '"';	

			if( buttonCodeLightBoxGroup )
				shortcode += ' lightbox_group="' + buttonCodeLightBoxGroup + '"';

			shortcode += ']' + buttonCodeContent + '[/button]';
		
		// Dropcap
		} else if( $currentShortcode === 'dropcap' ) {

			var dropcapType   = $('#dropcap-type').val(),
				dropcapContent = $('#dropcap-content').val(),
				dropcapSize = $('#dropcap-size').val();

			shortcode = '[dropcap';

			if( dropcapType )
				shortcode += ' type="' + dropcapType + '"';

			if( dropcapSize )
				dropcapSize += ' size="' + dropcapSize + '"';

			shortcode += ']' + dropcapContent + '[/dropcap]';

		// Typeicon
		} else if( $currentShortcode === 'typeicon' ) {

			var typeIcon  = $('#typeicon-icon').val(),
				typeIconSize = $('#typeicon-size').val();

			shortcode = '[typeicon';

			if( typeIcon )
				shortcode += ' icon="' + typeIcon + '"';

			if( typeIconSize )
				shortcode += ' size="' + typeIconSize + '"';				

			shortcode += ']';

		// List
		} else if( $currentShortcode === 'list' ) {

			var listIcon 		= $('#list-icon').val(),
				listListStyle	= $('#list-list-style').val(),
				listContent 	= $('#list-content').val();

			shortcode = '[list';

			if( listIcon )
				shortcode += ' icon="' + listIcon + '"';

			if( listListStyle )
				shortcode += ' list_style="' + listListStyle + '"';				

			shortcode += ']' + listContent + '[/list]';
			
		// Bootstrap label & badge
		} else if( $currentShortcode === 'badge_label' ) {

			var badgeLabelContent	= $('#badge_label-content').val(),
				badgeLabelStyle		= $('#badge_label-style').val(),
				badgeLabelType 		= $('#badge_label-type').val();

			shortcode = '[badge-label';

			if( badgeLabelStyle )
				shortcode += ' style="' + badgeLabelStyle + '"';

			if( badgeLabelType )
				shortcode += ' type="' + badgeLabelType + '"';				

			shortcode += ']' + badgeLabelContent + '[/badge-label]';
					
		// Lightbox
		} else if( $currentShortcode === 'lightbox' ) {

			var lightboxType 	= $('#lightbox-type').val(),
				lightboxFull 	= $('#lightbox-full').val(),
				lightboxTitle 	= $('#lightbox-title').val(),
				lightboxGroup 	= $('#lightbox-group').val(),
				lightboxContent = $('#lightbox-content').val();

			shortcode = '[lightbox';

			if( lightboxType )
				shortcode += ' type="' + lightboxType + '"';

			shortcode += ' full="' + lightboxFull + '"';

			if( lightboxTitle )
				shortcode += ' title="' + lightboxTitle + '"';

			if( lightboxGroup )
				shortcode += ' group="' + lightboxGroup.toLowerCase().replace(/ /g, '-') + '"';

			shortcode += ']' + lightboxContent + '[/lightbox]';
			
		}
		
		// Insert shortcode and remove popup
		tinyMCE.activeEditor.execCommand('mceInsertContent', false, shortcode);
		tb_remove();

	});

	// Display selected shortcode
	function ozy_backoffice_show_option( option ) {

		$('.option').hide();
		$( option ).show();

	}

})( jQuery );