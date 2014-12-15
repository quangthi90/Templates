<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );

class GalleryController extends JController
{  
	  function display()
	  {			
			$document 	= &JFactory::getDocument();
			$viewName 	= JRequest::getVar('view', 'gallery');
			$viewType 	= $document->getType();
			$view		= &$this->getView($viewName, $viewType);
			
			$model	= &$this->getModel( $viewName );

			if (!JError::isError( $model )) {
				$view->setModel( $model, true );
			}
			
			$view->setLayout('default');
			$view->display();			
	  }	  
	  function play()
	  {
	  		$document 	= &JFactory::getDocument();
			$viewName 	= JRequest::getVar('view', 'gallery');
			$viewType 	= $document->getType();
			$view		= &$this->getView($viewName, $viewType);
			
			$model	= &$this->getModel( $viewName );

			if (!JError::isError( $model )) {
				$view->setModel( $model, true );
			}
			
			$view->setLayout('default');
			$view->play();	
			exit();
	  }
}
?>