<?php

class TCVM_Admin_Factory{
	
	
		private static $_instance;
		
		/**
		 * @return  TCVM_Admin_Interface
		 */
		public static function Factory(){
			if( !self::$_instance ){
				self::$_instance = new TCVM_Admin_Imple();
			}
			return self::$_instance;
		}
}