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
				$this->_paypal->redirect( $rtn );
			}catch( Exception $ex ){
				$this->_logErrorPayment( $orderId, TCVM_Payment_Imple::PAYMENT_PAYPAL_ADAPTIVE, $ex->getMessage() );
				throw $ex;
			}
			
			$this->_logSuccessPayment( $orderId, TCVM_Payment_Imple::PAYMENT_PAYPAL_ADAPTIVE, $rtn['TRANSACTIONID'] , $rtn );
    		
			
			return $rtn;
			
			
			
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
				
				if( $id == 1 || $id == 3 ){
					
					$nvp['receiverEmail']["us"] = TCVM::GetInstance()->config->payment->paypal->receiver->us;
					$nvp['receiverAmount']["us"] = $nvp['receiverAmount']["us"] + $product["price"];
					$nvp['primaryReceiver']["us"] = "false";
					
				}else{
					
					$nvp['receiverEmail']["au"] = TCVM::GetInstance()->config->payment->paypal->receiver->au;
					$nvp['receiverAmount']["au"] = $nvp['receiverAmount']["au"] + $product["price"];
					$nvp['primaryReceiver']["au"] = "false";
					
				}
				
			}
			
			
			
			return $nvp;
				
		}
		
		
		private function _getReturnUrl( $orderId, $amt, $currencyCodeType, $paymentType  ){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'callback-paypal-adaptive' , 'controller' => 'pay' ,  'orderId' => $orderId ) , "default" ) ;
			
			return $rtn;
		}
		
		private function _getCancelUrl(){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'cancel-paypal-adaptive' , 'controller' => 'pay' ) , "default"  ) ;
			
			return $rtn;
			
		}
		
		private function _checkOrderCanExpress( $orderEntity ){
			
			
			
		}

		
		
		
	}
?>