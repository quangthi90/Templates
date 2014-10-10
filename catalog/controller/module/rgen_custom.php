<?php  
class ControllerModuleRgenCustom extends Controller {
	
	protected function index($setting) {
		static $module = 0;
		$this->data['module'] = $module++;

		// Identify page layout
		include('catalog/rgen/tools/layout_info/layout_info.php');

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

		$this->document->Layout = $this->data['layouts']; //$this->layoutlist();
		
		$this->data['setting'] = $setting;
		$this->data['position'] = isset($setting["position"]) ? $setting["position"] : null;

		// Display module on default positions
		if($this->data['setting']) {

			isset($this->data['setting']['ext_access']) ? $this->data['extCheck'] = $this->data['setting']['ext_access'] : $this->data['extCheck'] = 'n';
			if($this->data['extCheck'] == 'n') {

				/* Section full block style
				******************************/
				if (isset($setting['fullB']) && $setting['fullB'] == 'y') {
					
					$this->data['fullB_class'] = isset($setting['fullB_class']) && $setting['fullB_class'] != '' ? ' '.$setting['fullB_class'] : null;

					$setting['fullB_bgps1'] = isset($setting['fullB_bgps1']) ? $setting['fullB_bgps1'] : null;
					$setting['fullB_bgps2'] = isset($setting['fullB_bgps2']) ? $setting['fullB_bgps2'] : null;
					
					if (isset($setting['fullB_bgposition']) && $setting['fullB_bgposition'] != "other" && $setting['fullB_bgimg'] != '') {
						$bgPosition = $setting['fullB_bgposition'] != '' ? 'background-position: '.$setting['fullB_bgposition'].';' : 'background-position: left top;';
					}else{
						$bgPosition = $setting['fullB_bgposition'] == 'other' ? 'background-position: '.$setting['fullB_bgps1'].' '.$setting['fullB_bgps2'].';' : 'background-position: left top;';
					}

					$this->data['fullB_settings'] = isset($setting['fullB_bgcolor']) && $setting['fullB_bgcolor'] != '' ? 'background-color: '.$setting['fullB_bgcolor'].';' : null;
					$this->data['fullB_settings'] .= isset($setting['fullB_bgimg']) && $setting['fullB_bgimg'] != '' ? 'background-image: url(image/'.$setting['fullB_bgimg'].');' : null;
					$this->data['fullB_settings'] .= isset($setting['fullB_bgrepeat']) && $setting['fullB_bgimg'] != '' && $setting['fullB_bgrepeat'] != '' ? 'background-repeat: '.$setting['fullB_bgrepeat'].';' : 'background-repeat: repeat;';
					$this->data['fullB_settings'] .= $bgPosition;
					$this->data['fullB_settings'] .= isset($setting['fullB_bgAttachment']) && $setting['fullB_bgimg'] != '' && $setting['fullB_bgAttachment'] != '' ? 'background-attachment: '.$setting['fullB_bgAttachment'].';' : 'background-attachment: inherit;';
					$this->data['fullB_settings'] .= isset($setting['fullB_pd_t']) && $setting['fullB_pd_t'] != '' ? 'padding-top: '.$setting['fullB_pd_t'].'px;' : 'padding-top: 20px;';
					$this->data['fullB_settings'] .= isset($setting['fullB_pd_b']) && $setting['fullB_pd_b'] != '' ? 'padding-bottom: '.$setting['fullB_pd_b'].'px;' : 'padding-bottom: 20px;';
					$this->data['fullB_settings'] .= isset($setting['fullB_mr_t']) && $setting['fullB_mr_t'] != '' ? 'margin-top: '.$setting['fullB_mr_t'].'px;' : 'margin-top: 0px;';
					$this->data['fullB_settings'] .= isset($setting['fullB_mr_b']) && $setting['fullB_mr_b'] != '' ? 'margin-bottom: '.$setting['fullB_mr_b'].'px;' : 'margin-bottom: 0px;';
					$this->data['fullB_settings'] .= isset($setting['fullB_inline']) && $setting['fullB_inline'] != '' ? $setting['fullB_inline'] : null;
				}	//echo "<pre>".print_r($setting,true)."</pre>";

				/* TPL loader Settings
				*******************************/
				$rgen_optimize 		= $this->config->get('RGen_optimize');
				$cache 				= isset($rgen_optimize['cache_customhtml']) ? $rgen_optimize['cache_customhtml'] : 0;
				$dir 				= 'rgen_customhtml';
				$cache_suffix		= '';
			    $priceStatus		= null;
			    $taxStatus			= null;
			    $reviewStatus		= null;
			    $loggedIn			= null;
			    $tpl 				= 'module/rgen_custom.tpl';
				
				if(	isset($setting['cat_status']) && $setting['cat_status'] == "selc" ||
					isset($setting['prd_status']) && $setting['prd_status'] == "selp" ||
					isset($setting['brand_status']) && $setting['brand_status'] == "selb" ||
					isset($setting['info_status']) && $setting['info_status'] == "seli" )
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
	}

	public function ext_access($extKey){
		include('catalog/rgen/tools/layout_info/layout_info.php');
		$this->document->Layout = $this->data['layouts'];

		$setting = $this->config->get('rgen_custom_module');
		
		$ext = explode("|", $extKey);
		$ext_mod = $ext[0];
		$ext_id = $ext[1];

		/* TPL loader Settings
		*******************************/
		$tpl     = 'module/rgen_custom.tpl';
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
					isset($setting['ext_access']) ? $this->data['extCheck'] = $setting['ext_access'] : $this->data['extCheck'] = 'n';
					$this->data['setting'] = $setting;
					$this->data['position'] = $setting["position"];
					$this->getMod($setting);
					$this->template = $theme . '/template/'.$tpl;
					$extData = $this->render();
				}
			}
		}
		return $extData;
	}

	//protected function getMod($modId, $layoutID) {
	protected function getMod($setting) {
		
		$modId = $setting['mod_id'];
		$layoutID = $setting['layout_id'];
		isset($setting['ext_access']) ? $this->data['extCheck'] = $setting['ext_access'] : $this->data['extCheck'] = 'n';

		if ($this->document->Layout == $layoutID || $layoutID == 99999 || $this->data['extCheck'] = 'y') {
			$this->load->model('rgen/rgencustom');
			$this->data['RGen_custom'] = $this->model_rgen_rgencustom->getRGenCustomMod($modId);

			$descriptionGet = $this->model_rgen_rgencustom->descriptionGet($modId);
			if ($descriptionGet) {
				if (!isset($this->data['RGen_custom'][$modId]['title'])) {
					if (isset($descriptionGet['title'])) {
						$this->data['RGen_custom'][$modId]['title'] = $descriptionGet['title'];
					}
				}
				$this->data['RGen_custom'][$modId]['description'] = $descriptionGet['description'];
			}
		}
	}

	protected function sorting($modArr){
		//echo "<pre>".print_r($modArr,true)."</pre>";
		if ($modArr) {
			$sort_order = array();
			foreach ($modArr as $key => $value) {
				$sort_order[$key] = isset($value['sort_order']) ? $value['sort_order'] : 0;
			}
			array_multisort($sort_order, SORT_ASC, $modArr);
		}
		return $modArr;
	}
}
?>