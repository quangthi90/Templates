<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="view/rgen/lib/Messi-master/messi.css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/rgenadmin.css" />
<link rel='stylesheet' type="text/css" href='view/stylesheet/spectrum.css' />
<link rel='stylesheet' type="text/css" href='view/rgen/lib/Magnific-Popup/magnific-popup.css' />

<style type="text/css">
@font-face {
font-family: 'rgenregular';
src: url('../catalog/view/theme/rgen-opencart/image/rgen/icons/rgen-webfont.eot');
src: url('../catalog/view/theme/rgen-opencart/image/rgen/icons/rgen-webfont.eot?#iefix') format('embedded-opentype'),
   url('../catalog/view/theme/rgen-opencart/image/rgen/icons/rgen-webfont.woff') format('woff'),
   url('../catalog/view/theme/rgen-opencart/image/rgen/icons/rgen-webfont.ttf') format('truetype'),
   url('../catalog/view/theme/rgen-opencart/image/rgen/icons/rgen-webfont.svg#rgenregular') format('svg');
font-weight: normal;
font-style: normal;
}
.blockMsg { top: 15% !important; background: url(view/image/rgen_theme/ajax-loader.gif) no-repeat center 25px;  }
.rgen-sd-td-mod #main-tabs .brand { width: 140px; }
.rgen-sd-td-mod [data-theme="tab1"].tabs-left > .nav-tabs { width: 190px; }
.rgen-sd-td-mod #module-add { width: 130px; }
.messi-actions .btnbox .btn { padding: 4px 15px;}
</style>
<?php if(!$checkPermission){ ?>
<input type="hidden" id="permission" val="demo">
<?php } ?>
<div class="content-wrp">
	<div id="content" class="rgen-sd-td-mod">
		<div class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
			<?php } ?>
		</div>
		<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
		<?php } ?>
		<div class="box" id="main-wrapper">
			<!-- MAIN TABS START -->
			<div class="navbar" id='main-tabs'>
				<div class="navbar-inner">
					<span class="brand">R.Gen Theme<b><?php if (isset($version)) { echo $version; }else{ echo $ver; } ?></b></span>
					<ul class="nav">
						<li class="active">
							<a data-container=".mod-wrapper" data-url="index.php?route=module/<?php echo $modSettings['modKey']; ?>/assign&token=<?php echo $token; ?>">ASSIGN MODULES</a>
						</li>
						<li>
							<a data-container=".mod-wrapper" data-url="index.php?route=module/<?php echo $modSettings['modKey']; ?>/manage&token=<?php echo $token; ?>">MANAGE MODULES</a>
						</li>
					</ul>
				</div>
			</div>

			<form id="form" enctype="multipart/form-data">
				<div class="mod-wrapper"></div>
			</form>
		</div>
	</div>
</div>

<script src="view/javascript/rgen/bootstrap.min.js"></script>
<script src="view/javascript/rgen/rgenadmin.js"></script>
<script src="view/javascript/rgen/jquery.blockUI.js"></script>
<script src="view/rgen/lib/Messi-master/messi.min.js"></script>
<script src='view/javascript/rgen/spectrum.js'></script>
<script src='view/rgen/lib/Magnific-Popup/jquery.magnific-popup.min.js'></script>

<script type="text/javascript"><!--
//blockSection();
$("#main-tabs .nav a").rgenPost({
	before: function(){
		blockSection("#main-wrapper", '#d8d1c7');
	},
	after: function(data){
		$('#main-wrapper').unblock();
	},
	firstClick: true
});


function save(urlVal, dataContent, reLoad, msg){
	if($("body").find("#permission").length>0){
		permissionCheck();
	}else{
		$('body').prepend('<div class="saving"><span>Please wait...<span></div>');
		$(".saving").css({height: $("html").height()});
		if (typeof CKEDITOR != 'undefined'){ for(instance in CKEDITOR.instances){ CKEDITOR.instances[instance].updateElement(); } }
		
		$.ajax({
			type: "POST",
			url: urlVal,
			data: $(dataContent+' input[type=\'text\'],'+dataContent+' input[type=\'checkbox\']:checked,'+dataContent+' input[type=\'radio\']:checked,'+dataContent+' input[type=\'hidden\'],'+dataContent+' select,'+dataContent+' textarea').serializeArray(),
			dataType: "html",
			success: function(data) {
				//console.log(dataContent);
				console.log(data);
				if (data == "no data") {
					new Messi(
						'<p>No data added in module to save. Please add some data to save module.</p>', {
						modal: true, modalOpacity: 0.5,
						buttons: [{id: 0, val: 'y', label: 'Ok', class: 'btn-small btn-danger'}],
						callback: function(val) {
							if (val == 'y') {
								location.reload();
							};
						}
					});
				}else{
					if (reLoad == true) {
						successMsg(msg);
						location.reload();
					}else{
						successMsg(msg);
					};
				};
				
			}
		});
	}
}

function setswitch(){
	$(window).on("click",".switch",function(){
		var id = $(this).find('input[type="checkbox"]').attr('id');
		var name = $(this).find('input[type="checkbox"]').attr('name');

		if ($(this).find('input[type="checkbox"]').is(':checked')) {
			$(this).find('input[type="hidden"]').remove();
		} else {
		    $(this).append('<input type="hidden" name="' + name + '" value="0">');
		} 
	});
}
setswitch();

function permissionCheck(){
	// Loading screen
	$('body').prepend('<div class="saving"><span>Please wait...<span></div>');
	$(".saving").css({height: $("html").height()});
	$('.saving').addClass('error-msg').find("span").text("<?php echo $this->language->get('error_permission'); ?>").css({backgroundImage:""});
	$('.saving').animate({opacity:1}, 2000, function(){
		$('.saving').animate({opacity:0}, 300, function(){$('.saving').css({display:"none"}); $(".saving").remove();});
	});
}

function successMsg(msg){
	// Loading screen
	$('.saving').addClass('success-msg').find("span").text(msg).css({backgroundImage:""});
	$('.saving').animate({opacity:1}, 500, function(){
		$('.saving').animate({opacity:0}, 300, function(){$('.saving').css({display:"none"}); $(".saving").remove();});
	});
}

/*function image_upload(field, previewImg) {
	$('#dialog').remove();
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	$('#dialog').dialog({
		title: 'This is testing Image manager<br><div class="path">Uploaded image path to use in content => image/data/ Folder name if created / image name without space </div>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(data) {
						$('#' + previewImg).css({backgroundImage: 'url(' + data + ')'});
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: true,
		modal: false
	});
};*/

// Category
function catAutocomplete(inputObj) {
	$(inputObj).autocomplete({
		delay: 100,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item.name,
							value: item.category_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$(this).next('.auto-val').val(ui.item.value);
			return false;
		},
		focus: function(event, ui) { return false; }
	});
}

function prdAutocomplete(inputObj) {
	$(inputObj).autocomplete({
		delay: 100,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item.name,
							value: item.product_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$(this).next('.auto-val').val(ui.item.value);
			return false;
		},
		focus: function(event, ui) { return false; }
	});
}


// Manufacturer
function brandAutocomplete(inputObj) {
	$(inputObj).autocomplete({
		delay: 100,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item.name,
							value: item.manufacturer_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$(this).next('.auto-val').val(ui.item.value);
			return false;
		},
		focus: function(event, ui) { return false; }
	});
}


// Information
function infoAutocomplete(inputObj) {
	$(inputObj).autocomplete({
		delay: 100,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/information/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {	
					response($.map(json, function(item) {
						return {
							label: item.name,
							value: item.information_id
						}
					}));
				}   
			});
		}, 
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$(this).next('.auto-val').val(ui.item.value);
			return false;
		},
		focus: function(event, ui) { return false; }
	});
}


//--></script>



<?php echo $footer; ?>