<?php 
	class Admin_AdminController extends TCVM_ZendX_Controller_Action_Admin{
		
		/**
		 * 
		 * @var TCVM_Admin_Interface
		 */
		private $_admin;
		
		
		public function init(){
			$this->_admin = TCVM_Admin_Factory::Factory();
		}
		
		public function indexAction(){
			
		}
		
		public function doPasswordAction(){
		
			$password = $this->_getParam( "password" );
			
			$this->_admin->changePassword( $password );
			
			$this->redirect( "index", "index" , "admin" );
			
		}
		
		
		
		
	}