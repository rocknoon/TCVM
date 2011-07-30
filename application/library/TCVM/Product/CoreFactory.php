<?php
class TCVM_Product_CoreFactory{
	
	
		private static $_coursesInstance;
		
		/**
		 * @return  TCVM_Product_CoreAbstract
		 */
		public static function Factory( $type ){
			
			switch( $type ){
			
				case TCVM_Product_Imple::TYPE_COURSES:
					if( !self::$_coursesInstance ){
						self::$_coursesInstance = new TCVM_Product_Courses_Imple();
					}
					return self::$_coursesInstance;
					break;
				default:
					throw new Exception( "no such product type $type" );
					break;
			}
		}
}