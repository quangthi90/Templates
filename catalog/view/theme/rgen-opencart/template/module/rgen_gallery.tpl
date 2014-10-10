<?php 
	$col = $mod_settings['in_row_d'];
	if ($col == 9 || $col == 10) { $t = ' t-col-5'; }
	if ($col == 7 || $col == 8) { $t = ' t-col-4'; }
	if ($col == 5 || $col == 6) { $t = ' t-col-3'; }
	if ($col < 5) { $t = ''; }
	if ($col >= 2) { $m = ' m3-col-2 m2-col-2 m1-col-2'; }else{ $m = ""; }

	$mrgTB = "margin-top: ".$mod_settings['top']."px; margin-bottom: ".$mod_settings['bottom']."px;";
	$mrgT = $mod_settings['bottom']-$mod_settings['gutter'];
?>


<?php 
/* Full block settings ============== */
if ($position != 'column_left' && $position != 'column_right' && $extCheck == 'n'){ ?>
<div class="<?php 
	echo isset($fullB_settings['fullB']) && $fullB_settings['fullB'] == 'y' ? 'fullb' : null; 
	echo isset($fullB_class) ? $fullB_class : null;
	?>"<?php 
	echo isset($fullB_str) ? ' style="'.$fullB_str.'"' : null; 
	?> id="fullB<?php echo $module_count ?>-gallery-module"<?php echo $parallaxSpeed; ?>>
	<div class="fullB-inner">
<?php } 
/* Full block settings ============== */
?>


<div class="banners-module box gallery-module" style="<?php echo $mrgTB; ?>" id="gallery-module<?php echo $module_count ?>">
<?php //if ($mod_settings['h-effect'] == 'y' && $mod_settings['caption'] == 'y') { ?>
<style scoped>
#gallery-module<?php echo $module_count ?> .effect-oscar:hover .bnr-caption { background-color: <?php echo isset($mod_settings['cp-bg']) ? $mod_settings['cp-bg'] : 'rgba(0,0,0,0.3)'; ?>; }
#gallery-module<?php echo $module_count ?> .bnr-caption { color: <?php echo isset($mod_settings['cp-text']) ? $mod_settings['cp-text'] : '#fff'; ?>; }
</style>
<?php //} ?>

	<?php 
	// Module title
	if (isset($main_title[$l_id]) && $main_title[$l_id] != '') { ?>
	<div class="box-heading header-1"><?php echo htmlspecialchars_decode($main_title[$l_id], ENT_QUOTES); ?></div>
	<?php }

	// Module description
	if (isset($description[$l_id]) && $description[$l_id] != '') { echo htmlspecialchars_decode($description[$l_id], ENT_QUOTES ); } ?>
			
		<div class="box-content" style="text-align: center;">

		<?php 
		/* CONTENT AREA BANNERS ============== */
		if ($position != 'column_left' && $position != 'column_right'){ ?>

			<?php 
			/* Banners in grid
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Grid') { ?>
			<div class="banner-grid<?php echo ' gt-'.$mod_settings['gutter']; ?>">
				<div class="row<?php echo ' col-'.$col.$t.$m; ?>">
					<?php foreach ($modules as $module) { 
						$alt = isset($module['title'][$l_id]) ? ' alt="'.$module['title'][$l_id].'"' : null;
						$title = isset($module['title'][$l_id]) ? ' title="'.$module['title'][$l_id].'"' : null;
					?><div class="col">
						<a href="<?php echo $module['image'][1]; ?>" class="bnr effect-oscar"<?php echo $title; ?>>
							<span class="bnr-caption"><strong class="zoom-icon"></strong></span>
							<img src="<?php echo $module['thumb_image'][1]; ?>"<?php echo $alt; ?> />
						</a>
					</div>
					<?php } ?>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#gallery-module<?php echo $module_count ?>";
				$(mod + " .row").magnificPopup({
					delegate: '.col a',
					type: 'image',
					gallery: { enabled:true }
				});	
			});
			</script>
			
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banners in scroll
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Carousel') { ?>
			<div class="banner-grid<?php echo ' gt-'.$mod_settings['gutter']; ?>">
				<?php if ($mod_settings['arrow-status'] == 'y') { ?>
				<div class="carousel-arrows"><a class="prev"></a><a class="next"></a></div>
				<?php } ?>
				<div class="row<?php echo ' col-'.$col.$t.$m; ?>">
					<div class="owl-carousel box-product">
						<?php foreach ($modules as $module) { 
							$alt = isset($module['title'][$l_id]) ? ' alt="'.$module['title'][$l_id].'"' : null;
							$title = isset($module['title'][$l_id]) ? ' title="'.$module['title'][$l_id].'"' : null;
						?><div class="col">
							<a href="<?php echo $module['image'][1]; ?>" class="bnr effect-oscar"<?php echo $title; ?>>
								<span class="bnr-caption"><strong class="zoom-icon"></strong></span>
								<img src="<?php echo $module['thumb_image'][1]; ?>"<?php echo $alt; ?> />
							</a>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#gallery-module<?php echo $module_count ?>";

				$(mod + " .row").magnificPopup({
					delegate: '.col a',
					type: 'image',
					gallery: { enabled:true }
				});	

				var owl = $(mod + " .owl-carousel");
				owl.owlCarousel({
					itemsCustom : [ [0, 1], [420, 2], [600, 3], [768, 4], [940, <?php echo $col; ?>] ],
					navigation : false,
					navigationText : ["",""],
					pagination: <?php echo $mod_settings['pg-status'] == "y" ? 'true' : 'false'; ?>,
					responsiveBaseWidth: "#content"
				});

				<?php if ($mod_settings['arrow-status'] == 'y') { ?>
				// Custom Navigation Events
				$(mod + " .carousel-arrows .next").click(function(){ owl.trigger('owl.next'); });
				$(mod + " .carousel-arrows .prev").click(function(){ owl.trigger('owl.prev'); });
				<?php } ?>
				$(mod + " .owl-controls").addClass('carousel-controls');
			});
			</script>
			<?php }
			/*******************************/ ?>
			
		<?php } else {
		/* SIDE COLUMN BANNERS ============== */ ?>

			<?php 
			/* Banners in grid
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Grid') { ?>
			<div class="banner-grid<?php echo ' gt-'.$mod_settings['gutter']; ?>">
				<div class="row<?php echo ' col-'.$col.$t.$m; ?>">
					<?php foreach ($modules as $module) { 
						$alt = isset($module['title'][$l_id]) ? ' alt="'.$module['title'][$l_id].'"' : null;
						$title = isset($module['title'][$l_id]) ? ' title="'.$module['title'][$l_id].'"' : null;
					?><div class="col">
						<a href="<?php echo $module['image'][1]; ?>" class="bnr effect-oscar"<?php echo $title; ?>>
							<span class="bnr-caption"><strong class="zoom-icon"></strong></span>
							<img src="<?php echo $module['thumb_image'][1]; ?>"<?php echo $alt; ?> />
						</a>
					</div>
					<?php } ?>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#gallery-module<?php echo $module_count ?>";
				$(mod + " .row").magnificPopup({
					delegate: '.col a',
					type: 'image',
					gallery: { enabled:true }
				});	
			});
			</script>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banners in scroll
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Carousel') { ?>
			<div class="banner-grid">
				<div class="owl-carousel box-product">
					<?php foreach ($modules as $module) { 
						$alt = isset($module['title'][$l_id]) ? ' alt="'.$module['title'][$l_id].'"' : null;
						$title = isset($module['title'][$l_id]) ? ' title="'.$module['title'][$l_id].'"' : null;
					?><div class="item">
						<a href="<?php echo $module['image'][1]; ?>" class="bnr effect-oscar"<?php echo $title; ?>>
							<span class="bnr-caption"><strong class="zoom-icon"></strong></span>
							<img src="<?php echo $module['thumb_image'][1]; ?>"<?php echo $alt; ?> />
						</a>
					</div>
					<?php } ?>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#gallery-module<?php echo $module_count ?>";
				$(mod + " .box-product").magnificPopup({
					delegate: '.item a',
					type: 'image',
					gallery: { enabled:true }
				});

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
		/* SIDE COLUMN BANNERS END ============== */ ?>

	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#gallery-module<?php echo $module_count ?> .effect-oscar").each(function() {
		$(this).hover(function() {
			var t = ($(this).find('.bnr-caption').outerHeight()-$(this).find('.bnr-caption strong').outerHeight())/2;
			$(this).find('.bnr-caption strong').css({top: Math.round(t)});
		}, function() {});
	});
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
		$("#fullB<?php echo $module_count ?>-gallery-module").each(function(){
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
			fullB("#fullB<?php echo $module_count ?>-gallery-module", ".fullB-inner");
		});
		fullB("#fullB<?php echo $module_count ?>-gallery-module", ".fullB-inner");
	});
	</script>
	<?php } ?>
	</div>
</div>
<?php }
/* Full block settings ============== */
?>
