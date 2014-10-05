<?php 
	$this->load->library('rgen/rgen_lib');
	
	$theme = 	 $this->config->get('config_template');
	$device =  	 $this->rgen->device;
	$mobStatus = $this->config->get('RGen_optimizemob') == 1 && $device == 'm' ? 'm' : 'd';

	$tmp = array();
	foreach ($this->data['setting'] as $key => $value) { if ($value) { $tmp[] = $value; } }
	
	if($theme == "rgen-opencart"){
		if ($cache) {
			//$modName = implode("-", $tmp).$this->currency->getCode();
			$modName = serialize($tmp).$this->currency->getCode();
			$modFile = md5($modName)."_".$this->config->get('config_language_id').$mobStatus.$priceStatus.$taxStatus.$reviewStatus.$this->config->get('config_store_id').$cache_suffix;
			$cache_file = $this->rgen->cacheFilePath($theme, $dir, $modFile);
			if(!file_exists($cache_file)) {
				$this->getMod($setting);
				if (file_exists(DIR_TEMPLATE . $theme . '/template/'.$tpl)) {
					$this->template = $theme . '/template/'.$tpl;
				}
				$this->render();
				$this->rgen->cacheFile($this->render(), $cache_file);
			}else{
				$tpl = str_replace(DIR_TEMPLATE, '', $cache_file);
				$this->template = $tpl;
				$this->render();
			}
		}else{
			$this->getMod($setting);
			if (file_exists(DIR_TEMPLATE . $theme . '/template/'.$tpl)) {
				$this->template = $theme . '/template/'.$tpl;
				$this->render();
			}
		}
	}
 ?>