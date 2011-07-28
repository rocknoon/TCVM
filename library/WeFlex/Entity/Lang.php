<?php

/**
 * data structure
 * 
 * id
 * createTime
 * 'en' => array(
 * 		title => 'title_en_gb',
 * 		desc  => 'desc_en_gb'
 * ),
 * 'zn' => array(
 * 		title => 'title_zn',
 * 		desc  => 'desc_an'
 * )
 * 
 */
require_once 'WeFlex/Entity.php';

	class WeFlex_Entity_Lang extends WeFlex_Entity {
		
		/**
		 * current lang
		 */
		protected $_lang;
		
		/**
		 * array( 'title' , 'desc' )
		 * means these column support multiple lang
		 * 
		 */
		protected $_langColumnList = array();
		
		
		/**
	      * 构造函数
	      * 
	      * $coll => array(
	      * 	
	      * 	'id' => 1
	      * 	'perlink' => 'home'
	      * 	'langs'   => 
	      * 		'english' => 
	      * 			 "title" => "english_title"
	      * 			 "desc"  => "english_desc"
	      * 	    'ducth' => 
	      * 			 "title" => "ducth_title"
	      * 			 "desc"  => "ducth_desc"
	      * 		'chinese' => 
	      * 			 "title" => "chinese_title"
	      * 			 "desc"  => "chinese_desc"
	      * 
	      * )
	      *
	      */
	    function __construct( array $_langColumnList , array $coll )
	    {
	    	
	    	$this->_langColumnList = $_langColumnList;
	    	
	    	parent::__construct( $coll );
	    }
	    
	    
	    
	    /**
	     * the post data may looks like
	     *   'id' => 1
	      *  'perlink' => 'home'
	      *  'title'   => 
	      *  	'english' => 'english_title'
	      *     'ducth'   => 'ducth_title',
	      *     'chinese' => 'chinese_title'
	      *     
	      * this mehtod will make it looks like format we will use
	      *     
	      *     'id' => 1
	      * 	'perlink' => 'home'
	      * 	'langs'   => 
	      * 		'english' => 
	      * 			 "title" => "english_title"
	      * 			 "desc"  => "english_desc"
	      * 	    'ducth' => 
	      * 			 "title" => "ducth_title"
	      * 			 "desc"  => "ducth_desc"
	      * 		'chinese' => 
	      * 			 "title" => "chinese_title"
	      * 			 "desc"  => "chinese_desc"
	     *   
	     */
	    public static function ParseCollFromPost( $coll ){
	    	
	    	
	    }
		
		
		public function getLangFields(){
			return $this->_langColumnList;
		}
		
		
		
		public function setLang( $lang ){
			$this->_lang = $lang;
		}
	
		public function getLang() {
			return $this->_lang;
		}
		
		public function getBasicInfo(){
			
			$rtn = array();
			
			foreach( $this->_coll as $key => $value ){
				if( $key != 'langs' ){
					$rtn[$key] = $value ;	
				}
			}
			
			return $rtn;
			
			
		}
		
		public function getLangInfos(){
			return $this->_coll['langs'];
		}
		
	
		/**
		 * @see WeFlex_Entity::_getOffset()
		 *
		 * @param unknown_type $offset
		 * @return unknown
		 */
		protected function _getOffset( $offset ) {
			
			if( $this->_isColumnInLangList( $offset ) ){
				return $this->_coll['langs'][$this->_lang][$offset];
			}else{
				return parent::_getOffset( $offset );
			}
		
		}
		
		/**
		 * @see WeFlex_Entity::_setOffset()
		 *
		 * @param unknown_type $offset
		 * @param unknown_type $value
		 */
		protected function _setOffset($offset, $value) {
		
			if( $this->_isColumnInLangList( $offset ) ){
				$this->_coll['langs'][$this->_lang][$offset] = $value;	   				
			}else{
				parent::_setOffset( $offset , $value );
			}
			
		}
		
		private function _isColumnInLangList( $column ){
			
			foreach( $this->_langColumnList as $langColumn  ){
				if( $column == $langColumn ){
					return true;
				}	
			}
			return false;
		}
	


		
		
		
	}
?>