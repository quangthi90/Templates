<?php 
$this->commonData();
	$setting = $this->config->get($this->modSettings['modKey'].'_module');

	echo "<pre>Module data get ==> ".print_r($setting,true)."</pre>";
	
	$ext = explode("|", $extKey);
	$ext_mod = $ext[0];
	$ext_id = $ext[1];

	/* TPL loader Settings
	*******************************/
	$tpl     = $this->modSettings['main_tpl'];
	$theme   = $this->config->get('config_template');
	$extData = '';
	if (isset($setting)) {
		foreach ($setting as $key => $setting) {
			if (
				$setting['mod_id'] == $ext_mod && 
				$setting['ext_id'] == $ext_id && 
				$setting['status'] == 1 && 
				$setting['ext_access'] == 'y' && 
				file_exists(DIR_TEMPLATE . $theme . '/template/'.$tpl)
				) {
				
				$this->data['position'] = $setting["position"];
				$this->getMod($setting);
				$this->template = $theme . '/template/'.$tpl;
				$extData = $this->render();
			}
		}
	}
	return $extData;
?>