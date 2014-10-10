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
			<label class="control-label">Display style</label>
			<div class="controls">
				<?php 
					$ar 	= array("Grid", "Carousel");
					$id		= 'style';
				?>
				<div class="btn-group style mb10" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $value; ?>
					</label>
				<?php } ?>
				</div>
				<div class="bnr-style-preview mb10">
					<img src="view/image/rgen_theme/rgen_bnr_mod_typGrid.png" alt="Grid type" width="300" class="mb10" /><br>
					<a class="helpbtn" style="width:auto; padding: 5px 10px; font-size: 11px; height: auto; line-height: 1;" data-type="img" data-info="view/image/rgen_theme/rgen_bnr_mod_typGrid.png">Enlarge</a>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Pagination display in Carousel</label>
			<div class="controls">
				<?php 
					$ar 	= array("Yes" => 'y', "No" => 'n');
					$id		= 'pgstatus';
				?>
				<div class="btn-group page-status" data-toggle="buttons-radio">
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
			<label class="control-label">Effect</label>
			<div class="controls">
				<?php 
					$ar 	= array("Fade" => 'fade', "Slide" => 'slide');
					$id		= 'effect';
				?>
				<div class="btn-group effect" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $key; ?>
					</label>
				<?php } ?>
				</div>
				<div class="help-block mb10">
					Fade effect only work with single item display in row
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Blocks display in row</label>
			<div class="controls">
				<?php 
					$ar 	= array(1,2,3,4,5,6,7,8,9,10);
					$id		= 'in_row_d';
				?>
				<div class="btn-group in_row_d" data-toggle="buttons-radio">
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
			<label class="control-label">Space between blocks</label>
			<div class="controls">
				<?php 
					$ar 	= array(0,1,2,4,10,16,20,26,30,40,50,60);
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
			<label class="control-label">Top - Bottom spacing</label>
			<div class="controls tb">
				<input placeholder="Top" type="text" class="t input-mini" value="40"> - 
				<input placeholder="Bottom" type="text" class="b input-mini" value="40">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Separator line after banners</label>
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

$(obj).find('.style .btn').off('click');
$(obj).find('.style .btn').on('click', function(event) {
	event.preventDefault();
	var styletype = $(this).find("input[type='radio']").val();
	$(".bnr-style-preview img").attr({
		src: 'view/image/rgen_theme/rgen_bnr_mod_typ'+$(this).find("input[type='radio']").val()+'.png'
	});
	$(".bnr-style-preview .helpbtn").attr(
		"data-info", 'view/image/rgen_theme/rgen_bnr_mod_typ'+$(this).find("input[type='radio']").val()+'.png'
	);
});

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	$(obj).find(".bnr-style-preview img").attr('src','view/image/rgen_theme/rgen_bnr_mod_typ'+oldData_ar[0]+'.png');
	$(obj).find(".bnr-style-preview .helpbtn").attr('data-info','view/image/rgen_theme/rgen_bnr_mod_typ'+oldData_ar[0]+'.png');
	$(obj).find(".style input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".in_row_d input[value='"+oldData_ar[1]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".gt input[value='"+oldData_ar[2]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".tb .t").attr('value',oldData_ar[3]);
	$(obj).find(".tb .b").attr('value',oldData_ar[4]);
	$(obj).find(".sep input[value='"+oldData_ar[5]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".page-status input[value='"+oldData_ar[6]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".effect input[value='"+oldData_ar[7]+"']").prop('checked', true).parent().addClass('active');
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".style .active input[type='radio']").val()+"|"+
				  $(obj).find(".in_row_d .active input[type='radio']").val()+"|"+
				  $(obj).find(".gt .active input[type='radio']").val()+"|"+
				  $(obj).find(".tb .t").val()+"|"+
				  $(obj).find(".tb .b").val()+"|"+
				  $(obj).find(".sep .active input[type='radio']").val()+"|"+
				  $(obj).find(".page-status .active input[type='radio']").val()+"|"+
				  $(obj).find(".effect .active input[type='radio']").val();
				  //console.log(dataStr);
	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

function colorPic(parent) {
	$(parent+' .rgb').spectrum("destroy");
	$(parent+' .sp-replacer').remove();
	colorPicker(parent+' .rgb', 'rgb');
}
colorPic('.cp-bg');
colorPic('.cp-text');
colorPic('.cp-innerborder');
</script>