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
			<label class="control-label">Image container colors</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td class="img-bg">
							<span class="lbl">Background</span>
							<input type="text" class="rgb" value="" />
						</td>
						<td class="img-border">
							<span class="lbl">Border</span>
							<input type="text" class="rgb" value="" />
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Image type</label>
			<div class="controls">
				<?php 
					$ar 	= array("Image" => 'img', "Icon" => 'ico');
					$id		= 'img_type';
				?>
				<div class="btn-group img-type mb10" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $key; ?>
					</label>
				<?php } ?>
				</div>
				
				<div class="img image-block" style="display: ;">
					<?php $id = 'img'; ?>
					<div class="img-preview mb10" id="<?php echo $id; ?>-imgwrapper" style="vertical-align: top;">
						<div class="img-holder" id="<?php echo $id; ?>-preview"></div>
						<div class="btn-group btn-group-vertical">
							<a class="btn btn-small browse" data-id="<?php echo $id; ?>">Browse</a>
							<a class="btn btn-small clear" data-id="<?php echo $id; ?>">Clear</a>
						</div>
						<input type="hidden" id="<?php echo $id; ?>" value="" />
					</div>
					<script>
					$('#<?php echo $id; ?>-imgwrapper').setImage({
						token: $('.pop-active').attr("data-token"),
						no_img: $('.pop-active').attr("data-image")
					});
					</script>
				</div>

				<div class="ico image-block" style="display: none;">
					<input type="text" class="rgb" value="" />
					<input type="text" class="cls" placeholder="Enter CSS class name">
					<select class="input-small">
						<optgroup label="Icon size">
							<?php for ($x=20; $x <= 200; $x++) { ?>
							<option value="<?php echo $x; ?>"><?php echo $x; ?></option>
							<?php } ?>
						</optgroup>
					</select>
					<div class="help-block">
						Enter class name of Font Awesome icons (http://fortawesome.github.io/)<br>
						Example : <strong style="color: #000;">fa fa-bank</strong><br><br>
						
						Or use own custom class name to insert icon.
					</div>
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
<br><br><br><br><br><br><br>
<script>
var obj = '#pop_mod_setting';
var dataSource = ".apply, .model-box .ui-icon-closethick";
var noImg = $('.pop-active').attr("data-image");

$(".img-type").on('click', '.img-type label', function(event) {
	event.preventDefault();
	$(".image-block").hide();
	console.log($(this).find("input[type='radio']").val());
	$('.'+$(this).find("input[type='radio']").val()).show();
});

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	console.log(oldData_ar);
	$(obj).find(".img-bg input").attr('value',oldData_ar[0]);
	$(obj).find(".img-border input").attr('value',oldData_ar[1]);
	$(obj).find(".img-type input[value='"+oldData_ar[2]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find("#<?php echo $id; ?>").attr('value',oldData_ar[3]);

	var imgPath = String(oldData_ar[3]);
	if (imgPath.search("no_image") > -1) {
		$(obj).find('.img-holder').css({ backgroundImage: 'url('+oldData_ar[3]+')' });
	}else if(oldData_ar[3] == ''){
		$(obj).find('.img-holder').css({ backgroundImage: 'url('+noImg+')' });
	}else{
		$(obj).find('.img-holder').css({ backgroundImage: 'url(../image/'+oldData_ar[3]+')' });
	};

	$(obj).find(".ico .cls").attr('value',oldData_ar[4]);
	$(obj).find(".ico option[value='"+oldData_ar[5]+"']").prop('selected', true);
	$(obj).find(".ico .rgb").attr('value',oldData_ar[6]);

	if (oldData_ar[2] == 'ico') {
		$(obj).find(".ico").show();
		$(obj).find(".img").hide();
	}else{
		$(obj).find(".img").show();
		$(obj).find(".ico").hide();
	};
}


$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var img = $(obj).find("#<?php echo $id; ?>").val() == '' ? '' : $(obj).find("#<?php echo $id; ?>").val();
	var dataStr = $(obj).find(".img-bg input").val()+"|"+
				  $(obj).find(".img-border input").val()+"|"+
				  $(obj).find(".img-type .active input[type='radio']").val()+"|"+
				  img+"|"+
				  $(obj).find(".ico .cls").val()+"|"+
				  $(obj).find(".ico select").val()+"|"+
				  $(obj).find(".ico .rgb").val();
				
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
colorPic('.ico');

</script>