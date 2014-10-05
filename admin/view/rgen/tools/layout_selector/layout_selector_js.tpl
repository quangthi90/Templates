<?php /*
token
count		= counter apply
type 		= category, product, manufacturer or information
cssClass	= custom class (cat-selection)
nameVal		= 'rgen_customproducts_module[' . $module_row . '][cat_status]';
holderName	= $module_key.'['.$module_row.'][category][]';
autolist_v1	= 'name'
autolist_v2	= 'category_id'

URLS 
============
'index.php?route=catalog/information/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
*/ ?>

html += '<div class="select-wrp '+type+'">';
html += '	<div class="'+cssClass+'" id="autoSelect'+count+type+'-sel">';
				<?php
					$ar = array( 'All' => 'all', 'Selected' => 'sel');
					$dbKey 	= 'all';
				?>
				id = 'auto_status'+type+count;
html += '		<div class="btn-group auto-selector" data-toggle="buttons-radio">';
					<?php foreach ($ar as $key => $value) { ?>
						<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
html += '				<label for="'+id+'<?php echo '-' . $value; ?>"  type="button" class="btn-small btn<?php echo $selected; ?>">';
html += '					<input type="radio" id="'+id+'<?php echo '-' . $value; ?>" name="'+nameVal+'" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>';
html += '					<?php echo $key; ?>';
html += '				</label>';
					<?php } ?>
html += '		</div>';

html += '		<div class="selected-items" id="auto-selected'+count+type+'" data-array="'+holderName+'" style="display:none;">';
html += '			<input type="text" placeholder="Type category name to insert" class="auto-textbox find-'+count+type+'" value="" /><br>';
html += '			<div class="select_scrollbox scrollbox">';
html += '			</div>';
html += '		</div>';
html += '	</div>';
html += '</div>';
html += '<script>';
html += 'autocompleteTool(".find-'+count+type+'", "'+type+'", "'+token+'");';
html += '</script>';