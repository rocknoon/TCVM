<?php 
	interface TCVM_Admin_Interface{
		
		public function generDefaultAdmin();
		
		/**
		 * is user logined 
		 * 
		 * @return boolean
		 */
		public function isLogined();
		
		
		
		
		/**
		 * 用户登录
		 * 
		 * @return Eccky_User_Entity_User
		 */
		public function login( $username , $password );
		
		
		
		/**
		 * user logout
		 *
		 */
		public function logout();
		
		
		/**
		 * 
		 * @return int id
		 */
		public function changePassword( $password );
		
	
	
	}
?>