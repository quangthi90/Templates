<?php foreach ($modules as $module) { 
	$titlesize = isset($block_settings["block_titlesize"]) ? $block_settings["block_titlesize"] : '4';
	$title     = '<h3 class="header-'.$titlesize.'" style="'.$module['titleStyle'].'">'.htmlspecialchars_decode($module['title'][$l_id], ENT_QUOTES ).'</h3>';
	$imgPos    = $block_settings["img_position"] == 'l' ? ' img-l' : null;
	$wrp       = $block_settings["block_contentwrp"] == 'n' && $block_settings["img_position"] == 'l' ? ' wrp-n' : null;
?>
<div class="col">
	<div class="ctn-block<?php echo $imgPos.$wrp; ?>" style="<?php echo $module['blockStyle']; ?>">
		<?php if ($block_settings["block_title_position"] == "t") { echo $title; } ?>
		<?php if ($module['img_type'] == 'ico') { ?>
		<div class="img" style="<?php echo $module['imgStyle']; ?>" title="<?php echo $module['title'][$l_id]; ?>">
			<i class="<?php echo $module['ico']; ?>" style="<?php echo $module['iconStyle']; ?>"></i>
		</div>
		<?php }else{ ?>
		<div class="img" style="<?php echo $module['imgStyle']; ?>">
			<img src="<?php echo $module['img_src']; ?>" alt="<?php echo $module['title'][$l_id]; ?>">
		</div>
		<?php } ?>
		<div class="info-wrp">
			<?php if ($block_settings["block_title_position"] == "b") { echo $title; } ?>
			<div class="info" style="<?php echo $module['contentStyle']; ?>">
				<?php echo htmlspecialchars_decode($module['short_description'][$l_id], ENT_QUOTES ); ?>
			</div>
		</div>
		<b class="clearfix"></b>
	</div>
</div>
<?php } ?>