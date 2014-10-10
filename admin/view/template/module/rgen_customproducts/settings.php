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
			<label class="control-label">Items display in row</label>
			<div class="controls">
				<?php 
					$ar 	= array(1,2,3,4,5,6,7,8,9,10);
					$id		= 'other_in_row';
				?>
				<div class="btn-group other_in_row" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $value; ?>
					</label>
				<?php } ?>
				</div>
				<div class="help-block">
					This settings will not apply on products sections and some of carousel items
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Space between blocks</label>
			<div class="controls">
				<?php 
					$ar 	= array(1,2,4,10,12,14,16,18,20,22,24,26,28,30,40,50,60);
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
			<label class="control-label">Top - Bottom padding around module</label>
			<div class="controls tb">
				<input placeholder="Top" type="text" class="t input-mini" value="40"> - 
				<input placeholder="Bottom" type="text" class="b input-mini" value="40">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Top - Bottom margin around full block</label>
			<div class="controls tb">
				<input placeholder="Top" type="text" class="t-mr input-mini" value="40"> - 
				<input placeholder="Bottom" type="text" class="b-mr input-mini" value="40">
				<div class="help-block">
					This will apply on full block only
				</div>
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
<script>
var obj = '#pop_mod_setting';
var dataSource = ".apply, .model-box .ui-icon-closethick, .apply-bar";

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	//$(obj).find(".in_row_d input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".gt input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".tb .t").attr('value',oldData_ar[1]);
	$(obj).find(".tb .b").attr('value',oldData_ar[2]);
	$(obj).find(".tb .t-mr").attr('value',oldData_ar[3]);
	$(obj).find(".tb .b-mr").attr('value',oldData_ar[4]);
	$(obj).find(".sep input[value='"+oldData_ar[5]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".other_in_row input[value='"+oldData_ar[6]+"']").prop('checked', true).parent().addClass('active');
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".gt .active input[type='radio']").val()+"|"+
				  $(obj).find(".tb .t").val()+"|"+
				  $(obj).find(".tb .b").val()+"|"+
				  $(obj).find(".tb .t-mr").val()+"|"+
				  $(obj).find(".tb .b-mr").val()+"|"+
				  $(obj).find(".sep .active input[type='radio']").val()+"|"+
				  $(obj).find(".other_in_row .active input[type='radio']").val();
				  //7|20|40|40|0|0|n|5
	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});
</script>