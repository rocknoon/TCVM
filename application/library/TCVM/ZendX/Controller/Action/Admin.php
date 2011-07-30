<?php

	class TCVM_ZendX_Controller_Action_Admin extends TCVM_ZendX_Controller_Action
	{
	    
	    public function preDispatch(){
	    	parent::preDispatch();
	    	$this->_appendBasicJs();
	    	$this->_initAdmin();
	    	$this->_checkAdmin();
	    	
	    }
	    

	    
	    private function _checkAdmin(){
	    	
	    	$adminMod = TCVM_Admin_Factory::Factory();
	    	
	   	 	$notneedCheck = preg_match( "/upload/" , $this->_request->getActionName() );
	   		
	   	 	if( ($this->_request->getActionName() == 'login' && $this->_request->getControllerName() == 'index') || 
	   	 		 $this->_request->getActionName() == 'postlogin' && $this->_request->getControllerName() == 'index' ||
	   	 		 $notneedCheck ){
	   	 		 	return true;
	   	 		 }
	    	
	    	$adminMod = TCVM_Admin_Factory::Factory();
			$isLogined = $adminMod->isLogined();

			if( !$isLogined ){
				$this->_helper->redirector->gotoSimple('login', 'index' , 'admin');
			}

	    }
	    
	  
	    
	 
	    
		private function _initAdmin(){
			$adminMod = TCVM_Admin_Factory::Factory();
			$adminMod->generDefaultAdmin();
	    }
	    
	    
	    
		private function _appendBasicJs(){
	    	
			$this->appendJs('js/jquery-1.5.1.min.js');
			$this->appendJs('js/rocknoon/include.js');
	    	
	    }
	    
	    
	    
	    
	}
?>