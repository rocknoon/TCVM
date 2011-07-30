<?php 
	class TCVM_Product_Imple implements TCVM_Product_Interface{
		
		const TYPE_COURSES = 1;
		
		
		public function delete($productType, $productId) {
			
			$core = TCVM_Product_CoreFactory::Factory( $productType );
			return $core->delete( $productId );
			
		}
	
			
		public function get($productType, $id) {
			
			$core = TCVM_Product_CoreFactory::Factory( $productType );
			return $core->get( $id );
			
		}
	
			
		public function gets($productType, $conditions = array(), $order = null, $pageNo = null, $pageSize = null) {
			
			$core = TCVM_Product_CoreFactory::Factory( $productType );
			return $core->gets( $conditions , $order, $pageNo , $pageSize );
			
			
		}
	
			
		public function getsVisibleCourses($order = null, $pageNo = null, $pageSize = null, $cache = false) {
			// TODO Auto-generated method stub
			
		}
	
			
		public function save($productType, $data) {
			
			$core = TCVM_Product_CoreFactory::Factory( $productType );
			return $core->save( $data );
			
		}
		
		
		
		
	}
?>