<?php

class UserController extends TCVM_ZendX_Controller_Action_Front
{
	
	/**
	 * @var TCVM_User_Interface
	 */
	private $_user;
	
	public function init(){
		$this->_user = TCVM_User_Factory::Factory();
	}
	
	public function orderAction(){
		
		$order = TCVM_Order_Factory::Factory();
		$user  = TCVM_User_Factory::Factory();
		
		$loginUser = $user->getLoginedUser();
		
		$orders = $order->getsUserOrder( $loginUser['id'] );
		
		$this->assign( "orders", $orders );
		
		
	}
	
	public function electronicFundTransferAction(){
	
		
		
	}
	
	public function registerAction(){
		
		$this->title( "TCVM Australia | Register" );
		
	}
	
	public function loginAction(){
	
		$this->title( "TCVM Australia | Login" );
	}
	
	
	
	public function doRegisterAction(){
	
		$data = array();
		$data['email'] = $this->_getParam( "email" );
		$password	   = $this->_getParam( "password" );
		$data['password'] = $this->_getParam( "password" );
		$data['first_name'] = $this->_getParam( "first_name" );
		$data['last_name'] = $this->_getParam( "last_name" );
		$data['billing_address_1'] = $this->_getParam( "billing_address_1" );
		$data['billing_address_2'] = $this->_getParam( "billing_address_2" );
		$data['zip_code'] = $this->_getParam( "zip_code" );
		$data['city'] = $this->_getParam( "city" );
		$data['state'] = $this->_getParam( "state" );
		$data['telephone'] = $this->_getParam( "telephone" );
		$data['mobile'] = $this->_getParam( "mobile" );
		
		$this->_user->register( $data );
		$this->_user->login($data['email'], $password);
		
		$this->redirect( "index", "index" );
	}
	
	public function doLoginAction(){
	
		$email 		= $this->_getParam( "email" );
		$password 	= $this->_getParam( "password" );
		
		$this->_user->login($email, $password);
		
		$this->redirect( "index", "index" );
		
	}
	
	public function doLogoutAction(){
	
		
		$this->_user->logout();
		
		$this->redirect( "index", "index" );
		
	}
	
	


		

	
}