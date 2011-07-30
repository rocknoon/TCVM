<?php
	class TCVM
	{
		
		
		private static $_instance;
		
		
		/**
		 * @return Eccky
		 */
		public static function GetInstance(){
			if( !self::$_instance ){
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		public static function CleanCache(){
			
			$cache = Zend_Registry::get( 'cache' );
			$cache->clean();
			
		}

		
		
		public static function UseCache(){
			return self::GetInstance()->config->cache;
		}
	

		
		
		public $config;
		
		public function init(){
			$this->_configSystemIni();
		}
		
		
		
		
		
		private function _configSystemIni(){
			$this->config = WeFlex_Application::GetInstance()->configAll->tcvm;
		}
		
		
		
		
	}
?>