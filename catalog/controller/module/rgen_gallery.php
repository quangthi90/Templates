<?php

class ControllerModuleRGenGallery extends Controller {

	private $modSettings = array(
		'modKey' 		=> 'rgen_gallery',
		'modLng'		=> 'module/rgen_gallery',
		'modelPath' 	=> 'rgen/rgengallery',
		'model'			=> 'model_rgen_rgengallery',
		'main_tpl' 		=> 'module/rgen_gallery.tpl',
		'assign_tpl' 	=> 'module/rgen_gallery/rgen_gallery_assign.tpl',
		'manage_tpl' 	=> 'module/rgen_gallery/rgen_gallery_manage.tpl',
		'add_tpl' 		=> 'module/rgen_gallery/rgen_gallery_add.tpl',
		'edit_tpl' 		=> 'module/rgen_gallery/rgen_gallery_edit.tpl'
		);

	protected function index($setting) {
		$this->commonData();

		static $module_count = 0;
		$this->data['module_count'] = $module_count++;
		
		$this->data['setting'] = $setting;
		$this->data['position'] = $setting["position"];

		//echo "<pre>".print_r($setting,true)."</pre>";

		if($this->data['setting']) {

			include('catalog/rgen/tools/full_block/full_block.php');

			/* TPL loader Settings
			*******************************/
			$rgen_optimize 		= $this->config->get('RGen_optimize');
			$cache 				= isset($rgen_optimize['cache_gallery']) ? $rgen_optimize['cache_gallery'] : 0;
			$dir 				= 'rgen_gallery';
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
					isset($setting['brands']) && in_array($this->data['brand_id'], $setting['brands']) ||
					isset($setting['info']) && in_array($this->data['information_id'], $setting['info']))
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
		
		$this->data['module_description'] = $this->{$this->modSettings['model']}->RGenGetDescription($mod_name);
		
		// Main title
		$this->data['main_title'] = $this->data['module_description']['main_title'];
		$this->data['description'] = $this->data['module_description']['description'];

		// Module settings
		$tmpSetting = explode("|", $setting['bannerSettings']);
		$this->data['mod_settings'] = array(
			"display_style" 	=> $tmpSetting[0],
			"in_row_d" 			=> $tmpSetting[1],
			"gutter" 			=> $tmpSetting[2],
			"top" 				=> $tmpSetting[3],
			"bottom" 			=> $tmpSetting[4],
			"hr" 				=> $tmpSetting[5],
			"cp-bg"				=> $tmpSetting[6],
			"cp-text"			=> $tmpSetting[7]
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
		foreach ($this->data['module']['image_data'] as $k => $v) {

			if ($v['status'] == 1) {
				$this->data['modules'][] = array(
					'title' => $this->data['module_description']['image_data'][$v['id']]['title'],
					'image' => $this->data['module_description']['image_data'][$v['id']]['image']
				);
			}
		}
		/* Grid and Carousel banner sizes */
		$imgfill = isset($setting['imgfill']) ? $setting['imgfill'] : 'n';
		if ($this->data['mod_settings']['display_style'] == 'Grid' || $this->data['mod_settings']['display_style'] == 'Carousel') {
			foreach ($this->data['modules'] as $k => $v) {
				foreach ($v['image'] as $imgk => $imgv) {
					/*if (isset($imgv) && $imgv != '') {
						if ($imgfill == 'y') {
							// Generate resize image with specific crop size
							list($width_orig, $height_orig) = getimagesize(DIR_IMAGE.$imgv);
							$thumb_image = $this->model_tool_image->resize($imgv, $setting['img_w'], $setting['img_h'], $width_orig < $height_orig ? 'w' : 'h');
						}else{
							$thumb_image = $this->model_tool_image->resize($imgv, $setting['img_w'], $setting['img_h']);
						}
					}else{
						$thumb_image = $this->model_tool_image->resize("no_image.jpg", $setting['img_w'], $setting['img_h']);	
					}*/

					$thumb_image = $this->imgResize($imgv, $setting['img_w'], $setting['img_h'], $imgfill);
					$image = isset($imgv) && $imgv != '' ? "image/".$imgv : $this->model_tool_image->resize("no_image.jpg", 500, 500);
					
					$v['thumb_image'][$imgk] = $thumb_image;
					$v['image'][$imgk] = $image;
				}
				$this->data['modules'][$k]['thumb_image']=$v['thumb_image'];
				$this->data['modules'][$k]['image']=$v['image'];
			}
		}
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

		// Identify page layout
		include('catalog/rgen/tools/layout_info/layout_info.php');

		/* Files load in front end
		******************************/
		$this->document->addScript('catalog/view/theme/rgen-opencart/js/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/theme/rgen-opencart/stylesheet/magnific-popup.css');
	}
}
?>