<?php 
	class TCVM_Product_Courses_Imple extends TCVM_Product_CoreAbstract
	{
		
		/**
		 * @var TCVM_Product_Model_Courses
		 */
		private $_model;
		
		function __construct(){
			
			$this->_model = TCVM_Product_Model_Courses::GetInstance();
			
		}
		
		public function delete($productId) {
			$this->_model->delete( array( "id" => $productId )  );
		}
	
		public function get($id) {
			
			return $this->_get( $id );
			
		}
	
		public function gets($conditions = array(), $order = null, $pageNo = null, $pageSize = null) {
			
			return $this->_gets($conditions, $order, $pageNo, $pageSize);
			
			
		}
	
		public function save($data) {
			
			$id = $data['id'];
			$image = $data['image'];
			unset( $data['id'] );
			unset( $data['image'] );
			unset( $data['perlink'] );
			
			
			if( $id ){
				$this->_update( $id, $data );
			}
			//create
			else{
				$id = $this->_create( $data );	
			}
			
			$this->_updateImage( $id , $image );
			
			
			return $id;
			
		}
		
		private function _get($id) {
			
			$data = $this->_model->getOneByConditions( array( "id" => $id ) );
			
			if( !$data ){
				return null;
			}
			
			return new TCVM_Product_Entity_Courses( $data );
			
		}
		
		private function _updateImage( $id, $image ){
			
			if( $image ){	
				$imageModel = new TCVM_Product_Courses_Image();
				$imageUrl = $imageModel->formal( $id , $image );
				$updateArray['image'] = $imageUrl;
			}
			
			$this->_model->update( $updateArray , array( "id" => $id ));
			
		}
		
		private function _create( $data ){
			
			//check fileds
			
			$data['perlink'] = WeFlex_Util::GenerNameForSEO( $data["name"] );
			$data['date_add'] = time();
			
			return $this->_model->insert( $data );
			
			
			
		}
		
		private function _update( $id, $data ){
			
			//update perlink
			if( $data["name"] ){
				$data['perlink'] = WeFlex_Util::GenerNameForSEO( $data["name"] );
			}
			
			$this->_model->update( $data , array( "id" => $id ) );
		}
		
		private function _gets($conditions , $order , $pageNo , $pageSize ) {
			
			
			$datas = $this->_model->getAllByConditions($conditions, $order, $pageNo, $pageSize);
			
			$rtn = array();
			
			foreach( $datas as $data ){
				$rtn []= new TCVM_Product_Entity_Courses( $data );
			}
			
			return $rtn;
			
			
		}

		
		
		
	}
?>