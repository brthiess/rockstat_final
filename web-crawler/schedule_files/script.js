jQuery(function($) {
	$("#tabs").tabs();
	$('#search')
		.focus(function(){if ($(this).val() == 'Search') {$(this).val('');} })
		.blur(function(){if ($(this).val() == '') {$(this).val('Search');} })
});