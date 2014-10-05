<?php

class ControllerModuleRGenBanners extends Controller {

	private $modSettings = array(
		'modKey' 		=> 'rgen_banners',
		'modLng'		=> 'module/rgen_banners',
		'modelPath' 	=> 'rgen/rgenbanners',
		'model'			=> 'model_rgen_rgenbanners',
		'main_tpl' 		=> 'module/rgen_banners.tpl',
		'assign_tpl' 	=> 'module/rgen_banners/rgen_banners_assign.tpl',
		'manage_tpl' 	=> 'module/rgen_banners/rgen_banners_manage.tpl',
		'add_tpl' 		=> 'module/rgen_banners/rgen_banners_add.tpl',
		'edit_tpl' 		=> 'module/rgen_banners/rgen_banners_edit.tpl'
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
			$cache 				= isset($rgen_optimize['cache_banners']) ? $rgen_optimize['cache_banners'] : 0;
			$dir 				= 'rgen_banners';
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
			"h-effect"			=> $tmpSetting[6],
			"caption"			=> $tmpSetting[7],
			"cp-bg"				=> $tmpSetting[8],
			"cp-text"			=> $tmpSetting[9],
			"cp-innerborder"	=> $tmpSetting[10]
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

			/*foreach ($this->data['module_description']['image_data'][$v['id']]['image'] as $ik => $iv) {
				$image = $this->model_tool_image->resize(isset($iv) && $iv != '' ? $iv : "no_image.jpg", $setting['img_w'], $setting['img_h']);
				$this->data['module_description']['image_data'][$v['id']]['image'][$ik] = $image;

			}*/
			if ($v['status'] == 1) {
				if ($v['in_slide'] == 'y') {
					$this->data['in_slide'][] = array(
						'title' => $this->data['module_description']['image_data'][$v['id']]['title'],
						'image' => $this->data['module_description']['image_data'][$v['id']]['image'],
						'new_win' => $v['new_win'],
						'url' => isset($url) ? $url : null
					);
				}
				if (
					$v['in_slide'] == 'n' || 
					$this->data['mod_settings']['display_style'] == 'Grid' || 
					$this->data['mod_settings']['display_style'] == 'Carousel' ||
					$this->data['mod_settings']['display_style'] == '5' ||
					$this->data['mod_settings']['display_style'] == '6' ||
					$this->data['mod_settings']['display_style'] == '7' ||
					$this->data['mod_settings']['display_style'] == '10'
					) {
					$this->data['modules'][] = array(
						'title' => $this->data['module_description']['image_data'][$v['id']]['title'],
						'image' => $this->data['module_description']['image_data'][$v['id']]['image'],
						'new_win' => $v['new_win'],
						'url' => isset($url) ? $url : null
					);
				}
			}
			//$this->model_tool_image->resize(isset($brand_info['image']) ? $brand_info['image'] : "no_image.jpg", 80, 80);
		}
		//echo "<pre>".print_r($this->data['module']['image_data'],true)."</pre>";

		/* Grid and Carousel banner sizes */
		if ($this->data['mod_settings']['display_style'] == 'Grid' || $this->data['mod_settings']['display_style'] == 'Carousel') {
			foreach ($this->data['modules'] as $k => $v) {
				foreach ($v['image'] as $imgk => $imgv) {
					//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $setting['img_w'], $setting['img_h']);
					$image = $this->imgResize($imgv, $setting['img_w'], $setting['img_h'], $imgfill);
					$v['image'][$imgk] = $image;
				}
				$this->data['modules'][$k]['image']=$v['image'];
			}
		}

		/* Image sizes for banner display style 1 */
		if ($this->data['mod_settings']['display_style'] == '1') {
			$xl_w = 782; $xl_h = 386;
			$x_w = 386; $x_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if (isset($this->data['in_slide'])) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}else{
						if ($i==0) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
								$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}

			if (isset($this->data['in_slide'])) {
				foreach ($this->data['in_slide'] as $slk => $slv) {
					foreach ($slv['image'] as $imgk => $imgv) {
						//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
						$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
						$slv['image'][$imgk] = $image;
					}
					$this->data['in_slide'][$slk]['image'] = $slv['image'];
				}	
			}
		}

		/* Image sizes for banner display style 2 */
		if ($this->data['mod_settings']['display_style'] == '2') {
			$xl_w = 782; $xl_h = 386;
			$x_w = 188; $x_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if (isset($this->data['in_slide'])) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}else{
						if ($i==0) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
								$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}

			if (isset($this->data['in_slide'])) {
				foreach ($this->data['in_slide'] as $slk => $slv) {
					foreach ($slv['image'] as $imgk => $imgv) {
						//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
						$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
						$slv['image'][$imgk] = $image;
					}
					$this->data['in_slide'][$slk]['image'] = $slv['image'];
				}	
			}
		}

		/* Image sizes for banner display style 3 */
		if ($this->data['mod_settings']['display_style'] == '3') {
			$xl_w = 782; $xl_h = 386;
			$x_w = 188; $x_h = 188;
			$x1_w = 386; $x1_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if (isset($this->data['in_slide'])) {
						if ($i==0) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x1_w, $x1_h);
								$image = $this->imgResize($imgv, $x1_w, $x1_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}

					}else{
						if ($i==0) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
								$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}elseif ($i==1) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x1_w, $x1_h);
								$image = $this->imgResize($imgv, $x1_w, $x1_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}

			if (isset($this->data['in_slide'])) {
				foreach ($this->data['in_slide'] as $slk => $slv) {
					foreach ($slv['image'] as $imgk => $imgv) {
						//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
						$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
						$slv['image'][$imgk] = $image;
					}
					$this->data['in_slide'][$slk]['image'] = $slv['image'];
				}	
			}
		}

		/* Image sizes for banner display style 4 */
		if ($this->data['mod_settings']['display_style'] == '4') {
			$xl_w = 584; $xl_h = 386;
			$x_w = 287; $x_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if (isset($this->data['in_slide'])) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}else{
						if ($i==1) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
								$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}

			if (isset($this->data['in_slide'])) {
				foreach ($this->data['in_slide'] as $slk => $slv) {
					foreach ($slv['image'] as $imgk => $imgv) {
						//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
						$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
						$slv['image'][$imgk] = $image;
					}
					$this->data['in_slide'][$slk]['image'] = $slv['image'];
				}	
			}
		}

		/* Image sizes for banner display style 5 */
		if ($this->data['mod_settings']['display_style'] == '5') {
			$xl_w = 287; $xl_h = 386;
			$x_w = 287; $x_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if ($i==1 || $i==2) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
							$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}else{
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}
		}

		/* Image sizes for banner display style 6 */
		if ($this->data['mod_settings']['display_style'] == '6') {
			$xl_w = 584; $xl_h = 188;
			$x_w = 287; $x_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if ($i==2 || $i==3) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
							$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}else{
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}
		}

		/* Image sizes for banner display style 7 */
		if ($this->data['mod_settings']['display_style'] == '7') {
			$xl_w = 287; $xl_h = 386;
			$xl1_w = 584; $xl1_h = 188;
			$x_w = 287; $x_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if ($i==0 || $i==2) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
							$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					} elseif ($i==1) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl1_w, $xl1_h);
							$image = $this->imgResize($imgv, $xl1_w, $xl1_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					} else {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}
		}


		/* Image sizes for banner display style 8 */
		if ($this->data['mod_settings']['display_style'] == '8') {
			$xl_w = 586; $xl_h = 390;
			$x_w = 390; $x_h = 194;
			$x1_w = 194; $x1_h = 96;
			$x2_w = 194; $x2_h = 194;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if (isset($this->data['in_slide'])) {
						if($i==0){
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}elseif($i==1 || $i==2 || $i==5 || $i==6){
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x1_w, $x1_h);
								$image = $this->imgResize($imgv, $x1_w, $x1_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x2_w, $x2_h);
								$image = $this->imgResize($imgv, $x2_w, $x2_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}else{
						if ($i==0) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
								$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}elseif($i==1){
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}elseif($i==2 || $i==3 || $i==6 || $i==7){
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x1_w, $x1_h);
								$image = $this->imgResize($imgv, $x1_w, $x1_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x2_w, $x2_h);
								$image = $this->imgResize($imgv, $x2_w, $x2_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}

			if (isset($this->data['in_slide'])) {
				foreach ($this->data['in_slide'] as $slk => $slv) {
					foreach ($slv['image'] as $imgk => $imgv) {
						//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
						$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
						$slv['image'][$imgk] = $image;
					}
					$this->data['in_slide'][$slk]['image'] = $slv['image'];
				}	
			}
		}


		/* Image sizes for banner display style 9 */
		if ($this->data['mod_settings']['display_style'] == '9') {
			$xl_w = 782; $xl_h = 584;
			$x_w = 386; $x_h = 188;
			$x1_w = 188; $x1_h = 188;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if (isset($this->data['in_slide'])) {
						if($i==0){
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x1_w, $x1_h);
								$image = $this->imgResize($imgv, $x1_w, $x1_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}else{
						if ($i==0) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
								$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}elseif($i==1){
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x1_w, $x1_h);
								$image = $this->imgResize($imgv, $x1_w, $x1_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}

			if (isset($this->data['in_slide'])) {
				foreach ($this->data['in_slide'] as $slk => $slv) {
					foreach ($slv['image'] as $imgk => $imgv) {
						//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
						$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
						$slv['image'][$imgk] = $image;
					}
					$this->data['in_slide'][$slk]['image'] = $slv['image'];
				}	
			}
		}


		/* Image sizes for banner display style 10 */
		if ($this->data['mod_settings']['display_style'] == '10') {
			$xl_w = 380; $xl_h = 380;
			$x_w = 380; $x_h = 180;
			$i = 0;
			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if ($i == 1) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
							$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}else{
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}
		}


		/* Image sizes for banner display style 11 */
		if ($this->data['mod_settings']['display_style'] == '11') {
			$xl_w = 584; $xl_h = 584;
			$x_w = 287; $x_h = 287;
			$i = 0;

			if ($this->data['modules']) {
				foreach ($this->data['modules'] as $k => $v) {
					if (isset($this->data['in_slide'])) {
						foreach ($v['image'] as $imgk => $imgv) {
							//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
							$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
							$v['image'][$imgk] = $image;
						}
					}else{
						if ($i==0) {
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
								$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}else{
							foreach ($v['image'] as $imgk => $imgv) {
								//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $x_w, $x_h);
								$image = $this->imgResize($imgv, $x_w, $x_h, $imgfill);
								$v['image'][$imgk] = $image;
							}
						}
					}
					$this->data['modules'][$k]['image']=$v['image'];
				$i++;}
			}

			if (isset($this->data['in_slide'])) {
				foreach ($this->data['in_slide'] as $slk => $slv) {
					foreach ($slv['image'] as $imgk => $imgv) {
						//$image = $this->model_tool_image->resize(isset($imgv) && $imgv != '' ? $imgv : "no_image.jpg", $xl_w, $xl_h);
						$image = $this->imgResize($imgv, $xl_w, $xl_h, $imgfill);
						$slv['image'][$imgk] = $image;
					}
					$this->data['in_slide'][$slk]['image'] = $slv['image'];
				}	
			}
		}
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

		// Identify page layout
		include('catalog/rgen/tools/layout_info/layout_info.php');
	}
}
?>