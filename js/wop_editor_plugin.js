(function() {
    tinymce.create('tinymce.plugins.WopPlugin', {
        init : function(ed, url) {
	    ed.addCommand('wopShortCode', function() {
		tb_show( 'Select Sidebar', 'admin-ajax.php?action=wop_editor_dialog&width=400&height=220' );
	    });
            ed.addButton('wopplugin', {
                title : 'Add a widget area',
		cmd : 'wopShortCode',
                //image : url+'/../images/wop_tiny_mce.png'
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Widgets on Pages",
                author : 'Todd Halfpenny',
                authorurl : 'http://gingerbreaddesign.co.uk/todd/',
                infourl : 'http://gingerbreaddesign.co.uk/wordpress/widgets-on-pages/',
                version : "0.0.13"
            };
        }
    });
    tinymce.PluginManager.add('wopplugin', tinymce.plugins.WopPlugin);
})();



function insertShortCode(){
    var wop_select_box = jQuery( '#wop_sidebar' );	
    var class_select_box = jQuery( '#wop_align' );	
    var columns_select_box = jQuery( '#wop_columns' );
    tinyMCE.activeEditor.execCommand( "mceInsertContent", false, '[widgets_on_pages id="' + wop_select_box.val() + '" cols="' + columns_select_box.val() + '"]' );
    	tb_remove();
}

