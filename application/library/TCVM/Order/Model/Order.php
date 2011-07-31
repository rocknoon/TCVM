<?php
	class TCVM_Order_Model_Order extends WeFlex_Db_Model{
		
		protected $_tableName = 'order';
		
		
		private static $_instance;
		
		/**
		 * @return TCVM_Order_Model_Order
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}