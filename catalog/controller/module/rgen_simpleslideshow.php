<?php

class ControllerModuleRGenSimpleSlideshow extends Controller {

	private $modSettings = array(
		'modKey' 		=> 'rgen_simpleslideshow',
		'modLng'		=> 'module/rgen_simpleslideshow',
		'modelPath' 	=> 'rgen/rgensimpleslideshow',
		'model'			=> 'model_rgen_rgensimpleslideshow',
		'main_tpl' 		=> 'module/rgen_simpleslideshow.tpl',
		'assign_tpl' 	=> 'module/rgen_simpleslideshow/rgen_simpleslideshow_assign.tpl',
		'manage_tpl' 	=> 'module/rgen_simpleslideshow/rgen_simpleslideshow_manage.tpl',
		'add_tpl' 		=> 'module/rgen_simpleslideshow/rgen_simpleslideshow_add.tpl',
		'edit_tpl' 		=> 'module/rgen_simpleslideshow/rgen_simpleslideshow_edit.tpl'
		);

	protected function index($setting) {
		$this->commonData();

		/*static $module_count = 0;
		$this->data['module_count'] = $module_count++;*/
		
		$this->data['setting'] = $setting;
		$this->document->setting = $setting;
		$this->data['position'] = $setting["position"];

		/*$this->data['allScripts'] = implode(',', $this->data['scripts']);
		$this->data['allScripts'] = '"'.implode('","',explode(',',$this->data['allScripts'])).'"';*/

		if($this->data['setting']) {
			isset($this->data['setting']['ext_access']) ? $this->data['extCheck'] = $this->data['setting']['ext_access'] : $this->data['extCheck'] = 'n';
			if($this->data['extCheck'] == 'n') {
				include('catalog/rgen/tools/full_block/full_block.php');

				/* TPL loader Settings
				*******************************/
				$rgen_optimize 		= $this->config->get('RGen_optimize');
				$cache 				= isset($rgen_optimize['cache_simpleslideshow']) ? $rgen_optimize['cache_simpleslideshow'] : 0;
				$dir 				= 'rgen_simpleslideshow';
				$cache_suffix		= '';
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
	}

	public function ext_access($extKey){
		include('catalog/rgen/tools/ext_access/ext_access_assign.php');
		return $extData;
	}

	public function getMod($setting){
		
		$mod_name = $setting['mod_id'];
		$this->data['module_key'] = $mod_name;

		$this->data['modules'] = array();

		$this->data['module'] = $this->{$this->modSettings['model']}->RGenGetValue($mod_name);
		$this->data['module'] = $this->data['module'][$mod_name];

		//echo "<pre>".print_r($setting,true)."</pre>";
		
		$this->data['module_description'] = $this->{$this->modSettings['model']}->RGenGetDescription($mod_name);
	
		// Main title
		$this->data['main_title'] = $this->data['module_description']['main_title'];
		$this->data['description'] = $this->data['module_description']['description'];

		// Module settings
		$tmpSetting = explode("|", $setting['bannerSettings']);
		$this->data['mod_settings'] = array(
			//y|y|t|y|y|3000|fade|1|sfl|str|Power0.easeIn|cc|40|40|n
			//arrow-status|page-status|timer-pos|hover-status|autoplay|interval|transition|cp-style|incomingAnimation|outgoingAnimation|easing|cpPosition|t|b|sep
			"arrow-status"		=> isset($tmpSetting[0]) ? $tmpSetting[0] : "y",
			"pg-status"			=> isset($tmpSetting[1]) ? $tmpSetting[1] : "y",
			"timer-pos"			=> isset($tmpSetting[2]) ? $tmpSetting[2] : "t",
			"hover-stop"		=> isset($tmpSetting[3]) ? $tmpSetting[3] : "y",
			"autoplay"			=> isset($tmpSetting[4]) ? $tmpSetting[4] : "y",
			"interval"			=> isset($tmpSetting[5]) ? $tmpSetting[5] : 3000,
			"transition"		=> isset($tmpSetting[6]) ? $tmpSetting[6] : "fade",
			//"cp-style"			=> isset($tmpSetting[7]) ? $tmpSetting[7] : 1,
			"incomingAnimation"	=> isset($tmpSetting[7]) ? ' '.$tmpSetting[7] : " sfl",
			"outgoingAnimation"	=> isset($tmpSetting[8]) ? ' '.$tmpSetting[8] : " str",
			"easing"			=> isset($tmpSetting[9]) ? $tmpSetting[9] : "Power0.easeIn",
			//"cpPosition"		=> isset($tmpSetting[11]) ? $tmpSetting[11] : "cc",
			"top" 				=> isset($tmpSetting[10]) ? $tmpSetting[10] : 40,
			"bottom" 			=> isset($tmpSetting[11]) ? $tmpSetting[11] : 40,
			"hr" 				=> isset($tmpSetting[12]) ? $tmpSetting[12] : "n",
			"hide_cp"			=> isset($tmpSetting[13]) ? $tmpSetting[13] : "n",
			'img_w' 			=> isset($setting['img_w']) && $setting['img_w'] != '' ? $setting['img_w'] : 600,
			'img_h' 			=> isset($setting['img_h']) && $setting['img_h'] != '' ? $setting['img_h'] : 400
		);

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
		
		isset($setting['ext_access']) ? $this->data['extCheck'] = $setting['ext_access'] : $this->data['extCheck'] = 'n';
		// Generate full background array
		if ($this->data['fullB_settings']['fullB'] == 'y' && $this->data['extCheck'] == 'n') {
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

		/* Sorting banners
		******************************/
		$modArr = $this->data['module']['image_data'];
		if ($modArr) {
			$sort_order = array();
			foreach ($modArr as $key => $value) {
				$sort_order[$key] = isset($value['sort_order']) ? $value['sort_order'] : 0;
			}
			array_multisort($sort_order, SORT_ASC, $modArr);
		}
		$this->data['module']['image_data'] = $modArr;


		/* Generate banner array
		******************************/
		$imgfill = isset($setting['imgfill']) ? $setting['imgfill'] : 'n';
		foreach ($this->data['module']['image_data'] as $k => $v) {

			if (isset($v['cat_id']) && $v['cat_id'] != '' && $v['urlType'] == 'category') {
				$url = $this->url->link('product/category', 'path=' . $v['cat_id']);
			}elseif (isset($v['prd_id']) && $v['prd_id'] != '' && $v['urlType'] == 'product') {
				$url = $this->url->link('product/product', 'product_id=' . $v['prd_id']);
			}elseif (isset($v['brn_id']) && $v['brn_id'] != '' && $v['urlType'] == 'brand') {
				$url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $v['brn_id']);
			}elseif (isset($v['inf_id']) && $v['inf_id'] != '' && $v['urlType'] == 'info') {
				$url = $this->url->link('information/information', 'information_id=' . $v['brn_id']);
			}elseif (isset($v['url']) && $v['url'] != '' && $v['urlType'] == 'other') {
				$url = $v['url'];
			}else{
				$url = '';
			}

			/* Caption settings
			******************************/
			$tmpcp = explode("|", $v['cpSettings']);
			$this->data['cpSettings'] = array(
				"cp_theme" 			=> isset($tmpcp[0]) ? $tmpcp[0] : 'dark',
				"cp_style" 			=> isset($tmpcp[1]) ? $tmpcp[1] : '1',
				"cp_position" 		=> isset($tmpcp[2]) ? $tmpcp[2] : 'cc',
				"cp_align" 			=> isset($tmpcp[3]) ? $tmpcp[3] : 'c'
			);
			//echo "<pre>".print_r($this->data['cpSettings'],true)."</pre>";

			if ($v['status'] == 1) {
				
				if ($this->data['cpSettings']['cp_align'] == 'l') { $align = ' tl'; }
				if ($this->data['cpSettings']['cp_align'] == 'c') { $align = ' tc'; }
				if ($this->data['cpSettings']['cp_align'] == 'r') { $align = ' tr'; }

				if ($this->data['cpSettings']['cp_position'] == 'lt') { $x = 'left'; $y = 'top'; $h_offset = 70; $v_offset = 70; }
				if ($this->data['cpSettings']['cp_position'] == 'ct') { $x = 'center'; $y = 'top'; $h_offset = 0; $v_offset = 70; }
				if ($this->data['cpSettings']['cp_position'] == 'rt') { $x = 'right'; $y = 'top'; $h_offset = -70; $v_offset = 70; }
				if ($this->data['cpSettings']['cp_position'] == 'lc') { $x = 'left'; $y = 'center'; $h_offset = 70; $v_offset = 0; }
				if ($this->data['cpSettings']['cp_position'] == 'cc') { $x = 'center'; $y = 'center'; $h_offset = 0; $v_offset = 0; }
				if ($this->data['cpSettings']['cp_position'] == 'rc') { $x = 'right'; $y = 'center'; $h_offset = -70; $v_offset = 0; }
				if ($this->data['cpSettings']['cp_position'] == 'lb') { $x = 'left'; $y = 'bottom'; $h_offset = 70; $v_offset = -70; }
				if ($this->data['cpSettings']['cp_position'] == 'cb') { $x = 'center'; $y = 'bottom'; $h_offset = 0; $v_offset = -70; }
				if ($this->data['cpSettings']['cp_position'] == 'rb') { $x = 'right'; $y = 'bottom'; $h_offset = -70; $v_offset = -70; }

				if ($this->data['cpSettings']['cp_style'] == '6') { $h_offset = 0; $v_offset = 0; }
				
				$this->data['modules'][] = array(
					'title' => $this->data['module_description']['image_data'][$v['id']]['title'],
					'image' => $this->data['module_description']['image_data'][$v['id']]['image'],
					'cp_style' => ' ss-cp'.$this->data['cpSettings']['cp_style'],
					'cp_theme' => ' '.$this->data['cpSettings']['cp_theme'],
					'cp_align' => $align,
					'x' => $x,
					'y' => $y,
					'h' => $h_offset,
					'v' => $v_offset,
					'new_win' => $v['new_win'],
					'url' => isset($url) ? $url : null
				);
			}
			//$this->model_tool_image->resize(isset($brand_info['image']) ? $brand_info['image'] : "no_image.jpg", 80, 80);
		}
		//echo "<pre>".print_r($this->data['module']['image_data'],true)."</pre>";

		/* Grid and Carousel banner sizes */
		foreach ($this->data['modules'] as $k => $v) {
			foreach ($v['image'] as $imgk => $imgv) {
				//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $setting['img_w'], $setting['img_h']);
				$image = $this->imgResize($imgv, $setting['img_w'], $setting['img_h'], $imgfill);
				$v['image'][$imgk] = $image;
			}
			$this->data['modules'][$k]['image']=$v['image'];
		}
		//echo "<pre>".print_r($this->data['modules'],true)."</pre>";
		
		/*echo "<pre>".print_r($this->data['modules'],true)."</pre>";
		echo "<pre>".print_r($this->data['in_slide'],true)."</pre>";*/
	}

	public function imgResize($imgSource, $imgW, $imgH, $fill){
		if (isset($imgSource) && $imgSource != '') {
			if ($fill == 'y') {
				// Generate resize image with specific crop size
				list($width_orig, $height_orig) = getimagesize(DIR_IMAGE.$imgSource);
				$image = $this->model_tool_image->resize($imgSource, $imgW, $imgH, $width_orig < $height_orig ? 'w' : 'h');
			}else{
				$image = $this->model_tool_image->resize($imgSource, $imgW, $imgH);
			}
		}else{
			$image = $this->model_tool_image->resize("no_image.jpg", $imgW, $imgH);	
		}
		return $image;
	}


	// type = category , product , manufacturer , information 
	public function autoLoader($type, $id){
		$getData = array();
		include('catalog/rgen/tools/layout_info/layout_data.php');
		//echo "<pre>".print_r($getData,true)."</pre>";
		return $getData;
	}
	

	//include('catalog/rgen/tools/layout_info/layout_data.php');
	public function commonData() {
		$this->load->model('tool/image');
		$this->data['modSettings'] = $this->modSettings;
		$this->load->model($this->modSettings['modelPath']);
		$this->language->load($this->modSettings['modLng']);
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['l_id'] = $this->config->get('config_language_id');

		//static $module_count = 0;
		$this->data['module_count'] = $this->rgen->uid(); //$module_count++;

		/* Loading files
		******************************/
		$js1 = 'catalog/view/theme/' . $this->config->get('config_template') . '/revo/rs-plugin/js/jquery.themepunch.plugins.min.js';
		$js2 = 'catalog/view/theme/' . $this->config->get('config_template') . '/revo/rs-plugin/js/jquery.themepunch.revolution.min.js';
		$css1 = 'catalog/view/theme/' . $this->config->get('config_template') . '/revo/rs-plugin/css/settings.css';
		$css2 = 'catalog/view/theme/' . $this->config->get('config_template') . '/revo/rs-plugin/css/style.css';

		$this->document->addScript($js1);
		$this->document->addScript($js2);
		$this->document->addStyle($css1);
		$this->document->addStyle($css2);

		$this->data['styles'] = array($css1, $css2);
		$this->data['scripts'] = array($js1, $js2);

		// Identify page layout
		include('catalog/rgen/tools/layout_info/layout_info.php');
	}
}
?>