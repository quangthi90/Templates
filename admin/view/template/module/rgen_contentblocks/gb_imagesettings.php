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
			<label class="control-label">Image position</label>
			<div class="controls">
				<?php 
					$ar 	= array("Top" => 't', "Left" => 'l');
					$id		= 'img_position';
				?>
				<div class="btn-group img-position" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $key; ?>
					</label>
				<?php } ?>
				</div>
			</div>
		</div>

		<div class="control-group l" style="display: none;">
			<label class="control-label">Content wrap to image</label>
			<div class="controls">
				<?php 
					$ar 	= array("Yes" => 'y', "No" => 'n');
					$id		= 'content_wrp';
				?>
				<div class="btn-group text-wrp" data-toggle="buttons-radio">
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
			<label class="control-label">Image container</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Width</span>
							<input type="text" class="img-w input-mini" value="100" />
						</td>
						<td>
							<span class="lbl">Height</span>
							<input type="text" class="img-h input-mini" value="100" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">
				Image container offset
				<div class="help-block">Keep text box blank to reset value.</div>
			</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Top</span>
							<input type="text" class="img-t input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Right</span>
							<input type="text" class="img-r input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Bottom</span>
							<input type="text" class="img-b input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Left</span>
							<input type="text" class="img-l input-mini" value="" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Image container radius</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Top</span>
							<input type="text" class="img-r-t input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Right</span>
							<input type="text" class="img-r-r input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Bottom</span>
							<input type="text" class="img-r-b input-mini" value="" />
						</td>
						<td>
							<span class="lbl">Left</span>
							<input type="text" class="img-r-l input-mini" value="" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Image container border width</label>
			<div class="controls">
				<?php 
					$ar 	= array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,20);
					$id		= 'img-bdr';
				?>
				<div class="btn-group img-bdr mb10" data-toggle="buttons-radio">
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
	$(obj).find(".img-position input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".img-w").attr('value',oldData_ar[1]);
	$(obj).find(".img-h").attr('value',oldData_ar[2]);
	$(obj).find(".img-t").attr('value',oldData_ar[3]);
	$(obj).find(".img-r").attr('value',oldData_ar[4]);
	$(obj).find(".img-b").attr('value',oldData_ar[5]);
	$(obj).find(".img-l").attr('value',oldData_ar[6]);
	$(obj).find(".img-bdr input[value='"+oldData_ar[7]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".img-r-t").attr('value',oldData_ar[8]);
	$(obj).find(".img-r-r").attr('value',oldData_ar[9]);
	$(obj).find(".img-r-b").attr('value',oldData_ar[10]);
	$(obj).find(".img-r-l").attr('value',oldData_ar[11]);
	if (oldData_ar[0] == 'l') {
		$(obj).find(".l").show();
	}else{
		$(obj).find(".l").hide();
	};
	$(obj).find(".text-wrp input[value='"+oldData_ar[12]+"']").prop('checked', true).parent().addClass('active');
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".img-position .active input[type='radio']").val()+"|"+
				  $(obj).find(".img-w").val()+"|"+
				  $(obj).find(".img-h").val()+"|"+
				  $(obj).find(".img-t").val()+"|"+
				  $(obj).find(".img-r").val()+"|"+
				  $(obj).find(".img-b").val()+"|"+
				  $(obj).find(".img-l").val()+"|"+
				  $(obj).find(".img-bdr .active input[type='radio']").val()+"|"+
				  $(obj).find(".img-r-t").val()+"|"+
				  $(obj).find(".img-r-r").val()+"|"+
				  $(obj).find(".img-r-b").val()+"|"+
				  $(obj).find(".img-r-l").val()+"|"+
				  $(obj).find(".text-wrp .active input[type='radio']").val();
				  //console.log(dataStr);
	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

$('.img-position label').off('click');
$('.img-position .btn').on('click', function() {
	setTimeout(function(){
		if ($(".img-position .active input[type='radio']").val() == 't') {
			$('.l').hide();
		}else {
			$('.l').show();
		};
	}, 100);
});

function colorPic(parent) {
	$(parent+' .rgb').spectrum("destroy");
	$(parent+' .sp-replacer').remove();
	colorPicker(parent+' .rgb', 'rgb');
}
colorPic('.img-bg');
colorPic('.img-border');
</script>