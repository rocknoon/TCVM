<?php 
	interface TCVM_Cart_Interface
	{
		
		
		public function getCartInfo();
		
		public function basicInfo( $data );
		
		public function product( $data );
		
		public function profileAttached( $data );
		
		public function payInfo($data);
		
		public function doPay();
		
		public function callbackAfterUserPay();
	
		
	}
?>