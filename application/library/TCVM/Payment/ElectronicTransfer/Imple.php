<?php 
	class TCVM_Payment_ElectronicTransfer_Imple extends TCVM_Payment_CoreAbstract{
		

		
		public function setElectronicTransfer( $orderId ){
			
			
			//check order can setElectronicTransfer
			
			$order = TCVM_Order_Factory::Factory();
			$order->setElectronicTransfer( $orderId );
			
		}
	
			
		public function payOrder($orderId, $params = null) {
			
			
			$this->_logSuccessPayment( $orderId, TCVM_Payment_Imple::PAYMENT_PAYPAL_EXPRESS_CHECKOUT, null , null );
    		
			
			
			
			
		}

		
		
	}
?>