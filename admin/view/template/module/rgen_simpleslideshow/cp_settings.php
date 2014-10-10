<style>
.getValue .frm-small .control-label {
	width: 200px;
}
.getValue .frm-small .controls {
	margin-left: 210px;
}
</style>
<?php 
$transition = array(
	'Slide To Top'								=> 'slidetop',
	'Slide To Bottom'							=> 'slidebottom',
	'Slide To Right'							=> 'slideright',
	'Slide To Left'								=> 'slideleft',
	'Slide Horizontal'						 	=> 'slidehorizontal',
	'Slide Vertical'							=> 'slidevertical',
	'Slide Boxes'								=> 'boxslide',
	'Slide Slots Horizontal'					=> 'slotslide-horizontal',
	'Slide Slots Vertical'						=> 'slotslide-vertical',
	'Fade Boxes'								=> 'boxfade',
	'Fade Slots Horizontal'						=> 'slotfade-horizontal',
	'Fade Slots Vertical'						=> 'slotfade-vertical',
	'Fade and Slide from Right'					=> 'fadefromright',
	'Fade and Slide from Left'					=> 'fadefromleft',
	'Fade and Slide from Top'					=> 'fadefromtop',
	'Fade and Slide from Bottom'				=> 'fadefrombottom',
	'Fade To Left and Fade From Right'			=> 'fadetoleftfadefromright',
	'Fade To Right and Fade From Left'			=> 'fadetorightfadefromleft',
	'Fade To Top and Fade From Bottom'			=> 'fadetotopfadefrombottom',
	'Fade To Bottom and Fade From Top'			=> 'fadetobottomfadefromtop',
	'Parallax to Right'							=> 'parallaxtoright',
	'Parallax to Left'							=> 'parallaxtoleft',
	'Parallax to Top'							=> 'parallaxtotop',
	'Parallax to Bottom'						=> 'parallaxtobottom',
	'Zoom Out and Fade From Right'				=> 'scaledownfromright',
	'Zoom Out and Fade From Left'				=> 'scaledownfromleft',
	'Zoom Out and Fade From Top'				=> 'scaledownfromtop',
	'Zoom Out and Fade From Bottom'				=> 'scaledownfrombottom',
	'ZoomOut'									=> 'zoomout',
	'ZoomIn'									=> 'zoomin',
	'Zoom Slots Horizontal'						=> 'slotzoom-horizontal',
	'Zoom Slots Vertical'						=> 'slotzoom-vertical',
	'Fade'									 	=> 'fade',
	'Random Flat'								=> 'random-static',
	'Random Flat and Premium'					=> 'random',
	'Curtain from Left'							=> 'curtain-1',
	'Curtain from Right'						=> 'curtain-2',
	'Curtain from Middle'						=> 'curtain-3',
	'3D Curtain Horizontal'						=> '3dcurtain-horizontal',
	'3D Curtain Vertical'						=> '3dcurtain-vertical',
	'Cube Vertical'								=> 'cube',
	'Cube Horizontal'							=> 'cube-horizontal',
	'In Cube Vertical'							=> 'incube',
	'In Cube Horizontal'						=> 'incube-horizontal',
	'TurnOff Horizontal'						=> 'turnoff',
	'TurnOff Vertical'							=> 'turnoff-vertical',
	'Paper Cut'									=> 'papercut',
	'Fly In'									=> 'flyin',
	'Random Premium'							=> 'random-premium',
	'Random Flat and Premium'					=> 'random'
);
$IncomingAnimation = array(
	'Short from Top'			=> 'sft',
	'Short from Bottom'			=> 'sfb',
	'Short from Right'			=> 'sfr',
	'Short from Left'			=> 'sfl',
	'Long from Top'				=> 'lft',
	'Long from Bottom'			=> 'lfb',
	'Long from Right'			=> 'lfr',
	'Long from Left'			=> 'lfl',
	'Skew from Left'			=> 'skewfromleft',
	'Skew from Right'			=> 'skewfromright',
	'Skew Short from Left'		=> 'skewfromleftshort',
	'Skew Short from Right'		=> 'skewfromrightshort',
	'Fading'					=> 'fade',
	'Fade in, Rotate from a Random position and Degree'	=> 'randomrotate'
);
$OutgoingAnimation = array(
	'Short to Top'				=> 'stt',
	'Short to Bottom'			=> 'stb',
	'Short to Right'			=> 'str',
	'Short to Left'				=> 'stl',
	'Long to Top'				=> 'ltt',
	'Long to Bottom'			=> 'ltb',
	'Long to Right'				=> 'ltr',
	'Long to Left'				=> 'ltl',
	'Skew to Left'				=> 'skewtoleft',
	'Skew to Right'				=> 'skewtoright',
	'Skew Short to Left'		=> 'skewtoleftshort',
	'Skew Short to Right'		=> 'skewtorightshort',
	'Fading'					=> 'fadeout',
	'Fade in, Rotate from a Random position and Degree'	=> 'randomrotateout'
);
$easing = array(
	'Linear.easeNone',
	'Power0.easeIn',
	'Power0.easeInOut',
	'Power0.easeOut',
	'Power1.easeIn', 
	'Power1.easeInOut', 
	'Power1.easeOut', 
	'Power2.easeIn', 
	'Power2.easeInOut', 
	'Power2.easeOut', 
	'Power3.easeIn', 
	'Power3.easeInOut', 
	'Power3.easeOut', 
	'Power4.easeIn', 
	'Power4.easeInOut', 
	'Power4.easeOut', 
	'Quad.easeIn', 
	'Quad.easeInOut', 
	'Quad.easeOut', 
	'Cubic.easeIn', 
	'Cubic.easeInOut', 
	'Cubic.easeOut', 
	'Quart.easeIn', 
	'Quart.easeInOut', 
	'Quart.easeOut', 
	'Quint.easeIn', 
	'Quint.easeInOut', 
	'Quint.easeOut', 
	'Strong.easeIn', 
	'Strong.easeInOut', 
	'Strong.easeOut', 
	'Back.easeIn', 
	'Back.easeInOut', 
	'Back.easeOut', 
	'Bounce.easeIn', 
	'Bounce.easeInOut', 
	'Bounce.easeOut', 
	'Circ.easeIn', 
	'Circ.easeInOut', 
	'Circ.easeOut', 
	'Elastic.easeIn', 
	'Elastic.easeInOut', 
	'Elastic.easeOut', 
	'Expo.easeIn', 
	'Expo.easeInOut', 
	'Expo.easeOut', 
	'Sine.easeIn', 
	'Sine.easeInOut', 
	'Sine.easeOut', 
	'SlowMo.ease'
);
$cpPosition = array(
	'Top Left'			=> 'lt',
	'Top Center'		=> 'ct',
	'Top Right'			=> 'rt',
	'Center Left'		=> 'lc',
	'Center Center'		=> 'cc',
	'Center Right'		=> 'rc',
	'Bottom Left'		=> 'lb',
	'Bottom Center'		=> 'cb',
	'Bottom Right'		=> 'rb'
);
?>
<div class="getValue model-box" id="pop_mod_setting">
	<div class="form-horizontal frm-small">

		<div class="control-group">
			<label class="control-label">Caption color theme</label>
			<div class="controls">
				<?php 
					$ar 	= array("For dark background" => 'dark', "For light background" => 'light');
					$id		= 'cptheme';
				?>
				<div class="btn-group cptheme" data-toggle="buttons-radio">
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
			<label class="control-label">Caption text alignment</label>
			<div class="controls">
				<?php 
					$ar 	= array("Left" => 'l', "Center" => 'c', "Right" => 'r');
					$id		= 'cptxtalign';
				?>
				<div class="btn-group cptxtalign" data-toggle="buttons-radio">
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
			<label class="control-label">Caption style</label>
			<div class="controls">
				<?php 
					$ar 	= array("1", "2", "3", "4", "5", "6");
					$id		= 'style';
				?>
				<div class="btn-group cp-style mb10" data-toggle="buttons-radio">
				<?php foreach ($ar as $key => $value) { ?>
					<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
						<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
						<?php echo $value; ?>
					</label>
				<?php } ?>
				</div>
				<div class="bnr-style-preview mb10">
					<img src="view/image/rgen_theme/rgen_slideshow_cp1.png" alt="Caption style" width="300" class="mb10" /><br>
					<a class="helpbtn" style="width:auto; padding: 5px 10px; font-size: 11px; height: auto; line-height: 1;" data-type="img" data-info="view/image/rgen_theme/rgen_slideshow_cp1.png">Enlarge</a>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Position</label>
			<div class="controls">
				<?php 
					$ar 	= $cpPosition;
					$id		= 'cpPosition';
				?>
				<select class="cpPosition">
					<?php foreach ($ar as $key => $value) { ?>
					<option value="<?php echo $value; ?>"><?php echo $key; ?></option>
					<?php } ?>	
				</select>
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

$(obj).find('.cp-style .btn').off('click');
$(obj).find('.cp-style .btn').on('click', function(event) {
	event.preventDefault();
	var styletype = $(this).find("input[type='radio']").val();
	$(".bnr-style-preview img").attr({
		src: 'view/image/rgen_theme/rgen_slideshow_cp'+$(this).find("input[type='radio']").val()+'.png'
	});
	$(".bnr-style-preview .helpbtn").attr(
		"data-info", 'view/image/rgen_theme/rgen_slideshow_cp'+$(this).find("input[type='radio']").val()+'.png'
	);
});

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	$(obj).find(".cptheme input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".bnr-style-preview img").attr('src','view/image/rgen_theme/rgen_slideshow_cp'+oldData_ar[1]+'.png');
	$(obj).find(".cp-style input[value='"+oldData_ar[1]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".cpPosition option[value='"+oldData_ar[2]+"']").prop('selected', true);
	$(obj).find(".cptxtalign input[value='"+oldData_ar[3]+"']").prop('checked', true).parent().addClass('active');
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".cptheme .active input[type='radio']").val()+"|"+
				  $(obj).find(".cp-style .active input[type='radio']").val()+"|"+
				  $(obj).find(".cpPosition").val()+"|"+
				  $(obj).find(".cptxtalign .active input[type='radio']").val();
				  
				  //dark|1|cc|c
				  //y|y|t|y|y|3000|fade|1|sfl|str|Power0.easeIn|cc|40|40|n
				  //arrow-status|page-status|timer-pos|hover-status|autoplay|interval|transition|cp-style|incomingAnimation|outgoingAnimation|easing|cpPosition|t|b|sep
				  //console.log(dataStr);
	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

</script>