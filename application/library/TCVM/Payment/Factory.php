<?php
class TCVM_Payment_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  TCVM_Payment_Interface
		 */
		public static function Factory(){
			
			if( !self::$_instance ){
				self::$_instance = new TCVM_Payment_Imple();
			}
			return self::$_instance;
		}
}