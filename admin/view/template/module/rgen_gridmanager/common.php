var name = '';
var placeholder = '';

function addModule() {	
	html  =	'<div class="module-box">';
				name = '<?php echo $module_key; ?>[modData]['+module_row+'][id]';
	html += '	<input type="hidden" name="'+name+'" class="b_id" />';
	html += '	<table class="subfields withbdr">';
	html += '		<tr>';
	html += '			<td valign="top">';
	html += '				<span class="lbl">Grid size - Desktop or Large screens</span>';
							<?php 
								$ar 	= array(1,2,3,4,5,6,7,8,9,10,11,12);
								$dbKey 	= '3';
							?>
							name = '<?php echo $module_key; ?>[modData]['+module_row+'][col_size]';
							id = 'col'+module_row;
	html += '				<div class="btn-group grid-size mb10" data-toggle="buttons-radio">';
								<?php foreach ($ar as $key => $value) { ?>
									<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
	html += '						<label for="'+id+'<?php echo "-" . $value; ?>" type="button" class="btn-mini btn<?php echo $selected; ?>">';
	html += '							<input type="radio" id="'+id+'<?php echo "-" . $value; ?>" name="'+name+'" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>';
	html += '							<?php echo $value; ?>';
	html += '						</label>';
								<?php } ?>
	html += '				</div>';

	html += '				<span class="lbl">Grid size - Tablet screens</span>';
							<?php 
								$ar 	= array(1,2,3,4,5,6,7,8,9,10,11,12);
								$dbKey 	= '12';
							?>
							name = '<?php echo $module_key; ?>[modData]['+module_row+'][col_size_t]';
							id = 'col-t-'+module_row;
	html += '				<div class="btn-group grid-size-t mb10" data-toggle="buttons-radio">';
								<?php foreach ($ar as $key => $value) { ?>
									<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
	html += '						<label for="'+id+'<?php echo "-" . $value; ?>" type="button" class="btn-mini btn<?php echo $selected; ?>">';
	html += '							<input type="radio" id="'+id+'<?php echo "-" . $value; ?>" name="'+name+'" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>';
	html += '							<?php echo $value; ?>';
	html += '						</label>';
								<?php } ?>
	html += '				</div>';

	html += '				<span class="lbl">Grid size - Tablet screens</span>';
							<?php 
								$ar 	= array(1,2,3,4,5,6,7,8,9,10,11,12);
								$dbKey 	= '12';
							?>
							name = '<?php echo $module_key; ?>[modData]['+module_row+'][col_size_m]';
							id = 'col-m-'+module_row;
	html += '				<div class="btn-group grid-size-m mb10" data-toggle="buttons-radio">';
								<?php foreach ($ar as $key => $value) { ?>
									<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
	html += '						<label for="'+id+'<?php echo "-" . $value; ?>" type="button" class="btn-mini btn<?php echo $selected; ?>">';
	html += '							<input type="radio" id="'+id+'<?php echo "-" . $value; ?>" name="'+name+'" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>';
	html += '							<?php echo $value; ?>';
	html += '						</label>';
								<?php } ?>
	html += '				</div>';

	html += '			</td>';
	html += '			<td valign="top">';
	html += '				<span class="lbl">Select module</span>';
							<?php 
								$ar 	= isset($ext_data) ? $ext_data : '';
								$dbKey 	= '';
							?>
							name = '<?php echo $module_key; ?>[modData]['+module_row+'][selectedMod]';
	html += '				<span class="select mb10">';
	html += '					<select name="'+name+'" class="modlist"><option value="">Select module</option>';
									<?php foreach ($ar as $ar_k => $ar_v) { ?>
	html += '						<optgroup label="<?php echo $ar_k; ?>">';
										<?php if (isset($ar_v) && $ar_v != '') { foreach ($ar_v as $ar_v_k => $ar_v_v) { ?>
											<?php ($ar_v_v['mod_id'] == $dbKey) ? $selected = 'selected' : $selected=''; ?>
	html += '								<option data-key="<?php echo $ar_v_v["modKey"]; ?>" value="<?php echo $ar_v_v["mod_id"]."|".$ar_v_v["ext_id"]; ?>" <?php echo $selected; ?>><?php echo $ar_v_v["ext_name"]; ?></option>';
										<?php } }; ?>
	html += '						</optgroup>';
									<?php } ?>
	html += '					</select>';
								name = '<?php echo $module_key; ?>[modData]['+module_row+'][selectedModKey]';
	html += '					<input type="hidden" class="selectedModKey" name="'+name+'" value="" />'
	html += '				</span>';

	html += '				<div class="mb10">';
	html += '					<span class="lbl">Apply custom CSS class</span>';
								name = '<?php echo $module_key; ?>[modData]['+module_row+'][class]';
	html += '					<input type="text" placeholder="Apply CSS class" name="'+name+'" value="" />';
	html += '				</div>';

	html += '				<div class="mb10">';
	html += '					<span class="lbl">Apply quick inline style</span>';
								name = '<?php echo $module_key; ?>[modData]['+module_row+'][inline]';
	html += '					<input type="text" placeholder="Apply inline style" name="'+name+'" value="" />';
	html += '				</div>';

	html += '				<span class="lbl">Sort order & Status</span>';
							name = '<?php echo $module_key; ?>[modData]['+module_row+'][sort_order]';
	html += '				<input type="text" class="input-mini" name="'+name+'" value="0" style="margin:0px 10px 0 0;" />';
							<?php $dbKey = '1'; ?>
							name = '<?php echo $module_key; ?>[modData]['+module_row+'][status]';
							id = 'status'+module_row;
	html += '				<span class="switch">';
	html += '					<input type="checkbox" id="'+id+'" name="'+name+'" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">';
	html += '					<label for="'+id+'" class="switch-img"></label>';
	html += '					<?php if (!$dbKey) { ?><input type="hidden" name="'+name+'" value="0"><?php }?>';
	html += '				</span>';
	html += '			</td>';
	html += '			<td>';
	html += '				<span class="lbl">Background image</span>';
	html += '				<div class="img-preview img-p1" style="width: 150px;">';
								id = 'bgimg'+module_row; 
								name = '<?php echo $module_key; ?>[modData]['+module_row+'][bgimg]';
	html += '					<div class="img-holder" style="background-image:url(<?php echo $no_img; ?>);" id="'+id+'-preview"></div>';
	html += '					<div class="btn-group btn-group" style="background: #eee;">';
	html += '						<a class="btn btn-mini browse" data-id="'+id+'">Browse</a>';
	html += '						<a class="btn btn-mini clear" data-id="'+id+'">Clear</a>';
	html += '					</div>';
	html += '					<input type="hidden" id="'+id+'" name="'+name+'" value="" />';
	html += '				</div>';

	html += '			</td>';
	html += '		</tr>';
	html += '	</table>';
	html += '	<a class="btn-small btn-danger mod-del"><i class="icon-remove icon-white"></i></a>';
	html += '</div>';
	html += '';
							
	name = '<?php echo $module_key; ?>[modData]['+module_row+'][extmod_name]';
	$('.grid-preview .rw').append('<div class="gr3"><div class="g-in"><div class="size">Column size - 3</div><div class="mod">No any module selected</div><input type="hidden" name="'+name+'" value="" /></div></div>');
	$('.block-container').append(html);
	module_row++;
	imageUpload();
}

function gridSettings(){
	$('.module-box').each(function(index, val) {
		$(this).attr('id', 'mb'+index);
	});
	$('.block-container .grid-size').each(function(index, val) {
		$(this).attr('data-grid', 'mb'+index);
	});
	$('.grid-preview .rw > div').each(function(index, val) {
		$(this).attr('data-id', 'mb'+index);
	});
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
	modkey('.block-container > div', '.b_id');
	gridSettings();
});

$(window).off( "click", ".mod-del");
$(window).on('click', '.mod-del', function() {
	$('html, body').animate({ scrollTop: 0 }, 'slow'); 
	var obj = this;
	var col = $(this).parent().attr('id');
	$('.grid-preview .rw > div[data-id="'+col+'"]').remove();
	
	setTimeout(function(){ 
		console.log("set time out");
		$(obj).parent().remove();
		modkey('.block-container > div', '.b_id');
		gridSettings();
	},100);
});

$(window).on('click', '.grid-size input[type="radio"]', function(event) {
	var g = $(this).val();
	var id = $(this).parent().parent().attr('data-grid');
	var gBox = ".grid-preview .rw > div[data-id='"+id+"']";
	$(gBox).removeAttr('class');
	$(gBox).addClass('gr'+g);
	$(gBox).find('.g-in .size').text('Column size - '+g);
});

$(window).off( "change click", ".modlist");
$(window).on('change click', '.modlist', function(event) {
	$(this).next('.selectedModKey').val($(this).find("option:selected").attr('data-key'));
	var id = $(this).closest(".module-box").attr("id");
	var gBox = ".grid-preview .rw > div[data-id='"+id+"']";
	var lbl = $(this).find("option:selected").parent().attr('label') ? '<strong>'+$(this).find("option:selected").parent().attr('label')+'</strong><br>' : '';
	var lblval = $(this).find("option:selected").text();
	$(gBox).find('.g-in .mod').html(lbl+lblval);
	$(gBox).find('.g-in .mod').next().val(lbl+lblval);
	//console.log(id);
});

function imageUpload(){
	$('.img-preview').setImage({
		token: '<?php echo $token; ?>',
		no_img: '<?php echo $no_img; ?>'
	});	
} imageUpload();


