<?php

class ControllerModuleRGenContentblocks extends Controller {

	private $modSettings = array(
		'modKey' 		=> 'rgen_contentblocks',
		'modLng'		=> 'module/rgen_contentblocks',
		'modelPath' 	=> 'rgen/rgencontentblocks',
		'model'			=> 'model_rgen_rgencontentblocks',
		'main_tpl' 		=> 'module/rgen_contentblocks.tpl',
		'assign_tpl' 	=> 'module/rgen_contentblocks/rgen_contentblocks_assign.tpl',
		'manage_tpl' 	=> 'module/rgen_contentblocks/rgen_contentblocks_manage.tpl',
		'add_tpl' 		=> 'module/rgen_contentblocks/rgen_contentblocks_add.tpl',
		'edit_tpl' 		=> 'module/rgen_contentblocks/rgen_contentblocks_edit.tpl'
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
			$cache 				= isset($rgen_optimize['cache_contentblocks']) ? $rgen_optimize['cache_contentblocks'] : 0;
			$dir 				= 'rgen_contentblocks';
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

		$this->data['module_description'] = $this->{$this->modSettings['model']}->RGenGetDescription($mod_name);

		// Main title
		$this->data['main_title'] = $this->data['module_description']['main_title'];
		$this->data['description'] = $this->data['module_description']['description'];
		$this->data['description1'] = $this->data['module_description']['description1'];

		// Module settings
		$tmpSetting = explode("|", $setting['moduleSettings']);
		$this->data['mod_settings'] = array(
			"display_style" 	=> $tmpSetting[0],
			"in_row_d" 			=> $tmpSetting[1],
			"gutter" 			=> $tmpSetting[2],
			"top" 				=> $tmpSetting[3],
			"bottom" 			=> $tmpSetting[4],
			"hr" 				=> $tmpSetting[5]
		);
		
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

		
		/* Sorting data
		******************************/
		$modArr = $this->data['module']['mod_data'];
		if ($modArr) {
			$sort_order = array();
			foreach ($modArr as $key => $value) {
				$sort_order[$key] = isset($value['sort_order']) ? $value['sort_order'] : 0;
			}
			array_multisort($sort_order, SORT_ASC, $modArr);
		}
		$this->data['module']['mod_data'] = $modArr;


		/* Block setting
		******************************/
		$gb_imgsettings = explode("|", $this->data['module']['gb_imgsettings']);
		$gb_blocksettings = explode("|", $this->data['module']['gb_blocksettings']);
		//echo "<pre>".print_r($gb_blocksettings,true)."</pre>";
		$this->data['block_settings'] = array(
			'img_position'    => $gb_imgsettings[0],
			'img_w'           => isset($gb_imgsettings[1]) && $gb_imgsettings[1]!=''? $gb_imgsettings[1] : 100,
			'img_h'           => isset($gb_imgsettings[2]) && $gb_imgsettings[2]!=''? $gb_imgsettings[1] : 100,
			'img_offset_t'    => $gb_imgsettings[3],
			'img_offset_r'    => $gb_imgsettings[4],
			'img_offset_b'    => $gb_imgsettings[5],
			'img_offset_l'    => $gb_imgsettings[6],
			'img_border_size' => $gb_imgsettings[7],
			'img_radius_t'    => $gb_imgsettings[8],
			'img_radius_r'    => $gb_imgsettings[9],
			'img_radius_b'    => $gb_imgsettings[10],
			'img_radius_l'    => $gb_imgsettings[11],
			'block_contentwrp'     => $gb_imgsettings[12],
			
			'block_title_position' => $gb_blocksettings[0],
			'block_content_align'  => $gb_blocksettings[1],
			'block_pd_t'           => $gb_blocksettings[2],
			'block_pd_r'           => $gb_blocksettings[3],
			'block_pd_b'           => $gb_blocksettings[4],
			'block_pd_l'           => $gb_blocksettings[5],
			'block_border_size'    => $gb_blocksettings[6],
			'block_radius_t'       => $gb_blocksettings[7],
			'block_radius_r'       => $gb_blocksettings[8],
			'block_radius_b'       => $gb_blocksettings[9],
			'block_radius_l'       => $gb_blocksettings[10],
			'block_titlesize'      => $gb_blocksettings[11]
			);
	
		// Image CSS
		$this->data['imageCSS']  = $this->data['block_settings']['img_offset_t'] != '' ? 'margin-top:'.$this->data['block_settings']['img_offset_t'].'px;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_offset_r'] != '' ? 'margin-right:'.$this->data['block_settings']['img_offset_r'].'px;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_offset_b'] != '' ? 'margin-bottom:'.$this->data['block_settings']['img_offset_b'].'px;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_offset_l'] != '' ? 'margin-left:'.$this->data['block_settings']['img_offset_l'].'px;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_border_size'] != '' ? 'border-width:'.$this->data['block_settings']['img_border_size'].'px; border-style: solid; border-color: transparent;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_radius_t'] != '' ? 'border-top-left-radius:'.$this->data['block_settings']['img_radius_t'].'px;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_radius_r'] != '' ? 'border-top-right-radius:'.$this->data['block_settings']['img_radius_r'].'px;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_radius_b'] != '' ? 'border-bottom-left-radius:'.$this->data['block_settings']['img_radius_b'].'px;' : null;
		$this->data['imageCSS'] .= $this->data['block_settings']['img_radius_l'] != '' ? 'border-bottom-right-radius:'.$this->data['block_settings']['img_radius_l'].'px;' : null;

		// Block CSS
		$this->data['blockCSS']  = $this->data['block_settings']['block_pd_t'] != '' ? 'padding-top:'.$this->data['block_settings']['block_pd_t'].'px;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_pd_r'] != '' ? 'padding-right:'.$this->data['block_settings']['block_pd_r'].'px;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_pd_b'] != '' ? 'padding-bottom:'.$this->data['block_settings']['block_pd_b'].'px;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_pd_l'] != '' ? 'padding-left:'.$this->data['block_settings']['block_pd_l'].'px;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_border_size'] != '' ? 'border-width:'.$this->data['block_settings']['block_border_size'].'px; border-style: solid; border-color: transparent;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_radius_t'] != '' ? 'border-top-left-radius:'.$this->data['block_settings']['block_radius_t'].'px;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_radius_r'] != '' ? 'border-top-right-radius:'.$this->data['block_settings']['block_radius_r'].'px;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_radius_b'] != '' ? 'border-bottom-left-radius:'.$this->data['block_settings']['block_radius_b'].'px;' : null;
		$this->data['blockCSS'] .= $this->data['block_settings']['block_radius_l'] != '' ? 'border-bottom-right-radius:'.$this->data['block_settings']['block_radius_l'].'px;' : null;
		if($this->data['block_settings']["block_content_align"] == "l"){
			$this->data['blockCSS'] .= "text-align: left;";
		}elseif($this->data['block_settings']["block_content_align"] == "r") {
			$this->data['blockCSS'] .= "text-align: right;";
		}else{
			$this->data['blockCSS'] .= "text-align: center;";
		}

		/* Generate module array
		******************************/
		$imgfill = isset($setting['imgfill']) ? $setting['imgfill'] : 'n';

		foreach ($this->data['module']['mod_data'] as $k => $v) {

			$imgsettings = explode("|", $v['imgsettings']);
			$blocksettings = explode("|", $v['blocksettings']);

			/* Block settings 
			----------------------
			0 Block background
			1 Block border color
			2 Block title color
			3 Block text color
			4 Block inline css
			5 Image inline css
			6 Title inline css
			7 content inline */

			/* Image settings 
			----------------------
			0 Image background
			1 Image border color 
			2 Image type
			3 Image src
			4 Icon class
			5 Icon size
			6 Icon color */

			$this->data['blockStyle'] = $blocksettings[0] != '' ? 'background-color:'.$blocksettings[0].';' : null;
			$this->data['blockStyle'] .= $blocksettings[1] != '' ? 'border-color:'.$blocksettings[1].';' : null;
			$this->data['blockStyle'] .= $blocksettings[4] != '' ? htmlspecialchars_decode($blocksettings[4], ENT_QUOTES) : null;
			
			$this->data['titleStyle'] = $blocksettings[2] != '' ? 'color:'.$blocksettings[2].';' : null;
			$this->data['titleStyle'] .= $blocksettings[6] != '' ? htmlspecialchars_decode($blocksettings[6], ENT_QUOTES) : null;
			
			$this->data['imgStyle']  = $imgsettings[0] != '' ? 'background-color:'.$imgsettings[0].';' : null;
			$this->data['imgStyle'] .= $imgsettings[1] != '' ? 'border-color:'.$imgsettings[1].';' : null;
			$this->data['imgStyle'] .= $blocksettings[5] != '' ? htmlspecialchars_decode($blocksettings[5], ENT_QUOTES) : null;
			if ($this->data['block_settings']['img_position'] == 'l' || $imgsettings[2] == 'ico') {
			$this->data['imgStyle'] .= $this->data['block_settings']["img_w"] != '' ? 'width:'.$this->data['block_settings']["img_w"].'px;' : null;
			$this->data['imgStyle'] .= $this->data['block_settings']["img_h"] != '' ? 'height:'.$this->data['block_settings']["img_h"].'px;' : null;
			}

			$this->data['contentStyle'] = $blocksettings[3] != '' ? 'color:'.$blocksettings[3].';' : null;
			$this->data['contentStyle'] .= $blocksettings[7] != '' ? htmlspecialchars_decode($blocksettings[7], ENT_QUOTES) : null;

			$this->data['iconStyle']  = $imgsettings[5] != '' ? ' font-size:'.$imgsettings[5].'px;' : null;
			$this->data['iconStyle'] .= $imgsettings[5] != '' ? ' min-height:'.$imgsettings[5].'px;' : null;
			$this->data['iconStyle'] .= $imgsettings[5] != '' ? ' margin-top:-'.round(($imgsettings[5])/2).'px;' : null;
			$this->data['iconStyle'] .= $imgsettings[6] != '' ? ' color:'.$imgsettings[6].';' : null;

			if ($v['status'] == 1) {
				
				$this->data['modules'][] = array(
					'title'             => $this->data['module_description']['mod_data'][$v['id']]['title'],
					'short_description' => $this->data['module_description']['mod_data'][$v['id']]['short_description'],
					
					'block_bg'           => $blocksettings[0],
					'block_bordercolor'  => $blocksettings[1],
					'block_titlecolor'   => $blocksettings[2],
					'block_contentcolor' => $blocksettings[3],

					'inline_block'   => $blocksettings[4],
					'inline_image'   => $blocksettings[5],
					'inline_title'   => $blocksettings[6],
					'inline_content' => $blocksettings[7],

					'img_bg'            => $imgsettings[0],
					'img_bordercolor'   => $imgsettings[1],
					'img_type'          => $imgsettings[2],
					'img_src'           => $this->imgResize($imgsettings[3], $this->data['block_settings']['img_w'], $this->data['block_settings']['img_h'], $imgfill),
					'ico'               => $imgsettings[4],
					'ico_size'          => $imgsettings[5],
					'ico_color'         => $imgsettings[6],

					'imgStyle'          => $this->data['imgStyle'],
					'blockStyle'		=> $this->data['blockStyle'],
					'titleStyle'		=> $this->data['titleStyle'],
					'contentStyle'		=> $this->data['contentStyle'],
					'iconStyle' 		=> $this->data['iconStyle']
					
				);
			}
		}
		//echo "<pre>".print_r($this->data['module'],true)."</pre>";
		//echo "<pre>".print_r($this->data['modules'],true)."</pre>";
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
	}
}
?>