<?php $module_key = $modSettings['modKey'].'_module'.$module_row; ?>
<div id="<?php echo $module_key; ?>">
	<div class="section-title">
		Add module
		<div class="buttons pull-right" style="margin: -9px -10px 0 0;">
			<a id="saveBtn" class="btn btn-success btn-large">Save</a>
		</div>
	</div>
	<h4>General settings</h4>
	<div class="form-horizontal">
		<input type="hidden" name="<?php echo $module_key.'[mod_id]' ?>" value="<?php echo $module_key; ?>" />
		<div class="control-group">
			<label class="control-label">Module name</label>
			<div class="controls">
				<?php 
					$dbKey 	= 'Module '.$module_row;
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
					$dbKey 			= '';
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
						//Title position|Content alignment|Padding(t,r,b,l)|Border width|Radius(t,r,b,l)|Title size
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
	<div class="form-horizontal">
		<div class="tabs-left tb-left" data-theme="tab2">
			<a class="btn btn-success mod-add">Add block</a>
			<ul class="nav nav-tabs">
			</ul>
			<div class="tab-content">
			</div>
		</div>
		
	</div>
	<script>
	jQuery(document).ready(function($) {
		$(window).on("click", '.tb-left .nav-tabs a', function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
		$(".tb-left li:first a").click();
	});
	</script>
</div>
<div id="dialog-data"></div>

<script>
$(window).off( "click", "#saveBtn");
$(window).on('click', '#saveBtn', function(event) {
	modkey('.banner-container tr', '.b_id');
	event.preventDefault();
	
	var urlVal = "index.php?route=module/<?php echo $modSettings['modKey']; ?>/save&token=<?php echo $token; ?>&mod_name=<?php echo $module_key; ?>&t=new";
	var dataContent = '#mod-data';
	var reLoad = true;
	var msg = "<?php echo $this->language->get('text_success'); ?> Page will refresh after module data saved.";
	save(urlVal, dataContent, reLoad, msg);
});

var module_row = <?php echo $module_row; ?>;
<?php include 'common.php'; ?>
</script>
