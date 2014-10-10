<?php foreach ($modules as $module) { 
	$titlesize = isset($block_settings["block_titlesize"]) ? $block_settings["block_titlesize"] : '4';
	$title     = isset($module['title'][$l_id]) && $module['title'][$l_id] != '' ? '<h3 class="header-'.$titlesize.'" style="'.$module['titleStyle'].'">'.htmlspecialchars_decode($module['title'][$l_id], ENT_QUOTES ).'</h3>' : null;
	if ($block_settings["img_position"] == 'l' && $block_settings["img_status"] == 'y') {
		$imgPos = ' img-l';
	}elseif($block_settings["img_position"] == 'r' && $block_settings["img_status"] == 'y'){
		$imgPos = ' img-r';
	}else {
		$imgPos = '';
	}
	if ($block_settings["block_contentwrp"] == 'n' && $block_settings["img_position"] == 'l' ||
		$block_settings["block_contentwrp"] == 'n' && $block_settings["img_position"] == 'r') {
		$wrp = ' wrp-n';
	}else {
		$wrp = '';
	}

	if (isset($module["block_url"]) && $module["block_url"] != '') {
		$block_url = ' onclick="location.href=\''.$module["block_url"].'\';"';
		$cursor = 'cursor: pointer;';
	}else{
		$block_url = '';
		$cursor = '';
	}
	//$imgPos    = $block_settings["img_position"] == 'l' && $block_settings["img_status"] == 'y' ? ' img-l' : null;
	//$wrp       = $block_settings["block_contentwrp"] == 'n' && $block_settings["img_position"] == 'l' ? ' wrp-n' : null;
?>
<div class="col">
	<div class="ctn-block<?php echo $imgPos.$wrp; ?>" style="<?php echo $module['blockStyle'].$cursor; ?>" data-mh="<?php echo $module_count.'-'.$modkey; ?>-ctn"<?php echo $block_url; ?>>
		<?php if ($block_settings["block_title_position"] == "t") { echo $title; } ?>
		
		<?php if ($block_settings["img_status"] == 'y') { ?>
			<?php if (isset($module["img_url"]) && $module["img_url"]!='') { ?>
				<?php if ($module['img_type'] == 'ico') { ?>
				<a href="<?php echo $module["img_url"]; ?>" class="img" style="<?php echo $module['imgStyle']; ?>">
					<i class="<?php echo $module['ico']; ?>" style="<?php echo $module['iconStyle']; ?>"></i>
				</a>
				<?php }else{ ?>
				<a href="<?php echo $module["img_url"]; ?>" class="img" style="<?php echo $module['imgStyle']; ?>">
					<img src="<?php echo $module['img_src']; ?>" alt="<?php echo $module['title'][$l_id]; ?>">
				</a>
				<?php } ?>
			<?php }else{ ?>
				<?php if ($module['img_type'] == 'ico') { ?>
				<div class="img" style="<?php echo $module['imgStyle']; ?>">
					<i class="<?php echo $module['ico']; ?>" style="<?php echo $module['iconStyle']; ?>"></i>
				</div>
				<?php }else{ ?>
				<div class="img" style="<?php echo $module['imgStyle']; ?>">
					<img src="<?php echo $module['img_src']; ?>" alt="image">
				</div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		
		<div class="info-wrp">
			<?php if ($block_settings["block_title_position"] == "b") { echo $title; } ?>
			<?php if (isset($module['short_description'][$l_id]) && $module['short_description'][$l_id] != '') { ?>
			<div class="info" style="<?php echo $module['contentStyle']; ?>">
				<?php echo htmlspecialchars_decode($module['short_description'][$l_id], ENT_QUOTES ); ?>
			</div>
			<?php } ?>
		</div>
		
		<b class="clearfix"></b>
	</div>
</div>
<?php } ?>