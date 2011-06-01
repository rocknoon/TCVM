<?php 
	interface TCVM_Cart_Interface
	{
		
		/**
		 * push a product into cart
		 */
		public function push ( $type , $id );
		

		
		/**
		 * remove one product from cart
		 */
		public function remove( $productType , $id );

		/**
		 * clean cart
		 *
		 */
		public function clean();
		
		
		/**
		 * get cart all products
		 */
		public function getAllProducts();
		
		
		/**
		 * get cart total price
		 *
		 * @return float 
		 */
		public function getTotalPrice();
		
		
		public function callbackAfterUserPay();
		
	}
?>