<?php

class CartController extends TCVM_ZendX_Controller_Action_Front
{
	
	/**
	 * @var TCVM_Cart_Interface
	 */
	private $_cart;
	

    public function init()
    {
        $this->_cart = TCVM_Cart_Factory::Factory();
    }
	
	
	
	public function viewAction(){
		
		$products 	= $this->_cart->getAllProducts();
		$totalPrice = $this->_cart->getTotalPrice(); 
		
		$this->assign( "products", $products[TCVM_Product_Imple::TYPE_COURSES] );
		$this->assign( "totalPrice", $totalPrice );
		
	}
	
	public function shippingAction(){
	
	
		
	}
	
	public function confirmAction(){
	
		$products 	= $this->_cart->getAllProducts();
		$totalPrice = $this->_cart->getTotalPrice(); 
		$shipping	= $this->_cart->getShipping();
		
		$this->assign( "products", $products[TCVM_Product_Imple::TYPE_COURSES] );
		$this->assign( "totalPrice", $totalPrice );
		$this->assign( "shipping" , $shipping );
		
	
	}
	
	public function successAction(){
		
		
		
	}
	
	public function doConfirmAction(){
	
		$orderMod = TCVM_Order_Factory::Factory();
		
		$order = $orderMod->generateLoginUserOrder();
		
		$this->redirect( "success" , "cart" , "default" , array( "order_id" => $order['id'] ) );
		
	}
	
	public function doShippingAction(){
	
		$data = array();
		$data['first_name'] = $this->_getParam( "first_name" );
		$data['last_name'] = $this->_getParam( "last_name" );
		$data['mobile'] = $this->_getParam( "mobile" );
		$data['zip_code'] = $this->_getParam( "zip_code" );
		$data['city'] = $this->_getParam( "city" );
		$data['street'] = $this->_getParam( "street" );
		$data['country'] = $this->_getParam( "country" );
		
		
		$this->_cart->addShipping( $data );
		
		$this->redirect( "confirm" );
	}
	
	public function doRemoveAction(){
	
		$productId 		= $this->_getParam( "product_id" );
		$productType 	= $this->_getParam( "product_type" );

		$this->_cart->remove( $productType , $productId );
		
		$this->redirect( "view" );		
	}
	
	
	public function doAmountAction(){
	
		$productId 		= $this->_getParam( "product_id" );
		$productType 	= $this->_getParam( "product_type" );
		$amount 	    = $this->_getParam( "amount" );

		$this->_cart->amount( $productType , $productId, $amount );
		
		$this->redirect( "view" );		
	}
	
	public function doPushAction(){
		
		$productId 		= $this->_getParam( "product_id" );
		$productType 	= $this->_getParam( "product_type" );
		
		$this->_cart->push( $productType , $productId );
		
		$this->redirect( "view" );
	
	}
	
	
	
	


		

	
}