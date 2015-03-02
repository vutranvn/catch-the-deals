
( function($) {
    tinymce.PluginManager.add('hotdealblog_button_deal', function( editor, url ) {
        editor.addButton( 'hotdealblog_button_deal', {
            text: 'Add Deal',
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: 'Insert header tag',
                    width: 600,
                    height: 450,
                    body: [{
                        type: 'textbox',
                        name: 'name_deal',
                        label: 'Search'
                    },
                        {
                            type: 'textbox',
                            name: 'url',
                            label: 'Url Address'
                        }],
                    onsubmit: function( e ) {
                        editor.insertContent( '<a href="' + e.data.url + '">' + e.data.name_deal + '</a>');
                    }
                });
            }
        });
    });
})(jQuery);

( function($) {

    $.ajax({
        type : 'post',
        dataType : 'json',
        url : ajaxurl,
        data : { action : "get_data_deals" },
        success : function (result) {
            if(result) {
                console.log( result );
            } else {
                console.log( 'Fails' );
            }
        }
    });
})(jQuery);
