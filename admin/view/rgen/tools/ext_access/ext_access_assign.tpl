<div class="control-group">
	<label class="control-label">Access in grid manager</label>
	<div class="controls">
		<?php 
			$ar 	= array('Yes' => 'y', 'No' => 'n');
			$dbKey 	= isset($module['ext_access']) ? $module['ext_access'] : 'n';
			$name	= $module_key.'['.$module_row.'][ext_access]';
			$id		= 'ext_access'.$module_row;
			$extStatus = $dbKey;
		?>
		<div class="btn-group ext-access" data-toggle="buttons-radio">
			<?php foreach ($ar as $key => $value) { ?>
				<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
				<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn btn-small<?php echo $selected; ?>">
					<input type="radio" id="<?php echo $id . '-' . $value; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>
					<?php echo $key; ?>
				</label>
			<?php } ?>
		</div>
		<div style="margin-top:5px;margin-bottom:8px;<?php echo $dbKey == 'n' ? 'display:none;' : null; ?>">
			<?php 
				$dbKey 	= isset($module['ext_id']) ? $module['ext_id'] : 'ext_'.$module_row;
				$name	= $module_key.'['.$module_row.'][ext_id]';
			?>
			<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
			<?php 
				$dbKey 	= isset($module['ext_name']) ? $module['ext_name'] : 'Module-'.($module_row+1);
				$name	= $module_key.'['.$module_row.'][ext_name]';
			?>
			<input type="text" class="ext-name" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
			<div class="help-block">
				This name will display in Grid Manager module list.
			</div>
		</div>
	</div>
</div>