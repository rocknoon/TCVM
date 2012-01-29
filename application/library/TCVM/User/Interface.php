<?php 
	interface TCVM_User_Interface{
		
		/**
		 * is user logined 
		 * 
		 * @return boolean
		 */
		public function isLogined();
		
		/**
		 * user register
		 *
		 * @param array $data = array( 
		 * 	 'email', 'password' 
		 * )
		 * @return int id
		 */
		public function register( $data );
		
		
		
		
		/**
		 * 用户登录
		 *
		 * @param string $email
		 * @param string $password
		 * 
		 * @throws Exception('this user is not approved');
		 * @throws Exception('user does not exist');
		 * @throws Exception('password is not correct');
		 */
		public function login( $email , $password );
		

		
		
		
		/**
		 * user logout
		 *
		 */
		public function logout();
		
		
		
		
		
		/**
		 * get user information by id
		 *
		 * permission ( Magzine_User::ACL_USER_GET )
		 * 
		 * @param int $id
		 * 
		 * @throws Exception('you have no Magzine_User::ACL_USER_GET permission');
		 * 
		 * @return Magazine_User_Entity_User
		 * 
		 */
		public function getUserById( $id );
		
		

		public function isEmailExist( $email );
		
		public function getUserRegistrationBasic( $id );
		
		public function modifyUserRegistrationBasic( $id , $basic );
		
		
		
		/**
		 * get user by certain conditions
		 * 
		 * permission ( Magzine_User::ACL_USER_GET )
		 *
		 * @param array  $conditions
		 * @param string $order
		 * @param int    $pageNo
		 * @param int    $pageSize
		 * 
		 * @throws Exception('you have no Magzine_User::ACL_USER_GET permission');
		 * 
		 * @return array( Magazine_User_Entity )
		 * 
		 * 
		 */
		public function getUsers( $conditions = null , $order = null , $pageNo = null , $pageSize = null );
		
		
		public function getsCount(  $conditions = null  );
		
		/**
		 * get logined user 
		 * 
		 * @return array( Magazine_User_Entity )]
		 * 
		 */
		public function getLoginedUser();
		 
		public function changePassword($password);

		public function findPassword($email);

		public function loginThroughFindPassword($code);
		
	
	
	}
?>