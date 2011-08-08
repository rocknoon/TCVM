<?php
	class TCVM_Payment_Model_ApplyETF extends WeFlex_Db_Model{
		
		protected $_tableName = 'apply_etf';
		
		private static $_instance;
		
		/**
		 * @return TCVM_Payment_Model_ApplyETF
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}