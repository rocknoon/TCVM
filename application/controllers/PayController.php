<?php

class PayController extends TCVM_ZendX_Controller_Action_Front
{
	
	/**
	 * @var TCVM_Payment_Interface
	 */
	private $_pay;

    public function init()
    {
        /* Initialize action controller here */
    	
    	$this->_pay = TCVM_Payment_Factory::Factory();
    	
    }
    
    public function paymentAction(){
    
    	$orderId = $this->_getParam( "order_id" );
    	
    	$this->assign( "orderId", $orderId );
    }
    
    public function paypalDirectPayAction(){
    
    	$orderId = $this->_getParam( "order_id" );
    	
    	$this->assign( "orderId", $orderId );
    	
    }
	
	
	
	public function doPaypalExpressAction(){

		
		$orderId = $this->_getParam( "order_id" );
		
		$this->_pay->setPaypalExpress( $orderId );
	    
	}
	
	public function doPaypalDirectPayAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
		$params = array();
		$params['CREDITCARDTYPE'] = $this->_getParam( "credit_card_type" );
		$params['ACCT'] = $this->_getParam( "credit_card_number" );
		$params['EXPDATE'] = "092011";
		$params['FIRSTNAME'] = $this->_getParam( "first_name" );
		$params['LASTNAME'] = $this->_getParam( "last_name" );
		$params['STREET'] = $this->_getParam( "street" );
		$params['CITY'] = $this->_getParam( "city" );
		$params['STATE'] = $this->_getParam( "state" );
		$params['ZIP'] = $this->_getParam( "zip" );
		$params['COUNTRYCODE'] = $this->_getParam( "country_code" );
		$params['CVV2'] = $this->_getParam( "cvv2" );

		
		try {
			$this->_pay->payOrder( TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY , $orderId, $params );
		}catch(Exception $ex){
			dump($ex->getMessage());
			die();
			$this->redirect( "error", "pay", "default", array( "error" => $ex->getMessage() ) );
		}
		
		$this->redirect( "success", "pay", "default",  array( "order_id" => $orderId ));
		
	}
	
	public function doElectronicTransferAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
		$this->_pay->setElectronicTransfer( $orderId );
		
	}
	
	public function callbackPaypalExpressAction(){
	
		$orderId = $this->_getParam( "order_id" );
		
		try {
			$this->_pay->payOrder( $orderId , TCVM_Payment_Imple::PAYMENT_PAYPAL_EXPRESS_CHECKOUT );
		}catch( Exception $ex ){
			
		}
		
		
	}
	
	public function cancelPaypalExpressAction(){
	
		
		
		
	}
	
	public function errorAction(){
		
		$error = $this->_getParam( "error" );
		
		$orderId = $this->_getParam( "order_id" );
		
		$this->assign( "error" , $error );
		
	}
	
	public function successAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
	}
	
	public function pendingAction(){
	
		$orderId = $this->_getParam( "order_id" );
		
	}
	
	
	


		

	
}