<?php
	class TCVM_User_Model_User extends WeFlex_Db_Model{
		
		protected $_tableName = 'user';
		
		
		private static $_instance;
		
		/**
		 * @return TCVM_User_Model_User
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}