<?php 
if (isset($setting['mod_id']) && isset($RGen_custom)) {
	$l_id 	= $this->config->get('config_language_id');
	$mod_id = $setting['mod_id'];

	if ($RGen_custom[$mod_id]['position'] == 's_right' || $RGen_custom[$mod_id]['position'] == 's_left') {
		include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/common/RGen_customhtml_sticky.tpl");
	} 

	elseif ($RGen_custom[$mod_id]['position'] == 'ft_social') {
		include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/common/RGen_customhtml_footer.tpl");
	}

	elseif ($RGen_custom[$mod_id]['position'] == 'ft_below') {
		include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/common/RGen_customhtml_footerbottom.tpl");
	}

	elseif ($RGen_custom[$mod_id]['position'] == 'tp_above') {
		include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/common/RGen_customhtml_header.tpl");
	}

	elseif (
		$RGen_custom[$mod_id]['position'] == 'pd_above_img' ||
		$RGen_custom[$mod_id]['position'] == 'pd_below_img' ||
		$RGen_custom[$mod_id]['position'] == 'pd_above_options' ||
		$RGen_custom[$mod_id]['position'] == 'pd_below_options' ||
		$RGen_custom[$mod_id]['position'] == 'pd_above_tb' ||
		$RGen_custom[$mod_id]['position'] == 'pd_above_rel' ||
		$RGen_custom[$mod_id]['position'] == 'pd_tb'
		){
		include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/common/RGen_customhtml_".$RGen_custom[$mod_id]['position'].".tpl");
	}

	elseif ($RGen_custom[$mod_id]['position'] == 'footer_cards') {
		include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/common/RGen_customhtml_footercards.tpl");
	}
	
	else{
		include VQMod::modCheck("catalog/view/theme/rgen-opencart/template/common/rgen_custom.php");
	}
	
} ?>
