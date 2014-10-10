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
			<label class="control-label">Controls</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Arrows</span>
							<?php 
								$ar 	= array("Yes" => 'y', "No" => 'n');
								$id		= 'arrowstatus';
							?>
							<div class="btn-group arrow-status" data-toggle="buttons-radio">
							<?php foreach ($ar as $key => $value) { ?>
								<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
									<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
									<?php echo $key; ?>
								</label>
							<?php } ?>
							</div>
						</td>
						<td>
							<span class="lbl">Pagination</span>
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
						</td>
						<td>
							<span class="lbl">Timer</span>
							<?php 
								$ar 	= array("Top" => 't', "Bottom" => 'b');
								$id		= 'timer';
							?>
							<div class="btn-group timer-pos" data-toggle="buttons-radio">
							<?php foreach ($ar as $key => $value) { ?>
								<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
									<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
									<?php echo $key; ?>
								</label>
							<?php } ?>
							</div>
						</td>
						<td>
							<span class="lbl">Pause on hover</span>
							<?php 
								$ar 	= array("Yes" => 'y', "No" => 'n');
								$id		= 'hvstatus';
							?>
							<div class="btn-group hover-status" data-toggle="buttons-radio">
							<?php foreach ($ar as $key => $value) { ?>
								<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
									<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
									<?php echo $key; ?>
								</label>
							<?php } ?>
							</div>
						</td>
						<td>
							<span class="lbl">Autoplay</span>
							<?php 
								$ar 	= array("Yes" => 'y', "No" => 'n');
								$id		= 'autoplay';
							?>
							<div class="btn-group autoplay" data-toggle="buttons-radio">
							<?php foreach ($ar as $key => $value) { ?>
								<label for="<?php echo $id . '-' . $value; ?>"  type="button" class="btn-mini btn">
									<input type="radio" id="<?php echo $id . '-' . $value; ?>" value="<?php echo $value; ?>">
									<?php echo $key; ?>
								</label>
							<?php } ?>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Hide caption on mobile</label>
			<div class="controls">
				<?php 
					$ar 	= array("Yes" => 'y', "No" => 'n');
					$id		= 'hidem';
				?>
				<div class="btn-group hidem" data-toggle="buttons-radio">
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
			<label class="control-label">Interval</label>
			<div class="controls">
				<input placeholder="Top" type="text" class="interval input-mini" value="3000">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Slide transition</label>
			<div class="controls">
				<?php 
					$ar 	= $transition;
					$id		= 'transition';
				?>
				<select class="transition">
					<?php foreach ($ar as $key => $value) { ?>
					<option value="<?php echo $value; ?>"><?php echo $key; ?></option>
					<?php } ?>	
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Caption settings</label>
			<div class="controls">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Incoming animation</span>
							<?php 
								$ar 	= $IncomingAnimation;
								$id		= 'incomingAnimation';
							?>
							<select class="incomingAnimation">
								<?php foreach ($ar as $key => $value) { ?>
								<option value="<?php echo $value; ?>"><?php echo $key; ?></option>
								<?php } ?>	
							</select>
						</td>
						<td>
							<span class="lbl">Outgoing animation</span>
							<?php 
								$ar 	= $OutgoingAnimation;
								$id		= 'outgoingAnimation';
							?>
							<select class="outgoingAnimation">
								<?php foreach ($ar as $key => $value) { ?>
								<option value="<?php echo $value; ?>"><?php echo $key; ?></option>
								<?php } ?>	
							</select>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls tb">
				<table class="subfields withbdr">
					<tr>
						<td>
							<span class="lbl">Easing</span>
							<?php 
								$ar 	= $easing;
								$id		= 'easing';
							?>
							<select class="easing">
								<?php foreach ($ar as $key => $value) { ?>
								<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
								<?php } ?>	
							</select>
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
<script>
var obj = '#pop_mod_setting';
var dataSource = ".apply, .model-box .ui-icon-closethick, .apply-bar";

var oldData = $('.pop-active').next("input[type='hidden']").val();
if(oldData){
	var oldData_ar = oldData.split('|');
	$(obj).find(".arrow-status input[value='"+oldData_ar[0]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".page-status input[value='"+oldData_ar[1]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".timer-pos input[value='"+oldData_ar[2]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".hover-status input[value='"+oldData_ar[3]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".autoplay input[value='"+oldData_ar[4]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".interval").attr('value',oldData_ar[5]);
	$(obj).find(".transition option[value='"+oldData_ar[6]+"']").prop('selected', true);
	//$(obj).find(".cp-style input[value='"+oldData_ar[7]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".incomingAnimation option[value='"+oldData_ar[7]+"']").prop('selected', true);
	$(obj).find(".outgoingAnimation option[value='"+oldData_ar[8]+"']").prop('selected', true);
	$(obj).find(".easing option[value='"+oldData_ar[9]+"']").prop('selected', true);
	//$(obj).find(".cpPosition option[value='"+oldData_ar[11]+"']").prop('selected', true);
	$(obj).find(".tb .t").attr('value',oldData_ar[10]);
	$(obj).find(".tb .b").attr('value',oldData_ar[11]);
	$(obj).find(".sep input[value='"+oldData_ar[12]+"']").prop('checked', true).parent().addClass('active');
	$(obj).find(".hidem input[value='"+oldData_ar[13]+"']").prop('checked', true).parent().addClass('active');
	
}

$(obj).find(dataSource).off('change click focus input blur');
$(obj).find(dataSource).on('change click focus input blur', function(){
	var dataStr = $(obj).find(".arrow-status .active input[type='radio']").val()+"|"+
				  $(obj).find(".page-status .active input[type='radio']").val()+"|"+
				  $(obj).find(".timer-pos .active input[type='radio']").val()+"|"+
				  $(obj).find(".hover-status .active input[type='radio']").val()+"|"+
				  $(obj).find(".autoplay .active input[type='radio']").val()+"|"+
				  $(obj).find(".interval").val()+"|"+
				  $(obj).find(".transition").val()+"|"+
				  //$(obj).find(".cp-style .active input[type='radio']").val()+"|"+
				  $(obj).find(".incomingAnimation").val()+"|"+
				  $(obj).find(".outgoingAnimation").val()+"|"+
				  $(obj).find(".easing").val()+"|"+
				  //$(obj).find(".cpPosition").val()+"|"+
				  $(obj).find(".tb .t").val()+"|"+
				  $(obj).find(".tb .b").val()+"|"+
				  $(obj).find(".sep .active input[type='radio']").val()+"|"+
				  $(obj).find(".hidem .active input[type='radio']").val();

				  //y|y|t|y|y|3000|fade|1|sfl|str|Power0.easeIn|cc|40|40|n|n
				  //arrow-status|page-status|timer-pos|hover-status|autoplay|interval|transition|cp-style|incomingAnimation|outgoingAnimation|easing|cpPosition|t|b|sep
				  //console.log(dataStr);
	$('.pop-active').next("input[type='hidden']").attr('data-style', $(obj).find(".style .active input[type='radio']").val());
	$('.pop-active').next("input[type='hidden']").attr('value', dataStr);
});

</script>