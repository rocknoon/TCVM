<?php 
	interface TCVM_Payment_Interface
	{
		
		/**
		 * do a payment for the order.  will call the 3rd part api to do the payment
		 * 
		 * @param enum $paymethod
		 */
		public function payOrder( $payment , $orderId, $params = null );
		
		
		/**
		 * begin a paypal express process
		 */
		public function setPaypalExpress( $orderId );
		
		
		/**
		 * begin a electronic transfer
		 */
		public function setElectronicTransfer( $orderId );
		
		
		/**
		 * when a order is paid, but is still pending, we can use this interface to continue pay this order
		 * 
		 * @param unknown_type $orderId
		 * @param unknown_type $payment
		 */
		public function continuePay($orderId, $payment);
		
		
	}
?>