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

			$coursess = $this->_product->getAllCourses();
			
			$this->assign( "coursess" , $coursess );
		
		}
		
		public function createAction(){
			
			$this->appendJs('js/rocknoon/jplugin/jquery.swfupload.js');
				
			$this->render( "edit" );
			
		}
		
		public function editAction(){
			
			$this->appendJs('js/rocknoon/jplugin/jquery.swfupload.js');
	
			$id = $this->_getParam( "id" );
			
			$courses 		= $this->_product->getById($id);
			
			
			$this->assign( "courses" , $courses );
		}
		
		
		public function postsaveAction(){
			
						
			$data = array();
			$data['id']     = $this->_getParam( "id" );
			$data['name']  = $this->_getParam( "name" );
			$data["time_start"]   = strtotime($this->_getParam( "time_start" ));
			$data["time_end"]     =  strtotime($this->_getParam( "time_end" ));
			$data["before_price"] =  $this->_getParam( "before_price" );
			$data["now_price"]  =  $this->_getParam( "now_price" );
			$data['image'] = $this->_getParam( "image" );
			$data['visible'] = $this->_getParam( "visible" );
			$data['paypal'] = $this->_getParam( "paypal" );
			$data['desc'] = $this->_getParam( "desc" );
			
			
			//check data
			$this->_product->save( $data );
			
			
			$this->redirect( "index" , "courses" , "admin" );
			
		}
		
		public function postdeleteAction(){
	
			$id = $this->_getParam( "id" );
			
		
			$this->_product->delete( $id);
			
			$this->redirect( "index" , "courses" , "admin" );
		}
	
		
		
	}