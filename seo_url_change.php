<?php
require_once('config.php');
require_once(DIR_SYSTEM . 'library/db.php');
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 	
// create product alias
$query_product = $db->query("SELECT * FROM " . DB_PREFIX . "product_description");
foreach ($query_product->rows as $result) {

	$query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'product_id=" . (int)$result['product_id'] . "'");
	if (!$query_alias->num_rows) {
		$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$result['product_id'] . "', `keyword` = '" . title2uri($result['name']) ."'");
	}						
}

// create news alias
$query_product = $db->query("SELECT * FROM " . DB_PREFIX . "oldproduct");
foreach ($query_product->rows as $result) {

	$query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'product_id=" . (int)$result['linktoproduct'] . "'");
	if (!$query_alias->num_rows) {
		$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$result['linktoproduct'] . "', `keyword` = '" . title2uri($result['name']) ."'");
	}						
}

// create category alias
$query_category = $db->query("SELECT * FROM " . DB_PREFIX . "category_description");
foreach ($query_category->rows as $result) {

	$query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$result['category_id'] . "'");
	if (!$query_alias->num_rows) {
		$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$result['category_id'] . "', `keyword` = '" . title2uri($result['name']) ."'");
	}						
}

// create information alias
$query_information = $db->query("SELECT * FROM " . DB_PREFIX . "information_description");
foreach ($query_information->rows as $result) {

	$query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'information_id=" . (int)$result['information_id'] . "'");
	if (!$query_alias->num_rows) {
		$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=" . (int)$result['information_id'] . "', `keyword` = '" . title2uri($result['title']) ."'");
	}						
}

// create manufacturer alias
$query_manufacturer = $db->query("SELECT * FROM " . DB_PREFIX . "manufacturer");
foreach ($query_manufacturer->rows as $result) {

	$query_alias = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'manufacturer_id=" . (int)$result['manufacturer_id'] . "'");
	if (!$query_alias->num_rows) {
		$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$result['manufacturer_id'] . "', `keyword` = '" . title2uri($result['name']) ."'");
	}						
}

//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'path=43', `keyword` = 'phu-kien'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information_id=4', `keyword` = 'gioi-thieu'");
$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'account/login', `keyword` = 'dang-nhap'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'sims/list', `keyword` = 'sim-so-dep'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'news/category', `keyword` = 'tin-tuc'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/compare', `keyword` = 'so-sanh'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'apps/list', `keyword` = 'ung-dung'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'information/contact', `keyword` = 'lien-he'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/oldproduct', `keyword` = 'dien-thoai-cu'");
//$db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/search', `keyword` = 'tim-kiem'");



function title2uri($sValue) {
	return str_replace(
		array('&', '/', '\\', '"', '+',' '), 
		array('-', '-', '-', '-', '-','-'), 
		$sValue
	);
}

echo 'All url rewrite done!';
?>