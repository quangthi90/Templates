html += '			<div class="control-group">';
html += '				<label class="control-label">Access in grid manager</label>';
html += '				<div class="controls">';
							<?php 
								$ar 	= array('Yes' => 'y', 'No' => 'n');
								$dbKey 	= 'n';
							?>
							name = '<?php echo $module_key ?>['+module_row+'][ext_access]';
							id = 'ext_access'+module_row;
html += '					<div class="btn-group ext-access" data-toggle="buttons-radio">';
								<?php foreach ($ar as $key => $value) { ?>
									<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
html += '							<label for="'+id+'<?php echo "-" . $value; ?>"  type="button" class="btn btn-small<?php echo $selected; ?>">';
html += '								<input type="radio" id="'+id+'<?php echo "-" . $value; ?>" name="'+name+'" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>';
html += '								<?php echo $key; ?>';
html += '							</label>';
								<?php } ?>
html += '					</div>';
html += '					<div style="margin-top:5px;margin-bottom:8px;display:none;">';
								name = '<?php echo $module_key ?>['+module_row+'][ext_id]';
html += '						<input type="hidden" name="'+name+'" value="ext_'+getRandomInt()+'" />';
								name = '<?php echo $module_key ?>['+module_row+'][ext_name]';
html += '						<input type="text" class="ext-name" name="'+name+'" value="Module-'+(module_row+1)+'" />';
html += '						<div class="help-block">This name will display in Grid Manager module list.</div>';
html += '					</div>';
html += '				</div>';
html += '			</div>';