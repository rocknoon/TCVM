<?php

class PayController extends TCVM_ZendX_Controller_Action_Front
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	
	
	public function doPaypalExpressAction(){

		$payMod = TCVM_Payment_Factory::Factory();
		$payMod->payCart(  TCVM_Payment_Imple::PAYMENT_PAYPAL_EXPRESS_CHECKOUT );	
	    
	}
	
	public function doPaypalDirectPayAction(){
		
		$params = array();
		
		$payMod = TCVM_Payment_Factory::Factory();
		
		try {
			$tempOrderId = $payMod->payCart( TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY , $params );
		}catch(Exception $ex){
			
		}
		
		$payMod->callbackPay( $tempOrderId , TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY );
		
		
		
	}
	
	public function doElectronicTransferAction(){
		
		$payMod = TCVM_Payment_Factory::Factory();
		
		$tempOrderId = $payMod->payCart( TCVM_Payment_Imple::PAYMENT_ELECTRONIC_TRANSFER );
		
		$payMod->callbackPay( $tempOrderId , TCVM_Payment_Imple::PAYMENT_ELECTRONIC_TRANSFER );
			
		
	}
	
	public function callbackPaypalExpressAction(){
	
		$tempOrderId = $this->_getParam( "tempOrderId" );
		
		$payMod = TCVM_Payment_Factory::Factory();
		
		try {
			$payMod->callbackPay( $tempOrderId , TCVM_Payment_Imple::PAYMENT_ELECTRONIC_TRANSFER );
		}catch( Exception $ex ){
			
		}
		
		
	}
	
	public function errorAction(){
		
	}
	
	
	


		

	
}