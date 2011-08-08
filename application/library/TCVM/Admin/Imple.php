<?php 
	class TCVM_Admin_Imple implements TCVM_Admin_Interface {
	
		const SESSION_KEY = "tcvm-admin-session";
		
		
		
		/**
		 * @see TCVM_Admin_Interface::generDefaultAdmin()
		 *
		 */
		public function generDefaultAdmin() {
			
			$username = TCVM::GetInstance()->config->admin->username;
			$password = TCVM::GetInstance()->config->admin->username;
			
			$isExist = $this->_isUserNameExist( $username );
			if( !$isExist ){
				$data = array();
				$data['username'] = $username;
				$data['password'] = $password;
				$this->_create( $data );
			}
			
		}
		
		
		
		

		public function getLoginedAdmin() {
			
			return $this->_getSession();
			
		}
		
		
		
		
		
		
		public function isLogined() {
			
			if( $this->_getSession() ){
				return true;
			}else{
				return false;
			}
			
		}
		
		
		
		
		public function login( $username , $password ) {
			
			$admin = $this->_getAdminByUsername( $username );
			
			if( !$admin ){
				throw new Exception( "account information error" );
			}
			
			if( md5( $password ) != $admin['password'] ){
				throw new Exception( "account information error" );
			}
			
			$this->_setSession( $admin );
			
		}
		
		
		public function logout() {
			$this->_setSession( null );
		}
		
		
		
		
		public function changePassword($password) {
			
			$isLogin = $this->_getSession();
			
			if( !$isLogin ){
				throw new Exception ( "sorry you are not login" );
			}
			
			if( !$password ){
				throw new Exception ( "sorry new password could not be empty" );
			}
			
			$username    = TCVM::GetInstance()->config->admin->username;
			$newpassword = md5( $password );
					
			$model = TCVM_Admin_Model_Admin::GetInstance();
			
			$model->update( array( "password" => $newpassword ) , array( "username" => $username ) );
			
		}

		private function _isUserNameExist( $username ){
			
			$model = TCVM_Admin_Model_Admin::GetInstance();
			
			$admin = $model->getOneByConditions( array( "username" => $username ) );
		
			if( $admin ){
				return true;
			}else{
				return false;
			}
		}
		
		private function _create( $data ){
			
			$model = TCVM_Admin_Model_Admin::GetInstance();
			
			$data["password"] = md5( $data['password'] );
			$data['date_add'] = time();
			
			$id = $model->insert( $data );
			
			return $id; 
			
		}
		
		
		
		
		protected function _setSession( $user ){
			$userStr = serialize( $user );
			WeFlex_Session::Set( self::SESSION_KEY , $userStr );
		}
		
		protected function _getSession(){
			
			$userStr = WeFlex_Session::Get( self::SESSION_KEY );
			if( $userStr ){
				$user = unserialize( $userStr );
				return $user;
			}
			return false;
		}
		
		private function _getAdminByUsername( $username ){
			
			$model = TCVM_Admin_Model_Admin::GetInstance();
			
			$admin = $model->getOneByConditions( array( "username" => $username ) );
		
			if( $admin ){
				return new TCVM_Admin_Entity_Admin($admin);
			}else{
				return null;
			}
			
		}

		
	}
?>