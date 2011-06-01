<?php 
	interface TCVM_Payment_Interface
	{
		
		/**
		 * pay for a cart
		 * 
		 * 1. gener a temp order
		 * 2. pay temp order
		 * 
		 * @param enum $paymethod
		 * 
		 * @return temp_order_id
		 */
		public function payCart( $payment , $params = null );
		
		
		/**
		 * 
		 */
		public function callbackPay( $tempOrderId, $payment );
		
		
	}
?>