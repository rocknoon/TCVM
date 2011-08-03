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
		 * change certain product amount
		 */
		public function amount( $productType , $productId, $amount );
		
		
		/**
		 * fill in the shipping information
		 * 
		 * $data = array(  
		 * 	"phone"
		 *  "first_name"
		 *  "last_name"
		 * )
		 */
		public function addShipping( $data );
		
		
		public function getShipping();
		
		
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