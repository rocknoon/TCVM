<?php 
	class TCVM_Product_ImpleOld {
		
		const TYPE_COURSES = 1;
		
		const CACHE_GETS_VISIBLE_COURSES = "cache_product_gets_visible_courses";
		
		
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
			
			
			if( $cache ){
				
				/**
				 * local from cache
				 */
				$cache = Zend_Registry::get( 'cache' );
				
				//build namespace
				$namespace = self::CACHE_GETS_VISIBLE_COURSES . '_' . WeFlex_Util::GenerNameForCacheKey( $order ) . "_" . intval($pageNo) . "_" . intval( $pageSize ); 
				
				if(!$result = $cache->load( $namespace )) {
					$result = $this->_getsVisibleCourses( $order, $pageNo, $pageSize  );
				    $cache->save( $result ,  $namespace );
				} 
				
				return $result;
				
			}else{
				return $this->_getsVisibleCourses( $order, $pageNo, $pageSize  );
			}
			
			
			
		}
	
			
		public function save($productType, $data) {
			
			$core = TCVM_Product_CoreFactory::Factory( $productType );
			return $core->save( $data );
			
		}
		
		private function _getsVisibleCourses( $order, $pageNo, $pageSize ){
			
			$course = TCVM_Product_CoreFactory::Factory(self::TYPE_COURSES);
			
			$conditions = array();
			$conditions['visible'] = intval( true );
			
			return $course->gets( $conditions, $order, $pageNo , $pageSize );  
			
		}
		
		
		
		
	}
?>