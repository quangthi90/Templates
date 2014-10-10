<?php

class ControllerModuleRGenGridmanager extends Controller {

	private $modSettings = array(
		'modKey' 		=> 'rgen_gridmanager',
		'modLng'		=> 'module/rgen_gridmanager',
		'modelPath' 	=> 'rgen/rgengridmanager',
		'model'			=> 'model_rgen_rgengridmanager',
		'main_tpl' 		=> 'module/rgen_gridmanager.tpl',
		'assign_tpl' 	=> 'module/rgen_gridmanager/rgen_gridmanager_assign.tpl',
		'manage_tpl' 	=> 'module/rgen_gridmanager/rgen_gridmanager_manage.tpl',
		'add_tpl' 		=> 'module/rgen_gridmanager/rgen_gridmanager_add.tpl',
		'edit_tpl' 		=> 'module/rgen_gridmanager/rgen_gridmanager_edit.tpl'
		);
	protected function index($setting) {
		$this->commonData();

		static $module_count = 0;
		$this->data['module_count'] = $module_count++;
		
		$this->data['setting'] = $setting;
		$setting['module_count'] = $this->data['module_count'];
		$this->data['position'] = $setting["position"];

		//echo "<pre>".print_r($setting,true)."</pre>";
		
		if($this->data['setting']) {
			include('catalog/rgen/tools/full_block/full_block.php');

			/* TPL loader Settings
			*******************************/
			$rgen_optimize 		= $this->config->get('RGen_optimize');
			$cache 				= isset($rgen_optimize['cache_gridmanager']) ? $rgen_optimize['cache_gridmanager'] : 0;
			$dir 				= 'rgen_gridmanager';
			$cache_suffix		= $setting['modCacheKey'];
		    $priceStatus		= null;
		    $taxStatus			= null;
		    $reviewStatus		= null;
		    $loggedIn			= null;
		    $tpl 				= $this->modSettings['main_tpl'];
			
			if(	isset($setting['cat_status']) && $setting['cat_status'] == "sel" ||
				isset($setting['prd_status']) && $setting['prd_status'] == "sel" ||
				isset($setting['brand_status']) && $setting['brand_status'] == "sel" ||
				isset($setting['info_status']) && $setting['info_status'] == "sel" )
			{ 
				if(	isset($setting['category']) && in_array($this->data['category_id'], $setting['category']) ||
					isset($setting['products']) && in_array($this->data['product_id'], $setting['products']) ||
					isset($setting['brands']) && in_array($this->data['brand_id'], $setting['manufacturer']) ||
					isset($setting['information']) && in_array($this->data['information_id'], $setting['information']))
					{
					include('catalog/rgen/tools/tpl_loader/tpl_loader.php');
					}

			}else{
				include('catalog/rgen/tools/tpl_loader/tpl_loader.php');
			}
		}
	}

	public function getMod($setting){
		
		$mod_name = $setting['mod_id'];
		$this->data['module_key'] = $mod_name;

		$this->data['modules'] = array();

		$this->data['module'] = $this->{$this->modSettings['model']}->RGenGetValue($mod_name);
		$this->data['module'] = $this->data['module'][$mod_name];

		//echo "<pre>".print_r($setting,true)."</pre>";
		
		// Module settings
		$tmpSetting = explode("|", $setting['modSettings']);
		$this->data['mod_settings'] = array(
			"gutter" 			=> $tmpSetting[0],
			"top" 				=> $tmpSetting[1],
			"bottom" 			=> $tmpSetting[2],
			"hr" 				=> $tmpSetting[3],
			"sep-col"			=> $tmpSetting[4],
			"sep-col-color"		=> $tmpSetting[5],
			"row_b"				=> isset($tmpSetting[6]) ? 'margin-bottom: '.$tmpSetting[6].'px;' : '',
			"eq_h"				=> isset($tmpSetting[7]) && $tmpSetting[7] == "on" ? ' data-mh="'.$setting['module_count'].'-'.$this->modSettings['modKey'].'-col"' : null,
			"eq_h_status"		=> isset($tmpSetting[7]) ? $tmpSetting[7] : "on"
		);
		$this->data['colsep'] = isset($this->data['mod_settings']['sep-col']) && $this->data['mod_settings']['sep-col'] == 'y' ? 'border-right: 1px solid '.$this->data['mod_settings']['sep-col-color'].';' : null;
		$this->data['colsep_status'] = isset($this->data['mod_settings']['sep-col']) && $this->data['mod_settings']['sep-col'] == 'y' ? 'overflow: hidden;' : null;
		//echo "<pre>".print_r($this->data['mod_settings'],true)."</pre>";

		/* Section full block style
		******************************/
		$tmpFullb = explode("|", $setting['fullB']);
		$this->data['fullB_settings'] = array(
			"fullB" 				=> $tmpFullb[0],
			"fullB_class" 			=> $tmpFullb[1] != '' ? ' '.$tmpFullb[1] : null,
			"fullB_bgcolor" 		=> $tmpFullb[2] != '' ? 'background-color: '.$tmpFullb[2].';' : null,
			"fullB_bgimg"			=> strpos($tmpFullb[3],'no_image') !== false ? '' : 'background-image: url(image/'.$tmpFullb[3].');',
			"fullB_bgAttachment" 	=> $tmpFullb[4] != '' ? 'background-attachment: '.$tmpFullb[4].';' : 'background-attachment: inherit;',
			"fullB_bgrepeat" 		=> $tmpFullb[5] != '' ? 'background-repeat: '.$tmpFullb[5].';' : 'background-repeat: repeat;',
			"fullB_bgposition" 		=> $tmpFullb[6],
			"fullB_bgps1" 			=> $tmpFullb[7],
			"fullB_bgps2" 			=> $tmpFullb[8],
			"top" 					=> $tmpFullb[9] != '' ? 'margin-top:'.$tmpFullb[9].'px;': 'margin-top: 0px;',
			"bottom" 				=> $tmpFullb[10] != '' ? 'margin-bottom:'.$tmpFullb[10].'px;': 'margin-bottom: 0px;',
			"inlineCSS"				=> $tmpFullb[11] != '' ? $tmpFullb[11] : '',
			"parallax"				=> isset($tmpFullb[12]) && $tmpFullb[12] != '' ? $tmpFullb[12] : 'n'
		);
		/*echo "<pre>".print_r($tmpFullb,true)."</pre>";*/
		
		// Generate full background array
		if ($this->data['fullB_settings']['fullB'] == 'y') {
			$this->data['fullB_class'] = $this->data['fullB_settings']['fullB_class'];
			$setting['fullB_bgps'] = $this->data['fullB_settings']['fullB_bgps1'] . ' ' . $this->data['fullB_settings']['fullB_bgps2'];

			if ($this->data['fullB_settings']['fullB_bgposition'] != "other" && $this->data['fullB_settings']['fullB_bgimg'] != '') {
				$bgPosition = 'background-position: '.$this->data['fullB_settings']['fullB_bgposition'].';';
			}else{
				$bgPosition = 'background-position: '.$setting['fullB_bgps'].';';
			}

			$this->data['fullB_str'] = $this->data['fullB_settings']['fullB_bgcolor'];
			$this->data['fullB_str'] .= $this->data['fullB_settings']['fullB_bgimg'];
			$this->data['fullB_str'] .= $this->data['fullB_settings']['fullB_bgimg'] != '' ? $this->data['fullB_settings']['fullB_bgrepeat'] : null;
			$this->data['fullB_str'] .= $this->data['fullB_settings']['fullB_bgimg'] != '' ? $bgPosition : null;
			$this->data['fullB_str'] .= $this->data['fullB_settings']['fullB_bgimg'] != '' ? $this->data['fullB_settings']['fullB_bgAttachment'] : null;
			$this->data['fullB_str'] .= $this->data['fullB_settings']['top'];
			$this->data['fullB_str'] .= $this->data['fullB_settings']['bottom'];
			$this->data['fullB_str'] .= $this->data['fullB_settings']['inlineCSS'];

			$this->data['parallaxStatus'] = $this->data['fullB_settings']['parallax'];
			$this->data['parallaxSpeed'] = $this->data['fullB_settings']['parallax'] == 'y' ? ' data-speed="8"' : '';
		}else{ 
			$this->data['fullB_str'] = '';
			$this->data['parallaxStatus'] = '';
			$this->data['parallaxSpeed'] = '';
		}

		//echo "<pre>".print_r($this->data['fullB_str'],true)."</pre>";

		/* Sorting module data
		******************************/
		$modArr = $this->data['module']['modData'];
		if ($modArr) {
			$sort_order = array();
			foreach ($modArr as $key => $value) {
				$sort_order[$key] = isset($value['sort_order']) ? $value['sort_order'] : 0;
			}
			array_multisort($sort_order, SORT_ASC, $modArr);
		}
		$this->data['module']['modData'] = $modArr;

		/* Generate module array
		******************************/
		foreach ($this->data['module']['modData'] as $k => $v) {
			if ($v['status'] == 1) {
				$this->data['modules'][] = array(
					'col_size'    => $v['col_size'],
					'col_size_t'  => $v['col_size_t'],
					'col_size_m'  => $v['col_size_m'],
					'class'       => isset($v['class']) ? ' '.$v['class'] : '',
					'inline'    => isset($v['inline']) ? htmlspecialchars_decode($v['inline'], ENT_QUOTES) : '',
					'selectedMod' => isset($v['selectedMod']) && isset($v['selectedModKey']) ? $this->extLoader($v['selectedModKey'], 'ext_access', $v['selectedMod']) : null,
					'bgimg_status'		=> isset($v['bgimg']) && $v['bgimg'] != '' ? true : false,
					'bgimg'		=> isset($v['bgimg']) && $v['bgimg'] != '' ? 'background-image: url(image/'.$v['bgimg'].');' : null
				);
			}
		}

		//echo "<pre> module data => ".print_r($this->data['module'],true)."</pre>";
		//echo "<pre>".print_r($this->data['modules'],true)."</pre>";

	}

	// type = category , product , manufacturer , information 
	public function autoLoader($type, $id){
		$getData = array();
		include('catalog/rgen/tools/layout_info/layout_data.php');
		return $getData;
	}
	

	public function extLoader($ext, $method, $extKey) {
		if (file_exists(DIR_APPLICATION . 'controller/module/'.$ext.'.php')) {
			require_once(DIR_APPLICATION . 'controller/module/'.$ext.'.php');
			$class = 'ControllerModule' . str_replace('_', '', $ext);
			$class = new $class($this->registry);
			if (method_exists($class, $method)) {
				$extData = $class->{$method}($extKey);
				//echo "<pre>".print_r($extData,true)."</pre>";
				return $extData;
			}
		}
	}

	//include('catalog/rgen/tools/layout_info/layout_data.php');
	public function commonData() {
		$this->load->model('tool/image');
		$this->data['modSettings'] = $this->modSettings;
		$this->load->model($this->modSettings['modelPath']);
		$this->language->load($this->modSettings['modLng']);
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['l_id'] = $this->config->get('config_language_id');

		// Identify page layout
		include('catalog/rgen/tools/layout_info/layout_info.php');

		/* Files load in front end
		******************************/
		$this->document->addScript('catalog/view/theme/rgen-opencart/js/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/theme/rgen-opencart/stylesheet/magnific-popup.css');
	}
}
?>