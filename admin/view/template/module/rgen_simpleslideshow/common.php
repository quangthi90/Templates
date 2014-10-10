var name = '';
var placeholder = '';

function addModule() {	
	html  = '<tr class="tbl-vm" id="row'+module_row+'"><td>';
				name = '<?php echo $module_key; ?>[image_data]['+module_row+'][id]';
	html += '	<input type="hidden" name="'+name+'" class="b_id" />';

	html += '	<label class="lbl-1">Caption<a class="helpbtn helpbtn1" data-type="page" data-title="Caption formating" data-info="view/image/rgen_theme/rgen_simpleslideshow.html">Formating info</a></label>';
				<?php foreach ($languages as $language) { ?>
				name = '<?php echo $module_key; ?>[image_data]['+module_row+'][title][<?php echo $language["language_id"] ?>]';
				placeholder	= '<?php echo $language['name'];  ?> - Enter title';
	//html += '	<input type="text" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 225px 8px; padding-right: 40px;" placeholder="'+placeholder+'" name="'+name+'" value=""><br>';
	html += '	<textarea placeholder="'+placeholder+'" name="'+name+'" cols="10" rows="4" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 420px 8px; padding-right: 40px; width: 400px; font-size:12px;"></textarea><br>';
				<?php } ?>
				
	html += '	<label class="lbl-1">Caption settings</label>';
	html += '	<div>';
	html += '		<a data-url="view/template/module/<?php echo $modSettings['modKey']; ?>/cp_settings.php" data-title="Caption settings" class="popup btn mb10">Edit</a>';
					<?php $dbKey 	= $cpSettings; ?>
					name = '<?php echo $module_key; ?>[image_data]['+module_row+'][cpSettings]';
	html += '		<input type="hidden" class="cpSettings" name="'+name+'" value="<?php echo $dbKey; ?>" />';
	html += '	</div>';
	
	html += '	<label class="lbl-1">URL</label>';
				name = '<?php echo $module_key; ?>[image_data]['+module_row+'][urlType]';
	html += '	<span class="select" style="margin-bottom: 5px;">';
	html += '		<select name="'+name+'" style="width: 254px;" class="url-types">';
					<?php foreach ($urlType as $key => $value) { ?>
	html += '		<option value="<?php echo $value; ?>"><?php echo $key; ?></option>';
					<?php } ?>
	html += '		</select>';
	html += '	</span>';

	html += '	<div class="url-container">';
	html += '		<div class="other">';
						name = '<?php echo $module_key; ?>[image_data]['+module_row+'][url]';
	html += '			<input type="text" placeholder="Enter your url" name="'+name+'" value="" style="width: 240px;" />';
	html += '		</div>';

	html += '		<div class="category" style="display: none;">';
	html += '			<input type="text" class="cat-auto" placeholder="Type category name to insert" value="" style="width: 240px;" />';
						name = '<?php echo $module_key; ?>[image_data]['+module_row+'][cat_id]';
	html += '			<input type="hidden" class="auto-val" name="'+name+'" value="" />';
	html += '		</div>';

	html += '		<div class="product" style="display: none;">';
	html += '			<input type="text" class="prd-auto" placeholder="Type product name to insert" value="" style="width: 240px;" />';
						name = '<?php echo $module_key; ?>[image_data]['+module_row+'][prd_id]';
	html += '			<input type="hidden" class="auto-val" name="'+name+'" value="" />';
	html += '		</div>';

	html += '		<div class="brand" style="display: none;">';
	html += '			<input type="text" class="brn-auto" placeholder="Type manufacturer name to insert" value="" style="width: 240px;" />';
						name = '<?php echo $module_key; ?>[image_data]['+module_row+'][brn_id]';
	html += '			<input type="hidden" class="auto-val" name="'+name+'" value="" />';
	html += '		</div>';

	html += '		<div class="info" style="display: none;">';
	html += '			<input type="text" class="inf-auto" placeholder="Type information page to insert" value="" style="width: 240px;" />';
						name = '<?php echo $module_key; ?>[image_data]['+module_row+'][inf_id]';
	html += '			<input type="hidden" class="auto-val" name="'+name+'" value="" />';
	html += '		</div>';
	html += '	</div>';


	html += '	<table class="subfields withbdr">';
	html += '		<tr>';
	html += '			<td>';
	html += '				<label class="lbl-1">Open in new window</label>';
							<?php $ar = array('Yes'=>'y', 'No'=>'n'); $dbKey = 'n'; ?>
							name = '<?php echo $module_key; ?>[image_data]['+module_row+'][new_win]';
	html += '				<div class="btn-group" data-toggle="buttons-radio">';
								<?php foreach ($ar as $key => $value) { ?>
								id = 'new_win'+module_row+'-<?php echo $value; ?>';
								<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
	html += '					<label for="'+id+'"  type="button" class="btn-small btn<?php echo $selected; ?>">';
	html += '						<input type="radio" id="'+id+'" name="'+name+'" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>';
	html += '						<?php echo $key; ?>';
	html += '					</label>';
								<?php } ?>
	html += '				</div>';
	html += '			</td>';
	html += '		</tr>';
	html += '	</table>';
					
				
	html += '</td><td class="tc">';

				<?php foreach ($languages as $language) { ?>
	html += '	<div class="img-preview img-p1" style="vertical-align: top; width: auto;">';
					id = 'banner<?php echo $language["language_id"]; ?>'+module_row;
					name = '<?php echo $module_key; ?>[image_data]['+module_row+'][image][<?php echo $language["language_id"]; ?>]';
	html += '		<div class="img-holder" style="background-image:url(<?php echo $no_img; ?>);" id="'+id+'-preview"></div>';
	html += '		<div class="btn-group btn-group" style="background:url(view/image/flags/<?php echo $language["image"]; ?>) no-repeat 132px 11px #eee;">';
	html += '			<a class="btn btn-mini browse" data-id="'+id+'">Browse</a>';
	html += '			<a class="btn btn-mini clear" data-id="'+id+'">Clear</a>';
	html += '		</div>';
	html += '		<input type="hidden" id="'+id+'" name="'+name+'" value="" />';
	html += '	</div>';
				<?php } ?>

	html += '</td><td>';

				<?php $dbKey = '0'; ?>
				name = '<?php echo $module_key; ?>[image_data]['+module_row+'][status]';
				id = 'status'+module_row;
	html += '	<span class="switch">';
	html += '		<input type="checkbox" id="'+id+'" name="'+name+'" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">';
	html += '		<label for="'+id+'" class="switch-img"></label>';
	html += '		<?php if (!$dbKey) { ?><input type="hidden" name="'+name+'" value="0"><?php }?>';
	html += '	</span>';

	html += '</td><td>';

				name = '<?php echo $module_key; ?>[image_data]['+module_row+'][sort_order]';
	html += '	<input type="text" class="input-mini" name="'+name+'" value="0" style="margin:0px;" />';

	html += '</td><td><a class="btn btn-danger mod-del"><i class="icon-remove icon-white"></i></a></td></tr>';
	html += '';
	$('.banner-container').append(html);
	module_row++;

	catAutocomplete('.cat-auto');
	prdAutocomplete('.prd-auto');
	brandAutocomplete('.brn-auto');
	infoAutocomplete('.inf-auto');
	imageUpload();
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
	modkey('.banner-container tr', '.b_id');
});

$(window).off( "click", ".mod-del");
$(window).on('click', '.mod-del', function() {
	$(this).parent().parent().remove();
	modkey('.banner-container tr', '.b_id');
});

function imageUpload(){
	$('.img-preview').setImage({
		token: '<?php echo $token; ?>',
		no_img: '<?php echo $no_img; ?>'
	});	
} imageUpload();


$(window).off('click', '.popup');
$(window).on('click', '.popup', function(event) {
	event.preventDefault();
	blockSection("#mod-settings", '#d8d1c7');
	var source = this;
	var getTitle = $(this).attr('data-title');

	$(source).addClass('pop-active');
	$.ajax({
		type: "POST",
		url: $(this).attr('data-url'),
		dataType: "html",
		success: function(data, source) {
			$('#dialog-data').html('');
			$('#dialog-data').html(data);

			$('#dialog-data').dialog({
				title: getTitle,
				dialogClass: "model-box",
				open: function(event, ui) {
					var popup = this;
					$(popup).find('.apply').click(function(event) {
						blockSection(".ui-dialog", '#d8d1c7');
						setTimeout(function(){
							$(popup).dialog("close");
							$('.ui-dialog').unblock();
						}, 500);
					});
				},
				close: function (event, ui) {
					$('#dialog-data').html('');
					$('.pop-active').removeClass('pop-active');
				},
				width: 800,
				resizable: false,
				modal: true
			});

			$('#mod-settings').unblock();
		}
	});
});
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