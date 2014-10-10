<?php 
	$col = $mod_settings['in_row_d'];
	if ($col == 9 || $col == 10) { $t = ' t-col-5'; }
	if ($col == 7 || $col == 8) { $t = ' t-col-4'; }
	if ($col == 5 || $col == 6) { $t = ' t-col-3'; }
	if ($col < 5) { $t = ' t-col-2'; }
	if ($col >= 2) { $m = ' m3-col-1 m2-col-1 m1-col-1'; }else{ $m = ""; }

	$mrgTB = "margin-top: ".$mod_settings['top']."px; margin-bottom: ".$mod_settings['bottom']."px;";
	$mrgT = $mod_settings['bottom']-$mod_settings['gutter'];
	$modkey = 'contentblocks-module';
?>


<?php 
/* Full block settings ============== */
if ($position != 'column_left' && $position != 'column_right' && $extCheck == 'n'){ ?>
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
<div class="<?php echo $modkey.' '; ?>box" style="<?php echo $mrgTB; ?>" id="<?php echo $modkey.$module_count ?>">

<style scoped>
<?php
if($block_settings["block_content_align"] == "l"){
echo '#'. $modkey.$module_count. "{ text-align: left; }";
}elseif($block_settings["block_content_align"] == "r") {
echo '#'.$modkey.$module_count. "{ text-align: right; }";
}else{
echo '#'.$modkey.$module_count. "{ text-align: center; }";
}
?>
#<?php echo $modkey.$module_count ?> .ctn-block { <?php echo $blockCSS; ?> }
#<?php echo $modkey.$module_count ?> .ctn-block .img { <?php echo $imageCSS; ?> }
</style>

<?php 
	// Module title
	if (isset($main_title[$l_id]) && $main_title[$l_id] != '') { ?>
	<div class="box-heading header-1"><?php echo htmlspecialchars_decode($main_title[$l_id], ENT_QUOTES); ?></div>
	<?php } ?>
	<div class="box-content">
		<?php 
		// Module description
		if (isset($description[$l_id]) && $description[$l_id] != '') { echo htmlspecialchars_decode($description[$l_id], ENT_QUOTES ); } ?>
		<?php 
		/* CONTENT AREA ============== */
		if ($position != 'column_left' && $position != 'column_right'){ ?>

			<?php 
			/* Data in grid
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Grid') { ?>
			<div class="grid-wrp<?php echo ' gt-'.$mod_settings['gutter']; ?>">
				<div class="row<?php echo ' col-'.$col.$t.$m; ?>">
					<?php include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/module/rgen_contentblocks_data.php"); ?>
				</div>
				<b class="clearfix"></b>
			</div>
			
			
			<?php }
			/*******************************/ ?>



			<?php 
			/* Data in scroll
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Carousel') { ?>
			<div class="grid-wrp<?php echo ' gt-'.$mod_settings['gutter']; ?>">
				<div class="row<?php echo ' col-'.$col.$t.$m; ?>">
					<div class="box-product<?php echo $mod_settings['effect'] == 'slide' || $mod_settings['effect'] == 'fade' && $col != 1 ? " owl-carousel" : null; ?>">
						<?php include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/module/rgen_contentblocks_data.php"); ?>
					</div>
				</div>
				<b class="clearfix"></b>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#<?php echo $modkey.$module_count ?>";
				<?php if ($mod_settings['effect'] == 'slide' || $mod_settings['effect'] == 'fade' && $col != 1) { ?>
				$(mod + " .owl-carousel").owlCarousel({
					itemsCustom : [ [0, 1], [420, 2], [600, 3], [768, 4], [980, <?php echo $col; ?>] ],
					navigation : false,
					navigationText : ["",""],
					pagination: <?php echo $mod_settings['pg_status'] == 'y' ? 'true' : 'false'; ?>,
					responsiveBaseWidth: mod
				});
				$(mod + " .owl-prev").addClass('prev');
				$(mod + " .owl-next").addClass('next');
				$(mod + " .owl-controls").addClass('carousel-controls');
				$(mod + " .owl-buttons").css({paddingRight: "<?php $gt = $mod_settings['gutter']/2+5; echo $gt.'px'; ?>"});
				<?php }else { ?>
				$(mod + " .box-product").quovolver({ equalHeight : false });
				$(mod+' .quovolve .ctn-block').matchHeight('remove');
				<?php } ?>
				/**/
			});
			</script>
			<?php }
			/*******************************/ ?>
		
		<?php } else {
		/* SIDE COLUMN ============== */ ?>

			<?php 
			/* Data in grid
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Grid') { ?>
			<div class="grid-wrp">
				<div class="vr-col<?php echo ' b-'.$mod_settings['gutter']; ?>">
					<?php include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/module/rgen_contentblocks_data.php"); ?>
				</div>
				<b class="clearfix"></b>
			</div>
			<?php }
			/*******************************/ ?>

			<?php 
			/* Data in scroll
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Carousel') { ?>
			<div class="grid-wrp">
				<div class="owl-carousel box-product">
					<?php include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/module/rgen_contentblocks_data.php"); ?>
				</div>
				<b class="clearfix"></b>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#<?php echo $modkey.$module_count ?>";
				$(mod + " .owl-carousel").owlCarousel({
					navigation : false,
					pagination: true,
					singleItem:true
				});
				$(mod + " .owl-controls").addClass('carousel-controls');
				$(mod + " .owl-buttons").css({paddingRight: "<?php $gt = $mod_settings['gutter']/2+5; echo $gt.'px'; ?>"});
			});
			</script>
			<?php }
			/*******************************/ ?>
		
		<?php } 
		/* SIDE COLUMN END ============== */ ?>

		<?php  
		// Module description bottom
		if (isset($description1[$l_id]) && $description1[$l_id] != '') { echo htmlspecialchars_decode($description1[$l_id], ENT_QUOTES ); } ?>

		<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	var mod = "#<?php echo $modkey.$module_count ?>";
	
	<?php if ($block_settings["img_position"] == 'l') { ?>
	if ($(mod + " .img-l").hasClass('wrp-n')) {
		$(mod + " .img-l").css({opacity:0});
		setTimeout(function(){
			var r = <?php echo isset($block_settings["img_offset_r"]) && $block_settings["img_offset_r"] != '' ? $block_settings["img_offset_r"] : 20; ?>;
			$(mod + " .info-wrp").css('marginLeft', ($(mod + " .img").outerWidth()+r));
			$(mod + " .img-l").animate({opacity: 1}, 200, function() {});
		}, 200);
	};
	<?php } ?>

	<?php if ($block_settings["img_position"] == 'r') { ?>
	if ($(mod + " .img-r").hasClass('wrp-n')) {
		$(mod + " .img-r").css({opacity:0});
		setTimeout(function(){
			var r = <?php echo isset($block_settings["img_offset_l"]) && $block_settings["img_offset_l"] != '' ? $block_settings["img_offset_l"] : 20; ?>;
			$(mod + " .info-wrp").css('marginRight', ($(mod + " .img").outerWidth()+r));
			$(mod + " .img-r").animate({opacity: 1}, 200, function() {});
		}, 200);
	};
	<?php } ?>
});
</script>

<?php 
/* Full block settings ============== */
if ($position != 'column_left' && $position != 'column_right' && $extCheck == 'n'){ ?>
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
