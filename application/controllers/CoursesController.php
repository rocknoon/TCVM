<?php

class CoursesController extends TCVM_ZendX_Controller_Action_Front
{
	
	/**
	 * @var TCVM_Product_Interface
	 */
	private $_product;

    public function init()
    {
        $this->_product = TCVM_Product_Factory::Factory();
    }

    public function indexAction()
    {
        
    	$coursess = $this->_product->getsVisibleCourses( "date_add ASC", null, null, TCVM::UseCache() );
    	
    	$this->assign( "coursess" , $coursess );
    	$this->title( "TCVM Australia | Courses" );
    	
    }


}