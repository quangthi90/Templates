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
			<label class="control-label">Custom HTML above blocks</label>
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

		<div class="control-group">
			<label class="control-label">Custom HTML below blocks</label>
			<div class="controls">
				<?php 
					// Generate new array for description values from module array
					foreach ($languages as $language) {
						$lng_id = $language['language_id'];
						$description_arr['description1'][$lng_id] = isset($module['description1'][$lng_id]) ? $module['description1'][$lng_id] : '';
					}
					$tab_key        = "custom-html-lng-tabs1";
					$name_key       = $module_key.'[description1]';
					$placehoder_key = ' - Add custom HTML code';
					$description_arr_key = 'description1';

					include 'view/rgen/tools/tabs/lng_description.php';
				?>
			</div>
		</div>

	</div>

	<h4>Content block settings</h4>
	<div class="form-horizontal">
		<div class="mb30">
			<div class="control-group">
				<label class="control-label">Global image settings</label>
				<div class="controls">
					<a data-url="view/template/module/rgen_contentblocks/gb_imagesettings.php" data-title="Global image settings" class="popup btn">Edit</a>
					<?php 
						/*
						0 Image position
						1 Image container - Width
						2 Image container - Height
						3 Margin Top
						4 Margin Right
						5 Margin Bottom
						6 Margin Left
						7 Radius - Top Left
						8 Radius - Top Right
						9 Radius - Bottom Left
						10 Radius - Bottom Right
						11 Border size
						12 Content wrap to image
						*/
						$dbKey 	= isset($module['gb_imgsettings']) ? $module['gb_imgsettings'] : 't|100|100|||||0|||||n|y';
						$name	= $module_key.'[gb_imgsettings]';
					?>
					<input type="hidden" class="gb_imgsettings" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" data-labels="Image position|Image container - Width|Image container - Height|Margin Top|Margin Right|Margin Bottom|Margin Left|Radius - Top Left|Radius - Top Right|Radius - Bottom Left|Radius - Bottom Right|Border size|Content wrap to image|Display image" />
					<script>
					var obj = '.gb_imgsettings';
					$(obj).summary({
						dbkey: '<?php echo $dbKey; ?>',
						labels: $(obj).attr('data-labels'),
						place: obj,
						callback: function(index, val){
							if (val == 't') { val = 'Top'; };
							if (val == 'l') { val = 'Left'; };
							if (val == 'r') { val = 'Right'; };
							if (val == 'n') { val = 'No'; };
							if (val == 'y') { val = 'Yes'; };
							return val; 
						}
					});
					</script>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Global block settings</label>
				<div class="controls">
					<a data-url="view/template/module/rgen_contentblocks/gb_blocksettings.php" data-title="Global block settings" class="popup btn">Edit</a>
					<?php 
						/*
						0 Title position
						1 Content alignment
						2 Padding Top
						3 Padding Right
						4 Padding Bottom
						5 Padding Left
						6 Border size
						7 Radius - Top Left
						8 Radius - Top Right
						9 Radius - Bottom Left
						10 Radius - Bottom Right
						11 Title size
						*/
						$dbKey 	= isset($module['gb_blocksettings']) ? $module['gb_blocksettings'] : 'b|c|0|0|0|0|1|0|0|0|0|4|0|0|0';
						$name	= $module_key.'[gb_blocksettings]';
					?>
					<input type="hidden" class="gb_blocksettings" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" data-labels="Title position|Content alignment|Padding Top|Padding Right|Padding Bottom|Padding Left|Border size - Top|Radius - Top Left|Radius - Top Right|Radius - Bottom Left|Radius - Bottom Right|Title size|Border size - Right|Border size - Bottom|Border size - Left" />
					<script>
					var obj = '.gb_blocksettings';
					$(obj).summary({
						dbkey: '<?php echo $dbKey; ?>',
						labels: $(obj).attr('data-labels'),
						place: obj,
						callback: function(index, val){
							if (val == 'b') { val = 'Below image'; };
							if (val == 't') { val = 'Above image'; };
							if (val == 'c') { val = 'Center'; };
							if (val == 'l') { val = 'Left'; };
							if (val == 'r') { val = 'Right'; };
							return val; 
						}
					});
					</script>
				</div>
			</div>
		</div>
	</div>
	
	<h4>Add content blocks</h4>
	<div class="form-horizontal form-2">
		<div class="tabs-left tb-left" data-theme="tab2">
			<a class="btn btn-success mod-add">Add block</a>
			<ul class="nav nav-tabs">
				<?php $i = 0; if (isset($module['mod_data'])) { ?>
				<?php foreach ($module['mod_data'] as $k => $data_v) { ?>
				<li><a href="#tab-block-<?php echo $i+1; ?>">Block <?php echo $i+1; ?></a><i class="icon-remove ml10 mod-del"></i></li>
				<?php $i++; } ?>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<?php $i = 0; if (isset($module['mod_data'])) { ?>
				<?php foreach ($module['mod_data'] as $k => $data_v) { ?>
				<div class="tab-pane" id="tab-block-<?php echo $i+1; ?>">
					<?php 
						$dbKey 			= isset($data_v['id']) ? $data_v['id'] : null;
						$name			= $module_key.'[mod_data]['.$i.'][id]';
					?>
					<input type="hidden" name="<?php echo $name; ?>" class="moddata_id" value="<?php echo $dbKey; ?>" />

					<div class="control-group">
						<label class="control-label">Status and sort order:</label>
						<div class="controls">
							<?php 
								$dbKey 	= isset($data_v['sort_order']) ? $data_v['sort_order'] : '0';
								$name	= $module_key.'[mod_data]['.$i.'][sort_order]';
							?>
							<input type="text" class="input-mini mr10" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
							<?php 
								$dbKey 	= isset($data_v['status']) ? $data_v['status'] : '0';
								$name	= $module_key.'[mod_data]['.$i.'][status]';
								$id		= 'status'.$i;
							?>
							<span class="switch">
								<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $name; ?>" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">
								<label for="<?php echo $id; ?>" class="switch-img"></label>
								<?php if (!$dbKey) { ?><input type="hidden" name="<?php echo $name; ?>" value="0"><?php }?>
							</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Block settings</label>
						<div class="controls">
							<a data-url="view/template/module/rgen_contentblocks/blocksettings.php" data-title="Block settings" data-token="<?php echo $token; ?>" data-image="<?php echo $no_img; ?>" data-h="800" class="popup btn mb10">Edit</a>
							<?php 
								/*
								0 Block background
								1 Block border color
								2 Block title color
								3 Block text color
								4 Block inline css
								5 Image inline css
								6 Title inline css
								7 content inline css
								8 Link on full block
								*/
								$dbKey 	= isset($data_v['blocksettings']) ? $data_v['blocksettings'] : 'rgba(0,0,0,0)|rgba(0,0,0,0)|||||||';
								$name	= $module_key.'[mod_data]['.$i.'][blocksettings]';
							?>
							<input type="hidden" class="blocksettings" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" data-labels="Block background|Block border color|Block title color|Block text color|Block inline css|Image inline css|Title inline css|Content inline css|Link on full block" />
							<script>
							var obj = '#tab-block-<?php echo $i+1; ?> .blocksettings';
							$(obj).summary({
								dbkey: '<?php echo $dbKey; ?>',
								labels: $(obj).attr('data-labels'),
								place: obj,
								callback: function(index, val){}
							});
							</script>

						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Image settings</label>
						<div class="controls">
							<a data-url="view/template/module/rgen_contentblocks/imagesettings.php" data-title="Image settings" data-token="<?php echo $token; ?>" data-image="<?php echo $no_img; ?>" data-h="800" class="popup btn mb10">Edit</a>
							<?php 
								/*
								0 Image background
								1 Image border color 
								2 Image type
								3 Image src
								4 Icon class
								5 Icon size
								6 Icon color 
								7 URL 
								*/
								$dbKey 	= isset($data_v['imgsettings']) ? $data_v['imgsettings'] : 'rgba(0,0,0,0)|rgba(0,0,0,0)|img|||20|rgba(255,255,255,1)|';
								$name	= $module_key.'[mod_data]['.$i.'][imgsettings]';
							?>
							<input type="hidden" class="imgsettings" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" data-labels="Image background|Image border color|Image type|Image src|Icon class|Icon size|Icon color|Link on image" />
							<script>
							var obj = '#tab-block-<?php echo $i+1; ?> .imgsettings';
							$(obj).summary({
								dbkey: '<?php echo $dbKey; ?>',
								labels: $(obj).attr('data-labels'),
								place: obj,
								callback: function(index, val){
									if (val == 'ico') { val = 'Icon'; };
									if (val == 'img') { val = 'Image'; };
									return val; 
								}
							});
							</script>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">Title</label>
						<div class="controls">
							<?php foreach ($languages as $language) { ?>
							<?php 
								$dbKey 			= isset($data_v['title'][$language['language_id']]) ? $data_v['title'][$language['language_id']] : null;
								$name			= $module_key.'[mod_data]['.$i.'][title]['.$language['language_id'].']';
								$placeholder	= $language['name'] . ' - Enter title';
							?><input type="text" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 225px 8px; padding-right: 40px;" placeholder="<?php echo $placeholder; ?>" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>"><br>
							<?php } ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Description</label>
						<div class="controls">
							<?php foreach ($languages as $language) { ?>
							<?php 
								$dbKey 			= isset($data_v['short_description'][$language['language_id']]) ? $data_v['short_description'][$language['language_id']] : null;
								$name			= $module_key.'[mod_data]['.$i.'][short_description]['.$language['language_id'].']';
								$placeholder	= $language['name'] . ' - Enter description';
							?>
							<textarea placeholder="<?php echo $placeholder; ?>" name="<?php echo $name; ?>" cols="30" rows="5" style="background:url(view/image/flags/<?php echo $language['image']; ?>) no-repeat 420px 8px; padding-right: 40px; width: 400px;"><?php echo $dbKey; ?></textarea><br>
							<?php } ?>
						</div>
					</div>

				</div>
				<?php $i++; } ?>
				<?php } ?>
			</div>
		</div>
		
	</div>
	<script>
	
	</script>
	<!-- <div class="help-block">
		<strong>"Use in slide show"</strong> feature only work with pre-define banner layouts which allow slide show with banners.
	</div> -->
</div>
<div id="dialog-data"></div>

<script>
$(window).off( "click", "#saveBtn");
$(window).on('click', '#saveBtn', function(event) {
	modkey('.tb-left .tab-content .tab-pane', '.moddata_id');
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
