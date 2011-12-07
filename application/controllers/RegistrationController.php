<?php

class RegistrationController extends TCVM_ZendX_Controller_Action_Front
{
	
	/**
	 * @var TCVM_Cart_Interface
	 */
	private $_cart;
	

    public function init()
    {
        $this->_cart = TCVM_Cart_Factory::Factory();
    }
    
    
 
    
	
	
	
	public function preDispatch() {
		parent::preDispatch();
		
		
		
		
		
		
	}
	
	public function loginFirstAction(){
	
		
	}

	public function basicAction(){
		
		$isLogin =  Zend_Registry::get( "IS_LOGIN" );
		
		if( !$isLogin ){
			$this->redirect("login-first");
		}
		
		$this->_renderCartInfo();
		
	}
	
	
	public function productAction(){
	
		
		$this->_renderCartInfo();
		
		$productMod = TCVM_Product_Factory::Factory();
		
		$courses = $productMod->getCourses();
		
		$this->assign( "courses",  $courses );
		
	}
	
	public function paymethodAction(){
	
		$this->_renderCartInfo();
		
		
	}
	
	
	public function profileAction(){
	
		$this->_renderCartInfo();
		
		
	}
	
	public function postPaymethodAction(){
	
		$data = $this->_getFilterParams();
		
		$this->_cart->payInfo( $data );
		
		$this->redirect( "profile" , "registration" );
		
	}
	
	public function postBasicAction(){
		
		$data = array();
		$data['veterinary_acupuncture'] = $this->_getParam( "veterinary_acupuncture" );
		
		
		$this->_cart->basicInfo( $data );
		
		$this->redirect( "product" , "registration" );
		
	}
	
	
	
	public function ajaxProductAction(){
	
		$id = $this->_getParam( "id" );
		$type = $this->_getParam( "type" );
		
		try{
			$this->_cart->pushProduct( $id , $type);
			$cartInfo = $this->_cart->getCartInfo();
		}catch( Exception $ex ){
			$this->error( $ex->getMessage() ); 
		}
		
		$this->success($cartInfo);  
	}
	
	public function ajaxDeductAction(){
	
		
		try{
			$this->_cart->fifthSessionDeduct();
			$cartInfo = $this->_cart->getCartInfo();
		}catch( Exception $ex ){
			$this->error( $ex->getMessage() ); 
		}
		
		$this->success($cartInfo);  	
		
		
	}
	
	private function _renderCartInfo(){
	
		
		$cartInfo = $this->_cart->getCartInfo();
		$this->assign( "cartInfo" , $cartInfo );
		
	}

		

	
}