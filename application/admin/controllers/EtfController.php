<?php 
	class Admin_EtfController extends TCVM_ZendX_Controller_Action_Admin{
		
		
		
		
		
		

		public function indexAction(){
			
			$pageSize 	= 10;
	    	$pageNo 	= $this->paginationNo();
	    	
	    	$pay = TCVM_Payment_Factory::Factory();
	    	
	    	$etfs 	= $pay->getsETF(array() , "date_add DESC" , $pageNo , $pageSize);
	    	$count  = $pay->getsETFCount( array() );
			
			
			$pagination = $this->pagination( $count , $pageSize );
			
			$this->assign( "pagination" , $pagination);
			$this->assign( "etfs" , $etfs );
		
		}
		
		
	
		
		
		
	}