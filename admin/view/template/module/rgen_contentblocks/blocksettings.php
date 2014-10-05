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
			<label class="control-label">Block colors</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td class="bg">
							<span class="lbl">Background</span>
							<input type="text" class="rgb" value="" />
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
			<label class="control-label">Block content colors</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td class="title-color">
							<span class="lbl">Title</span>
							<input type="text" class="rgb" value="" />
						</td>
						<td class="content-color">
							<span class="lbl">Content</span>
							<input type="text" class="rgb" value="" />
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label">Inline style on block</label>
			<div class="controls">
				<input type="text" class="inline-block" style="width:95%;" value="">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Inline style on image</label>
			<div class="controls">
				<input type="text" class="inline-image" style="width:95%;" value="">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Inline style on title</label>
			<div class="controls">
				<input type="text" class="inline-title" style="width:95%;" value="">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Inline style on content</label>
			<div class="controls">
				<input type="text" class="inline-content" style="width:95%;" value="">
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
<br><br><br><br><br><br><br><br><br><br><br><br>
<script>
var obj = '#pop_mod_setting';
var dataSource = ".apply, .model-box .ui-icon-closethick";

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	console.log(oldData_ar);
	$(obj).find(".bg input").attr('value',oldData_ar[0]);
	$(obj).find(".border input").attr('value',oldData_ar[1]);
	$(obj).find(".title-color input").attr('value',oldData_ar[2]);
	$(obj).find(".content-color input").attr('value',oldData_ar[3]);
	$(obj).find(".inline-block").attr('value',oldData_ar[4]);
	$(obj).find(".inline-image").attr('value',oldData_ar[5]);
	$(obj).find(".inline-title").attr('value',oldData_ar[6]);
	$(obj).find(".inline-content").attr('value',oldData_ar[7]);
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".bg .rgb").val()+"|"+
				  $(obj).find(".border .rgb").val()+"|"+
				  $(obj).find(".title-color .rgb").val()+"|"+
				  $(obj).find(".content-color .rgb").val()+"|"+
				  $(obj).find(".inline-block").val()+"|"+
				  $(obj).find(".inline-image").val()+"|"+
				  $(obj).find(".inline-title").val()+"|"+
				  $(obj).find(".inline-content").val();
				 
				 //console.log(dataStr);
	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

function colorPic(parent) {
	$(parent+' .rgb').spectrum("destroy");
	$(parent+' .sp-replacer').remove();
	colorPicker(parent+' .rgb', 'rgb');
}
colorPic('.bg');
colorPic('.border');
colorPic('.title-color');
colorPic('.content-color');
</script>