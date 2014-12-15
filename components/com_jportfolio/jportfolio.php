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



global $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $database, $jportfolioConf;

//$mainframe->setPageTitle( 'Dự án tiêu biểu' ); 	


require_once( $mainframe->getPath( 'class' ) );

require_once( $mainframe->getPath( 'front_html' ) );



if (file_exists($mosConfig_absolute_path.'/components/com_jportfolio/lang/'.$mosConfig_lang.'.php'))

      include_once($mosConfig_absolute_path.'/components/com_jportfolio/lang/'.$mosConfig_lang.'.php');

   else

   if (file_exists($mosConfig_absolute_path.'/components/com_jportfolio/lang/english.php'))

         include_once($mosConfig_absolute_path.'/components/com_jportfolio/lang/english.php');



//get configuration

jport_conf();



$mainframe->addCustomHeadTag( '<link href="'.$mosConfig_live_site.'/components/com_jportfolio/css/'.$jportfolioConf->css_file.'" rel="stylesheet" type="text/css" />' ); 



$option = trim( mosGetParam( $_REQUEST, 'option' ));

$cat	= (int) ( mosGetParam( $_REQUEST, 'cat', 0 ));

if($cat)
	JP_one_cat( $cat );
else
	JP_categories();


// ****************************** end of main part

// --------------- functions



function JP_categories()

{

	global $database, $option, $mainframe, $mosConfig_live_site, $mosConfig_absolute_path, $jportfolioConf, $Itemid;


	
	$limit 		= intval( mosGetParam( $_REQUEST, 'limit', 6 ) );

	$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );

	$limit = $limit ? $limit : 6 ;
		
		
		
		

	$database->setQuery('SELECT * FROM #__jportfolio_categories where published=1 ORDER BY ordering'  );

	$rows = $database -> loadObjectList();


	if ($database -> getErrorNum()) {

		echo $database -> stderr();

		return false;

	}
	
	
	
	$total = count($rows);

	jimport('joomla.html.pagination');

	$pageNav = new JPagination( $total, $limitstart, $limit );
		
		
		
		
		

	

	$mainframe->setPageTitle( $jportfolioConf->title ); 

	$mainframe->appendMetaTag( 'description', $jportfolioConf->meta_desc );

	$mainframe->appendMetaTag( 'keywords', $jportfolioConf->meta_keywords );

	// current theme

	$theme = explode('/', $jportfolioConf->css_file);

	$view = $mosConfig_absolute_path.'/components/com_jportfolio/css/'.$theme[0].'/jp_categories.php';

	// check if view file exist in theme folder; if not, call local display function

	if (!file_exists($view))

	{

		display_categories( $option, $rows, $pageNav );

	}

	else

	{

		include($view);

	}

}



function JP_one_cat( $cat )

{

	global  $mainframe, $option, $Itemid, $mosConfig_live_site, $mosConfig_absolute_path, $jportfolioConf;


	$database 	=& JFactory::getDBO();

	$params = new stdClass();

	if ( $Itemid ) {

		$menu = new mosMenu( $database );

		$menu->load( $Itemid );

		$params = new mosParameters( $menu->params ); 

	} else {

		$menu = '';

		$params = new mosParameters( '' );

	}



	$params->def('back_button', $mainframe->getCfg( 'back_button' ) );

	$params->def('item_navigation', $mainframe->getCfg( 'item_navigation' ));

	$params->def('display_num', 6);

	



	

	

	$and = '';

		if($cat!=0) $and = ' and p.catid = '.$cat;

	
		$limit 		= intval( mosGetParam( $_REQUEST, 'limit', 6 ) );

		$limitstart = intval( mosGetParam( $_REQUEST, 'limitstart', 0 ) );



		  

		$limit = $limit ? $limit : $params->get( 'display_num' ) ;


				
				
		$database->setQuery('SELECT p.*, c.cat_path FROM #__jportfolio_projects p, #__jportfolio_categories c WHERE p.catid=c.id and p.published=1 and c.published=1 '.$and.' ORDER BY ordering '  );

		$rows = $database -> loadObjectList();
		//echo $limitstart.'='.$limit;
		
		$total = count($rows);
		
		if ($database -> getErrorNum()) {

			echo $database -> stderr();

			return false;

			}

		

		

		jimport('joomla.html.pagination');



		$pageNav = new JPagination( $total, $limitstart, $limit );


		
		
		
		
		$database->setQuery('SELECT * FROM #__jportfolio_categories WHERE id = '.$cat  );
		$categ = $database->loadObjectList();


		$pp=$categ[0]->cat_name;

		$mainframe->appendPathWay($pp);

		
		$document	= &JFactory::getDocument();
		

		$mainframe->setPageTitle( $categ[0]->cat_name.' - '.$params->get( 'page_title' ) ); 	

		$mainframe->appendMetaTag( 'description', $categ[0]->meta_desc );

		$mainframe->appendMetaTag( 'keywords', $categ[0]->meta_keywords );

	  

	// current theme

	$theme = explode('/', $jportfolioConf->css_file);

	$view = $mosConfig_absolute_path.'/components/com_jportfolio/css/'.$theme[0].'/jp_category.php';

	// check if view file exist in theme folder; if not, call local display function

	if (!file_exists($view))

	{

		display_one_cat($rows, $params, $pageNav, $categ[0]->cat_name, $categ[0]->id  ); 

	}

	else

	{

		

		include($view);

	}

	

		

		



}





function JP_project( $cat, $project )

{

	global $database, $mainframe, $option, $Itemid, $mosConfig_live_site, $mosConfig_absolute_path, $jportfolioConf;

	

	$params = new stdClass();

	if ( $Itemid ) {

		$menu = new mosMenu( $database );

		$menu->load( $Itemid );

		$params = new mosParameters( $menu->params ); 

	} else {

		$menu = '';

		$params = new mosParameters( '' );

	}



	$params->def('back_button', $mainframe->getCfg( 'back_button' ) );

	$params->def('item_navigation', $mainframe->getCfg( 'item_navigation' ));

		

	$database->setQuery('SELECT * FROM #__jportfolio_categories WHERE id = '.$cat );

	$categ = $database -> loadObjectList();

	if ($database -> getErrorNum()) {

		echo $database -> stderr();

		return false;

	}

	

	if ($categ && $categ[0]->published)

	{

	

		$database->setQuery('SELECT * FROM #__jportfolio_projects WHERE catid='.$cat.' AND published = 1  ORDER BY ordering '  );

		$proj = $database -> loadObjectList();

		if ($database -> getErrorNum()) {

			echo $database -> stderr();

			return false;

		}

	

		if ($proj)  

		{

			// find array id for project

			$pid = -1;

			foreach ($proj as $key=>$p) 

			{

				if ($p->id == $project ) $pid = $key;

			}

		

			$prev = '';

			$next = '';

			// if $pid found, then project exists

			if ($pid > -1)

			{

				foreach ($proj as $key=>$p) 

				{

					if ($key == ($pid - 1)) $prev = $p->id;

					if ($key == ($pid + 1)) $next = $p->id;

				}



				$pp="<a href=\"?option=com_jportfolio&amp;cat=".$categ[0]->id."&amp;Itemid=".$Itemid."\">".$categ[0]->cat_name."</a>";

				$mainframe->appendPathWay($pp);



				$pp=$proj[$pid]->name;

				$mainframe->appendPathWay($pp);  

		

				$mainframe->setPageTitle( $jportfolioConf->title.' - '.$categ[0]->cat_name.' - '.$proj[$pid]->name ); 	

				$mainframe->appendMetaTag( 'description', $proj[$pid]->meta_desc );

				$mainframe->appendMetaTag( 'keywords', $proj[$pid]->meta_keywords );

						

				// current theme

				$theme = explode('/', $jportfolioConf->css_file);

				$view = $mosConfig_absolute_path.'/components/com_jportfolio/css/'.$theme[0].'/jp_project.php';

				// check if view file exist in theme folder; if not, call local display function

				if (!file_exists($view))

				{

					display_project( $categ[0]->id, $categ[0]->cat_name, $categ[0]->cat_path, $proj[$pid], $params, $prev, $next ); 

				}

				else

				{

					$catid = $categ[0]->id;

					$catname = $categ[0]->cat_name;

					$catinfo = $categ[0]->cat_info;

					$catpath = $categ[0]->cat_path;

					$proj = $proj[$pid];

					include($view);

				}

				

			}

			else echo _COM_JP_ITEM_NOT_PUBLISHED; //actually does not exists

		}

		else echo _COM_JP_ITEM_NOT_PUBLISHED;

	}

	else echo _COM_JP_ALB_NOT_PUBLISHED;

	

}



// get configuration data

function jport_conf()

{

	global $database, $jportfolioConf;

	

	$database->setQuery('SELECT * FROM #__jportfolio_conf'  );

	$conf_rows = $database -> loadObjectList();

	if ($database -> getErrorNum()) {

		echo $database -> stderr();

		return false;

	}

	

	if (count($conf_rows) == 0)

	{

		// no rows in configuration table, so just installed

		// then insert initial config

		$sample_template = _COM_JP_SAMPLE_TEMPLATE;

		

		$query = "INSERT INTO `#__jportfolio_conf` VALUES (1,'1.3','images/stories/','Portfolio'," .

				"'Sample description.','jp_99pct_white.css', ".

				" 'Sample portfolio - description', 'portfolio, keyword2', ' $sample_template ' )";

  		$database->setQuery( $query );

  		$rows = $database -> query();

		if ($database -> getErrorNum()) {

		echo 'Error: '.$database -> stderr();

		}

		// read conf once again

		$database->setQuery('SELECT * FROM #__jportfolio_conf'  );

	  $conf_rows = $database -> loadObjectList();

	  if ($database -> getErrorNum()) {

		  echo $database -> stderr();

		  return false;

	  }

		

		$jportfolioConf=$conf_rows[0];

	}

	else

	$jportfolioConf=$conf_rows[0];

	

}



// functions needed in views (jp_categories.php, jp_category.php, jp_project.php in themes)

// for jp_categories.php

function jpGetCategoryLink( $catid )

{

	global $option, $Itemid;

	

	$seflink = sefRelToAbs('index.php?option='.$option.'&amp;cat='.$catid.'&amp;Itemid='.$Itemid);

	return $seflink;

}



function jpGetCategoryImage( &$catimg )

{

	global $jportfolioConf, $mosConfig_live_site;

	

	$imagelink = $mosConfig_live_site.'/'.$jportfolioConf->base_path.$catimg;

	return $imagelink;

}



// for jp_category.php

function jpGetProjectLink( &$categ, &$proj )

{

	global $option, $Itemid;

	

	$catid = $categ[0]->id;

	$link2=sefRelToAbs('index.php?option='.$option.'&amp;cat='.$catid.'&amp;project='.$proj->id.'&amp;Itemid='.$Itemid);

	return $link2;

}



function jpGetProjectImage( &$categ, &$proj )

{

	global $jportfolioConf, $mosConfig_absolute_path, $mosConfig_live_site;

	

	$catpath = $categ[0]->cat_path;

    $src=$jportfolioConf->base_path.$catpath.'/'.$proj->proj_image;

	$file = explode('.',$proj->proj_image);

	if (!file_exists($mosConfig_absolute_path.'/'.$src))

	{

		$src='components/com_jportfolio/images/no_image.png';

	}

	return $mosConfig_live_site.'/'.$src;

}



// for jp_project.php

function jpIsOneImage( &$proj )

{

	$file = explode('.',$proj->proj_image);

	if (substr($file[0],-1,1) == '1')

		return false;

	else

		return true;

}





function jpDisplayProjectImages( &$categ, &$proj, $class )

{

	global $jportfolioConf, $mosConfig_absolute_path, $mosConfig_live_site;

	

	$catpath = $categ[0]->cat_path;

    $src=$jportfolioConf->base_path.$catpath.'/'.$proj->proj_image;

	$file = explode('.',$proj->proj_image);

	$name = substr($proj->proj_image,0,strlen($file[0])-1);

	$i = 2;

	// display images from 2 to 9, if exist

	for ($i;$i<10;$i++)

	{

		$name2 = $name.$i.'.'.$file[1]; 

		$src=$jportfolioConf->base_path.$catpath.'/'.$name2;

		if (file_exists($mosConfig_absolute_path.'/'.$src)):

		?>

			<div class="<?php echo $class; ?>" >

				<img src="<?php echo $mosConfig_live_site.'/'.$src; ?>" border="0" alt="<?php echo _COM_JP_PROJ_NAME.$proj->name; ?>" />

			</div>

		<?php

		endif;

	}

	return true;

}



function jpDisplayProjectImagesImg( &$categ, &$proj, $class )

{

	global $jportfolioConf, $mosConfig_absolute_path, $mosConfig_live_site;

	

	$catpath = $categ[0]->cat_path;

    $src=$jportfolioConf->base_path.$catpath.'/'.$proj->proj_image;

	$file = explode('.',$proj->proj_image);

	$name = substr($proj->proj_image,0,strlen($file[0])-1);

	$i = 2;

	// display images from 2 to 9, if exist

	for ($i;$i<10;$i++)

	{

		$name2 = $name.$i.'.'.$file[1]; 

		$src=$jportfolioConf->base_path.$catpath.'/'.$name2;

		if (file_exists($mosConfig_absolute_path.'/'.$src)):

		?>

			

				<img src="<?php echo $mosConfig_live_site.'/'.$src; ?>" border="0" alt="<?php echo _COM_JP_PROJ_NAME.$proj->name; ?>" class="<?php echo $class; ?>" />

			

		<?php

		endif;

	}

	return true;

}



function jpDisplayProjectImagesBg( &$categ, &$proj, $class )

{

	global $jportfolioConf, $mosConfig_absolute_path, $mosConfig_live_site;

	

	$catpath = $categ[0]->cat_path;

    $src=$jportfolioConf->base_path.$catpath.'/'.$proj->proj_image;

	$file = explode('.',$proj->proj_image);

	$name = substr($proj->proj_image,0,strlen($file[0])-1);

	$i = 2;

	// display images from 2 to 9, if exist

	for ($i;$i<10;$i++)

	{

		$name2 = $name.$i.'.'.$file[1]; 

		$src=$jportfolioConf->base_path.$catpath.'/'.$name2;

		if (file_exists($mosConfig_absolute_path.'/'.$src)):

		?>

			<div class="<?php echo $class; ?>" style="background:url(<?php echo $mosConfig_live_site.'/'.$src; ?>) no-repeat center center;">

				

			</div>

		<?php

		endif;

	}

	return true;

}



function jpGetNavLink( $catid, $link )

{

	global $option, $Itemid;

	$outlink = sefRelToAbs('index.php?option='.$option.'&amp;cat='.$catid.'&amp;project='.$link.'&amp;Itemid='.$Itemid);

	return $outlink;

}





?>