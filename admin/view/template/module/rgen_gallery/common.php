var name = '';
var placeholder = '';

function addModule() {	
	html  =	'<div class="gallery-box">';
				name = '<?php echo $module_key; ?>[image_data]['+module_row+'][id]';
	html += '	<input type="hidden" name="'+name+'" class="b_id" />';
	html += '	<table class="subfields withbdr">';
	html += '		<tr>';
	html += '			<td>';
							
	html += '				<div class="img-preview img-p1">';
								id = 'banner1'+module_row;
								name = '<?php echo $module_key; ?>[image_data]['+module_row+'][image][1]';
	html += '					<div class="img-holder" style="background-image:url(<?php echo $no_img; ?>);" id="'+id+'-preview"></div>';
	html += '					<div class="btn-group btn-group" style="background: #eee;">';
	html += '						<a class="btn btn-mini browse" data-id="'+id+'">Browse</a>';
	html += '						<a class="btn btn-mini clear" data-id="'+id+'">Clear</a>';
	html += '					</div>';
	html += '					<input type="hidden" id="'+id+'" name="'+name+'" value="" />';
	html += '				</div>';

	html += '			</td>';
	html += '			<td>';
	html += '				<span class="lbl">Image title</span>';
							<?php foreach ($languages as $language) { ?>
							name = '<?php echo $module_key; ?>[image_data]['+module_row+'][title][<?php echo $language["language_id"] ?>]';
							placeholder	= '<?php echo $language['name'];  ?> - Enter title';
	html += '				<input type="text" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 225px 8px; padding-right: 40px; margin-bottom: 5px;" placeholder="'+placeholder+'" name="'+name+'" value=""><br>';
							<?php } ?>
							

	html += '				<br><span class="lbl">Sort order & Status</span>';
							name = '<?php echo $module_key; ?>[image_data]['+module_row+'][sort_order]';
	html += '				<input type="text" class="input-mini" name="'+name+'" value="0" style="margin:0px 10px 0 0;" />';
							<?php $dbKey = '0'; ?>
							name = '<?php echo $module_key; ?>[image_data]['+module_row+'][status]';
							id = 'status'+module_row;
	html += '				<span class="switch">';
	html += '					<input type="checkbox" id="'+id+'" name="'+name+'" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">';
	html += '					<label for="'+id+'" class="switch-img"></label>';
	html += '					<?php if (!$dbKey) { ?><input type="hidden" name="'+name+'" value="0"><?php }?>';
	html += '				</span>';

	html += '			</td>';
	html += '		</tr>';
	html += '	</table>';
	html += '	<a class="btn-small btn-danger mod-del"><i class="icon-remove icon-white"></i></a>';
	html += '</div>';
	html += '';

	$('.banner-container').append(html);
	module_row++;
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
	modkey('.banner-container > div', '.b_id');
});

$(window).off( "click", ".mod-del");
$(window).on('click', '.mod-del', function() {
	$(this).parent().remove();
	modkey('.banner-container > div', '.b_id');
});

function imageUpload(){
	$('.img-preview').setImage({
		token: '<?php echo $token; ?>',
		no_img: '<?php echo $no_img; ?>'
	});	
} imageUpload();
