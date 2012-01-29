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
	
			
		public function getsCount($conditions = null) {
			
			$this->_getsCount($conditions);
			
		}
	
			
		public function getUserById($id) {
			
			return $this->_model->getOneByConditions( array( "id" => $id ) );
		}
	
			
		public function getUsers($conditions = null, $order = null, $pageNo = null, $pageSize = null) {
			
			return $this->_getsUsers($conditions , $order , $pageNo , $pageSize );
			
		}
	
			
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
		
		
		public function getUserRegistrationBasic($id) {
			
			$user = $this->_model->getOneByConditions( array( "id" => $id ) );
			
			return unserialize( $user["registration_basic_defualt"] );
		}

			
		public function modifyUserRegistrationBasic($id, $basic) {
			
			$this->_model->update( array( "registration_basic_defualt" => serialize( $basic ) ) ,array( "id" => $id ));
			
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
		
		public function changePassword($password) {
			
			$isLogined = $this->_getSession();
			
			if( !$isLogined ){
				throw new Exception( "you should login first to change your password" );
			}
			
			
			$userInfo = $this->_getSession();
			
			$this->_changePassword( $userInfo['id'] , $password );
			
			
			
			
		}

		
		public function findPassword($email) {
			
			$userInfo = $this->_getByEmail( $email );
			
			
			$code = md5(time());
			
			$this->_model->update( array( "findpassword_code" => $code, "findpassword_code_used" => intval(false) ) , array( "id" => $userInfo["id"] ) );
	
			$title = "TCVM User FindPassword";
			
			
			$url = WeFlex_Util::GetFullUrl( array( "controller" => "user" , "action" => "change-password" , "code" => $code ) , "default"  );
			$html = '';
			$html .= "****************************************************<br/>";
			$html .= "****************************************************<br/>";
			$html .= "Dear ".$userInfo["first_name"].",<br/><br/>";
			$html .= "Here you can change your password.<br/><br/>";
			$html .= '<p><a href="'.$url.'">'.$url.'</a></p><br/><br/>';
			$html .= 'TCVM Team<br/>';
			
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
			$headers .= 'From: admin@tcvm.com.au' . "\r\n" . 'Reply-To: admin@tcvm.com.au' . "\r\n";
			
			@mail(	$email , 
					$title,
					$html,
					$headers );
		}

		
		public function loginThroughFindPassword($code) {
				
			$userInfo = $this->_model->getOneByConditions( array( "findpassword_code" => $code ) );
			
			if( !$userInfo ){
				throw new Exception( "the url is not correct");
			}
			

			if( $userInfo['findpassword_code_used'] ){
				throw new Exception( "this code is already be used");
			}
			
			$this->_setSession( $userInfo );
			
			$this->_model->update( array( "findpassword_code_used" => intval(true) ) , array( "id" => $userInfo['id'] ) );
			
		}
		
		private function _getsUsers( $conditions , $order , $pageNo , $pageSize  ){
			
			$datas = $this->_model->getAllByConditions( $conditions , $order , $pageNo , $pageSize  );  
			
			$rtn = array();
			
			foreach( $datas as $data ){
				$rtn []= new TCVM_User_Entity_User( $data );
			}
			
			return $rtn;
		}
		
		private function _getsCount($conditions = null){
			return $this->_model->where( $conditions )->count();
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
		
		private function _changePassword( $id , $password ){
			
			$this->_model->update( array( "password" => md5($password) ) , array( "id" => $id ) );
		}

		
		
		
		
	}
?>