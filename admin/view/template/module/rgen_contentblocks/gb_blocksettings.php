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
			<label class="control-label">Title position</label>
			<div class="controls">
				<?php 
					$ar 	= array('Below image'=>'b', 'Above image'=>'t');
					$id		= 'title_position';
				?>
				<div class="btn-group title-position" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $key; ?>
					</label>
				<?php } ?>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Title size</label>
			<div class="controls">
				<?php 
					$ar 	= array(1,2,3,4);
					$id		= 'title_size';
				?>
				<div class="btn-group title-size" data-toggle="buttons-radio">
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
			<label class="control-label">Content alignment</label>
			<div class="controls">
				<?php 
					$ar 	= array('Left'=>'l', 'Center'=>'c', 'Right'=>'r');
					$id		= 'content_align';
				?>
				<div class="btn-group content-align" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $key; ?>
					</label>
				<?php } ?>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Padding</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Top</span>
							<input type="text" class="pd-t input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Right</span>
							<input type="text" class="pd-r input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Bottom</span>
							<input type="text" class="pd-b input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Left</span>
							<input type="text" class="pd-l input-mini" value="" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Radius</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Top</span>
							<input type="text" class="radius-t input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Right</span>
							<input type="text" class="radius-r input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Bottom</span>
							<input type="text" class="radius-b input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Left</span>
							<input type="text" class="radius-l input-mini" value="" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Border width</label>
			<div class="controls">
				<?php 
					$ar 	= array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,20);
					$id		= 'bdr';
				?>
				<div class="btn-group bdr mb10" data-toggle="buttons-radio">
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
			<label class="control-label"></label>
			<div class="controls">
				<a class="btn apply btn-success">Apply</a>
			</div>
		</div>
	</div>
</div>
<script>
var obj = '#pop_mod_setting';
var dataSource = ".apply, .model-box .ui-icon-closethick";

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	//console.log(oldData_ar);
	$(obj).find(".title-position input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".content-align input[value='"+oldData_ar[1]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".pd-t").attr('value',oldData_ar[2]);
	$(obj).find(".pd-r").attr('value',oldData_ar[3]);
	$(obj).find(".pd-b").attr('value',oldData_ar[4]);
	$(obj).find(".pd-l").attr('value',oldData_ar[5]);
	$(obj).find(".bdr input[value='"+oldData_ar[6]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".radius-t").attr('value',oldData_ar[7]);
	$(obj).find(".radius-r").attr('value',oldData_ar[8]);
	$(obj).find(".radius-b").attr('value',oldData_ar[9]);
	$(obj).find(".radius-l").attr('value',oldData_ar[10]);
	$(obj).find(".title-size input[value='"+oldData_ar[11]+"']").prop('checked', true).parent().addClass('active');
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".title-position .active input[type='radio']").val()+"|"+
				  $(obj).find(".content-align .active input[type='radio']").val()+"|"+
				  $(obj).find(".pd-t").val()+"|"+
				  $(obj).find(".pd-r").val()+"|"+
				  $(obj).find(".pd-b").val()+"|"+
				  $(obj).find(".pd-l").val()+"|"+
				  $(obj).find(".bdr .active input[type='radio']").val()+"|"+
				  $(obj).find(".radius-t").val()+"|"+
				  $(obj).find(".radius-r").val()+"|"+
				  $(obj).find(".radius-b").val()+"|"+
				  $(obj).find(".radius-l").val()+"|"+
				  $(obj).find(".title-size .active input[type='radio']").val();
				  //console.log(dataStr);
	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

function colorPic(parent) {
	$(parent+' .rgb').spectrum("destroy");
	$(parent+' .sp-replacer').remove();
	colorPicker(parent+' .rgb', 'rgb');
}
colorPic('.img-bg');
colorPic('.img-border');
</script>