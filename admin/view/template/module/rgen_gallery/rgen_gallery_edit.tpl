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

		<div class="control-group">
			<label class="control-label">Main section title</label>
			<div class="controls">
				<?php foreach ($languages as $language) { ?>
				<?php 
					$dbKey 			= isset($module['main_title'][$language['language_id']]) ? $module['main_title'][$language['language_id']] : null;
					$name			= $module_key.'[main_title]['.$language['language_id'].']';
					$placeholder	= $language['name'] . ' - Enter title';
				?><input type="text" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 225px 8px; padding-right: 40px;" placeholder="<?php echo $placeholder; ?>" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>"><br>
				<?php } ?>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Custom HTML above images</label>
			<div class="controls">
				<?php 
					// Generate new array for description values from module array
					foreach ($languages as $language) {
						$lng_id = $language['language_id'];
						$description_arr['description'][$lng_id] = isset($module['description'][$lng_id]) ? $module['description'][$lng_id] : '';
					}
					$tab_key        = "custom-html-lng-tabs";
					$name_key       = $module_key.'[description]';
					$placehoder_key = ' - Add custom HTML code';
					$description_arr_key = 'description';

					include 'view/rgen/tools/tabs/lng_description.php';
				?>
			</div>
		</div>

	</div>

	<h4>Add gallery images <a class='btn btn-success mod-add' style="margin: 0 0 0 20px;"><i class="icon-plus icon-white"></i></a></h4>
	<div class="form-horizontal banner-container clearfix gallery-image-container">
	<?php $i = 0; if (isset($module['image_data'])) { ?>
	<?php foreach ($module['image_data'] as $k => $img_v) { ?>
	<div class="gallery-box">
		<?php 
			$dbKey 			= isset($img_v['id']) ? $img_v['id'] : null;
			$name			= $module_key.'[image_data]['.$i.'][id]';
		?>
		<input type="hidden" name="<?php echo $name; ?>" class="b_id" value="<?php echo $dbKey; ?>" />
		<table class="subfields withbdr">
			<tr>
				<td>
					<div class="img-preview img-p1">
						<?php
							$dbKey  = isset($img_v['image'][1]) ? $img_v['image'][1] : null;
							$name	= $module_key.'[image_data]['.$i.'][image][1]';
							$id		= 'banner1'.$i;
						?>
						<div class="img-holder" style="background-image:url(<?php if (!$dbKey) {echo $no_img;}else{echo '../image/' . $dbKey;} ?>);" id="<?php echo $id; ?>-preview"></div>
						<div class="btn-group btn-group" style="background:#eee;">
							<a class="btn btn-mini browse" data-id="<?php echo $id; ?>">Browse</a>
							<a class="btn btn-mini clear" data-id="<?php echo $id; ?>">Clear</a>
						</div>
						<input type="hidden" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
						
					</div>
				</td>
				<td>
					<span class="lbl">Image title</span>
					<?php foreach ($languages as $language) { ?>
					<?php 
						$dbKey 			= isset($img_v['title'][$language['language_id']]) ? $img_v['title'][$language['language_id']] : null;
						$name			= $module_key.'[image_data]['.$i.'][title]['.$language['language_id'].']';
						$placeholder	= $language['name'] . ' - Enter title';
					?><input type="text" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 225px 8px; padding-right: 40px; margin-bottom: 5px;" placeholder="<?php echo $placeholder; ?>" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>"><br>
					<?php } ?>
					<br>
					<span class="lbl">Sort order & Status</span>
					<?php 
						$dbKey 	= isset($img_v['sort_order']) ? $img_v['sort_order'] : '0';
						$name	= $module_key.'[image_data]['.$i.'][sort_order]';
					?>
					<input type="text" class="input-mini" data-clone="sort_order" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" style="margin:0px 10px 0 0;" />
					<?php 
						$dbKey 	= isset($img_v['status']) ? $img_v['status'] : '0';
						$name	= $module_key.'[image_data]['.$i.'][status]';
						$id		= 'status'.$i;
					?>
					<span class="switch">
						<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">
						<label for="<?php echo $id; ?>" class="switch-img"></label>
						<?php if (!$dbKey) { ?><input type="hidden" name="<?php echo $name; ?>" value="0"><?php }?>
					</span>
					
				</td>
			</tr>
		</table>
		<a class='btn-small btn-danger mod-del'><i class="icon-remove icon-white"></i></a>
	</div>
	<?php $i++; } ?>
	<?php } ?>
	</div>
</div>


<script>
$(window).off( "click", "#saveBtn");
$(window).on('click', '#saveBtn', function(event) {
	modkey('.banner-container tr', '.b_id');
	event.preventDefault();
	
	var urlVal = "index.php?route=module/<?php echo $modSettings['modKey']; ?>/save&token=<?php echo $token; ?>&mod_name=<?php echo $module_key; ?>&t=edit";
	var dataContent = '#mod-data';
	var reLoad = false;
	var msg = "<?php echo $this->language->get('text_success'); ?>";
	save(urlVal, dataContent, reLoad, msg);

});

var module_row = <?php echo $i; ?>;
<?php include 'common.php'; ?>
</script>
