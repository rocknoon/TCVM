<?php 
	class TCVM_User_Imple implements TCVM_User_Interface{
			
		
		const SESSION_NAME_SPACE = "tcvm-user";
		
		/**
		 * @var TCVM_User_Model_User
		 */
		private $_model;
		
		function __construct(){
			
			$this->_model = TCVM_User_Model_User::GetInstance();
			
		}
		
		public function getLoginedUser() {
			
			return $this->_getLoginedUser();
			
		}
	
			/* (non-PHPdoc)
		 * @see TCVM_User_Interface::getsCount()
		 */
		public function getsCount($conditions = null) {
			// TODO Auto-generated method stub
			
		}
	
			/* (non-PHPdoc)
		 * @see TCVM_User_Interface::getUserById()
		 */
		public function getUserById($id) {
			// TODO Auto-generated method stub
			
		}
	
			/* (non-PHPdoc)
		 * @see TCVM_User_Interface::getUsers()
		 */
		public function getUsers($conditions = null, $order = null, $pageNo = null, $pageSize = null) {
			// TODO Auto-generated method stub
			
		}
	
			/* (non-PHPdoc)
		 * @see TCVM_User_Interface::isEmailExist()
		 */
		public function isEmailExist($email) {
			// TODO Auto-generated method stub
			
		}
	
		
		public function isLogined() {
			
			$loginUser = $this->_getLoginedUser();
			if( $loginUser ){
				return true;
			}else{
				return false;
			}
			
		}
	
			
		public function login($email, $password) {
			
			$user = $this->_getByEmail( $email );
			
			if( !$user ){
				throw new Exception( "user don't exist" );
			}
			
			$md5Password = md5( $password );
			
			if( $user['password'] != $md5Password ){
				throw new Exception( "password is not correct" );
			}
			
			$this->_setSession( $user );
			
			
		}
	
			
		public function logout() {
			
			$this->_setSession( null );
			
		}
	
			/* (non-PHPdoc)
		 * @see TCVM_User_Interface::modifyUserPassword()
		 */
		public function modifyUserPassword($id, $password) {
			// TODO Auto-generated method stub
			
		}
	
			
		public function register($data) {
			
			if( !$data['email'] ){
				throw new Exception( "email address could not be null");
			}
			
			if( !$data['password'] ){
				throw new Exception( "password could not be null");
			}
			
			//check email
			$isExist = $this->_isEmailExist( $data['email'] );
			if( $isExist ){
				throw new Exception( "sorry, email address already exist");
			}
			
			
			$data['password'] = md5( $data['password']  );
			$data['date_add'] = time();

			$this->_model->insert( $data );
			
			
		}
		
		private function _getLoginedUser(){
			
			return $this->_getSession();
			
		}
		
		private function _setSession( $user ){
			$userStr = serialize( $user );
			WeFlex_Session::Set( self::SESSION_NAME_SPACE , $userStr );
		}
		
		private function _getSession(){
			
			$userStr = WeFlex_Session::Get( self::SESSION_NAME_SPACE );
			if( $userStr ){
				$user = unserialize( $userStr );
				return $user;
			}
			return null;
		}
		
		private function _isEmailExist( $email ){
			
			$data = $this->_model->getOneByConditions( array( 'email' => $email )  );
			if ($data)
			{
				return true;
			}
				
			return false;
			
		}
		
		private function _getByEmail( $email ){
			
			$data = $this->_model->getOneByConditions( array( 'email' => $email )  );
			if ($data)
			{
				return new TCVM_User_Entity_User( $data );
			}
			return false;
			
		}

		
		
		
		
	}
?>