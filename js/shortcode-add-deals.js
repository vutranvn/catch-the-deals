
( function($) {

	tinymce.PluginManager.add('hotdealblog_button_deal', function( editor, url ) {
		editor.addButton( 'hotdealblog_button_deal', {
			text: 'Add Deal',
			icon: false,
			onclick: function() {
				retrieve_deals_data(function ( data_deals ) {
					console.log( data_deals );
				});
                data_tmp = [
                    {text: 'Left', value: 'left'},
                    {text: 'Right', value: 'right'},
                    {text: 'Center', value: 'center'}
                ],
				editor.windowManager.open( {
					title: 'Insert deals',
					width: 600,
					height: 270,
                    data: data_tmp,
					body: [
						{
							type: 'textbox',
							name: 'box_title',
							label: 'Search ID',
							size: 20
						},
						{
							type: 'listbox',
							name: 'deal_name',
							label: 'Deals',
							'values': data_tmp
						},
						{
							type: 'textbox',
							name: 'deal_ulr',
							label: 'Deal url',
                            value:  '123'
						},
					],
					onsubmit: function( e ) {
						editor.insertContent( '<a href="' + e.data.url + '">' + e.data.name_deal + '</a>');
					}
				});
			}
		});
	});

})(jQuery);

/*count: "0"
deal_ID: "#234567"
deal_url: "http://www.hotdeal.vn/ho-chi-minh/thoi-trang-nu/dam-oversize-hoa-tiet-mua-xuan-1.html"
description: ""
name: "Đầm Oversize Họa Tiết Mùa Xuân 1"
parent: "0"
slug: "1"
taxonomy: "deal"
term_group: "0"
term_id: "307"
term_taxonomy_id: "307"*/

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
