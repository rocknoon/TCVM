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
			$session1["image"] = "/images/s1.jpg";
			$session1["time_start"] = array( "year" => "2012","month" => 5,"date"  => 1);
			$session1["time_end"] =  array( "year" => "2012","month" => 7,"date"  => 1);
			$session1["price"] =  array("before" => 1045,"now"    => 1095 );
			
			
			
			$session2 = array();
			$session2["id"] = 2;
			$session2["name"] = "Session 2";
			$session2["image"] = "/images/s2.jpg";
			$session2["time_start"] = array( "year" => "2012","month" => 7,"date"  => 5);
			$session2["time_end"] =  array( "year" => "2012","month" => 7,"date"  => 8);
			$session2["price"] =  array("before" => 1620,"now"    => 1670 );
			
			$session3 = array();
			$session3["id"] = 3;
			$session3["name"] = "Session 3";
			$session3["image"] = "/images/s3.jpg";
			$session3["time_start"] = array( "year" => "2012","month" => 7,"date"  => 9);
			$session3["time_end"] =  array( "year" => "2012","month" => 10,"date"  => 17);
			$session3["price"] =  array("before" => 945,"now"    => 995 );
			
			$session4 = array();
			$session4["id"] = 4;
			$session4["name"] = "Session 4";
			$session4["image"] = "/images/s4.jpg";
			$session4["time_start"] = array( "year" => "2012","month" => 10,"date"  => 18);
			$session4["time_end"] =  array( "year" => "2012","month" => 10,"date"  => 21);
			$session4["price"] =  array("before" => 1620,"now"    => 1670 );
			
			$session5 = array();
			$session5["id"] = 5;
			$session5["name"] = "Session 5";
			$session5["image"] = "/images/s5.jpg";
			$session5["time_start"] = array( "year" => "2013","month" => 1,"date"  => 17);
			$session5["time_end"] =  array( "year" => "2013","month" => 1,"date"  => 20);
			$session5["price"] =  array("before" => 1720,"now"    => 1770 );
			
			
			$rtn = array( $session1["id"] => $session1,
						  $session2["id"] => $session2,
						  $session3["id"] => $session3,
					$session4["id"] => $session4,
					$session5["id"] => $session5  );
			
			return $rtn;
			
		}

		
		

		
		
		
		
		
		
	}
?>