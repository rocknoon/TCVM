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
	
	
	public function basicAction(){
	
		$cartInfo = $this->_cart->getCartInfo();
		
		
		$this->assign( "cartInfo" , $cartInfo );
		
	}
	
	public function postBasicAction(){
		
		$data = array();
		$data['veterinary_acupuncture'] = $this->_getParam( "veterinary_acupuncture" );
		
		
		$this->_cart->basicInfo( $data );
		
		$this->redirect( "basic" , "registration" );
		
	}

		

	
}