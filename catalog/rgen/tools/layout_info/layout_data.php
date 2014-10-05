<?php 
	/* Use
	+++++++++++++++
	public function autoLoader($type, $id){
		$getData = '';
		require_once('catalog/rgen/tools/layout_info/layout_data.php');
	}
	*/
	
	if ($type == 'category') {
		echo "category in";
		$this->load->model('catalog/category');
		$getData = $this->model_catalog_category->getCategory($id);
		//return $getData;
	
	} elseif ($type == 'product') {
		$this->load->model('catalog/product');
		$getData = $this->model_catalog_product->getProduct($id);
		//return $getData;
	
	} elseif ($type == 'manufacturer') {
		$this->load->model('catalog/manufacturer');
		$getData = $this->model_catalog_manufacturer->getManufacturer($id);
		//return $getData;
	
	} else {
		$this->load->model('catalog/information');
		$getData = $this->model_catalog_information->getInfoPage($id);
		//return $getData;
	}
	
?>