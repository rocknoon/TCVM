<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

/**
	 * @var Zend_Controller_Front
	 */
	protected $_front;

	
	protected function _initFront(){
		$this->bootstrap('frontController');
		$this->_front = $this->getResource('frontController');
	}
	
	protected function _initView(){
		
		$view = new Zend_View();
		
		$view->setEncoding( 'UTF-8' );
		$view->doctype( Zend_View_Helper_Doctype::XHTML11 );
		
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		
		Zend_Registry::set( 'view' , $view );
	}
	

	protected function _initWfAjax(){
    	
    	$wfAjax = new WeFlex_ZendX_Controller_Action_Helper_WfAjax();
    	Zend_Controller_Action_HelperBroker::addHelper( $wfAjax );
    	
    	return $wfAjax;
    	
    }
    
	protected function _initControllers()
    {
    	$this->_front->addControllerDirectory(APPLICATION_PATH . '/admin/controllers', 'admin');
    }
    
	protected function _initRouter(){

		$facultyRouter = new Zend_Controller_Router_Route(
		    'faculty',
		    array(
		        'controller' => 'page',
		        'action'     => 'faculty',
		    	'module'	 => 'default'
		    )
		);
		
		$certificationRouter = new Zend_Controller_Router_Route(
		    'certification',
		    array(
		        'controller' => 'page',
		        'action'     => 'certification',
		    	'module'	 => 'default'
		    )
		);
		
		$outofauRouter = new Zend_Controller_Router_Route(
		    'out-of-australia',
		    array(
		        'controller' => 'page',
		        'action'     => 'outofau',
		    	'module'	 => 'default'
		    )
		);
		
		$qigongRouter = new Zend_Controller_Router_Route(
		    'qigong',
		    array(
		        'controller' => 'page',
		        'action'     => 'qigong',
		    	'module'	 => 'default'
		    )
		);
		
		$moxibustionRouter = new Zend_Controller_Router_Route(
		    'moxibustion',
		    array(
		        'controller' => 'page',
		        'action'     => 'moxibustion',
		    	'module'	 => 'default'
		    )
		);
		
		
		
		
		$router = $this->_front->getRouter();
		
		$router->addRoute('faculty', $facultyRouter);
		$router->addRoute('certification', $certificationRouter);
		$router->addRoute('outofau', $outofauRouter);
		$router->addRoute('qigong', $qigongRouter);
		$router->addRoute('moxibustion', $moxibustionRouter);
		
	}
	
	protected function _initCache(){

		$frontendOptions = array(
		   'caching' => true,
		   'lifetime' => 3600, // cache lifetime of 2 hours
		   'automatic_serialization' => true
		);
		 
		$backendOptions = array(
		    'cache_dir' => realpath(APPLICATION_PATH . '/../cache') // Directory where to put the cache files
		);
		 
		// getting a Zend_Cache_Core object
		$cache = Zend_Cache::factory('Core',
		                             'File',
		                             $frontendOptions,
		                             $backendOptions);             
		                       
		                             
		Zend_Registry::set( 'cache' , $cache );
		
		
	}


}