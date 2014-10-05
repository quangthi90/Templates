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

	<h4>Add banners</h4>
	<table class="table table-bordered extra-pd">
		<thead>
			<tr class="table-header tbl-vm">
				<th style="width:260px;">Banner details</th>
				<th>Banner image</th>
				<th style="width:50px;" class="tc">Status</th>
				<th style="width:75px;" class="tc">Sort order</th>
				<th style="width:30px;" class="tc"><a class='btn btn-success mod-add'><i class="icon-plus icon-white"></i></a></th>
			</tr>
		</thead>
		<tbody class="banner-container">
			
		</tbody>
	</table>
</div>

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
