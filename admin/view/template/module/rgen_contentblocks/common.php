var name = '';
var placeholder = '';

function addModule() {	
	tab  = '<li><a href="#tab-block-'+module_row+'">Block '+module_row+'</a><i class="icon-remove ml10 mod-del"></i></li>';
	$('.tb-left .nav-tabs').append(tab);

	html  = '<div class="tab-pane new-pn'+module_row+'" id="tab-block-'+module_row+'">';
				name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][id]';
	html += '	<input type="hidden" name="'+name+'" class="moddata_id" />';

	html += '	<div class="control-group">';
	html += '		<label class="control-label">Status and sort order:</label>';
	html += '		<div class="controls">';
						name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][sort_order]';
	html += '			<input type="text" class="input-mini mr10" name="'+name+'" value="0" />';
						<?php $dbKey = '0'; ?>
						name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][status]';
						id = 'status'+module_row;
	html += '			<span class="switch">';
	html += '				<input type="checkbox" id="'+id+'" name="'+name+'" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">';
	html += '				<label for="'+id+'" class="switch-img"></label>';
	html += '				<?php if (!$dbKey) { ?><input type="hidden" name="'+name+'" value="0"><?php }?>';
	html += '			</span>';
	html += '		</div>';
	html += '	</div>';

	/*html += '	<div class="control-group">';
	html += '		<label class="control-label">Block background</label>';
	html += '		<div class="controls block-bg">';
					name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][bg]';
	html += '		<input type="text" class="rgb" name="'+name+'" value="rgba(0,0,0,0)" />';
	html += '		</div>';
	html += '	</div>';*/

	html += '	<div class="control-group">';
	html += '		<label class="control-label">Block settings</label>';
	html += '		<div class="controls">';
	html += '			<a data-url="view/template/module/rgen_contentblocks/blocksettings.php" data-title="Block settings" data-token="<?php echo $token; ?>" data-image="<?php echo $no_img; ?>" data-h="800" class="popup btn mb10">Edit</a>';
						name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][blocksettings]';
	html += '			<input type="hidden" class="blocksettings" name="'+name+'" value="rgba(0,0,0,0)|rgba(0,0,0,0)||||||" data-labels="Block background|Block border color|Block title color|Block text color|Block inline css|Image inline css|Title inline css|Content inline css" data-labels="Block background|Block border color|Block title color|Block text color|Block inline css|Image inline css|Title inline css|Content inline css" />';
	html += '		</div>';
	html += '	</div>';
	html += '	<script>';
	html += '	var obj = ".new-pn'+module_row+' .blocksettings";';
	html += '	$(obj).summary({';
	html += '		dbkey: $(obj).attr("value"),';
	html += '		labels: $(obj).attr("data-labels"),';
	html += '		place: obj,';
	html += '		callback: function(index, val){}';
	html += '	});';
	html += '	</\script>';

	html += '	<div class="control-group">';
	html += '		<label class="control-label">Image settings</label>';
	html += '		<div class="controls">';
	html += '			<a data-url="view/template/module/rgen_contentblocks/imagesettings.php" data-title="Image settings" data-token="<?php echo $token; ?>" data-image="<?php echo $no_img; ?>" data-h="800" class="popup btn mb10">Edit</a>';
						name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][imgsettings]';
	html += '			<input type="hidden" class="imgsettings" name="'+name+'" value="rgba(0,0,0,0)|rgba(0,0,0,0)|img|||20|rgba(255,255,255,1)" data-labels="Image background|Image border color|Image type|Image src|Icon class|Icon size|Icon color" />';
	html += '		</div>';
	html += '	</div>';
	html += '	<script>';
	html += '	var obj = ".new-pn'+module_row+' .imgsettings";';
	html += '	$(obj).summary({';
	html += '		dbkey: $(obj).attr("value"),';
	html += '		labels: $(obj).attr("data-labels"),';
	html += '		place: obj,';
	html += '		callback: function(index, val){';
	html += '			if (val == "ico") { val = "Icon"; };';
	html += '			if (val == "img") { val = "Image"; };';
	html += '			return val;';
	html += '		}';
	html += '	});';
	html += '	</\script>';
	
	html += '	<div class="control-group">';
	html += '		<label class="control-label">Title</label>';
	html += '		<div class="controls">';
						<?php foreach ($languages as $language) { ?>
						name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][title][<?php echo $language["language_id"] ?>]';
						placeholder	= '<?php echo $language['name'];  ?> - Enter title';
	html += '			<input type="text" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 225px 8px; padding-right: 40px;" placeholder="'+placeholder+'" name="'+name+'" value=""><br>';
						<?php } ?>
	html += '		</div>';
	html += '	</div>';

	html += '	<div class="control-group">';
	html += '		<label class="control-label">Description</label>';
	html += '		<div class="controls">';
						<?php foreach ($languages as $language) { ?>
						name = '<?php echo $module_key; ?>[mod_data]['+module_row+'][short_description][<?php echo $language["language_id"] ?>]';
						placeholder	= '<?php echo $language['name'];  ?> - Enter description';
	html += '			<textarea placeholder="'+placeholder+'" name="'+name+'" cols="30" rows="5" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 420px 8px; padding-right: 40px; width: 400px;"></textarea><br>';
						<?php } ?>
	html += '		</div>';
	html += '	</div>';


	html += '</div>';
	html += '';
	$('.tb-left .tab-content').append(html);


	module_row++;

	imageUpload();
	tabReset();
	colorPic('.block-bg');
}

$(window).off( "change", ".url-types");
$(window).on('change', '.url-types', function(event) {
	event.preventDefault();
	$(this).parent().next('.url-container').children('div').hide();
	$(this).parent().next('.url-container').find('.'+$(this).val()).show();
});

$(window).off( "click", ".mod-add");
$(window).on('click', '.mod-add', function() {
	addModule();
	modkey('.tb-left .tab-content .tab-pane', '.moddata_id');
	$(".tb-left li:first a").click();
});

$(window).off( "click", ".mod-del");
$(window).on('click', '.mod-del', function() {
	$($(this).prev().attr('href')).remove();
	$(this).parent().remove();
	if ($(".tb-left li").length > 0) {
		$(".tb-left li:first a").click();
	};
	//modkey('.banner-container tr', '.b_id');
	modkey('.tb-left .tab-content .tab-pane', '.moddata_id');
});

function imageUpload(){
	$('.img-preview').setImage({
		token: '<?php echo $token; ?>',
		no_img: '<?php echo $no_img; ?>'
	});	
} imageUpload();

function tabReset(){
	$(".tb-left li").each(function(index, val) {
		$(this).find('a').text('Block '+(index+1));
		$(this).find('a').attr('href', '#tab-block-'+(index+1));
		$(this).find('a').attr('href', '#tab-block-'+(index+1));
	});
	$(".tb-left .tab-pane").each(function(index, val) {
		$(this).attr('id', 'tab-block-'+(index+1));
	});
}

jQuery(document).ready(function($) {
	tabReset();
	$(window).on("click", '.tb-left .nav-tabs a', function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$(".tb-left li:first a").click();
});

function colorPic(parent) {
	$(parent+' .rgb').spectrum("destroy");
	$(parent+' .sp-replacer').remove();
	colorPicker(parent+' .rgb', 'rgb');
}
colorPic('.block-bg');

//$(window).off( "click", ".browse");
/*$(window).on('click', '.browse', function() {
	//$(this).setImage();
	//image_upload($(this).attr('data-id'), $(this).attr('data-id')+'-preview');
});*/
/*$(window).off( "click", ".clear");
$(window).on('click', '.clear', function() {
	$('#'+$(this).attr('data-id')+'-preview').css({backgroundImage: 'url(<?php echo $no_img; ?>)'});
	$('#'+$(this).attr('data-id')).attr('value', '');
});*/