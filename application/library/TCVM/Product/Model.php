<?php
	class TCVM_Product_Model extends WeFlex_Db_Model{
		
		protected $_tableName = 'product_courses';
		
		
		private static $_instance;
		
		/**
		 * @return TCVM_Product_Model
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}