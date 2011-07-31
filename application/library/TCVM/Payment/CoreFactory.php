<?php
class TCVM_Payment_CoreFactory{
	
	
		private static $_paypalExpressInstance;
		
		/**
		 * @return  TCVM_Payment_CoreAbstract
		 */
		public static function Factory( $type ){
			
			switch( $type ){
			
				case TCVM_Payment_Imple::PAYMENT_PAYPAL_EXPRESS_CHECKOUT:
					if( !self::$_paypalExpressInstance ){
						self::$_paypalExpressInstance = new TCVM_Payment_PaypalExpress_Imple();
					}
					return self::$_paypalExpressInstance;
					break;
				default:
					throw new Exception( "no such payment type $type" );
					break;
			}
		}
}