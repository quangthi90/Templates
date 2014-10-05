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
			<label class="control-label">Custom HTML above banners</label>
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

	<h4>Add banners</h4>
	<div class="help-block">
		<strong>"Use in slide show"</strong> feature only work with pre-define banner layouts which allow slide show with banners.
	</div>
	<table class="table table-bordered extra-pd">
		<thead>
			<tr class="table-header tbl-vm">
				<th style="width:260px;">Banner details</th>
				<th class="tc">Banner image</th>
				<th style="width:50px;" class="tc">Status</th>
				<th style="width:75px;" class="tc">Sort order</th>
				<th style="width:30px;" class="tc"><a class='btn btn-success mod-add'><i class="icon-plus icon-white"></i></a></th>
			</tr>
		</thead>
		<tbody class="banner-container">
			<?php $i = 0; if (isset($module['image_data'])) { ?>
			<?php foreach ($module['image_data'] as $k => $img_v) { ?>
			<tr class="table-header tbl-vm" id="row<?php echo $i; ?>">
				<td>
					<?php 
						$dbKey 			= isset($img_v['id']) ? $img_v['id'] : null;
						$name			= $module_key.'[image_data]['.$i.'][id]';
					?>
					<input type="hidden" name="<?php echo $name; ?>" class="b_id" value="<?php echo $dbKey; ?>" />

					<label class="lbl-1">Banner title</label>
					<?php foreach ($languages as $language) { ?>
					<?php 
						$dbKey 			= isset($img_v['title'][$language['language_id']]) ? $img_v['title'][$language['language_id']] : null;
						$name			= $module_key.'[image_data]['.$i.'][title]['.$language['language_id'].']';
						$placeholder	= $language['name'] . ' - Enter title';
					?><input type="text" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 225px 8px; padding-right: 40px;" placeholder="<?php echo $placeholder; ?>" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>"><br>
					<?php } ?>

					<label class="lbl-1">Banner URL</label>
					<?php 
						$ar 	= $urlType;
						$dbKey 	= isset($img_v['urlType']) ? $img_v['urlType'] : null;
						$name	= $module_key.'[image_data]['.$i.'][urlType]';
					?>
					<span class='select' style="margin-bottom: 5px;">
						<select name="<?php echo $name; ?>" style="width: 254px;" class="url-types">
							<?php foreach ($ar as $key => $value) { ?>
								<?php ($value ==  $dbKey) ? $selected = 'selected' : $selected=''; ?>
								<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
							<?php } ?>
						</select>
					</span>
					<div class="url-container">
						<div class="other" style="display:<?php echo isset($img_v['urlType']) && $img_v['urlType'] == 'other' ? 'block' : 'none'; ?>;">
							<?php 
								$dbKey 	= isset($img_v['url']) ? $img_v['url'] : null;
								$name	= $module_key.'[image_data]['.$i.'][url]';
							?>
							<input type="text" placeholder="Enter your url" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" style="width: 240px;" />
						</div>
						<div class="category" style="display:<?php echo isset($img_v['urlType']) && $img_v['urlType'] == 'category' ? 'block' : 'none'; ?>;">
							<input type="text" class="cat-auto" placeholder="Type category name to insert" value="<?php echo isset($img_v['catName']) ? $img_v['catName'] : null ?>" style="width: 240px;" />
							<?php 
								$dbKey 	= isset($img_v['cat_id']) ? $img_v['cat_id'] : null;
								$name	= $module_key.'[image_data]['.$i.'][cat_id]';
							?>
							<input type="hidden" class="auto-val" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
						</div>
						<div class="product" style="display:<?php echo isset($img_v['urlType']) && $img_v['urlType'] == 'product' ? 'block' : 'none'; ?>;">
							<input type="text" class="prd-auto" placeholder="Type product name to insert" value="<?php echo isset($img_v['prdName']) ? $img_v['prdName'] : null ?>" style="width: 240px;" />
							<?php 
								$dbKey 	= isset($img_v['prd_id']) ? $img_v['prd_id'] : null;
								$name	= $module_key.'[image_data]['.$i.'][prd_id]';
							?>
							<input type="hidden" class="auto-val" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
						</div>
						<div class="brand" style="display:<?php echo isset($img_v['urlType']) && $img_v['urlType'] == 'brand' ? 'block' : 'none'; ?>;">
							<input type="text" class="brn-auto" placeholder="Type manufacturer name to insert" value="<?php echo isset($img_v['brnName']) ? $img_v['brnName'] : null ?>" style="width: 240px;" />
							<?php 
								$dbKey 	= isset($img_v['brn_id']) ? $img_v['brn_id'] : null;
								$name	= $module_key.'[image_data]['.$i.'][brn_id]';
							?>
							<input type="hidden" class="auto-val" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
						</div>
						<div class="info" style="display:<?php echo isset($img_v['urlType']) && $img_v['urlType'] == 'info' ? 'block' : 'none'; ?>;">
							<input type="text" class="inf-auto" placeholder="Type information page to insert" value="<?php echo isset($img_v['infName']) ? $img_v['infName'] : null ?>" style="width: 240px;" />
							<?php 
								$dbKey 	= isset($img_v['inf_id']) ? $img_v['inf_id'] : null;
								$name	= $module_key.'[image_data]['.$i.'][inf_id]';
							?>
							<input type="hidden" class="auto-val" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
						</div>
					</div>

					<table class="subfields withbdr">
						<tr>
							<td>
								<label class="lbl-1">Open in new window</label>
								<?php 
									$ar 	= array('Yes'=>'y', 'No'=>'n');
									$dbKey 	= isset($img_v['new_win']) ? $img_v['new_win'] : 'n';
									$name	= $module_key.'[image_data]['.$i.'][new_win]';
									$id		= 'new_win'.$i;
								?>
								<div class="btn-group" data-toggle="buttons-radio">
									<?php foreach ($ar as $key => $value) { ?>
										<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
										<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-small btn<?php echo $selected; ?>">
											<input type="radio" id="<?php echo $id . '-' . $value; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>
											<?php echo $key; ?>
										</label>
									<?php } ?>
								</div>
							</td>
							<td>
								<label class="lbl-1">Use in slide show</label>
								<?php 
									$ar 	= array('Yes'=>'y', 'No'=>'n');
									$dbKey 	= isset($img_v['in_slide']) ? $img_v['in_slide'] : 'n';
									$name	= $module_key.'[image_data]['.$i.'][in_slide]';
									$id		= 'in_slide'.$i;
								?>
								<div class="btn-group" data-toggle="buttons-radio">
									<?php foreach ($ar as $key => $value) { ?>
										<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
										<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-small btn<?php echo $selected; ?>">
											<input type="radio" id="<?php echo $id . '-' . $value; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>
											<?php echo $key; ?>
										</label>
									<?php } ?>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td class="tc">
					<?php foreach ($languages as $language) { ?>
					<div class="img-preview img-p1" style="vertical-align: top; width: auto;">
						<?php
							$dbKey  = isset($img_v['image'][$language['language_id']]) ? $img_v['image'][$language['language_id']] : null;
							$name	= $module_key.'[image_data]['.$i.'][image]['.$language['language_id'].']';
							$id		= 'banner'.$language['language_id'].$i;
						?>
						<div class="img-holder" style="background-image:url(<?php if (!$dbKey) {echo $no_img;}else{echo '../image/' . $dbKey;} ?>);" id="<?php echo $id; ?>-preview"></div>
						<div class="btn-group btn-group" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 132px 11px #eee;">
							<a class="btn btn-mini browse" data-id="<?php echo $id; ?>">Browse</a>
							<a class="btn btn-mini clear" data-id="<?php echo $id; ?>">Clear</a>
						</div>
						<input type="hidden" id="<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
					</div>
					<?php } ?>
				</td>
				<td>
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
				<td>
					<?php 
						$dbKey 	= isset($img_v['sort_order']) ? $img_v['sort_order'] : '0';
						$name	= $module_key.'[image_data]['.$i.'][sort_order]';
					?>
					<input type="text" class="input-mini" data-clone="sort_order" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" style="margin:0px;" />
				</td>
				<td><a class='btn btn-danger mod-del'><i class="icon-remove icon-white"></i></a></td>
			</tr>
			<?php $i++; } ?>
			<?php } ?>
		</tbody>
	</table>
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
