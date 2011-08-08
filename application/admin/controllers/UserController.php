<?php 
	class Admin_UserController extends TCVM_ZendX_Controller_Action_Admin{
		
		/**
		 * 
		 * @var TCVM_User_Interface
		 */
		private $_order;
		
		
		
		public function init() {
			
			$this->_user = TCVM_User_Factory::Factory();
			
		}

		public function indexAction(){
			
			$pageSize 	= 10;
	    	$pageNo 	= $this->paginationNo();
	    	
			$users = $this->_user->getUsers( array() , "date_add DESC" , $pageNo , $pageSize);
			$count  = $this->_user->getsCount( array() );
			
			$pagination = $this->pagination( $count , $pageSize );
			
			$this->assign( "pagination" , $pagination);
			$this->assign( "users" , $users );
		
		}
		
		
	
		
		
		
	}