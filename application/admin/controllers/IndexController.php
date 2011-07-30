<?php 
	class Admin_IndexController extends TCVM_ZendX_Controller_Action_Admin{
		
		
		
		
		public function indexAction(){
			
		}
		
		public function cleancacheAction(){
			
			TCVM::CleanCache();
			die();
		}
		
		public function logoutAction(){
		
			$adminMod =  TCVM_Admin_Factory::Factory();
			$adminMod->logout();
			
			$this->redirect("login" , "index" , "admin");
			
		}
		
		public function loginAction(){
	    	
	    	$this->_helper->layout->setLayout('login');
	    	$this->render();
	    }
	    
	 	public function postloginAction()
	    {
			$username  =  $this->getRequest()->getParam( 'username' );
			$password =  $this->getRequest()->getParam( 'password' );
	    	
			
	       	$adminMod =  TCVM_Admin_Factory::Factory();
	      	 
	      	try {
	      		$adminMod->login( $username , $password );
	      	}catch( Exception $ex ){
	      		$this->assign( 'error' ,  $ex->getMessage());
	      		$this->_helper->layout->setLayout('login');
	      		$this->render( 'login' );
	      		return;
	      	}
	      	
	      	$this->redirect( 'index' , 'index' , 'admin' );
	      	
	    }
	    
		public function imageuploadAction(){
			
			$image = new TCVM_Image();
			
			try {
    			$imageUrl = $image->upload();
    		}catch( Exception $ex ){
    			$this->_helper->json( array( 'error' => $ex->getMessage() ) );
    		}
    		$this->_helper->json( array( 'imageUrl' => $imageUrl ) );
			
		}
		
		
		
		
	}