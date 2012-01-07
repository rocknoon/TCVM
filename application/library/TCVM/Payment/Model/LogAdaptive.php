<?php
	class TCVM_Payment_Model_LogAdaptive extends WeFlex_Db_Model{
		
		protected $_tableName = 'log_adaptive';
		
		private static $_instance;
		
		/**
		 * @return TCVM_Payment_Model_LogAdaptive
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}