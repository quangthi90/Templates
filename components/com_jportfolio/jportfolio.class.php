<?php

/**

* JPortfolio for Joomla 1.0.13

*

* @version 1.3  2008-02-04

* @Copyright (C) 2008 Konrad Gretkiewicz - kgretk@anetus.com, www.anetus.com

* @ All rights reserved.

* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL

* This program is free software; you can redistribute it and/or

* modify it under the terms of the GNU General Public License (GPL).

* as published by the Free Software Foundation.

* This program is distributed in the hope that it will be useful,

* but WITHOUT ANY WARRANTY; without even the implied warranty of

* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

* See the GNU General Public License for more details.

*/



defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );





class jportfolioConf extends mosDBTable {

	var $id = null;

	var $version = null;

	var $base_path = null;

	var $title = null;

	var $description = null;

	var $css_file = null;

	var $meta_desc = null;

    var $meta_keywords = null;

    var $proj_template = null;

	

	function jportfolioConf(&$db){

		$this->mosDBTable('#__jportfolio_conf', 'id', $db);

	}

}



class jportfolioCategories extends mosDBTable {

    var $id = null;

    var $cat_name = null;
	var $alias = null;

    var $cat_info = null;

    var $cat_path = null;

    var $meta_desc = null;

    var $meta_keywords = null;

    var $cat_image = null;

    var $cat_grp = null;

    var $ordering = null;

    var $access = null;

    var $published = null;

	

	function jportfolioCategories(&$db){

		$this->mosDBTable('#__jportfolio_categories', 'id', $db);

	}

}



class jportfolioProjects extends mosDBTable {

	var $id = null;

	var $catid = null;

	var $name = null;
	
	var $url = null;	

	var $description = null;

	var $meta_desc = null;

    var $meta_keywords = null;

	var $proj_image = null;

	var $proj_images_path = null;

	var $userid = null;

	var $date	= null;

	var $ordering = null;

	var $access = null;

	var $published = null;



	function jportfolioProjects(&$db){

		$this->mosDBTable('#__jportfolio_projects', 'id', $db);

	}

}





?>



