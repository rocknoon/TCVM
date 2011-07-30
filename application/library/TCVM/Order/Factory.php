<?php
class TCVM_Order_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  TCVM_Order_Interface
		 */
		public static function Factory(){
			
			if( !self::$_instance ){
				self::$_instance = new TCVM_Order_Imple();
			}
			return self::$_instance;
		}
}