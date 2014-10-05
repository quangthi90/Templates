<?php 
$yn = array(
	"No" => 'n',
	"Yes" => 'y'
);
$positions = array(
	'Content Top' 		=> 'content_top',
	'Content Bottom' 	=> 'content_bottom',
	'Content Left' 		=> 'column_left',
	'Content Right' 	=> 'column_right'
);
$ImgRepeat = array( 
	'no-repeat',
	'repeat',
	'repeat-x',
	'repeat-y',
	'inherit'
); 
$ImgPosition = array( 
	'left top',
	'left bottom',
	'right top',
	'right bottom',
	'center top',
	'center bottom',
	'center center',
	'other'
);
$bodyBgAttachment = array( 'inherit', 'fixed');
?>
<div class="getValue model-box" id="fullB_setting">
	<div class="form-horizontal frm-small">
		<div class="control-group">
			<label class="control-label">Display in full block</label>
			<div class="controls">
				<?php $ar = $yn; ?>
				<select class="input-small fullB-status">
					<?php foreach ($ar as $key => $value) { ?>
					<option value="<?php echo $value; ?>"><?php echo $key; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="block-settings" style="display:none;">
			<div class="alert alert-info">
				Display in full block section does not support in page with side column layout and<br>
				position with "Column Right" and "Column Left" inside side column.
			</div>
			<div class="control-group">
				<label class="control-label">Apply CSS class</label>
				<div class="controls">
					<input type="text" class="input-medium fullB-class" value="" />
					<a class="btn btn-mini" data-val="dark-thm">On dark</a>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Apply inline CSS</label>
				<div class="controls">
					<input type="text" class="input-medium fullB-inlinecss" value="" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Background color</label>
				<div class="controls">
					<input type="text" class="rgb" value="" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Background image</label>
				<div class="controls">
					<div class="img-preview mb10" id="fullB_bgimg" style="vertical-align: top;">
						<?php $id = 'fullB-bgimg'; ?>
						<div class="img-holder" id="<?php echo $id; ?>-preview"></div>
						<div class="btn-group btn-group-vertical">
							<a class="btn btn-small browse" data-id="<?php echo $id; ?>">Browse</a>
							<a class="btn btn-small clear" data-id="<?php echo $id; ?>">Clear</a>
						</div>
						<input type="hidden" id="<?php echo $id; ?>" value="" />
					</div>
					
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Background image settings</label>
				<div class="controls">
					<?php $ar = $bodyBgAttachment; ?>
					<select style="width:180px; margin-bottom:10px;" class="fullB-bgAttachment">
						<optgroup label="Background attachment">
						<?php foreach ($ar as $key) { ?>
							<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
						<?php } ?>
						</optgroup>
					</select>

					<?php $ar = $ImgRepeat; ?>
					<select style="width:180px; margin-bottom:10px;" class="fullB-bgrepeat">
						<optgroup label="Background repeat">
						<?php foreach ($ar as $key) { ?>
							<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
						<?php } ?>
						</optgroup>
					</select><br>

					<?php $ar = $ImgPosition; ?>
					<select class="fullB-bgposition" style="width:180px; margin-bottom:10px;">
						<optgroup label="Background position">
						<?php foreach ($ar as $key) { ?>
							<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
						<?php } ?>
						</optgroup>
					</select>
				
					<div class="otherpos" style="display: none;">
						<input type="text" class="input-mini fullB-bgps1" value="">
						<input type="text" class="input-mini fullB-bgps2" value="">
					</div>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">Parallax background image</label>
				<div class="controls">
					<?php 
						$ar 	= array("Yes" => 'y', "No" => 'n');
						$id		= 'content_wrp';
					?>
					<div class="btn-group parallax" data-toggle="buttons-radio">
					<?php foreach ($ar as $key => $value) { ?>
						<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
							<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
							<?php echo $key; ?>
						</label>
					<?php } ?>
					</div>
					<div class="help-block">
						Background image settings will not work with parallax background image.
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">Top margin - Bottom margin</label>
				<div class="controls tb">
					<input placeholder="Top" type="text" class="t input-mini" value="40"> - 
					<input placeholder="Bottom" type="text" class="b input-mini" value="40">
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
<script><!--
var noImg = $('.pop-active').attr("data-image");
//$('.img-holder').css({ backgroundImage: 'url('+noImg+')' });

$.getScript( "view/javascript/rgen/rgenadmin.js", function(data, textStatus, jqxhr) {
	$('#fullB_bgimg').setImage({
		token: $('.pop-active').attr("data-token"),
		no_img: $('.pop-active').attr("data-image")
	});
	$('#fullB_setting').fullBock();
});

var obj = '#fullB_setting';
var dataSource = ".apply, .model-box .ui-icon-closethick, .model-box .ui-dialog-titlebar-close";

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	$(obj).find(".fullB-status option[value='"+oldData_ar[0]+"']").prop('selected', 'selected');
	if (oldData_ar[0] == "y") {
		$(obj).find('.block-settings').show();
	};
	$(obj).find(".fullB-class").attr('value',oldData_ar[1]);
	$(obj).find(".rgb").attr('value',oldData_ar[2]);
	$(obj).find("#fullB-bgimg").attr('value',oldData_ar[3]);

	var imgPath = String(oldData_ar[3]);
	if (imgPath.search("no_image") > -1) {
		$(obj).find('.img-holder').css({ backgroundImage: 'url('+oldData_ar[3]+')' });
	}else if(oldData_ar[3] == ''){
		$(obj).find('.img-holder').css({ backgroundImage: 'url('+noImg+')' });
	}else{
		$(obj).find('.img-holder').css({ backgroundImage: 'url(../image/'+oldData_ar[3]+')' });
	};

	$(obj).find(".fullB-bgAttachment option[value='"+oldData_ar[4]+"']").prop('selected', 'selected');
	$(obj).find(".fullB-bgrepeat option[value='"+oldData_ar[5]+"']").prop('selected', 'selected');
	$(obj).find(".fullB-bgposition option[value='"+oldData_ar[6]+"']").prop('selected', 'selected');

	if (oldData_ar[6] == "other") {
		$(obj).find('.otherpos').show();
	};

	$(obj).find(".fullB-bgps1").attr('value',oldData_ar[7]);
	$(obj).find(".fullB-bgps2").attr('value',oldData_ar[8]);
	$(obj).find(".tb .t").attr('value',oldData_ar[9]);
	$(obj).find(".tb .b").attr('value',oldData_ar[10]);
	$(obj).find(".fullB-inlinecss").attr('value',oldData_ar[11]);
	$(obj).find(".parallax input[value='"+oldData_ar[12]+"']").prop('checked', true).parent().addClass('active');
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){

	var img = $(obj).find("#fullB-bgimg").val() == '' ? noImg : $(obj).find("#fullB-bgimg").val();
	var parallax = $(obj).find(".parallax .active input[type='radio']").val() ? $(obj).find(".parallax .active input[type='radio']").val() : 'n';

	var dataStr = $(obj).find(".fullB-status").val()+"|"+
				  $(obj).find(".fullB-class").val()+"|"+
				  $(obj).find(".rgb").val()+"|"+
				  img +"|"+
				  $(obj).find(".fullB-bgAttachment").val()+"|"+
				  $(obj).find(".fullB-bgrepeat").val()+"|"+
				  $(obj).find(".fullB-bgposition").val()+"|"+
				  $(obj).find(".fullB-bgps1").val()+"|"+
				  $(obj).find(".fullB-bgps2").val()+"|"+
				  $(obj).find(".tb .t").val()+"|"+
				  $(obj).find(".tb .b").val()+"|"+
				  $(obj).find(".fullB-inlinecss").val()+"|"+
				  parallax;
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

function colorPic(parent) {
	$(parent+' .rgb').spectrum("destroy");
	$(parent+' .sp-replacer').remove();
	colorPicker(parent+' .rgb', 'rgb');
}
colorPic('#fullB_setting');

//--></script>