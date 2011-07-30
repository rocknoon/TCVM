<?php
class TCVM_User_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  TCVM_User_Interface
		 */
		public static function Factory(){
			
			if( !self::$_instance ){
				self::$_instance = new TCVM_User_Imple();
			}
			return self::$_instance;
		}
}