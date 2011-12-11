<?php 
	class TCVM_Order_Imple implements TCVM_Order_Interface{
		
		
		/**
		 * waitting pay
		 */
		const STATUS_WAITTING_PAY = 1000;
		
		/**
		 * when user didn't finish paypal purchase
		 */
		const STATUS_WAITTING_PAYPAL_FINISH = 1001;
		
		/**
		 * when user didn't finish credit purchase
		 */
		const STATUS_WAITTING_CREDIT_FINISH = 1002;
		
		
		/**
		 * when user choose electronic pay
		 */
		const STATUS_WAITTING_ELECTRONIC_TRANSFER = 1003;
		
		
		const STATUS_CANCEL  = 4000;
		
		const STATUS_EXPIRED = 5000;
		
		const STATUS_SUCCESS = 2000;
		
		
		/**
		 * @var TCVM_Order_Model_Order
		 */
		private $_orderModel;
		
		/**
		 * @var TCVM_Order_Model_OrderProduct
		 */
		private $_orderProductModel;
		
		
		function __construct(){
			$this->_orderModel 			= TCVM_Order_Model_Order::GetInstance();
			$this->_orderProductModel 	= TCVM_Order_Model_OrderProduct::GetInstance();
		}
		
		public function generateLoginUserOrder() {
			
			$cart = TCVM_Cart_Factory::Factory();
			$user = TCVM_User_Factory::Factory();
			
			//check login
			$loginUser 	  = $user->getLoginedUser();
			if( !$loginUser ){
				throw new Exception( "sorry, only login user can generate order");
			}
			
			//check cart products
			
			//check shipping
			
			
			$cartInfo = $cart->getCartInfo();
			$userId = $loginUser['id'];
			$totalPrice	  = $cartInfo["total_price"];
			
			return $this->_generateOrder( $userId, $cartInfo, $totalPrice );
			
			
		}
		
		
		
	
		public function getsUserOrder($userId, $order = null, $pageNo = null , $pageSize = null ) {
			
			
			$conditions = array();
			$conditions["user_id"] = $userId;
			
			return $this->_gets( $conditions, $order, $pageNo , $pageSize );
			
		}
		
		
		

		
		public function getOrder($orderId) {
			
			if( !$orderId ){
				throw new Exception( "order id couldn't not be null" );
			}
			
			$orders = $this->_gets( array( "id" => $orderId ) );
			
			return $orders[0];
			
		}
		
		
		
		
		
		
		
		
		public function adminStatus($orderId, $status) {
			
			$this->_changeStatus( $orderId , $status);
			
		}

		public function getsOrder($conditions = array(), $order = null, $pageNo = null, $pageSize = null) {
			return $this->_gets($conditions , $order , $pageNo , $pageSize);
		}

		
		
		public function getsOrderCount($conditions = array()) {
			return $this->_getsCount($conditions);
			
		}

		public function setElectronicTransfer($orderId) {
			
			
			$this->_changeStatus( $orderId , self::STATUS_WAITTING_ELECTRONIC_TRANSFER );
			
		}

		public function callbackOrderSuccessPay($orderId) {
			
			//only waiiting can be paid
			
			$this->_changeStatus( $orderId , self::STATUS_SUCCESS );
			
		}

		private function _generateOrder( $userId, $cartInfo, $totalPrice ){
			
			
			$orderInfo = array();
			$orderInfo["user_id"] = $userId;
			$orderInfo["cart_info"] = serialize( $cartInfo );
			$orderInfo["total_price"] = $totalPrice;
			$orderInfo["status"] 	= self::STATUS_WAITTING_PAY;
			$orderInfo["date_add"] = time();
			
			$cartProducts = $cartInfo[TCVM_Cart_Imple::STEP_PRODUCT]["products"];
			
			$orderId = $this->_orderModel->insert($orderInfo);
			
			foreach( $cartProducts as $id => $product ){
				
					$orderProductInfo = array();
					$orderProductInfo['order_id'] = $orderId;
					$orderProductInfo['product_id']   = $id;
					$orderProductInfo['price']   = $product["price"];
					$orderProductInfo['type']   = $product["type"];

					$this->_orderProductModel->insert($orderProductInfo);

			}
			
			return $orderId;
			
		}
		
		private function _changeStatus( $orderId, $status ){
			
			$this->_orderModel->update( array( "status" => $status ), array( "id" => $orderId ) );
			
		}
		
		private function _getsCount( $conditions  ){
			return $this->_orderModel->where( $conditions )->count();
		}
		
		private function _gets( $conditions, $order = null, $pageNo = null , $pageSize = null ){
			
			$rtn = array();
			
			$product = TCVM_Product_Factory::Factory();
			
			$orderDatas = $this->_orderModel->getAllByConditions( $conditions, $order, $pageNo , $pageSize );
			
			foreach( $orderDatas as $orderData ){
				
				$orderProductDatas = $this->_orderProductModel->getAllByConditions( array( "order_id" => $orderData['id'] ) );
				
				$orderInfo = $orderData;
				$orderInfo["cart_info"] = unserialize( $orderInfo["cart_info"] );
				$orderInfo['products'] = array();
				
				foreach( $orderProductDatas as $orderProductData ){
					
					$productEntity = $product->getById( $orderProductData['product_id'] );
					
					$orderProductInfo = array();
					$orderProductInfo["id"] 			= $orderProductData['product_id'];
					$orderProductInfo["name"] 			= $productEntity['name'];
					$orderProductInfo["price"] 			= $orderProductData['price'];
					
					$orderInfo['products'] []= new TCVM_Order_Entity_OrderProduct( $orderProductInfo );
					
				}
				
				$rtn []= new TCVM_Order_Entity_Order( $orderInfo );
				
				
			}
			
			
			return $rtn;
			
		}
		
		
		
		
		
		
		
		
	}
?>