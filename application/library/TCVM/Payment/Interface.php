<?php 
	interface TCVM_Payment_Interface
	{
		
		/**
		 * do a payment in the 3rd part.
		 * 
		 * @exception order already be paid
		 * @exception order is not belong to login user
		 * @exception order is cancel
		 * @exception user is not login
		 * 
		 * @param enum $paymethod
		 */
		public function payOrder( $payment , $orderId, $params = null );
		
		
		/**
		 * when success pay order in the bank, then callback this function
		 * 1. change order status( according with payment )
		 * 
		 * @exception order already be paid
		 * @exception order is not belong to login user
		 * 
		 */
		public function callbackPay( $orderId, $payment );
		
		/**
		 * when a order is paid, but is still pending, we can use this interface to continue pay this order
		 * 
		 * @param unknown_type $orderId
		 * @param unknown_type $payment
		 */
		public function continuePay($orderId, $payment);
		
		
	}
?>