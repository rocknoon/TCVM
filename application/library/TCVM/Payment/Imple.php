<?php 
	class TCVM_Payment_Imple implements TCVM_Payment_Interface{
		
		const PAYMENT_PAYPAL_EXPRESS_CHECKOUT = 1;
		const PAYMENT_PAYPAL_DIRECT_PAY		  = 2;
		const PAYMENT_ELECTRONIC_TRANSFER	  = 3;
		
		
		
		public function payOrder($payment, $orderId, $params = null) {
			
			$paymentCore = TCVM_Payment_CoreFactory::Factory($payment);
			
			$paymentCore->payOrder( $orderId, $params );
			
			$this->_orderSuccess( $orderId );
			$this->_cleanCart();
			
		}
		
		

		
		/**
		 * special functions
		 */
		
		
		
		
		public function setElectronicTransfer($orderId) {
			
			$paymentCore = TCVM_Payment_CoreFactory::Factory(self::PAYMENT_ELECTRONIC_TRANSFER);
			$paymentCore->setElectronicTransfer($orderId);
			
		}
	
			
		public function setPaypalExpress($orderId) {
			
			$paymentCore = TCVM_Payment_CoreFactory::Factory(self::PAYMENT_PAYPAL_EXPRESS_CHECKOUT);
			$paymentCore->setExpressCheckout($orderId);
			
		}
		
		
		
		
		public function continuePay($orderId, $payment) {
			// TODO Auto-generated method stub
			
		}
		
		
		
		
		
		public function getsETF($conditions = array(), $order = null, $pageNo = null, $pageSize = null) {
			
			$model = TCVM_Payment_Model_ApplyETF::GetInstance();
			
			$rtn = $model->getAllByConditions($conditions, $order , $pageNo , $pageSize );
			 
			return $rtn;
		}
	
			
		public function getsETFCount($conditions = array()) {
			
			$model = TCVM_Payment_Model_ApplyETF::GetInstance();
			
			return $model->where( $conditions ) ->count();
			
		}
	
			
		public function recordETF($orderId, $info) {
			
			$model = TCVM_Payment_Model_ApplyETF::GetInstance();
			
			$model->insert( array(
				'order_id' => $orderId,
				"info"	   => $info,
				"date_add" => time()
			) );
			
			
		}

		private function _orderSuccess( $orderId ){
			
			$order = TCVM_Order_Factory::Factory();
			
			$order->callbackOrderSuccessPay( $orderId );
		}
		
		private function _cleanCart(){
			
			$cart = TCVM_Cart_Factory::Factory();
			
			$cart->clean();
			
		}

	

		
		

		
		
		
		
		
		
		
	}
?>