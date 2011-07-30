<?php 
	interface TCVM_Product_Interface
	{
		
		/**
		 * add product
		 */
		public function save( $productType , $data );
		
		public function delete( $productType , $productId );
		
		public function gets( $productType, $conditions = array(), $order = null , $pageNo = null, $pageSize = null  );
		
		public function get( $productType, $id );
		
		
		
		
		/**
		 *
		 * for certain product
		 * 
		 */
		public function getsVisibleCourses( $order = null , $pageNo = null , $pageSize = null, $cache = false );
	}
?>