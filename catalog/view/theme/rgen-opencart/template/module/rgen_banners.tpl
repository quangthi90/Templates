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
if ($position != 'column_left' && $position != 'column_right'){ ?>
<div class="<?php 
	echo isset($fullB_settings['fullB']) && $fullB_settings['fullB'] == 'y' ? 'fullb' : null; 
	echo isset($fullB_class) ? $fullB_class : null;
	?>"<?php 
	echo isset($fullB_str) ? ' style="'.$fullB_str.'"' : null; 
	?> id="fullB<?php echo $module_count ?>-banners-module"<?php echo $parallaxSpeed; ?>>
	<div class="fullB-inner">
<?php } 
/* Full block settings ============== */
?>


<div class="banners-module box" style="<?php echo $mrgTB; ?>" id="banners-module<?php echo $module_count ?>">
<?php if ($mod_settings['h-effect'] == 'y' && $mod_settings['caption'] == 'y') { ?>
<style scoped>
#banners-module<?php echo $module_count ?> .effect-oscar .bnr-caption::before { border-color: <?php echo isset($mod_settings['cp-innerborder']) ? $mod_settings['cp-innerborder'] : '#fff'; ?>; }
#banners-module<?php echo $module_count ?> .effect-oscar:hover .bnr-caption { background-color: <?php echo isset($mod_settings['cp-bg']) ? $mod_settings['cp-bg'] : 'rgba(0,0,0,0.3)'; ?>; }
#banners-module<?php echo $module_count ?> .bnr-caption { color: <?php echo isset($mod_settings['cp-text']) ? $mod_settings['cp-text'] : '#fff'; ?>; }
</style>
<?php } ?>

<?php if ($mod_settings['h-effect'] == 'n' && $mod_settings['caption'] == 'y') { ?>
<style scoped>
#banners-module<?php echo $module_count ?> .cp-no-effect .bnr-caption { 
	background-color: <?php echo isset($mod_settings['cp-bg']) ? $mod_settings['cp-bg'] : 'rgba(0,0,0,0.3)'; ?>; 
	color: <?php echo isset($mod_settings['cp-text']) ? $mod_settings['cp-text'] : '#fff'; ?>;
}
</style>
<?php } ?>
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
						$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
						$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
					?><div class="col">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banners in scroll
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Carousel') { ?>
			<div class="controls-top banner-grid<?php echo ' gt-'.$mod_settings['gutter']; ?>">
				<div class="row<?php echo ' col-'.$col.$t.$m; ?>">
					<div class="owl-carousel box-product">
					<?php foreach ($modules as $module) { 
						$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
						$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
					?><div class="col">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					</div>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#banners-module<?php echo $module_count ?>";
				$(mod + " .owl-carousel").owlCarousel({
					itemsCustom : [ [0, 2], [420, 2], [600, 3], [768, 4], [980, <?php echo $col; ?>] ],
					navigation : true,
					navigationText : ["",""],
					pagination: true,
					responsiveBaseWidth: mod
				});
				$(mod + " .owl-prev").addClass('prev');
				$(mod + " .owl-next").addClass('next');
				$(mod + " .owl-controls").addClass('carousel-controls');
				$(mod + " .owl-buttons").css({paddingRight: "<?php $gt = $mod_settings['gutter']/2+5; echo $gt.'px'; ?>"});
			});
			</script>
			<?php }
			/*******************************/ ?>
			

			<?php 
			/* Banner layout - 1
			******************************/
			if ($mod_settings['display_style'] == '1') { ?>
			<div class="masonry-wrp g10" data-g="g10">
				
				<?php if (isset($in_slide)){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="8" class="masonry-item">
						<div class="slide-widget" data-auto="true" data-effect="fadeUp" data-interval="2000" data-pauseonhover="true" data-height="386" data-width="782">
							<?php foreach ($in_slide as $k => $v){ 
								$sld 	= '<img src="'.$v['image'][$l_id] .'" alt="'.$v['title'][$l_id].'" />';
								$sld_target = $v['new_win'] == 'y' ? ' target="_blank" ' : null;
							?>
							<?php if ($v['url'] != '') { ?>
							<div class="slide"><a href="<?php echo $v['url']; ?>"<?php echo $sld_target; ?>><?php echo $sld; ?></a></div>
							<?php } else { ?>
							<div class="slide"><?php echo $sld; ?></div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
				if (isset($in_slide)){
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php }else{ ?>
					<?php if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="8" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
				<?php } ?>

				<?php $layout1_i++; } ?>
			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 2
			******************************/
			if ($mod_settings['display_style'] == '2') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php if (isset($in_slide)){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="8" class="masonry-item">
						<div class="slide-widget" data-auto="true" data-effect="fadeUp" data-interval="2000" data-pauseonhover="true" data-height="386" data-width="782">
							<?php foreach ($in_slide as $k => $v){ 
								$sld 	= '<img src="'.$v['image'][$l_id] .'" alt="'.$v['title'][$l_id].'" />';
								$sld_target = $v['new_win'] == 'y' ? ' target="_blank" ' : null;
							?>
							<?php if ($v['url'] != '') { ?>
							<div class="slide"><a href="<?php echo $v['url']; ?>"<?php echo $sld_target; ?>><?php echo $sld; ?></a></div>
							<?php } else { ?>
							<div class="slide"><?php echo $sld; ?></div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
				if (isset($in_slide)){
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php }else{ ?>
					<?php if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="8" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
				<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 3
			******************************/
			if ($mod_settings['display_style'] == '3') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php if (isset($in_slide)){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="8" class="masonry-item">
						<div class="slide-widget" data-auto="true" data-effect="fadeUp" data-interval="2000" data-pauseonhover="true" data-height="386" data-width="782">
							<?php foreach ($in_slide as $k => $v){ 
								$sld 	= '<img src="'.$v['image'][$l_id] .'" alt="'.$v['title'][$l_id].'" />';
								$sld_target = $v['new_win'] == 'y' ? ' target="_blank" ' : null;
							?>
							<?php if ($v['url'] != '') { ?>
							<div class="slide"><a href="<?php echo $v['url']; ?>"<?php echo $sld_target; ?>><?php echo $sld; ?></a></div>
							<?php } else { ?>
							<div class="slide"><?php echo $sld; ?></div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
				if (isset($in_slide)){
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php }else{ ?>
					<?php if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="8" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
				<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>

			<?php 
			/* Banner layout - 4
			******************************/
			if ($mod_settings['display_style'] == '4') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
					$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
					$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;

					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
				<?php $layout1_i++; } ?>

				<?php if (isset($in_slide)){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="6" class="masonry-item">
						<div class="slide-widget" data-auto="true" data-effect="fadeUp" data-interval="2000" data-pauseonhover="true" data-height="386" data-width="584">
							<?php foreach ($in_slide as $k => $v){ 
								$sld 	= '<img src="'.$v['image'][$l_id] .'" alt="'.$v['title'][$l_id].'" />';
								$sld_target = $v['new_win'] == 'y' ? ' target="_blank" ' : null;
							?>
							<?php if ($v['url'] != '') { ?>
							<div class="slide"><a href="<?php echo $v['url']; ?>"<?php echo $sld_target; ?>><?php echo $sld; ?></a></div>
							<?php } else { ?>
							<div class="slide"><?php echo $sld; ?></div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
				if (isset($in_slide)){
					if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php }else{ ?>

					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="6" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 5
			******************************/
			if ($mod_settings['display_style'] == '5') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 5){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 6
			******************************/
			if ($mod_settings['display_style'] == '6') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="6" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="6" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 5){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 7
			******************************/
			if ($mod_settings['display_style'] == '7') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="6" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 8
			******************************/
			if ($mod_settings['display_style'] == '8') { ?>
			<div class="masonry-wrp g2" data-g="g2">

				<?php if (isset($in_slide)){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="6" class="masonry-item">
						<div class="slide-widget" data-auto="true" data-effect="fadeUp" data-interval="2000" data-pauseonhover="true" data-height="390" data-width="584">
							<?php foreach ($in_slide as $k => $v){ 
								$sld 	= '<img src="'.$v['image'][$l_id] .'" alt="'.$v['title'][$l_id].'" />';
								$sld_target = $v['new_win'] == 'y' ? ' target="_blank" ' : null;
							?>
							<?php if ($v['url'] != '') { ?>
							<div class="slide"><a href="<?php echo $v['url']; ?>"<?php echo $sld_target; ?>><?php echo $sld; ?></a></div>
							<?php } else { ?>
							<div class="slide"><?php echo $sld; ?></div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
				if (isset($in_slide)){
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 5){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 6){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php }else{ ?>
					<?php if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="6" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 3){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div  data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 5){ ?>
					<div  data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 6){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 7){ ?>
					<div data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 9
			******************************/
			if ($mod_settings['display_style'] == '9') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php if (isset($in_slide)){ ?>
					<div data-ss-rowspan="6" data-ss-colspan="8" class="masonry-item">
						<div class="slide-widget" data-auto="true" data-effect="fadeUp" data-interval="2000" data-pauseonhover="true" data-height="584" data-width="782">
							<?php foreach ($in_slide as $k => $v){ 
								$sld 	= '<img src="'.$v['image'][$l_id] .'" alt="'.$v['title'][$l_id].'" />';
								$sld_target = $v['new_win'] == 'y' ? ' target="_blank" ' : null;
							?>
							<?php if ($v['url'] != '') { ?>
							<div class="slide"><a href="<?php echo $v['url']; ?>"<?php echo $sld_target; ?>><?php echo $sld; ?></a></div>
							<?php } else { ?>
							<div class="slide"><?php echo $sld; ?></div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
				if (isset($in_slide)){
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php }else{ ?>

					<?php if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="6" data-ss-colspan="8" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div  data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 5){ ?>
					<div  data-ss-rowspan="2" data-ss-colspan="2" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 10
			******************************/
			if ($mod_settings['display_style'] == '10') { ?>
			<div class="masonry-wrp g20" data-g="g20">

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="4" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div data-ss-rowspan="2" data-ss-colspan="4" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banner layout - 11
			******************************/
			if ($mod_settings['display_style'] == '11') { ?>
			<div class="masonry-wrp g10" data-g="g10">

				<?php if (isset($in_slide)){ ?>
					<div data-ss-rowspan="6" data-ss-colspan="6" class="masonry-item">
						<div class="slide-widget" data-auto="true" data-effect="fadeUp" data-interval="2000" data-pauseonhover="true" data-height="584" data-width="782">
							<?php foreach ($in_slide as $k => $v){ 
								$sld 	= '<img src="'.$v['image'][$l_id] .'" alt="'.$v['title'][$l_id].'" />';
								$sld_target = $v['new_win'] == 'y' ? ' target="_blank" ' : null;
							?>
							<?php if ($v['url'] != '') { ?>
							<div class="slide"><a href="<?php echo $v['url']; ?>"<?php echo $sld_target; ?>><?php echo $sld; ?></a></div>
							<?php } else { ?>
							<div class="slide"><?php echo $sld; ?></div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php 
				$layout1_i = 0;
				foreach ($modules as $module) { 
				$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
				$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				
				if (isset($in_slide)){
					if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php }else{ ?>

					<?php if ($layout1_i == 0){ ?>
					<div data-ss-rowspan="6" data-ss-colspan="6" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 1){ ?>
					<div data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 2){ ?>
					<div data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
					<?php if ($layout1_i == 3){ ?>
					<div data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

					<?php if ($layout1_i == 4){ ?>
					<div  data-ss-rowspan="3" data-ss-colspan="3" class="masonry-item">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="imgblock<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>

				<?php } ?>

				<?php $layout1_i++; } ?>

			</div>
			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			<?php }
			/*******************************/ ?>

		<?php } else {
		/* SIDE COLUMN BANNERS ============== */ ?>

			<?php 
			/* Banners in grid
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Grid') { ?>
			<div class="banner-grid<?php echo ' gt-'.$mod_settings['gutter']; ?>">
				<div class="vr-col b-10">
					<?php foreach ($modules as $module) { 
						$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
						$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
					?><div class="col">
						<?php if ($module['url'] != '') { ?>
						<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</a>
						<?php } else { ?>
						<span class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
							<?php echo $img; ?>
							<?php if ($mod_settings['caption'] == 'y') { ?>
							<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
							<?php } ?>
						</span>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<?php }
			/*******************************/ ?>


			<?php 
			/* Banners in scroll
			******************************/	?>
			<?php if ($mod_settings['display_style'] == 'Carousel') { ?>
			<div class="banner-grid">
				<div class="owl-carousel box-product">
				<?php foreach ($modules as $module) { 
					$img 	= '<img src="'.$module['image'][$l_id] .'" alt="'.$module['title'][$l_id].'" />';
					$target = $module['new_win'] == 'y' ? ' target="_blank" ' : null;
				?><div class="item">
					<?php if ($module['url'] != '') { ?>
					<a href="<?php echo $module['url']; ?>"<?php echo $target; ?>class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
						<?php echo $img; ?>
						<?php if ($mod_settings['caption'] == 'y') { ?>
						<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
						<?php } ?>
					</a>
					<?php } else { ?>
					<span class="bnr<?php echo $mod_settings['h-effect'] == 'y' ? " effect-oscar" : " cp-no-effect"; ?>">
						<?php echo $img; ?>
						<?php if ($mod_settings['caption'] == 'y') { ?>
						<?php echo isset($module['title'][$l_id]) ? '<span class="bnr-caption"><strong>' . $module['title'][$l_id] . '</strong></span>' : null; ?>
						<?php } ?>
					</span>
					<?php } ?>
				</div>
				<?php } ?>
				</div>
				<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
			</div>
			<script type="text/javascript">
			$(document).ready(function() {
				var mod = "#banners-module<?php echo $module_count ?>";
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
	$("#banners-module<?php echo $module_count ?> .effect-oscar").each(function() {
		$(this).hover(function() {
			var t = ($(this).find('.bnr-caption').outerHeight()-$(this).find('.bnr-caption strong').outerHeight())/2;
			$(this).find('.bnr-caption strong').css({top: Math.round(t)});
		}, function() {});
	});
});
</script>



<?php 
/* Full block settings ============== */
if ($position != 'column_left' && $position != 'column_right'){ ?>
	<?php if (isset($fullB_settings['fullB']) && $fullB_settings['fullB'] == 'y') { ?>
	<script>
	jQuery(document).ready(function($) {
		$("#fullB<?php echo $module_count ?>-banners-module").fullblock({ child: ".fullB-inner" });
		
		<?php if($parallaxStatus == 'y'){ ?>
		// Parallax image function
		$("#fullB<?php echo $module_count ?>-banners-module").each(function(){
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

	});
	</script>
	<?php } ?>
	</div>
</div>
<?php }
/* Full block settings ============== */
?>
