<?php
	class TCVM_Order_Model_OrderProduct extends WeFlex_Db_Model{
		
		protected $_tableName = 'order_product';
		
		
		private static $_instance;
		
		/**
		 * @return TCVM_Order_Model_OrderProduct
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}