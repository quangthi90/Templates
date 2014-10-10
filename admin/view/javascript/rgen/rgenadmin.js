$(document).ready(function(){

	$('#main-tabs .nav a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	/*CUSTOM CODE TABS*/
	$('#tabs1 a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$('#tabs1 > li:first').addClass('active');
	/*$('#customHtm .tab-content .tab-pane:first').addClass('active');*/
	$('#RevoMain .tab-content .tab-pane:first').addClass('active');

	$('#customMenu .nav-tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	$('#RGen-ddMenu-tab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
	$('#customMenuItems a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	$('#customHtmlMenu a:first').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$('#customHtmlMenu li:first').addClass('active');
	$('#RGen-htmlMenu .tab-content .tab-pane:first').addClass('active');
	
	$('#custom-ft a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
	$('#theme_tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
	$('#customCode a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	$('#slideshowCaption a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$('#slideshowCaption li:first, #RGen-cap1 li:first, #RGen-cap2 li:first').addClass('active');
	$('#slideshowCaption .tab-content .tab-pane:first, #RGen-cap1 .tab-content .tab-pane:first, #RGen-cap2 .tab-content .tab-pane:first').addClass('active');
	

	$('#widgetID').live('click', function() {
		$('.widget-popup').dialog({
			dialogClass: "widgetid-popup",
			open: function(event, ui) {},
			title: 'widget ID',
			bgiframe: false,
			width: 900,
			height: 750,
			resizable: false,
			modal: false,
			closeOnEscape: true
		});	
	});
	
	$('.capcss').live('click', function() {
		$('.CSS-structure').dialog({
			dialogClass: "CSS-structure-popup",
			open: function(event, ui) {},
			title: 'Caption style CSS structure',
			bgiframe: false,
			width: 500,
			height: 300,
			resizable: false,
			modal: false,
			closeOnEscape: true
		});	
	});

	// RADIO BUTTONS
	$('body').on('click', '.btn-group .btn', function (e) {
		if (!this) return e.preventDefault(); // stops modal from being shown
		$(this).button();
	})


	// HELP BUTTONS
	$(window).off("click", ".helpbtn, .sethelp");
	$(window).on("click", ".helpbtn, .sethelp", function(){
		if($(this).attr("data-type") == "img"){
			Messi.img($(this).attr("data-info"), {modal: true, modalOpacity: 0.5});	
		}
		if($(this).attr("data-type") == "info"){
			new Messi($(this).attr("data-info"), {
				title: $(this).attr('data-title')?$(this).attr('data-title'):'Help', titleClass: 'msg-title', modal: true, modalOpacity: 0.5,
				buttons: [{id: 0, val: 'C', label: 'Close', class: 'btn-small'}]
			});
		}
		if($(this).attr("data-type") == "page"){
			//console.log($(this).attr("data-info"));
			Messi.load($(this).attr("data-info"), {
				title: $(this).attr('data-title')?$(this).attr('data-title'):'Help', titleClass: 'msg-title', modal: true, modalOpacity: 0.5, width:'800px',
				buttons: [{id: 0, val: 'C', label: 'Close', class: 'btn-small'}]
			});
		}
	});

	/* AUTO TAB SETUP */
	/*var T = 0;
	var CT = 0;
	var CP = 0;
	$('.content-tab').each(function(){
		T++
		var createCls = 'cTab'+T;
		$(this).addClass(createCls);
		
		var newCls = '.cTab'+ T + ' > .nav-tabs a';
		//var newClsPane = '.cTab'+T + ' .tab-content';
		$(newCls).click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
	});*/
	
});
function getRandomInt() {
	var d = new Date();
    var n = d.getTime();
	return n;
}

$.fn.summary = function(options) { 
	var settings = $.extend({
		dbkey: '',
		callback: function(){ },
		labels: '',
		place: '',
		after: function(){ },
		firstClick: false
	}, options );
	summary = this;
	
	$(settings.place+'+ .summary').remove();
	$(settings.place).after('<ul class="summary help-block"></ul>');
	
	var summaryLabels = settings.labels.split('|');
	var summaryData = settings.dbkey;
	if(summaryData){
		var summaryData_ar = summaryData.split('|');
		$.each(summaryData_ar, function(index, val) {

			var valdata = settings.callback(index, val) ? settings.callback(index, val) : val;
			var key = summaryLabels[index];
			//data_arr[key] = valdata;
			$(settings.place + '+ .summary').append('<li><b>'+key+'</b><span>'+valdata+'</span></li>')
			//$(summary).find(settings.path+':eq('+index+') '+settings.target).text(valdata);
		});
	}
};


function messages(type, message) {
	$('body').prepend('<div class="saving"><span>Please wait...<span></div>');
	$(".saving").css({height: $("html").height()});
	if (type == 'error') {
		$('.saving').addClass('error-msg');
	};
	// Loading screen
	$('.saving').find("span").text(message).css({backgroundImage:""});
	$('.saving').animate({opacity:1}, 2000, function(){
		$('.saving').animate({opacity:0}, 300, function(){$('.saving').css({display:"none"}); $(".saving").remove();});
	});
}

function colorPicker(obj, format){
	$(obj).each(function() {
		$(this).spectrum({
			appendTo: $(this).parent(),
			preferredFormat: format,
			showAlpha: true,
			showInput: true,
			showPalette: true,
			palette: [["rgba(0, 0, 0, 0.5)", "rgb(255, 255, 255, 0.5)"]]
		});
	});
}

$.fn.rgenPost = function(options) { 
	var settings = $.extend({
		before: function(){ },
		after: function(){ },
		firstClick: false
	}, options );
	
	rgentb = this;

	$(rgentb).each(function() {
		$(this).on("click", function(){
			var obj = $(this);
			settings.before(obj);
			
			var container = $(this).attr("data-container");
			var url = $(this).attr("data-url");

			$.post(url, function(data) {
				$(container).html(data);
				settings.after(data);
			});	
		});
	});
	//url = $(rgentb).attr("data-url");
	if (settings.firstClick == true) {
		$(rgentb).first().click();
	};
};



function blockSection(blockarea, bgColor, msg){

	var msg = msg && msg != '' ? msg : 'Just a moment...';

	$(blockarea).block({
		css: { 
			top: '10%',
			border: 'none', 
			padding: '50px 20px 20px 20px', 
			backgroundColor: '#333', 
			'-webkit-border-radius': '10px', 
			'-moz-border-radius': '10px', 
			opacity: 0.7, 
			color: '#fff',
			fontSize: '16px',
			fontWeight: "bold"
		},
		overlayCSS:{ backgroundColor: bgColor, opacity: 0.6 },
		message: ''+msg+''
	});
}

function modkey(obj, key) {
	$(obj).each(function(index, val) {
		$(this).find(key).attr('value', index);
	});
}

// Full block display function
$.fn.fullBock = function(options) { 
	var settings = $.extend({
		before: function(){ },
		after: function(){ }
	}, options );
	
	fullb = this;

	$(fullb).each(function() {
		var obj = $(this);
		settings.before(obj);
		
		obj.find('.fullB-status').off("change");
		obj.find('.fullB-status').on("change", function(){
			if ($(this).val() == "y"){
				obj.find('.block-settings').show();
			}else{
				obj.find('.block-settings').hide();
			};
		});

		obj.find('.fullB-bgposition').off("change");
		obj.find('.fullB-bgposition').on("change", function(){
			if ($(this).val() == "other"){
				obj.find('.otherpos').show();
				$(this).parent().next('.otherpos').show();
			}else{
				obj.find('.otherpos').hide();
			};
		});

		obj.find('[data-val="dark-thm"]').off("click");
		obj.find('[data-val="dark-thm"]').on("click", function(){
			$(this).prev('input').val($(this).attr('data-val'));
		});

	});
};

/* 
Upload image
===============
R.Gen banner : Upload banners
*/
$.fn.setImage = function(options) { 
	var settings = $.extend({
		token: '',
		browse: '.browse',
		remove: '.clear',
		no_img: '',
		before: function(){ },
		after: function(){ }
	}, options );
	
	setImage = this;

	$(setImage).each(function() {
		var obj = $(this);
		settings.before(obj);
		// Upload image
		obj.find(settings.browse).off( "click");
		obj.find(settings.browse).on('click', function() {
			if (settings.token != '') {
				image_upload($(this).attr('data-id'), $(this).attr('data-id')+'-preview');
			}
		});
		// Clear image
		obj.find(settings.remove).off( "click");
		obj.find(settings.remove).on('click', function() {
			if (settings.no_img != '') {
				$('#'+$(this).attr('data-id')+'-preview').css({backgroundImage: 'url('+settings.no_img+')'});
				$('#'+$(this).attr('data-id')).attr('value', '');
			}
		});
	});

	function image_upload(field, previewImg) {
		$('#dialog').remove();
		$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token='+settings.token+'&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
		$('#dialog').dialog({
			title: 'Image manager<br><div class="path">Uploaded image path to use in content => image/data/ Folder name if created / image name without space </div>',
			close: function (event, ui) {
				if ($('#' + field).attr('value')) {
					$.ajax({
						url: 'index.php?route=common/filemanager/image&token='+settings.token+'&image=' + encodeURIComponent($('#' + field).attr('value')),
						dataType: 'text',
						success: function(data) {
							$('#' + previewImg).css({backgroundImage: 'url(' + data + ')'});
						}
					});
				}
			},	
			bgiframe: false,
			width: 800,
			height: 450,
			resizable: true,
			modal: false
		});
	};
};


// Auto complete
function autocompleteTool(inputName, urlCategory, token, value1, value2){
	$(inputName).autocomplete({
		delay: 100,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/'+urlCategory+'/autocomplete&token='+token+'&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {	
					response($.map(json, function(item) {
						//console.log(item);
						if (urlCategory == 'category') {
							return {
								label: item.name,
								value: item.category_id
							}
						};
						if (urlCategory == 'product') {
							return {
								label: item.name,
								value: item.product_id
							}
						};
						if (urlCategory == 'manufacturer') {
							return {
								label: item.name,
								value: item.manufacturer_id	
							}
						};
						if (urlCategory == 'information') {
							return {
								label: item.name,
								value: item.information_id	
							}
						};
						/*return {
							label: item.name,
							value: item.category_id
						}*/
					}));
				}
			});
		}, 
		select: function(event, ui) {
			var catBox = '#' + $(this).parent().attr('id') + ' .scrollbox';
			var arrName = $(this).parent().attr('data-array');
			$(catBox + ui.item.value).remove();
			$(catBox).append('<div>' + ui.item.label + '<img src="view/image/delete.png" class="remove" /><input type="hidden" name="'+arrName+'" value="' + ui.item.value + '" /></div>');
			return false;
		},
		focus: function(event, ui) {
		  return false;
	   }
	});
	$(window).off('click', '.scrollbox .remove');
	$(window).on('click', '.scrollbox .remove', function() {
		$(this).parent().remove();
	});

	$(window).off('click', '.auto-selector [type="radio"]');
	$(window).on('click', '.auto-selector [type="radio"]', function(event) {
		//console.log($(this).val());
		//event.preventDefault();
		$(this).val() == 'sel' ? 
		$(this).parent().parent().next().show() :
		$(this).parent().parent().next().hide();
	});
}
