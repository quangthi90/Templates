$(window).off( "click", ".ext-access input[type='radio']");
$(window).on('click', ".ext-access input[type='radio']", function() {
	console.log($(this).val());
	if ($(this).val() == 'y') {
		$(this).parent().parent().next('div').show();
		$(this).parent().parent().parent().parent().next('.mod-setting-wrp').hide();
	}else {
		$(this).parent().parent().parent().parent().next('.mod-setting-wrp').show();
		$(this).parent().parent().next('div').hide();
	};
});