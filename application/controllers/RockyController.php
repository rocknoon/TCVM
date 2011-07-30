<?php

class RockyController extends TCVM_ZendX_Controller_Action_Front
{
	
	
	public function indexAction(){
		
 
		$data = array();
		$data['name'] = "Rocky";
		$data['price'] = "12.1";
		$data['short_desc'] = "Rocky111";
		$data['desc'] = "22222";
		$data['visible'] = 1;
	
		
		
		$productMod = TCVM_Product_Factory::Factory();
		
		$productMod->save( TCVM_Product_Imple::TYPE_COURSES , $data);
		
		die();
	}
	
	
	


		

	
}