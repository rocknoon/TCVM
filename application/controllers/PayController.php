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
    }
    
    public function paymentAction(){
    
    	$orderId = $this->_getParam( "order_id" );
    	
    	$this->assign( "order_id", $orderId );
    }
	
	
	
	public function doPaypalExpressAction(){

		
		$orderId = $this->_getParam( "order_id" );
		
		$this->_pay->payOrder( TCVM_Payment_Imple::PAYMENT_PAYPAL_EXPRESS_CHECKOUT , $orderId );
	    
	}
	
	public function doPaypalDirectPayAction(){
		
		$params = array();
		$orderId = $this->_getParam( "order_id" );
		
		
		try {
			$this->_pay->payOrder( TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY , $orderId, $params );
		}catch(Exception $ex){
			
		}
		
		$this->_pay->callbackPay( $orderId , TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY );
		
		
		
	}
	
	public function doElectronicTransferAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
		$this->_pay->payOrder( TCVM_Payment_Imple::PAYMENT_ELECTRONIC_TRANSFER , $orderId );
		
		$this->_pay->callbackPay( $orderId , TCVM_Payment_Imple::PAYMENT_ELECTRONIC_TRANSFER );
			
	}
	
	public function callbackPaypalExpressAction(){
	
		$orderId = $this->_getParam( "order_id" );
		
		try {
			$this->_pay->callbackPay( $orderId , TCVM_Payment_Imple::PAYMENT_PAYPAL_EXPRESS_CHECKOUT );
		}catch( Exception $ex ){
			
		}
		
		
	}
	
	public function errorAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
	}
	
	public function successAction(){
		
		$orderId = $this->_getParam( "order_id" );
		
	}
	
	public function pendingAction(){
	
		$orderId = $this->_getParam( "order_id" );
		
	}
	
	
	


		

	
}