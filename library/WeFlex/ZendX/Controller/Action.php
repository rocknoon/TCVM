<?php 
	
	class WeFlex_ZendX_Controller_Action extends Zend_Controller_Action
	{
		
		function preDispatch(){
			parent::preDispatch();
			$this->_renderGlobalVariable();
			
		}
		
		
		public function layout( $layout ){
			$this->_helper->layout->setLayout( $layout );
		}
		
		public function assign( $spec, $value = null ){
			$this->view->assign($spec , $value);
		}
		
		public function success( $info = null ){
			$hasWfAjax = $this->_helper->hasHelper( 'WfAjax' );
			if( $hasWfAjax ){
				$this->_helper->wfAjax->success( $info );
			}
		}
		
		public function error( $info = null ){
			$hasWfAjax = $this->_helper->hasHelper( 'WfAjax' );
			if( $hasWfAjax ){
				$this->_helper->wfAjax->error( $info );
			}
		}
		
		public function pagination( $count , $size , $router = null , $className = null , $pageNoKey = null ){
			
			$request = $this->_request;
			$view	 = $this->view;

			$pageNav = new WeFlex_Pagination($count , $size , $request , $view , $router , $className , $pageNoKey );
			$html = $pageNav->show();
			return $html;
			
		}
		
		public function paginationNo( $pageNoKey = null ){
			
			if( $pageNoKey ){
				$pageNo = $this->_request->getParam( $pageNoKey );
			}else{
				$pageNo = $this->_request->getParam( WeFlex_Pagination::DEFAULT_PAGENO_KEY );
			}
			if( empty( $pageNo ) ){
				$pageNo = 1;
			}
			
			return $pageNo;
			
			
		}
		
		public function redirect( $action, $controller = null, $module = null, array $params = array() ){
			$this->_helper->redirector->gotoSimple( $action , $controller, $module, $params );
		}
		
		/**
		 * redirect to a external url
		 * @param string $url
		 */
		public function redirectUrl( $url ){
			$this->_helper->redirector->gotoUrl($url);
		}
		
		/**
		 * translate quick using
		 */
		public function _($messageId, $locale = null){
			
			if( $this->view->translate ){
				return $this->view->translate->_( $messageId, $locale);
			}else{
				return $messageId;
			}
		}
		
		/**
		 * add js file
		 */
		
		public function appendJs($file){
			
			$usingMergeJs = false;
			if( WeFlex_Application::GetInstance()->config->js && WeFlex_Application::GetInstance()->config->js->compress ){
				$usingMergeJs = WeFlex_Application::GetInstance()->config->js->compress;
			}
			
			if( !$usingMergeJs ){
				$this->view->headScript()->appendFile( $this->view->baseUrl() 	.'/' . $file, 	'text/javascript');
			}
		}
		
		public function title($title){
			 $this->view->headTitle( $title );
		}
		
		/**
		 * add js file
		 */
		
		public function jsonDecode($json){
			return Zend_Json::decode( $json );
		}
		
		public function jsonEncode( $array ){
			return Zend_Json::encode( $array );
		}
		
		
		public function checkMethod( $method ){
			
			$method = strtoupper( $method );
	
			switch( $method ){
				
				case 'POST':
					$flag = $this->getRequest()->isPost();
					break;
				case 'GET':
					$flag = $this->getRequest()->isGet();
					break;
				case 'PUT':
					$flag = $this->getRequest()->isPut();
					break;
				case 'DELETE':
					$flag = $this->getRequest()->isDelete();
					break;
				default:
					throw new Exception( 'No Support Http Method' );
					break;
				
			}
			
			if( !$flag ){	
				throw new Exception("This request need http method :" . $method );
			}
			
			
			
		}
		
		
		private function _renderGlobalVariable(){
	    	
	    	$this->assign( 'action' , $this->_getParam( 'action' ) );
	    	$this->assign( 'controller' , $this->_getParam( 'controller' ) );
	    	$this->assign( 'module' , $this->_getParam( 'module' ) );
	    	
	    }
	    
	    protected function _getFilterParams(){
	    	
	    	$data = $this->_getAllParams();
	    	unset( $data['controller'] );
	    	unset( $data['action'] );
	    	unset( $data['module'] );
	    	
	    	return $data;
	    	
	    	
	    }
		
		
	}

?>