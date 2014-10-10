<?php 
$l_id 		= $this->config->get('config_language_id');
$mod_id 	= $setting['mod_id'];

if(	isset($setting['cat_status']) && $setting['cat_status'] == "selc" ||
	isset($setting['prd_status']) && $setting['prd_status'] == "selp" ||
	isset($setting['brand_status']) && $setting['brand_status'] == "selb" ||
	isset($setting['info_status']) && $setting['info_status'] == "seli" )
{ 
	if(	isset($setting['category']) && in_array($category_id, $setting['category']) ||
		isset($setting['products']) && in_array($product_id, $setting['products']) ||
		isset($setting['brands']) && in_array($brand_id, $setting['brands']) ||
		isset($setting['info']) && in_array($information_id, $setting['info']))
		{ 
		include VQMod::modCheck('catalog/view/theme/rgen-opencart/template/module/rgen_customproducts_holder.php');
		}
}else{ 
	include VQMod::modCheck('catalog/view/theme/rgen-opencart/template/module/rgen_customproducts_holder.php');
} ?>

