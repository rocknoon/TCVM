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
    
    public function applyForEtfAction(){
    
    	
    	
    }
 	
	public function doApplyForEtfAction(){
	
		$data = array();
		
		$orderId = $this->_getParam( "order_id" );
		$info    = $this->_getParam( "info" );
		
		$this->_pay->recordETF( $orderId, $info );
		
		$this->redirect( "success-etf" );
		
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
			$this->redirect( "error", "pay", "default", array( "error" => $ex->getMessage() ) );
		}
		
		$this->redirect( "success", "pay", "default",  array( "order_id" => $orderId ));
		
	}
	
	public function doElectronicTransferAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
		
		$this->_pay->setElectronicTransfer( $orderId );
		
		$this->redirect( "electronic-finish", "pay", "default",  array( "order_id" => $orderId ));
		
	}
	
	public function callbackPaypalExpressAction(){
	
		
		$params = array();
		$params['token'] 		  = $this->_getParam( "token" );
		$params['PayerID'] 		  = $this->_request->getParam( 'PayerID' );
		$params['paymentAmount'] 		  = $this->_request->getParam( 'paymentAmount' );
		$params['currencyCodeType'] 		  = $this->_request->getParam( 'currencyCodeType' );
		$params['paymentType'] 		  = $this->_request->getParam( 'paymentType' );
    
		
		$orderId = $this->_getParam( "orderId" );
		
		
		
		try {
			$this->_pay->payOrder( TCVM_Payment_Imple::PAYMENT_PAYPAL_EXPRESS_CHECKOUT,  $orderId , $params );
		}catch( Exception $ex ){
			$this->redirect( "error", "pay", "default", array( "error" => $ex->getMessage() ) );
		}
		
		$this->redirect( "success", "pay", "default",  array( "order_id" => $orderId ));
		
	}
	
	public function electronicFinishAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
		
		
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
	
	public function successEtfAction(){
		
		
		
	}
	
	public function pendingAction(){
	
		$orderId = $this->_getParam( "order_id" );
		
	}
	
	
	


		

	
}