<?php
class TCVM_Payment_CoreFactory{
	
	
		private static $_paypalExpressInstance;
		
		private static $_paypalDirectInstance;
		
		private static $_electronicTransferInstance;
		
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
				case TCVM_Payment_Imple::PAYMENT_PAYPAL_DIRECT_PAY:
					if( !self::$_paypalDirectInstance ){
						self::$_paypalDirectInstance = new TCVM_Payment_PaypalDirect_Imple();
					}
					return self::$_paypalDirectInstance;
					break;
				case TCVM_Payment_Imple::PAYMENT_ELECTRONIC_TRANSFER:
					if( !self::$_electronicTransferInstance ){
						self::$_electronicTransferInstance = new TCVM_Payment_ElectronicTransfer_Imple();
					}
					return self::$_electronicTransferInstance;
					break;
				default:
					throw new Exception( "no such payment type $type" );
					break;
			}
		}
}