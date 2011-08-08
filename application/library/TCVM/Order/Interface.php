<?php 
	interface TCVM_Order_Interface{
		
		
		/**
		 * generate order from cart
		 * 
		 * //如果用户没登陆 抛出异常
		 *
		 * return  boolean
		 */
		public function generateLoginUserOrder();
		
		
		
		
		/**
		 * get certain user order information
		 */
		public function getsUserOrder( $userId , $order = null, $pageNo = null , $pageSize = null );
		
		
		public function getOrder( $orderId );
		
		/**
		 * gets all the order
		 */
		public function getsOrder( $conditions = array(), $order = null, $pageNo = null , $pageSize = null );
		
		public function getsOrderCount( $conditions = array() );
		
		
		public function adminStatus( $orderId , $status );
		
		
		/**
		 * when user select electronic payment, will call this function
		 */
		public function setElectronicTransfer( $orderId );
		
		/**
		 * when order success pay, call this function
		 */
		public function callbackOrderSuccessPay( $orderId );
		
		
		
		
		
		
		
		
	}
?>