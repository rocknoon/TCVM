<?php 
	class TCVM_Product_Imple implements TCVM_Product_Interface{
		
		
		public function getCourses() {
			
		
			return $this->_getCourses();
		 
		    					
		    					

  	

			
		}
		
		public function getById($id) {
			
			$courses = $this->_getCourses();
			return $courses[$id];
			
		}
		
		public function canGetBeforePrice( $id ){
			$courses = $this->_getCourses();
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
			
			$session5 = array();
			$session5["id"] = 5;
			$session5["name"] = "Session 5";
			$session5["image"] = "";
			$session5["time_start"] = array( "year" => "2012","month" => 4,"date"  => 1);
			$session5["time_end"] =  array( "year" => "2012","month" => 5,"date"  => 1);
			$session5["price"] =  array("before" => 900,"now"    => 1000 );
			
			
			$rtn = array( $session1["id"] => $session1,
						  $session2["id"] => $session2,
						  $session5["id"] => $session5  );
			
			return $rtn;
			
		}

		
		

		
		
		
		
		
		
	}
?>