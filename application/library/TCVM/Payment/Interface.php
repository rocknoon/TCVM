<?php 
	interface TCVM_Payment_Interface
	{
		
		/**
		 * do a payment for the order.  will call the 3rd part api to do the payment
		 * 
		 * @param enum $paymethod
		 */
		public function payOrder( $orderId, $params = null );
		
		
		/**
		 * apply for etf
		 */
		public function recordETF( $orderId , $info );
		
		public function getsETF( $conditions = array() , $order = null , $pageNo = null, $pageSize = null );
		
		public function getsETFCount( $conditions = array() );
	}
?>