<?php
class ControllerModuleRGenGallery extends Controller {
	
	private $error = array();
	private $modSettings = array(
		'modKey' 		=> 'rgen_gallery',
		'modLng'		=> 'module/rgen_gallery',
		'modelPath' 	=> 'rgen/rgengallery',
		'model'			=> 'model_rgen_rgengallery',
		'main_tpl' 		=> 'module/rgen_gallery/rgen_gallery.tpl',
		'assign_tpl' 	=> 'module/rgen_gallery/rgen_gallery_assign.tpl',
		'manage_tpl' 	=> 'module/rgen_gallery/rgen_gallery_manage.tpl',
		'add_tpl' 		=> 'module/rgen_gallery/rgen_gallery_add.tpl',
		'edit_tpl' 		=> 'module/rgen_gallery/rgen_gallery_edit.tpl'
		);

	/********************************************
	CREATE TABLE FOR RGEN DB */
	public function install() {
		$this->load->model($this->modSettings['modelPath']);
		$this->{$this->modSettings['model']}->install();
		$this->{$this->modSettings['model']}->installDataTable();
	}

	public function uninstall() {
		$this->load->model($this->modSettings['modelPath']);
		$this->{$this->modSettings['model']}->uninstall();
	}
	/*********************************************/
	
	public function index() {
		$this->install();
		$this->commonData();
		
		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
		//Choose which template file will be used to display this request.
		$this->template = $this->modSettings['main_tpl'];
		$this->children = array(
			'common/header',
			'common/footer',
		);

		//Send the output.
		$this->response->setOutput($this->render());
	}

	public function assign() {
		$this->commonData();
		$this->data['modules'] = $this->{$this->modSettings['model']}->RGenGetAll($this->modSettings['modKey']);
		foreach ($this->data['modules'] as $key => $value) {
			$this->data['module_list'][$key]['mod_id'] = $value['mod_id'];
			$this->data['module_list'][$key]['modName'] = $value['modName'];
		}

		// Get config data of module
		$config_data = array(
			$this->modSettings['modKey']."_module"
		);
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}
		//echo "<pre>".print_r($this->data[$conf],true)."</pre>";
		
		$this->template = $this->modSettings['assign_tpl'];
		$this->response->setOutput($this->render());
	}

	public function manage() {
		$this->commonData();

		$this->data['modules'] = $this->{$this->modSettings['model']}->RGenGetAll($this->modSettings['modKey']);

		$this->template = $this->modSettings['manage_tpl'];
		$this->response->setOutput($this->render());
	}

	public function add() {
		$this->commonData();

		$this->template = $this->modSettings['add_tpl'];
		$this->response->setOutput($this->render());
	}

	public function edit() {
		$this->commonData();
		//$this->getmodule();

		if (isset($this->request->get['mod_name'])) {
			$mod_name = $this->request->get['mod_name'];
			$this->data['module'] = $this->{$this->modSettings['model']}->RGenGetValue($mod_name);
			$this->data['module'] = $this->data['module'][$mod_name];

			$this->data['module_key'] = $mod_name;
			$this->data['module_description'] = $this->{$this->modSettings['model']}->RGenGetDescription($mod_name);
			$this->data['module']['main_title'] = isset($this->data['module_description']['main_title']) ? $this->data['module_description']['main_title'] : '';
			$this->data['module']['description'] = isset($this->data['module_description']['description']) ? $this->data['module_description']['description'] : '';

			if (isset($this->data['module']['image_data'])) {
				foreach ($this->data['module']['image_data'] as $k => $v) {
					$this->data['module']['image_data'][$k]['title'] = $this->data['module_description']['image_data'][$v['id']]['title'];
					$this->data['module']['image_data'][$k]['image'] = $this->data['module_description']['image_data'][$v['id']]['image'];
				}
			}

			$this->template = $this->modSettings['edit_tpl'];
			$this->response->setOutput($this->render());
		}

	}

	public function getmodule() {
		$this->commonData();

		if (isset($this->request->get['mod_name'])) {
			$mod_name = $this->request->get['mod_name'];
			$this->data['modules'] = $this->{$this->modSettings['model']}->RGenGetValue($mod_name);
		}
	}

	public function save() {
		$this->commonData();
		$type = isset($this->request->get['t']) ? $this->request->get['t'] : null;

		if (isset($this->request->get['mod_name'])) {
			$mod_name = $this->request->get['mod_name'];
			
			if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate() && $type == 'new'){
				// Save new module
				//$this->arrayManager($mod_name);
				$response = $this->arrayManager($mod_name);
				if ($response != 'no data') {
					$this->{$this->modSettings['model']}->RGenInsert($this->modSettings['modKey'], $this->request->post);
				}else{
					echo $response;
				}
			}elseif($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate() && $type == 'edit'){
				$this->{$this->modSettings['model']}->RGenDescriptionDelete($mod_name);
				// Save existing module
				$this->arrayManager($mod_name);
				$this->{$this->modSettings['model']}->RGenEditValue($this->modSettings['modKey'], $mod_name, $this->request->post[$mod_name]);
			}
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate() && $type == 'assign'){
			//echo "<pre>".print_r($this->request->post,true)."</pre>";
			$this->{$this->modSettings['model']}->RGenAddSetting($this->modSettings['modKey'], $this->request->post);
		}
	}

	public function delete() {
		$this->commonData();

		if (isset($this->request->get['mod_name'])) {
			$mod_name = $this->request->get['mod_name'];
			// Removing module
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()){
				//echo "<pre>".print_r($this->config->get($this->modSettings['modKey'].'_module'),true)."</pre>";
				$this->{$this->modSettings['model']}->RGenDeleteValue($mod_name);
				$this->{$this->modSettings['model']}->RGenDescriptionDelete($mod_name);
				
				// Updating system settings entries
				$sys_setting = $this->config->get($this->modSettings['modKey'].'_module');
				if (isset($sys_setting)) {
					foreach ($sys_setting as $k => $v) {
						if ($v['mod_id'] == $mod_name) { unset($sys_setting[$k]); }
					}
					// $value, $group, $key
					$this->{$this->modSettings['model']}->RGenUpdateSetting($sys_setting, $this->modSettings['modKey'], $this->modSettings['modKey']."_module");
				}

			}
		}
	}

	// Manage post data of module and generate new array
	public function arrayManager($mod_name) {
		if (isset($this->request->post[$mod_name]['image_data'])) {
			foreach ($this->request->post[$mod_name]['image_data'] as $ik => $iv) {
				foreach ($this->data['languages'] as $lk => $lv) {
					$this->data['description'] = array(
						'language_id' 	=> $lv['language_id'],
						'group' 		=> $this->modSettings['modKey'],
						'mod_id' 		=> $mod_name,
						'banner_id' 	=> $iv['id'],
						'section_title' => isset($this->request->post[$mod_name]['main_title'][$lv['language_id']]) ? $this->request->post[$mod_name]['main_title'][$lv['language_id']] : '',
						'title' 		=> $iv['title'][$lv['language_id']],
						'image' 		=> $iv['image'][1],
						'description' 	=> isset($this->request->post[$mod_name]['description'][$lv['language_id']]) ? $this->request->post[$mod_name]['description'][$lv['language_id']] : ''
					);
					$this->{$this->modSettings['model']}->RGenDescriptionInsert($this->data['description']);
				}
				unset($this->request->post[$mod_name]['image_data'][$ik]['title']);
				unset($this->request->post[$mod_name]['image_data'][$ik]['image']);
			}
			$response = 'set data';
		}else{
			$response = 'no data';
		}
		unset($this->request->post[$mod_name]['section_title']);
		unset($this->request->post[$mod_name]['description']);
		return $response;
	}

	public function commonData() {
		$this->data['modSettings'] = $this->modSettings;
		$this->load->model($this->modSettings['modelPath']);
		$this->load->language($this->modSettings['modLng']);
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['version'] = $this->config->get('rgen_theme_version') ? $this->config->get('rgen_theme_version') : 'RGEN THEME';

		$text_strings = array(
				'heading_title',
				'text_enabled',
				'text_disabled',
				'text_content_top',
				'text_content_bottom',
				'text_column_left',
				'text_column_right',
				'entry_layout',
				'entry_limit',
				'entry_image',
				'entry_position',
				'entry_status',
				'entry_sort_order',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'entry_example' //this is an example extra field added
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/'.$this->modSettings['modKey'], 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/'.$this->modSettings['modKey'], 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		foreach ($this->data['layouts'] as $key => $value) {
			$this->data['layouts'][$key]['route'] = $this->model_design_layout->getLayoutRoutes($value['layout_id']);
		}

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		/* Image tools
		******************************/
		$this->load->model('tool/image');
		$this->data['no_img'] = $this->model_tool_image->resize('no_image.jpg', 150, 150);

		/* User permission check
		******************************/
		$this->data['checkPermission'] = $this->user->hasPermission('modify', 'module/'.$this->modSettings['modKey']);

		/* Module rows
		******************************/
		$this->data['module_row'] = $this->{$this->modSettings['model']}->LastID();
		if ($this->data['module_row']) {
			$this->data['module_row']++;
		}else{
			$this->data['module_row'] = 1;
		}

		/* Module data arrays
		******************************/
		$this->data['displayStyle'] = array(
			"Grid" 		=> 'grid',
			"Carousel"	=> 'scroll'
		);
		$this->data['urlType'] = array(
			"Other" 		=> 'other',
			"Category"		=> 'category',
			"Product" 		=> 'product',
			"Manufacturer" 	=> 'brand',
			"Information" 	=> 'info'
		);
		$this->data['yn'] = array(
			"No" => 'n',
			"Yes" => 'y'
		);

		// common module positions
		include 'view/rgen/tools/positions/positions.php';

		$this->data['ImgRepeat'] = array( 
			'no-repeat',
			'repeat',
			'repeat-x',
			'repeat-y',
			'inherit'
		); 
		$this->data['ImgPosition'] = array( 
			'left top',
			'left bottom',
			'right top',
			'right bottom',
			'center top',
			'center bottom',
			'center center',
			'other'
		);
		$this->data['bodyBgAttachment'] = array( 'inherit', 'fixed');
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/'.$this->modSettings['modKey'])) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}


}
?>