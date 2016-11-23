(function() {

	tinymce.create('tinymce.plugins.ozyBackofficeShortcodes', {
		init : function(ed, url) {
			ed.addButton('ozy_backoffice_shortcodes', {
				title : 'Shortcodes',
				image : url + '/img/add.png',
				onclick : function() {
					tb_show('Shortcodes Manager', url + '/tinymce.php?&width=670&height=600');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "Cosmox Shortcodes",
				author : 'Ozy Themes',
				authorurl : 'http://ozythemes.com/',
				infourl : 'http://cosmox.ozythemes.com/help',
				version : "0.3"
			};
		}
	});
	
	tinymce.PluginManager.add('ozy_backoffice_shortcodes', tinymce.plugins.ozyBackofficeShortcodes);
	
})();