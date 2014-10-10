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
	</div>

	<h4>Add Grid Blocks <a class='btn btn-success mod-add' style="margin: 0 0 0 20px;"><i class="icon-plus icon-white"></i></a></h4>
	<div class="form-horizontal clearfix block-container">
		<div class="grid-preview">
			<div>
				<h4 style="margin: 0 0 5px 0;">Grid block size preview</h4>
				<div class="help-block" align="center" style="margin: 0 0 20px 0;">
					Grid blocks work based on Bootstrap grid concept.
				</div>
				<div class="rw"></div>
			</div>
		</div>
	</div>
</div>

<script>
$(window).off( "click", "#saveBtn");
$(window).on('click', '#saveBtn', function(event) {
	modkey('.block-container .module-box', '.b_id');
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
