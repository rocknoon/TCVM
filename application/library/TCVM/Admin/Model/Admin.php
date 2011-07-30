<?php 
	class TCVM_Admin_Model_Admin extends WeFlex_Db_Model{
		
		protected $_tableName = 'admin';
		
		
		private static $_instance;
		
		/**
		 * @return TCVM_Admin_Model_Admin
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		
	}