<div id="<?php echo $module_key; ?>">
	<div class="section-title">
		Edit module
		<div class="buttons pull-right" style="margin: -9px -10px 0 0;">
			<a id="saveBtn" class="btn btn-success btn-large">Save</a>
		</div>
	</div>
	<h4>General settings</h4>
	<div class="form-horizontal">
		<?php 
			$dbKey 	= isset($module['mod_id']) ? $module['mod_id'] : $module_key;
			$name	= $module_key.'[mod_id]';
		?>
		<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
		<div class="control-group">
			<label class="control-label">Module name</label>
			<div class="controls">
				<?php 
					$dbKey 	= isset($module['modName']) ? $module['modName'] : 'Module '.$module_row;
					$name	= $module_key.'[modName]';
				?>
				<input type="text" placeholder="Module name" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
			</div>
		</div>
	</div>

	<h4>Add grid blocks <a class='btn btn-success mod-add' style="margin: 0 0 0 20px;"><i class="icon-plus icon-white"></i></a></h4>
	<div class="form-horizontal clearfix block-container">
		<div class="grid-preview">
			<div>
				<h4 style="margin: 0 0 5px 0;">Grid block size preview</h4>
				<div class="help-block" align="center" style="margin: 0 0 20px 0;">
					Grid blocks work based on Bootstrap grid concept.
				</div>
				<div class="rw">
					<?php 
					$i = 0;
					$modData = 'modData';
					if (isset($module[$modData])) { ?>
					<?php foreach ($module[$modData] as $k => $mod_v) { ?>
					<div class="gr<?php echo $mod_v['col_size'] ?>" data-id="mb<?php echo $mod_v['id']; ?>">
						<div class="g-in">
							<div class="size">Column size - <?php echo $mod_v['col_size'] ?></div>
							<?php if (isset($ext_list) && in_array($mod_v["selectedMod"], $ext_list)) { ?>
							<?php 
								$dbKey 	= isset($mod_v['extmod_name']) ? $mod_v['extmod_name'] : 'No any module selected';
								$name	= $module_key.'['.$modData.']['.$i.'][extmod_name]';
							?>
							<div class="mod"><?php echo htmlspecialchars_decode($dbKey, ENT_QUOTES); ?></div>
							<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
							<?php } else { ?>
							<div class="mod">No any module selected</div>
							<?php } ?>
						</div>
					</div>
					<?php $i++; }} ?>
				</div>
			</div>
		</div>
	<?php 
	$i = 0; 
	$modData = 'modData';
	if (isset($module[$modData])) { ?>
	<?php foreach ($module[$modData] as $k => $mod_v) {
	/*if (in_array($mod_v["selectedMod"], $ext_list)) {*/ ?>
	<div class="module-box" id="mb<?php echo $mod_v['id']; ?>">
		<?php 
			$dbKey 			= isset($mod_v['id']) ? $mod_v['id'] : null;
			$name			= $module_key.'['.$modData.']['.$i.'][id]';
		?>
		<input type="hidden" name="<?php echo $name; ?>" class="b_id" value="<?php echo $dbKey; ?>" />
		<table class="subfields withbdr">
			<tr>
				<td valign="top">
					<span class="lbl">Grid size - Desktop or Large screens</span>
					<?php 
						$ar 	= array(1,2,3,4,5,6,7,8,9,10,11,12);
						$dbKey 	= isset($mod_v['col_size']) ? $mod_v['col_size'] : '3';
						$name	= $module_key.'['.$modData.']['.$i.'][col_size]';
						$id		= 'col'.$mod_v['id'];
					?>
					<div class="btn-group grid-size mb10" data-toggle="buttons-radio" data-grid="mb<?php echo $mod_v['id']; ?>">
						<?php foreach ($ar as $key => $value) { ?>
							<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
							<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn<?php echo $selected; ?>">
								<input type="radio" id="<?php echo $id . '-' . $value; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>
								<?php echo $value; ?>
							</label>
						<?php } ?>
					</div>

					<span class="lbl">Grid size - Tablet screens</span>
					<?php 
						$ar 	= array(1, 2,3,4,5,6,7,8,9,10,11,12);
						$dbKey 	= isset($mod_v['col_size_t']) ? $mod_v['col_size_t'] : '12';
						$name	= $module_key.'['.$modData.']['.$i.'][col_size_t]';
						$id		= 'col-t-'.$mod_v['id'];
					?>
					<div class="btn-group grid-size-t mb10" data-toggle="buttons-radio" data-grid="mb<?php echo $mod_v['id']; ?>">
						<?php foreach ($ar as $key => $value) { ?>
							<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
							<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn<?php echo $selected; ?>">
								<input type="radio" id="<?php echo $id . '-' . $value; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>
								<?php echo $value; ?>
							</label>
						<?php } ?>
					</div>

					<span class="lbl">Grid size - Mobile screens</span>
					<?php 
						$ar 	= array(1, 2,3,4,5,6,7,8,9,10,11,12);
						$dbKey 	= isset($mod_v['col_size_m']) ? $mod_v['col_size_m'] : '12';
						$name	= $module_key.'['.$modData.']['.$i.'][col_size_m]';
						$id		= 'col-m-'.$mod_v['id'];
					?>
					<div class="btn-group grid-size-m mb10" data-toggle="buttons-radio" data-grid="mb<?php echo $mod_v['id']; ?>">
						<?php foreach ($ar as $key => $value) { ?>
							<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
							<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn<?php echo $selected; ?>">
								<input type="radio" id="<?php echo $id . '-' . $value; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>
								<?php echo $value; ?>
							</label>
						<?php } ?>
					</div>

				</td>
				<td valign="top">
					<span class="lbl">Select module</span>
					<?php 
						$ar 	= isset($ext_data) ? $ext_data : '';
						$dbKey 	= isset($mod_v['selectedMod']) ? $mod_v['selectedMod'] : '';
						$name	= $module_key.'['.$modData.']['.$i.'][selectedMod]';
						$id		= 'selectedMod'.$mod_v['id'];
					?>
					<span class='select mb10'>
						<select name="<?php echo $name; ?>" class="modlist">
							<option data-key="" value="">Select module</option>
							<?php foreach ($ar as $ar_k => $ar_v) { ?>
								<optgroup label="<?php echo $ar_k; ?>">
								<?php if (isset($ar_v) && $ar_v != '') { foreach ($ar_v as $ar_v_k => $ar_v_v) { ?>
									<?php ($ar_v_v['mod_id'].'|'.$ar_v_v['ext_id'] == $dbKey) ? $selected = 'selected' : $selected=''; ?>
									<option data-key="<?php echo $ar_v_v['modKey']; ?>" value="<?php echo $ar_v_v['mod_id'].'|'.$ar_v_v['ext_id']; ?>" <?php echo $selected; ?>><?php echo $ar_v_v['ext_name']; ?></option>
								<?php } } ?>
								</optgroup>
							<?php } ?>
						</select>
						<?php 
							$dbKey 	= isset($mod_v['selectedModKey']) ? $mod_v['selectedModKey'] : '';
							$name	= $module_key.'['.$modData.']['.$i.'][selectedModKey]';
						?>
						<input type="hidden" class="selectedModKey" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
					</span>
					<div class="mb10">
						<span class="lbl">Apply custom CSS class</span>
						<?php 
							$dbKey 	= isset($mod_v['class']) ? $mod_v['class'] : '';
							$name	= $module_key.'['.$modData.']['.$i.'][class]';
						?>
						<input type="text" placeholder="Apply CSS class" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
					</div>

					<div class="mb10">
						<span class="lbl">Apply quick inline style</span>
						<?php 
							$dbKey 	= isset($mod_v['inline']) ? $mod_v['inline'] : '';
							$name	= $module_key.'['.$modData.']['.$i.'][inline]';
						?>
						<input type="text" placeholder="Apply inline style" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
					</div>

					<span class="lbl">Sort order & Status</span>
					<?php 
						$dbKey 	= isset($mod_v['sort_order']) ? $mod_v['sort_order'] : '0';
						$name	= $module_key.'['.$modData.']['.$i.'][sort_order]';
					?>
					<input type="text" class="input-mini" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" style="margin:0px 10px 0 0;" />
					<?php 
						$dbKey 	= isset($mod_v['status']) ? $mod_v['status'] : '0';
						$name	= $module_key.'['.$modData.']['.$i.'][status]';
						$id		= 'status'.$i;
					?>
					<span class="switch">
						<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">
						<label for="<?php echo $id; ?>" class="switch-img"></label>
						<?php if (!$dbKey) { ?><input type="hidden" name="<?php echo $name; ?>" value="0"><?php }?>
					</span>
				</td>
				<td>
					<span class="lbl">Background image</span>
					<div class="img-preview img-p1" style="width: 150px;">
						<?php
							$dbKey  = isset($mod_v['bgimg']) ? $mod_v['bgimg'] : '';
							$name	= $module_key.'['.$modData.']['.$i.'][bgimg]';
							$id		= 'bgimg'.$i;
						?>
						<div class="img-holder" style="background-image:url(<?php if (!$dbKey) {echo $no_img;}else{echo '../image/' . $dbKey;} ?>);" id="<?php echo $id; ?>-preview"></div>
						<div class="btn-group btn-group" style="background:#eee;">
							<a class="btn btn-mini browse" data-id="<?php echo $id; ?>">Browse</a>
							<a class="btn btn-mini clear" data-id="<?php echo $id; ?>">Clear</a>
						</div>
						<input type="hidden" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
					</div>
				</td>
			</tr>
		</table>
		<a class='btn-small btn-danger mod-del'><i class="icon-remove icon-white"></i></a>
	</div>
	<?php /*}*/ $i++; } ?>
	<?php } ?>
	</div>
</div>


<script>
$(window).off( "click", "#saveBtn");
$(window).on('click', '#saveBtn', function(event) {
	modkey('.block-container .module-box', '.b_id');
	event.preventDefault();
	
	var urlVal = "index.php?route=module/<?php echo $modSettings['modKey']; ?>/save&token=<?php echo $token; ?>&mod_name=<?php echo $module_key; ?>&t=edit";
	var dataContent = '#mod-data';
	var reLoad = false;
	var msg = "<?php echo $this->language->get('text_success'); ?>";
	save(urlVal, dataContent, reLoad, msg);

});
$('.modlist').each(function(index, el) {
	$(this).next('.selectedModKey').val($(this).find("option:selected").attr('data-key'));
});
var module_row = <?php echo $i; ?>;
<?php include 'common.php'; ?>
</script>
