<style>
.getValue .frm-small .control-label {
	width: 200px;
}
.getValue .frm-small .controls {
	margin-left: 210px;
}
</style>
<div class="getValue model-box" id="pop_mod_setting">
	<div class="form-horizontal frm-small">
		<div class="control-group">
			<label class="control-label">Space between columns</label>
			<div class="controls">
				<?php 
					$ar 	= array(0,1,2,4,10,12,14,16,18,20,22,24,26,28,30,40,50,60,70,80,90,100);
					$id		= 'gt';
				?>
				<div class="btn-group gt" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $value; ?>
					</label>
				<?php } ?>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Space between rows</label>
			<div class="controls">
				<input type="text" class="rwmb input-mini" value="" />
				<div class="help-block">
					Leave blank to apply default spacing between rows
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Grid block's equal height</label>
			<div class="controls">
				<?php 
					$ar 	= array("Enable" => 'on', "Disable" => 'off');
					$id		= 'eqh';
				?>
				<div class="btn-group eqh-col" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $key; ?>
					</label>
				<?php } ?>
				</div>
				<div class="help-block">
					This setting will apply row specific equal height on grid blocks
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Separators between columns</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td class="bg">
							<span class="lbl">Status</span>
							<?php 
								$ar 	= array("Yes" => 'y', "No" => 'n');
								$id		= 'sep';
							?>
							<div class="btn-group sep-col" data-toggle="buttons-radio">
							<?php foreach ($ar as $key => $value) { ?>
								<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
									<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
									<?php echo $key; ?>
								</label>
							<?php } ?>
							</div>
						</td>
						<td class="border">
							<span class="lbl">Border</span>
							<input type="text" class="rgb" value="" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Top - Bottom spacing</label>
			<div class="controls tb">
				<input placeholder="Top" type="text" class="t input-mini" value="40"> - 
				<input placeholder="Bottom" type="text" class="b input-mini" value="40">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Separator line after module</label>
			<div class="controls">
				<?php 
					$ar 	= array("Yes" => 'y', "No" => 'n');
					$id		= 'sep';
				?>
				<div class="btn-group sep" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $key; ?>
					</label>
				<?php } ?>
				</div>
			</div>
		</div>
		<div class="control-group apply-bar">
			<label class="control-label"></label>
			<div class="controls">
				<a class="btn apply btn-success">Apply</a>
			</div>
		</div>
	</div>
</div>
<br><br><br><br><br><br><br><br>
<script>
var obj = '#pop_mod_setting';
var dataSource = ".apply, .model-box .ui-icon-closethick, .apply-bar";

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	$(obj).find(".gt input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".tb .t").attr('value',oldData_ar[1]);
	$(obj).find(".tb .b").attr('value',oldData_ar[2]);
	$(obj).find(".sep input[value='"+oldData_ar[3]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".sep-col input[value='"+oldData_ar[4]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".border input").attr('value',oldData_ar[5]);
	$(obj).find(".rwmb").attr('value',oldData_ar[6]);
	$(obj).find(".eqh-col input[value='"+oldData_ar[7]+"']").prop('checked', true).parent().addClass('active');
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".gt .active input[type='radio']").val()+"|"+
				  $(obj).find(".tb .t").val()+"|"+
				  $(obj).find(".tb .b").val()+"|"+
				  $(obj).find(".sep .active input[type='radio']").val()+"|"+
				  $(obj).find(".sep-col .active input[type='radio']").val()+"|"+
				  $(obj).find(".border .rgb").val()+"|"+
				  $(obj).find(".rwmb").val()+"|"+
				  $(obj).find(".eqh-col .active input[type='radio']").val();
				  

	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

function colorPic(parent) {
	$(parent+' .rgb').spectrum("destroy");
	$(parent+' .sp-replacer').remove();
	colorPicker(parent+' .rgb', 'rgb');
}
colorPic('.border');
</script>