<?php 
	interface TCVM_Product_Interface
	{
		
		
		/**
		 * 
		 * return array(
		 * 	  array(
		 *      "id"
		 *      "name",
		 *      "picture",
		 *      "time_start" => array( 
		 *      	"year" => "2012",
		 *          "month" => 5,
		 *          "date"  => 1
		 *     	 )
		 *     "time_end"   => rray( 
		 *      	"year" => "2012",
		 *          "month" => 5,
		 *          "date"  => 1
		 *     ),
		 *     "price" => array(
		 *     	"before" => 1024,
		 *      "now"    => 1080
		 *     )
		 *    )
		 * 	
		 * )
		 */
		public function getCourses();
		
		
		public function getById( $id );
		
		
		
		
		
		
	}
?>