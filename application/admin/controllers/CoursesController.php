<?php 
	class Admin_CoursesController extends TCVM_ZendX_Controller_Action_Admin{
		
		/**
		 * 
		 * @var TCVM_Product_Interface
		 */
		private $_product;
		
		
		
		public function init() {
			
			$this->_product = TCVM_Product_Factory::Factory();
			
		}

		public function indexAction(){

			$coursess = $this->_product->gets( TCVM_Product_Imple::TYPE_COURSES, array(), "date_add DESC" );
			
			$this->assign( "coursess" , $coursess );
		
		}
		
		public function createAction(){
			
			$this->appendJs('js/rocknoon/jplugin/jquery.swfupload.js');
				
			$this->render( "edit" );
			
		}
		
		public function editAction(){
			
			$this->appendJs('js/rocknoon/jplugin/jquery.swfupload.js');
	
			$id = $this->_getParam( "id" );
			
			$courses 		= $this->_product->get( TCVM_Product_Imple::TYPE_COURSES , $id);
			
			
			$this->assign( "courses" , $courses );
		}
		
		
		public function postsaveAction(){
			
						
			$data = array();
			$data['id']     = $this->_getParam( "id" );
			$data['name']  = $this->_getParam( "name" );
			$data['desc']   = $this->_getParam( "desc" );
			$data['short_desc']   = $this->_getParam( "short_desc" );
			$data['price'] = $this->_getParam( "price" );
			$data['image'] = $this->_getParam( "image" );
			$data['visible'] = $this->_getParam( "visible" );
			
			//check data
			$this->_product->save( TCVM_Product_Imple::TYPE_COURSES, $data );
			
			
			$this->redirect( "index" , "courses" , "admin" );
			
		}
		
		public function postdeleteAction(){
	
			$id = $this->_getParam( "id" );
			
		
			$this->_product->delete( TCVM_Product_Imple::TYPE_COURSES, $id);
			
			$this->redirect( "index" , "courses" , "admin" );
		}
	
		
		
	}