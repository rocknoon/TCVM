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
			
			$rtn[self::STEP_PRODUCT]["products"][$id] = array();
			$rtn[self::STEP_PRODUCT]["products"][$id]["type"] = $type;
			$rtn[self::STEP_PRODUCT]["products"][$id]["paypal"] = $course["paypal"];
			
			$this->_setSession( self::STEP_PRODUCT , $rtn[self::STEP_PRODUCT]);
			
		}

		public function basicInfo($data) {	
		
			
			if(!isset($data["veterinary_acupuncture"])){
				$data["veterinary_acupuncture"] = array();
			}
			
			if(!isset($data["tcvm_clinical_approach"])){
				$data["tcvm_clinical_approach"] = array();
			}
			
			if(!isset($data["advanced_programs"])){
				$data["advanced_programs"] = array();
			}
			
			if(!isset($data["practice"])){
				$data["practice"] = array();
			}
			
			
			
			$this->_setSession( self::STEP_BASIC , $data );
		}
		
		
		public function getCartInfo() {
			
			$rtn = $this->_getSession();
			
			$rtn["total_price"] = $this->_cacludePrice($rtn);
		
			return $rtn;
			
			
		}

		public function payInfo($data) {
			$this->_setSession( self::STEP_PAYINFO , $data );
			
		}
	
			
		public function product($data) {
			$this->_setSession( self::STEP_PRODUCT , $data );
			
		}
	
		
		public function profileAttached($data) {
			
			
			$uploadDir = APPLICATION_PUBLIC_PATH.'/upload/profile/';
		    WeFlex_Util::MkDir( $uploadDir );
		    	
		    	
			//process new file
			if( $data["biographical"] ){
				$file = $data["biographical"];
				$extention = explode(".", $file['name']);
		    	$fileName = md5(time()).".".$extention[1];
		    	$newfile = $uploadDir . "/" . $fileName;
		    	WeFlex_Util::Copy( $file['tmp_name'] , $newfile);
		    	$fileUrl = '/upload/profile/' . $fileName;
		    	$data["biographical"] = $fileUrl;
			}
			
			if( $data["photo"] ){
				$file = $data["photo"];
				$extention = explode(".", $file['name']);
		    	$fileName = md5(time() + 1).".".$extention[1];
		    	$newfile = $uploadDir . "/" . $fileName;
		    	WeFlex_Util::Copy( $file['tmp_name'] , $newfile);
		    	$fileUrl = '/upload/profile/' . $fileName;
		    	$data["photo"] = $fileUrl;
			}
		
		   
		    
			
			
			
			
			
			
			$this->_setSession( self::STEP_PROFILE , $data );
			
		}
		
		
		
		
		
		
		
		
		public function rememberBasic() {
			
			$userMod = TCVM_User_Factory::Factory();
			$session = $this->_getSession();
			
			$loginUser = $userMod->getLoginedUser();
			$userMod->modifyUserRegistrationBasic($loginUser["id"], $session[self::STEP_BASIC]);

		}

		public function cleanCart() {
			WeFlex_Session::Set( self::SESSION_CART, null );
			
		}
		
		

		
		public function cleanProduct() {
			
			$rtn = $this->_getSession();
			
			$rtn[self::STEP_PRODUCT] = null;
			
			$this->_setSession( self::STEP_PRODUCT , $rtn[self::STEP_PRODUCT]);
			
		}

		public function isMeNewUser() {
			
			return $this->_isMeNewUser();
			
		}

		private function _setSession( $step, $data ){
			
			$cartSession = $this->_getSession();
			$cartSession[$step] = $data;
			
			WeFlex_Session::Set( self::SESSION_CART, $cartSession );
			
		}
		
		private function _getSession(){
			
			$session = WeFlex_Session::Get( self::SESSION_CART );
			
			$userMod = TCVM_User_Factory::Factory();
			
			$loginUser = $userMod->getLoginedUser();
			$basic = $userMod->getUserRegistrationBasic($loginUser["id"]);
			
			//init 4 step
			if( !$session ){
				$session = array();
			}
			
			if( !isset($session[self::STEP_BASIC]) && !$basic ){
				$session[self::STEP_BASIC] = array();
				$session[self::STEP_BASIC]["veterinary_acupuncture"] = array();
				$session[self::STEP_BASIC]["tcvm_clinical_approach"] = array();
				$session[self::STEP_BASIC]["advanced_programs"] = array();
				$session[self::STEP_BASIC]["practice"] = array();
			}
			
			if( !isset($session[self::STEP_BASIC]) && $basic ){
				$session[self::STEP_BASIC] = $basic;
			}
			
			if( !isset($session[self::STEP_PAYINFO]) ){
				$session[self::STEP_PAYINFO] = array();
			}
				
			if( !isset($session[self::STEP_PRODUCT]) ){
				$session[self::STEP_PRODUCT] = array();
				$session[self::STEP_PRODUCT]["products"] = array();
				$session[self::STEP_PRODUCT]["deduct"] = 0;
				
				if( $this->_isMeNewUser() ){
					$session[self::STEP_PRODUCT]["new"] = self::NEW_USER_FEE;
				}
				
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
			foreach( $products as $id => $product ){
				$item = $productMod->getById( $id );
				$price = $item["price"][$product["type"]];
				if( $this->_myReTokenCourse( $id ) ){
					$price = $price * (1 -  self::RETOKEN_DISCOUNT);
					$cartInfo["info"][$id] = $item["name"] . "get ".(self::RETOKEN_DISCOUNT * 100)."% discount";
				}
				$rtn += $price;
				$cartInfo[self::STEP_PRODUCT]["products"][$id]["price"] = $price;
			}
				
			}
			
			
			
			if( $deduct && key_exists( "5" , $products) ){
				$rtn = $rtn - self::FIFTH_SESSION_DEDUCT;
				$cartInfo[self::STEP_PRODUCT]["products"][5]["price"] = $cartInfo[self::STEP_PRODUCT]["products"][5]["price"] - self::FIFTH_SESSION_DEDUCT;
			}
			
			return $rtn;
			
		}
		
		private function _isMeNewUser(){
			
			$user = TCVM_User_Factory::Factory()->getLoginedUser();
			
			if( !$user ){
				throw new Exception( "sorry, you are not login" );
			}
			
			$sql = "select id from `order` where status = ".TCVM_Order_Imple::STATUS_SUCCESS." and  user_id = " . WeFlex_Db::QuoteInto( "?" , $user["id"]);
			
			$rtn = WeFlex_Db::Query($sql);
			
			if( empty( $rtn ) ){
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
					AND order_product.product_id = " . WeFlex_Db::QuoteInto( "?" , $id) . " AND `order`.status = ".TCVM_Order_Imple::STATUS_SUCCESS;
			
			$rtn = WeFlex_Db::Query($sql);
			
			if( !empty( $rtn ) ){
				return true;
			}else{
				return false;
			}
			
		}
		
		
	} 
?>