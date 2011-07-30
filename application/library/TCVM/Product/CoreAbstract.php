<?php 
	abstract class TCVM_Product_CoreAbstract{
		

		/**
		 * add product
		 */
		public function save( $data ){}
		
		public function delete( $productId ){}
		
		public function gets( $conditions = array(), $order = null , $pageNo = null, $pageSize = null ){}
		
		public function get( $id ){}
		
	}
?>