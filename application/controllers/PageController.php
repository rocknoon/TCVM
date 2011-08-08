<?php

class PageController extends TCVM_ZendX_Controller_Action_Front
{


    public function facultyAction()
    {
       $this->title( "TCVM Australia | Faculty" );
    }
    
	public function certificationAction()
    {
       $this->title( "TCVM Australia | Certification" );
    }
    
	public function outofauAction()
    {
       $this->title( "TCVM Australia | Out of Australia" );
    }


}

