<?php 
	class TCVM_Cart_Imple implements TCVM_Cart_Interface{
		
		
		const SESSION_CART = "session_cart";
		const NEW_USER_FEE = 100;
		const RETOKEN_DISCOUNT = 0.3;
		const FIFTH_SESSION_DEDUCT  = 350;
		
		
		const STEP_BASIC   		= "basic";
		const STEP_PRODUCT   	= "product";
		const STEP_PAYINFO   	= "payinfo";
		const STEP_PROFILE   	= "profile";
		
		
		
		
		
		public function fifthSessionDeduct() {
			
			$rtn = $this->_getSession();
			
			$rtn[self::STEP_PRODUCT]["deduct"] = 1;
			
			$this->_setSession( self::STEP_PRODUCT , $rtn[self::STEP_PRODUCT]);
			
		}
	
			
		public function pushProduct( $id , $type ) {
			
			$productMod = TCVM_Product_Factory::Factory();
			
			$course = $productMod->getById( $id );
			
			if( !$course ){
				throw new Exception( "now such product" );
			}
			
			if( $type != "now" && $type != "before" ){
				throw new Exception( "invalid type" );
			}
			
			  
			$rtn = $this->_getSession();
			
			$rtn[self::STEP_PRODUCT]["products"][$id] = $type;
			
			$this->_setSession( self::STEP_PRODUCT , $rtn[self::STEP_PRODUCT]);
			
		}

		public function basicInfo($data) {	
			$this->_setSession( self::STEP_BASIC , $data );
		}
		
		
		public function getCartInfo() {
			
			$rtn = $this->_getSession();
			
			$rtn["total_price"] = $this->_cacludePrice($rtn);
		
			return $rtn;
			
			
		}

		public function payInfo($data) {
			$this->_setSession( self::STEP_BASIC , $data );
			
		}
	
			
		public function product($data) {
			$this->_setSession( self::STEP_BASIC , $data );
			
		}
	
		
		public function profileAttached($data) {
			$this->_setSession( self::STEP_BASIC , $data );
			
		}
		
		
		public function doPay() {
			// TODO Auto-generated method stub
			
		}
		
		public function callbackAfterUserPay() {
			// TODO Auto-generated method stub
			
		}
		
		
		
		
		public function isMeNewUser() {
			// TODO Auto-generated method stub
			
		}

		private function _setSession( $step, $data ){
			
			$cartSession = $this->_getSession();
			$cartSession[$step] = $data;
			
			WeFlex_Session::Set( self::SESSION_CART, $cartSession );
			
		}
		
		private function _getSession(){
			
			$session = WeFlex_Session::Get( self::SESSION_CART );
			
			
			//init 4 step
			if( !$session ){
				$session = array();
			}
			
			if( !isset($session[self::STEP_BASIC]) ){
				$session[self::STEP_BASIC] = array();
				$session[self::STEP_BASIC]["veterinary_acupuncture"] = array();
			}
			
			if( !isset($session[self::STEP_PAYINFO]) ){
				$session[self::STEP_PAYINFO] = array();
			}
				
			if( !isset($session[self::STEP_PRODUCT]) ){
				$session[self::STEP_PRODUCT] = array();
				$session[self::STEP_PRODUCT]["products"] = array();
				$session[self::STEP_PRODUCT]["deduct"] = 0;
			}
			
			if( !isset($session[self::STEP_PROFILE]) ){
				$session[self::STEP_PROFILE] = array();
			}
			
			if( !isset($session["total_price"]) ){
				$session["total_price"] = 0;
			}
			
			if( !isset($session["info"]) ){
				$session["info"] = array();
			}
			
			return $session;
			
			
		}
		
		private function _cacludePrice( &$cartInfo ){
			
			$productMod = TCVM_Product_Factory::Factory();
			$products = $cartInfo[self::STEP_PRODUCT]["products"];
			
			$deduct   = $cartInfo[self::STEP_PRODUCT]["deduct"];
			$rtn = 0;
			
			//if a new user, add 100$fee
			if( $this->_isMeNewUser() ){
				$rtn += self::NEW_USER_FEE;
			}
			
			
			if( is_array( $products ) ){
			//if re-token course
			foreach( $products as $id => $type ){
				$item = $productMod->getById( $id );
				$price = $item["price"][$type];
				if( $this->_myReTokenCourse( $id ) ){
					$rtn += $price * (1 -  self::RETOKEN_DISCOUNT);
					$cartInfo["info"][$id] = $item["name"] . "get ".(self::RETOKEN_DISCOUNT * 100)."% discount";
				}else{
					$rtn += $price;
				}
			}
				
			}
			
			
			
			if( $deduct ){
				$rtn = $rtn - self::FIFTH_SESSION_DEDUCT;
			}
			
			return $rtn;
			
		}
		
		private function _isMeNewUser(){
			
			$user = TCVM_User_Factory::Factory()->getLoginedUser();
			
			if( !$user ){
				throw new Exception( "sorry, you are not login" );
			}
			
			$sql = "select id from `order` where user_id = " . WeFlex_Db::QuoteInto( "?" , $user["id"]);
			
			$rtn = WeFlex_Db::Query($sql);
			
			if( !empty( $rtn ) ){
				return true;
			}else{
				return false;
			}
			
			
		}
		
		private function _myReTokenCourse( $id ){
			
			$user = TCVM_User_Factory::Factory()->getLoginedUser();
			
			if( !$user ){
				throw new Exception( "sorry, you are not login" );
			}
			
			$sql = "SELECT `order`.id
					FROM  `order` 
					LEFT JOIN order_product ON `order`.id = order_product.order_id
					WHERE `order`.user_id = ". WeFlex_Db::QuoteInto( "?" , $user["id"]) ."
					AND order_product.product_id = " . WeFlex_Db::QuoteInto( "?" , $id);
			
			$rtn = WeFlex_Db::Query($sql);
			
			if( !empty( $rtn ) ){
				return true;
			}else{
				return false;
			}
			
		}
		
		
	} 
?>