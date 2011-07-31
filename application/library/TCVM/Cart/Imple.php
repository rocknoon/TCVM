<?php 
	class TCVM_Cart_Imple implements TCVM_Cart_Interface{
		
		
		const SESSION_PRODUCTS = 'tcvm-cart-products';
		const SESSION_SHIPPING = 'tcvm-cart-shipping';
		
		
		/**
		 * @var TCVM_Product_Interface
		 */
		private $_product;
		
		function __construct(){
			$this->_product = TCVM_Product_Factory::Factory();
		}
		
		
		public function addShipping($data) {
			
			//check
			
			$this->_setShippingSession($data);
			
		}
	
			
		public function callbackAfterUserPay() {
			// TODO Auto-generated method stub
			
		}
	
			
		public function clean() {
			// TODO Auto-generated method stub
			
		}
	
			
		public function getAllProducts() {
			
			$products = $this->_getSession();
			
			return $products;
			
		}
	
			
		public function getShipping() {
			return $this->_getShippingSession();
		}
	
		public function getTotalPrice() {
			
			$totalPrice = 0;
			
			$products = $this->_getSession();
			
			

			foreach ( $products as $productType => $items )
			{
				foreach ( $items as $item )
				{
					$totalPrice += $item['price'] * $item['amount'];	
				}
			}
			
			return $totalPrice;
			
		}
	
			
		public function push($type, $id) {
			
			$productEntity = $this->_product->get( $type , $id  );
			
			if(!$productEntity)
			{
				throw new Exception( $this->_translate->_("product is not exist ") , 1 );	
			}
			else 
			{	
				$this->_setSession( $type , $productEntity );
				return true;
			}
			
		}
	
			
		public function remove($productType, $id) {
			// TODO Auto-generated method stub
			
		}
		
		private function _setSession( $productType , $entity  ){
			
			$cartArray = WeFlex_Session::Get( self::SESSION_PRODUCTS );
			
			if( !$cartArray ){
				$cartArray  = array();
			}else{
				$cartArray 	= unserialize( $cartArray );
				
			}
			
			$cartEntity = new TCVM_Cart_Entity_Product( array(
				"id" => $entity['id'],
				"name" => $entity['name'],
				"price" => $entity['price'],
				"product_type" => $productType,
				"amount"	   => 1
			) );

			$cartArray[$productType][$entity['id']] = $cartEntity;
			
			$cartArray = serialize( $cartArray );
			
			
			WeFlex_Session::Set( self::SESSION_PRODUCTS , $cartArray );
		}
		
		private function _getSession(){
			
			$entityStr = WeFlex_Session::Get( self::SESSION_PRODUCTS );
			
			if(!$entityStr)
			{
				return array();
			}
			
			$entityArray = unserialize( $entityStr );
			

			return $entityArray ;	
		}
		
		private function _setShippingSession( $data ){
		
			WeFlex_Session::Set( self::SESSION_SHIPPING , serialize( $data ) );
			
		}
		
		private function _getShippingSession(  ){
			return unserialize( WeFlex_Session::Get( self::SESSION_SHIPPING ));
		}

		
		
		
	} 
?>