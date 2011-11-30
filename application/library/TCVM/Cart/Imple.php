<?php 
	class TCVM_Cart_Imple implements TCVM_Cart_Interface{
		
		
		const SESSION_CART = "session_cart";
		
		
		const STEP_BASIC   		= "basic";
		const STEP_PRODUCT   	= "product";
		const STEP_PAYINFO   	= "payinfo";
		const STEP_PROFILE   	= "profile";
		
		
		public function basicInfo($data) {	
			$this->_session( self::STEP_BASIC , $data );
		}
		
		
		public function getCartInfo() {
			
			return $this->_getSession();
			
		}

		public function payInfo($data) {
			$this->_session( self::STEP_BASIC , $data );
			
		}
	
			
		public function product($data) {
			$this->_session( self::STEP_BASIC , $data );
			
		}
	
		
		public function profileAttached($data) {
			$this->_session( self::STEP_BASIC , $data );
			
		}
		
		
		public function doPay() {
			// TODO Auto-generated method stub
			
		}
		
		public function callbackAfterUserPay() {
			// TODO Auto-generated method stub
			
		}
		
		private function _setSession( $step, $data ){
			
			$cartSession = $this->_getSession();
			$cartSession[$step] = $data;
			
			
		}
		
		private function _getSession(){
			
			$session = WeFlex_Session::Get( self::SESSION_CART );
			
			
			//init 4 step
			if( !$session ){
				$session = array();
			}
			
			if( !$session[self::STEP_BASIC] ){
				$session[self::STEP_BASIC] = array();
			}
			
			if( !$session[self::STEP_PAYINFO] ){
				$session[self::STEP_PAYINFO] = array();
			}
				
			if( !$session[self::STEP_PRODUCT] ){
				$session[self::STEP_PRODUCT] = array();
			}
			
			if( !$session[self::STEP_PROFILE] ){
				$session[self::STEP_PRODUCT] = array();
			}
			
			return $session;
			
			
		}
		
		
	} 
?>