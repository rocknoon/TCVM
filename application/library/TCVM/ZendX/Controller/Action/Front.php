<?php

	class TCVM_ZendX_Controller_Action_Front extends TCVM_ZendX_Controller_Action
	{
		
		const SESSION_URLS = 'session-urls';
	    
	    public function preDispatch(){
	    	parent::preDispatch();
	 
	    	$this->_appendBasicJs();
	    	$this->_assignGlobalVal();
	    	$this->_assignTitle();
	    	
	    }
	    
	    
	    private function _assignTitle(){
	    	
	    	 $this->title( "TCVM Australia" );
	    	
	    }
	    
	 
	    
	    private function _assignGlobalVal(){
	    	
	    	$userMod = TCVM_User_Factory::Factory();
	    
	    	$isLogin = $userMod->isLogined();
	    	
	    	if( $isLogin ){
	    		$loginUser = $userMod->getLoginedUser();
	    		$this->assign( "loginUser" , $loginUser );
	    	}
	    	
	    	Zend_Registry::set( "IS_LOGIN" , $isLogin);
	    	$this->assign( "isLogin" , $isLogin );
	    }
	    
	    private function _appendBasicJs(){
	    	$this->appendJs('js/jquery-1.5.1.min.js');
			$this->appendJs('js/rocknoon/include.js');
	    
	    }
	    
	
	    
	   
	    
	}
?>