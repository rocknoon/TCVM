<?php 
	class TCVM_Payment_PaypalAdaptive_Imple extends TCVM_Payment_CoreAbstract{
		
		
		/**
		 * @var WeFlex_Api_Paypal_Adaptive
		 */
		private $_paypal;
		
		/**
		 * @var Zend_Controller_Request_Http
		 */
		private $_request;
		
		function __construct(){
			
			$this->_request	  = Zend_Controller_Front::getInstance()->getRequest();
			$this->_paypal	  = new WeFlex_Api_Paypal_Adaptive( 
				TCVM::GetInstance()->config->payment->paypal->username, 
				TCVM::GetInstance()->config->payment->paypal->password, 
				TCVM::GetInstance()->config->payment->paypal->sign, 
				TCVM::GetInstance()->config->payment->paypal->appId, 
				TCVM::GetInstance()->config->payment->paypal->deviceIp, 
				TCVM::GetInstance()->config->payment->paypal->env
			);
			
		}
		
		
	
		
		
		public function payOrder($orderId, $params = null) {
			
			$orderEntity = $this->_getOrder($orderId);
			$param = $this->_generPaypalParam( $orderEntity );
		
			try {
				$rtn = $this->_paypal->pay( $param );
				
				//pay key
				WeFlex_Session::Set( "paypal-adaptive-pay-key" , $rtn["payKey"]);
				WeFlex_Session::Set( "order_id" , $orderId);
				
				$this->_logAdaptive( $orderId, $rtn["payKey"] );
				$this->_paypal->redirect( $rtn );
			}catch( Exception $ex ){
				$this->_logErrorPayment( $orderId, TCVM_Payment_Imple::PAYMENT_PAYPAL_ADAPTIVE, $ex->getMessage() );
				throw $ex;
			}
			
			
			
			return $rtn;	
			
		}
		
		public function checkPayment(){

			$payKey = WeFlex_Session::Get( "paypal-adaptive-pay-key");
			$orderId = WeFlex_Session::Get( "order_id" );
			
			if( !$payKey ){
				throw new Exception( "no pay key" );
			}
			
		
			$rtn = $this->_paypal->paymentDetail( $payKey );
			
			/* Display the API response back to the browser.
			   If the response from PayPal was a success, display the response parameters'
			   If the response was an error, display the errors received using APIError.php.
			 */
			$ack = strtoupper($rtn["responseEnvelope.ack"]);
			
			if( $ack != "SUCCESS" ){
				$this->_logErrorPayment( $orderId , TCVM_Payment_Imple::PAYMENT_PAYPAL_ADAPTIVE, $rtn);
				throw new Exception("the payment has some error");
			}
			
			$this->_logSuccessPayment( $orderId , TCVM_Payment_Imple::PAYMENT_PAYPAL_ADAPTIVE, $payKey , $rtn);
			
		}
		
		private function _generPaypalParam( $orderEntity ){
			
			
			$nvp = array();
			$nvp["returnURL"] = $this->_getReturnUrl( $orderEntity['id'] );
			$nvp["cancelURL"] = $this->_getCancelUrl();
			$nvp["actionType"] = "PAY";
			$nvp['currencyCode'] = "AUD";
			$nvp["clientDeviceId"]  = "mydevice";
			$nvp["clientIp"]  = WeFlex_Util::GetIp();
			$nvp["memo"]  = "Thanks!";
			$nvp["feesPayer"] = "EACHRECEIVER";
			
			$nvp['receiverEmail'] = array();
			$nvp['receiverAmount'] = array();
			$nvp['primaryReceiver'] = array();
			
		
			
			$products = $orderEntity["cart_info"][TCVM_Cart_Imple::STEP_PRODUCT]["products"];
			
			foreach( $products as $id => $product ){
				
				if( $product["paypal"] == "us" ){
					
					$nvp['receiverEmail']["us"] = TCVM::GetInstance()->config->payment->paypal->receiver->us;
					$nvp['receiverAmount']["us"] = $nvp['receiverAmount']["us"] + $product["price"];
					$nvp['primaryReceiver']["us"] = "false";
					
				}else{
					
					$nvp['receiverEmail']["au"] = TCVM::GetInstance()->config->payment->paypal->receiver->au;
					$nvp['receiverAmount']["au"] = $nvp['receiverAmount']["au"] + $product["price"];
					$nvp['primaryReceiver']["au"] = "false";
					
				}
				
			}
			
			//application fee
			if( $orderEntity["cart_info"][TCVM_Cart_Imple::STEP_PRODUCT]["new"] ){
				$nvp['receiverEmail']["us"] = TCVM::GetInstance()->config->payment->paypal->receiver->us;
				$nvp['receiverAmount']["us"] = $nvp['receiverAmount']["us"] + $orderEntity["cart_info"][TCVM_Cart_Imple::STEP_PRODUCT]["new"];
				$nvp['primaryReceiver']["us"] = "false";
			}
			
			
			
			return $nvp;
				
		}
		
		
		private function _getReturnUrl( $orderId   ){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'callback-paypal-adaptive' , 'controller' => 'pay' ,  'orderId' => $orderId ) , "default" ) ;
			
			return $rtn;
		}
		
		private function _getCancelUrl(){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'cancel-paypal-adaptive' , 'controller' => 'pay' ) , "default"  ) ;
			
			return $rtn;
			
		}
		
		private function _checkOrderCanExpress( $orderEntity ){
			
			
			
		}
		
		protected function _logAdaptive( $orderId, $payKey ){
			
			$errorModel = TCVM_Payment_Model_LogAdaptive::GetInstance();
			
			$errorModel->insert( array(
				"order_id" => $orderId,
				"pay_key"  => $payKey,
				"date_add" => time()
			) );
			
		}

		
		
		
	}
?>