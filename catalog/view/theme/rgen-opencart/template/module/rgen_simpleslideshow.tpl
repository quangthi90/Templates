<?php 
	$mrgTB = "margin-top: ".$mod_settings['top']."px; margin-bottom: ".$mod_settings['bottom']."px;";
	$mrgT = $mod_settings['bottom'];
	$modkey = 'simpleslideshow-module';
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
<style scoped>
<?php if ($mod_settings['arrow-status'] == 'n') { ?>
#<?php echo $modkey.$module_count ?> .tparrows { display: none; }	
<?php } ?>
<?php if ($mod_settings['pg-status'] == 'n') { ?>
#<?php echo $modkey.$module_count ?> .tp-bullets { display: none; }
<?php } ?>

#<?php echo $modkey.$module_count ?>,
#<?php echo $modkey.$module_count ?> .revo-slides {
	<?php echo isset($mod_settings['img_w']) && $position != 'slideshow_full' ? "max-width:" . $mod_settings['img_w'] . "px;" : null; ?>
	<?php echo isset($mod_settings['img_h']) ? "max-height:" . $mod_settings['img_h'] . "px !important;" : null; ?>
}
</style>

<div class="<?php echo $modkey.' '; ?>box" style="<?php echo $mrgTB; ?>" id="<?php echo $modkey.$module_count ?>">
	<?php 
	// Module title
	if (isset($main_title[$l_id]) && $main_title[$l_id] != '') { ?>
	<div class="box-heading header-1"><?php echo htmlspecialchars_decode($main_title[$l_id], ENT_QUOTES); ?></div>
	<?php }

		// Module description
		if (isset($description[$l_id]) && $description[$l_id] != '') { echo htmlspecialchars_decode($description[$l_id], ENT_QUOTES ); } ?>
				
		<div class="box-content revo-slideshow-wrapper normal" style="text-align: center;<?php echo $position == 'slideshow_full' ? 'opacity:0;' : null; ?>">
			<div class="bannercontainer">
				<div class="revo-slides" style="opacity:1;">
					<ul>
						<?php foreach ($modules as $module) { 
							$url = isset($module['url']) && $module['url'] != '' ? ' data-link="'.$module['url'].'"' : null;
							$target = $module['new_win'] == 'y' ? ' data-target="_blank" ' : null; ?>
							<li data-transition="fade"<?php echo $url.$target; ?>>
								<img data-lazyload="<?php echo $module['image'][$l_id]; ?>" src="catalog/view/theme/rgen-opencart/revo/rs-plugin/images/dummy.png"  alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
								<div class="tp-caption ss-cp<?php 
									echo $module['cp_theme'].
										 $module['cp_style'].
										 $module['cp_align'].
										 $mod_settings['incomingAnimation'].
										 $mod_settings['outgoingAnimation']; 
									?>"
									data-x="<?php echo $module['x']; ?>"
									data-y="<?php echo $module['y']; ?>"
									data-hoffset="<?php echo $module['h']; ?>"
									data-voffset="<?php echo $module['v']; ?>"
									data-speed="500"
									data-easing="<?php echo $mod_settings['easing']; ?>"
									data-endspeed="500"><?php echo htmlspecialchars_decode($module['title'][$l_id], ENT_QUOTES ); ?>
								</div>
							</li>
						<?php } ?>
					</ul>
					<div class="tp-bannertimer<?php echo isset($mod_settings['timer-pos']) && $mod_settings['timer-pos'] == 'b' ? ' tp-bottom' : null; ?>"></div>
				</div>
			</div>

			<div class="clearfix<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? ' hr' : '' ?>" style="<?php echo isset($mod_settings['hr']) && $mod_settings['hr'] == 'y' ? 'margin-top:'.$mrgT.'px;' : null; ?>"></div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			var mod = "#<?php echo $modkey.$module_count ?>";
			$(mod+' .tp-caption').each(function() {
				var c = $(this).find('*').length
				if (c > 0) {
					$(this).wrapInner( "<div class='cp-wrp'></div>");
				}else{
					$(this).wrapInner( "<div class='t40'></div>");
				};
			});

			function rvSimpleSlider() {
				$(mod+' .revo-slides').revolution({
					delay: <?php echo $mod_settings['interval']; ?>,
					startwidth:<?php echo $mod_settings['img_w']; ?>,
					startheight:<?php echo $mod_settings['img_h']; ?>,
					autoHeight:"on",
					onHoverStop:"on",
					hideBulletsOnMobile:"off",
					hideArrowsOnMobile:"on",
					navigationType:"bullet",
					navigationArrows:"solo",
					navigationStyle:"round",
					navigationVOffset: 0,
					touchenabled:"on",
					stopAtSlide: <?php echo $mod_settings['autoplay'] == 'y' ? "-1" : '1'; ?>,
					stopAfterLoops: <?php echo $mod_settings['autoplay'] == 'y' ? "-1" : '0'; ?>,
					fullWidth:"<?php echo $position == 'slideshow_full' ? 'on' : 'off'; ?>",
					forceFullWidth:"off",
					fullScreen:"off",
					hideAllCaptionAtLimit: <?php echo $mod_settings['hide_cp'] == 'y' ? 420 : 0; ?>
				});
			}

			<?php if ($position == "slideshow_full") {; ?>
				$(mod+' .revo-slideshow-wrapper').css('opacity', '0');
				loadCSS = function(href) {
					var cssLink = $("<link rel='stylesheet' type='text/css' href='"+href+"'>");
					$("head").append(cssLink);
				};
				<?php foreach ($styles as $key => $style) { ?>
				// load the css file 
				loadCSS("<?php echo $style; ?>");
				<?php } ?>

				// Loading js files
				$.when(
				<?php foreach ($scripts as $key => $script) { ?>
				$.getScript("<?php echo $script; ?>"),
				<?php } ?>
				$.Deferred(function(deferred){
					$(deferred.resolve);
				})).done(function(){
					rvSimpleSlider();
					$(mod+' .revo-slideshow-wrapper').animate({'opacity': 1}, 400,function(){});
				}).fail(function(jqxhr, settings, exception) {
					$(mod+' .revo-slideshow-wrapper').hide();
					$(mod).append('<div align="center">Slide show scripts not loaded. Please refresh page and check again.</div>');
				});
  
			<?php }else{; ?>
				rvSimpleSlider();
			<?php }; ?>
		});
		</script>
	</div>

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
