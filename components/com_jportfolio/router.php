<?php
/**
* @version		$Id: router.php 10711 2008-08-21 10:09:03Z eddieajau $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

function JportfolioBuildRoute(&$query)
{
	  $menu = &JSite::getMenu();
	if (empty($query['Itemid'])) {
		$menuItem = &$menu->getActive();
	} else {
		$menuItem = &$menu->getItem($query['Itemid']);
	}
	
	
	  $segments = array();
       if(isset( $query['cat'] ))
       {
                $segments[] = $query['cat'];
                unset( $query['cat'] );
       };
       return $segments;

}

function JportfolioParseRoute($segments)
{
		$vars = array();
       $menu = &JSite::getMenu();
      $menuItem = &$menu->getActive();
	  
	  
	
	
       // Count segments
       $count = count( $segments );
       //Handle View and Identifier
      
	  $id   = explode( '-', $segments[$count-1] );
	   $vars['cat'] = (int) $id[0];
	   
       return $vars;

}
