<?php
	class TCVM_Payment_Model_LogSuccess extends WeFlex_Db_Model{
		
		protected $_tableName = 'log_payment_success';
		
		private static $_instance;
		
		/**
		 * @return TCVM_Payment_Model_LogError
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}