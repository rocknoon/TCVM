<?php 
	abstract class TCVM_Payment_CoreAbstract
	{
		
		abstract public function payOrder($orderId, $params = null);
		
		abstract public function callbackPay( $orderId, $payment );
		
		
		
		
	}
?>