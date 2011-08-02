<?php 
	class TCVM_Payment_PaypalExpress_Imple extends TCVM_Payment_CoreAbstract{
		
		const STATUS_COMPLETED = "Completed";
		
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
		
		public function setExpressCheckout( $orderId ){
			
			$orderEntity = $this->_getOrder($orderId);
			
			
			$this->_checkOrderCanExpress( $orderEntity );
			$param = $this->_generPaypalParam( $orderEntity );
    		$this->_paypal->setExpressCheckout( $param );
			
		}
	
			
		public function payOrder($orderId, $params = null) {
			
			
			
		}
		
		private function _generPaypalParam( $orderEntity ){
			
			$currencyCodeType = "AUD";
			$paymentType	  = 'Sale';
			
			$products 		  = $orderEntity['products'];
			$amt			  = $orderEntity['total_price'];
			
			$returnUrl		  = $this->_getReturnUrl( $orderId );
			$cancelUrl		  = $this->_getCancelUrl();
			
			
			$nvpArray = array();
			
			for( $i = 0; $i < count($products) ; $i ++ ){
				
				$nvpArray["L_NAME".$i] = WeFlex_Util::GenerNameForSEO($products[$i]['name']);
				$nvpArray["L_AMT".$i] = $products[$i]['price'];
				$nvpArray["L_QTY".$i] = $products[$i]['amount'];
			}
			
			$nvpArray["RETURNURL"] = $returnUrl;
			$nvpArray["CANCELURL"] = $cancelUrl;
			$nvpArray["CURRENCYCODE"]  = $currencyCodeType;
			$nvpArray["PAYMENTACTION"] = $paymentType;
			$nvpArray["AMT"]		   = (string)$amt;
			$nvpArray["NOSHIPPING"]	   = "1";
			
			return $nvpArray;
				
		}
		
		
		private function _getReturnUrl( $orderId ){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'callback-paypal-express' , 'controller' => 'pay' , 'order_id' => $orderId ) , "default" ) ;
			
			return $rtn;
		}
		
		private function _getCancelUrl(){
			
			$rtn = WeFlex_Util::GetFullUrl(array('action' => 'cancel-paypal-express' , 'controller' => 'pay' ) , "default"  ) ;
			
			return $rtn;
			
		}
		
		private function _checkOrderCanExpress( $orderEntity ){
			
			
			
		}

		
		
		
	}
?>