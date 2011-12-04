<?php 
	class TCVM_Product_Imple implements TCVM_Product_Interface{
		
		
		public function getCourses() {
			
		
			return $this->_getCourses();
		 
		    					
		    					

  	

			
		}
		
		public function getById($id) {
			
			$courses = $this->_getCourses();
			return $courses[$id];
			
		}
		
		private function _getCourses(){
			
			$session1 = array();
			$session1["id"] = 1;
			$session1["name"] = "Session 1";
			$session1["image"] = "";
			$session1["time_start"] = array( "year" => "2012","month" => 5,"date"  => 1);
			$session1["time_end"] =  array( "year" => "2012","month" => 6,"date"  => 1);
			$session1["price"] =  array("before" => 1024,"now"    => 1080 );
			
			
			
			$session2 = array();
			$session2["id"] = 2;
			$session2["name"] = "Session 2";
			$session2["image"] = "";
			$session2["time_start"] = array( "year" => "2012","month" => 4,"date"  => 1);
			$session2["time_end"] =  array( "year" => "2012","month" => 5,"date"  => 1);
			$session2["price"] =  array("before" => 222,"now"    => 333 );
			
			
			$rtn = array( $session1["id"] => $session1,
						  $session2["id"] => $session2  );
			
			return $rtn;
			
		}

		
		

		
		
		
		
		
		
	}
?>