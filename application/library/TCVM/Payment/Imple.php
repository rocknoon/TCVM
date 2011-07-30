<?php 
	class TCVM_Payment_Imple implements TCVM_Payment_Interface{
		
		const PAYMENT_PAYPAL_EXPRESS_CHECKOUT = 1;
		const PAYMENT_PAYPAL_DIRECT_PAY		  = 2;
		const PAYMENT_ELECTRONIC_TRANSFER	  = 3;
		
		
		
		public function payOrder($payment, $orderId, $params = null) {
			// TODO Auto-generated method stub
			
		}

		
		
		public function callbackPay($tempOrderId, $payment) {
			
			$paymentCore = TCVM_Payment_Core_Factory::Factory($payment);
			
			try {
				$formalOrderId = $paymentCore->callbackPay();
			}catch( Exception $ex ){
				
			}
			
			
			
			$this->_cleanCart();
			$this->_sendMail();
			$this->_log();
			
		}
		
		
		
		public function continuePay($orderId, $payment) {
			// TODO Auto-generated method stub
			
		}

	

		
		

		
		
		
		
		
		
		
	}
?>