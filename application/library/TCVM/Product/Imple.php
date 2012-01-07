<?php 
	class TCVM_Product_Imple implements TCVM_Product_Interface{
		
		/**
		 * @var TCVM_Product_Model
		 */
		private $_model;
		
		function __construct(){
			
			$this->_model = TCVM_Product_Model::GetInstance();
			
		}
		
		public function getCourses() {
			
			
			$data = $this->_model->getAllByConditions( array( "visible" => intval(true) ) , "date_add DESC" );
			
			$rtn = array();
			
			foreach( $data as $course ){
				$rtn[$course["id"]] = $this->_rebuildCourse($course);;
			}
			return $rtn;
		}
		
		
		public function getAllCourses() {
			
			$data = $this->_model->getAllByConditions( array() , "date_add DESC" );
			
			$rtn = array();
			
			foreach( $data as $course ){
				$rtn[$course["id"]] = $this->_rebuildCourse($course);;
			}
			return $rtn;
			
		}
		
		
		
		public function getById($id) {
			
			$data = $this->_model->getOneByConditions(array( "id" => $id ) );
			
			if( $data ){
				$data = $this->_rebuildCourse( $data );
			}
			
			return $data;
			
		}
		
		public function canGetBeforePrice( $id ){
			$courses = $this->getCourses();
			$course = $courses[$id];
			
			$now = time();
			
			if( $course["time_start"]["month"] == 1 ){
				$beforeMonth = 12;
				$beforeYear  = $course["time_start"]["year"] - 1;
			}else{
				$beforeMonth = $course["time_start"]["month"] - 1;
				$beforeYear  = $course["time_start"]["year"];
			}
			
			$beforeTime = mktime(0, 0, 0, $beforeMonth, 1, $beforeYear);
			
			if( $now > $beforeTime ){
				return false;
			}else{
				return true;
			}
			
		}
		

		
		public function save($data) {
			
			
			$id = $data['id'];
			$image = $data['image'];
			unset( $data['id'] );
			unset( $data['image'] );
			
			
			if( $id ){
				$this->_model->update( $data , array( "id" => $id ) );
			}
			//create
			else{
				$data['date_add'] = time();
				$id =  $this->_model->insert( $data );
			}
			
			if( $image ){	
				$imageModel = new TCVM_Product_Image();
				$imageUrl = $imageModel->formal( $id , $image );
				$updateArray['image'] = $imageUrl;
				$this->_model->update( $updateArray , array( "id" => $id ));
			}
			
			return $id;
			
		}
		
		
		public function delete($id) {
			
			$this->_model->delete( array("id" => $id) );
			
		}

		private function _rebuildCourse( $course ){
			
			$timeStart = array();
			$timeStart["year"] = intval( date( "Y" , $course["time_start"] ) );
			$timeStart["month"] = intval( date( "n" , $course["time_start"] ) );
			$timeStart["date"] = intval( date( "j" , $course["time_start"] ) );
			
			$timeEnd = array();
			$timeEnd["year"] = intval( date( "Y" , $course["time_end"] ) );
			$timeEnd["month"] = intval( date( "n" , $course["time_end"] ) );
			$timeEnd["date"] = intval( date( "j" , $course["time_end"] ) );
			
			
			$price = array();
			$price["before"] = $course["before_price"];
			$price["now"] 	 = $course["now_price"];
			
			
			$course["time_start_int"] = $course["time_start"];
			$course["time_end_int"] = $course["time_end"];
			$course["time_start"] = $timeStart;
			$course["time_end"] = $timeEnd;
			$course["price"] = $price;
			
			
			return $course;
			
		}

		
		
		
	}
?>