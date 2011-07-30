<?php
class TCVM_Cart_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  TCVM_Cart_Interface
		 */
		public static function Factory(){
			
			if( !self::$_instance ){
				self::$_instance = new TCVM_Cart_Imple();
			}
			return self::$_instance;
		}
}