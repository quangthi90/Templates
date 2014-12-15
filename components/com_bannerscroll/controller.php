<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );

class BannerScrollController extends JController
{  
	  function display()
	  {			
			$document 	= &JFactory::getDocument();
			$viewName 	= JRequest::getVar('view', 'bannerScroll');
			$viewType 	= $document->getType();
			$view		= &$this->getView($viewName, $viewType);
			
			$model	= &$this->getModel( $viewName );

			if (!JError::isError( $model )) {
				$view->setModel( $model, true );
			}
			
			$view->setLayout('default');
			$view->display();		exit();	
	  }	  
	  
	  
	  
	  function load_bannerScroll()
	  {			
			$document 	= &JFactory::getDocument();
			$viewName 	= JRequest::getVar('view', 'bannerScroll');
			$viewType 	= $document->getType();
			$view		= &$this->getView($viewName, $viewType);
			
			$model	= &$this->getModel( $viewName );

			if (!JError::isError( $model )) {
				$view->setModel( $model, true );
			}
			
			//$view->setLayout('default_load_bannerScroll');
			$view->load_bannerScroll();		exit();	
	  }	  

}
?>