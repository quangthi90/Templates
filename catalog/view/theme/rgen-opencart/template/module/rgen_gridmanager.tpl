<?php 
	$mrgTB  = "margin-top: ".$mod_settings['top']."px; margin-bottom: ".$mod_settings['bottom']."px;";
	$mrgT   = $mod_settings['bottom']-$mod_settings['gutter'];
	$modkey = 'gridmanager-module';
?>


<?php 
/* Full block settings ============== */
if ($position != 'column_left' && $position != 'column_right'){ ?>
<div class="<?php 
	echo isset($fullB_settings['fullB']) && $fullB_settings['fullB'] == 'y' ? 'fullb' : null; 
	echo isset($fullB_class) ? $fullB_class : null;
	?>"<?php 
	echo isset($fullB_str) ? ' style="'.$fullB_str.'"' : null; 
	?> id="fullB<?php echo $module_count.'-'.$modkey; ?>"<?php echo $parallaxSpeed; ?>>
	<div class="fullB-inner">
<?php } 
/* Full block settings ============== */
?>
<div class="<?php echo $modkey.' '; ?>box" style="<?php echo $mrgTB.$colsep_status; ?>" id="<?php echo $modkey.$module_count ?>">
	<div class="box-content" style="text-align: center;">
		<?php 
		if ($position != 'column_left' && $position != 'column_right'){ ?>
		<div class="rw gut-<?php echo $mod_settings['gutter']; ?>">
			<?php foreach ($modules as $key => $value) { ?>
			<div class="col-d-<?php echo $value['col_size']; ?> col-t-<?php echo isset($value['col_size_t']) ? $value['col_size_t'] : '1'; ?> col-m-<?php 
				echo isset($value['col_size_m']) ? $value['col_size_m'] : '1';
				echo $value['bgimg_status'] ? ' bg-block' : null;
				echo $value['class'];
				echo $value['selectedMod'] == '' ? " hidden-phone hidden-tablet" : null;
				?>" style="<?php echo $colsep.$mod_settings['row_b'].$value['bgimg']; ?>"<?php //echo $mod_settings['eq_h']; ?>>
				<div class="col-inner" style="<?php echo $value['inline']; ?>"><?php echo $value['selectedMod']; ?></div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
	</div>
</div>
<script>
$('#<?php echo $modkey.$module_count ?> .custom-tabs a').on('click', function(event) {
	event.preventDefault();
	$.fn.matchHeight._update(true);
});
<?php if ($mod_settings['eq_h_status'] == "on") { ?>
$(document).ready(function() {
	var obj = "#<?php echo $modkey.$module_count ?> > .box-content > .rw > [class^=col]";
	$(obj).matchHeight(true)
});
<?php }; ?>
</script>
<?php 
/* Full block settings ============== */
if ($position != 'column_left' && $position != 'column_right'){ ?>
	<?php if (isset($fullB_settings['fullB']) && $fullB_settings['fullB'] == 'y') { ?>
	<script>
	jQuery(document).ready(function($) {
		<?php if($parallaxStatus == 'y'){ ?>
		// Parallax image function
		$("#fullB<?php echo $module_count.'-'.$modkey; ?>").each(function(){
			var $bgobj = $(this); // assigning the object
			$(window).scroll(function() {
				var yPos = -($(window).scrollTop() / $bgobj.data('speed'));
				// Put together our final background position
				var coords = '50% '+ yPos + 'px';
				// Move the background
				$bgobj.css({ backgroundPosition: coords });
			}); 
		});
		<?php } ?>

		$(window).resize(function(){
			fullB("#fullB<?php echo $module_count.'-'.$modkey; ?>", ".fullB-inner");
		});
		fullB("#fullB<?php echo $module_count.'-'.$modkey; ?>", ".fullB-inner");
	});
	</script>
	<?php } ?>
	</div>
</div>
<?php }
/* Full block settings ============== */
?>
