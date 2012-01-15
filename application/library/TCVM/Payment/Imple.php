<?php 
	class TCVM_Payment_Imple implements TCVM_Payment_Interface{
		
		const PAYMENT_PAYPAL_EXPRESS_CHECKOUT = 1;
		const PAYMENT_PAYPAL_DIRECT_PAY		  = 2;
		const PAYMENT_PAYPAL_ADAPTIVE	  	  = 3;
		const PAYMENT_ELECTRONIC_TRANSFER	  = 4;
		
		
		
		
		public function payOrder($orderId, $params = null) {
			
			$order = TCVM_Order_Factory::Factory();
			
			$orderInfo = $order->getOrder( $orderId );
			$this->_checkOrderCanBePaid($orderInfo);
			
			$paymentCore = TCVM_Payment_CoreFactory::Factory($orderInfo["cart_info"][TCVM_Cart_Imple::STEP_PAYINFO]["paymethod"]);
			
			$paymentCore->payOrder( $orderId, $params );
			
			
		}
		
		

		
		
		
		
		
		
		
		public function getsETF($conditions = array(), $order = null, $pageNo = null, $pageSize = null) {
			
			$model = TCVM_Payment_Model_ApplyETF::GetInstance();
			
			$rtn = $model->getAllByConditions($conditions, $order , $pageNo , $pageSize );
			 
			return $rtn;
		}
	
			
		public function getsETFCount($conditions = array()) {
			
			$model = TCVM_Payment_Model_ApplyETF::GetInstance();
			
			return $model->where( $conditions ) ->count();
			
		}
	
			
		public function recordETF($orderId, $info) {
			
			$model = TCVM_Payment_Model_ApplyETF::GetInstance();
			
			$model->insert( array(
				'order_id' => $orderId,
				"info"	   => $info,
				"date_add" => time()
			) );
			
			
		}
		

		public function email($orderId) {
			
			$orderInfo = TCVM_Order_Factory::Factory()->getOrder($orderId);
			
			$zendView = new Zend_View();
			$zendView->assign( "orderInfo" , $orderInfo );
			$zendView->setEncoding( 'UTF-8' );
			
			$path = realpath(dirname(__FILE__) );
			$zendView->setScriptPath( $path );	
			
			$html = $zendView->render("success.phtml" );
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
			$headers .= 'From: admin@tcvm.com.au' . "\r\n" . 'Reply-To: admin@tcvm.com.au' . "\r\n";
			
			$to = array( $orderInfo["email"] , "register@tcvm.com" ,"naturalvet@earthlink.net", "admin@tcvm.com.au" );
			
			
			foreach( $to as $emailA ){
				@mail(	$emailA , 
					"TCVM Course Booking",
					$html,
					$headers );
			}
			
			
			
		}

		private function _orderSuccess( $orderId ){
			
			$order = TCVM_Order_Factory::Factory();
			
			$order->callbackOrderSuccessPay( $orderId );
		}
		
		private function _cleanCart(){
			
			$cart = TCVM_Cart_Factory::Factory();
			
			$cart->clean();
			
		}
		
		private function _checkOrderCanBePaid( $order ){
			
			if( $order['status'] == TCVM_Order_Imple::STATUS_CANCEL ){
				throw new Exception( "order is canceled" );
			}
			
			if( $order['status'] == TCVM_Order_Imple::STATUS_EXPIRED ){
				throw new Exception( "order is expired" );
			}
			
			if( $order['status'] == TCVM_Order_Imple::STATUS_SUCCESS ){
				throw new Exception( "order is already paid" );
			}
			
		}
		
			
		/**
		 * deprecated functions
		 */
		
		
		private function _setElectronicTransfer($orderId) {
			
			$paymentCore = TCVM_Payment_CoreFactory::Factory(self::PAYMENT_ELECTRONIC_TRANSFER);
			$paymentCore->setElectronicTransfer($orderId);
			
		}
	
			
		private function _setPaypalExpress($orderId) {
			
			$paymentCore = TCVM_Payment_CoreFactory::Factory(self::PAYMENT_PAYPAL_EXPRESS_CHECKOUT);
			$paymentCore->setExpressCheckout($orderId);
			
		}
		
		
		
		
		private function _continuePay($orderId, $payment) {
			// TODO Auto-generated method stub
			
		}

	

		
		

		
		
		
		
		
		
		
	}
?>