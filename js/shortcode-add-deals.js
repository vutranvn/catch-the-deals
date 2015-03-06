
( function($) {

	tinymce.PluginManager.add('hotdealblog_button_deal', function( editor, url ) {
		retrieve_deals_data(function ( data ) {
			console.log(data);
		});
		editor.addButton( 'hotdealblog_button_deal', {
			text: 'Add Deal',
			icon: false,
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert header tag',
					width: 600,
					height: 270,
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

    tinymce.init({
        selector: 'textarea',
        plugins: 'hotdealblog_button_deal',
        toolbar: 'hotdealblog_button_deal'
    });
})(jQuery);

function retrieve_deals_data( handleData ) {
	jQuery.ajax({
		type : 'post',
		dataType : 'json',
		url : ajaxurl,
		data : { action : "get_data_deals" },
		success : function ( data ) {
			handleData( data );
		}
	});
}
