<?php 
	class Admin_OrderController extends TCVM_ZendX_Controller_Action_Admin{
		
		/**
		 * 
		 * @var TCVM_Order_Interface
		 */
		private $_order;
		
		
		
		public function init() {
			
			$this->_order = TCVM_Order_Factory::Factory();
			
		}

		public function indexAction(){
			
			$pageSize 	= 10;
	    	$pageNo 	= $this->paginationNo();
	    	
			$orders = $this->_order->getsOrder( array() , "id DESC" , $pageNo , $pageSize);
			$count  = $this->_order->getsOrderCount( array() );
			
			$pagination = $this->pagination( $count , $pageSize );
			
			$this->assign( "pagination" , $pagination);
			$this->assign( "orders" , $orders );
		
		}
		
		
		public function viewAction(){
			
	
			$id = $this->_getParam( "id" );
			
			$order 		= $this->_order->getOrder( $id);
			
			
			$this->assign( "order" , $order );
		}
		
		public function doStatusAction(){
		
			$id 	= $this->_getParam( "id" );
			$status = $this->_getParam( "status" );
			
			$this->_order->adminStatus( $id , $status );
			
			$this->redirect( "index" , "order" , "admin" );
		}
		
		
		
		
		
	}