<?php 
	interface TCVM_Order_Interface{
		
		
		/**
		 * 从购物车生成临时订单
		 * 
		 * //如果用户没登陆 抛出异常
		 *
		 * return  boolean
		 */
		public function generateLoginUserTempOrder();
		
		
		/**
		 * 成功支付一个临时订单
		 * 
		 * 1. 判断临时订单状态
		 * 2. 从临时订单生成正式订单
		 * 3. 发送成功支付的邮件
		 * 
		 * @param int $tempOrderId 临时订单id
		 * @param int paymethod    paypal or ideal
		 * @param int payinfo      paypal or ideal info
		 *
		 * @return boolean 
		 */
		public function generateOrderFromTempOrder( $tempOrderId , $paymethod , $status, $payinfo );
		
		
		/**
		 * Get user's formal order if he login
		 * 
		 * @return array 
		 *
		 */
		public function getFormalOrder( $formalOrderId );
		
		/**
		 * Get all of  orders by any conditions 
		 *
		 * permission ( Magzine_ACL::ACL_FORMAL_ORDER_GET )
		 * 
		 * @param array   $conditions
		 * @param string  $order
		 * @param integer $pageNo
		 * @param integer $pageSize
		 * 
		 * @return array
		 */
		public function getFormalOrders( $conditions = null , $order = null , $pageNo = null , $pageSize = null );
		
		public function getFormalOrdersCount( $conditions = null );
		
		
	}
?>