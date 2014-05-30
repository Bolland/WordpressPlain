jQuery(document).ready(function($) {


//********************************************************
// load and apply tooltips
//********************************************************

	$('span.ap_tooltip').each(function() {
		ap_apply_tooltip(this);
	});

	function ap_apply_tooltip(element){
		jQuery(element).qtip({
			content: jQuery(element).attr('tooltip'), // Use the tooltip attribute of the element for the content
			show: { delay: 700, solo: true },
			hide: { when: 'mouseout', fixed: true, delay: 200, effect: 'fade' },
			style: {
				width:	300,
				padding: 10,
				color:	'black',
				tip:	'topLeft',
				border: {
					width:	4,
					radius:	5,
					color:	'#666'
				},
				name:	'light',
				position: {
					corner: {
						target: 'rightMiddle',
						tooltip: 'leftMiddle'
					}
				}
			}
		});
	}

//********************************************************
// You're still here? It's over. Go home.
//********************************************************


});	// end init
