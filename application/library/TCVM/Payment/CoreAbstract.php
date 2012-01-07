<?php 
	abstract class TCVM_Payment_CoreAbstract
	{
		
		abstract public function payOrder($orderId, $params = null);		
		
		
		/**
		 * get a order information
		 */
		protected function _getOrder( $orderId ){
			
			$order = TCVM_Order_Factory::Factory();
			$orderEntity	   = $order->getOrder( $orderId );
			return $orderEntity;
		}
		
		protected function _logSuccessPayment( $orderId, $payment, $transactionId , $info = null ){
			
			$successModel = TCVM_Payment_Model_LogSuccess::GetInstance();
			
			$successModel->insert( array(
				"order_id" => $orderId,
				"payment"  => $payment,
				"transaction_id"	   => $transactionId,
				"info"		=> serialize( $info ),
				"date_add" => time()
			) );
		}
		
		protected function _logErrorPayment( $orderId, $payment, $error ){
			
			$errorModel = TCVM_Payment_Model_LogError::GetInstance();
			
			$errorModel->insert( array(
				"order_id" => $orderId,
				"payment"  => $payment,
				"error"	   => serialize( $error ),
				"date_add" => time()
			) );
			
		}
		
	}
?>