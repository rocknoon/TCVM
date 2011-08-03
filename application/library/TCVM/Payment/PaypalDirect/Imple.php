<?php 
	class TCVM_Payment_PaypalDirect_Imple extends TCVM_Payment_CoreAbstract{
		
		/**
		 * @var WeFlex_Api_Paypal_Nvp
		 */
		private $_paypal;
		
		/**
		 * @var Zend_Controller_Request_Http
		 */
		private $_request;
		
		function __construct(){
			
			$this->_request	  = Zend_Controller_Front::getInstance()->getRequest();
			$this->_paypal	  = new WeFlex_Api_Paypal_Nvp( 
				TCVM::GetInstance()->config->payment->paypal->username, 
				TCVM::GetInstance()->config->payment->paypal->password, 
				TCVM::GetInstance()->config->payment->paypal->sign, 
				TCVM::GetInstance()->config->payment->paypal->env
			);
			
		}
		
		
	
			
		public function payOrder($orderId, $params = null) {
			
			//check order status if suscess or cancel can't be paid 
			
			
			$rtn = array();
			
			$params 	 = $this->_generPaypalParam( $orderId, $params );
			
			try {
				$rtn = $this->_paypal->doDirectPay( $params );
			}catch( Exception $ex ){
				$this->_logErrorPayment( $orderId, TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY, $ex->getMessage() );
				throw $ex;
			}
    		
    		$this->_logSuccessPayment( $orderId, TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY, $rtn['TRANSACTIONID'] , $rtn );
    		
			
			return $rtn;
			
		}
		
		private function _generPaypalParam( $orderId, $params ){
			
			$order = TCVM_Order_Factory::Factory();
			
			$orderEntity	   = $order->getOrder( $orderId );
			
			$params['PAYMENTACTION'] = 'Sale';
			$params['CURRENCYCODE'] = 'AUD';
			$params['IPADDRESS'] 	 = WeFlex_Util::GetIp();
			$params['AMT'] 	         = $orderEntity['total_price'];
			
			
			
			return $params;
				
		}
		
		
		private function _getReturnUrl( $orderId ){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'callback-paypal-express' , 'controller' => 'pay' , 'order_id' => $orderId ) , "default" ) ;
			
			return $rtn;
		}
		
		private function _getCancelUrl(){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'cancel-paypal-express' , 'controller' => 'pay' ) , "default"  ) ;
			
			return $rtn;
			
		}

		
		
		
	}
?>