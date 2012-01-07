<?php 
	class TCVM_Product_Image extends WeFlex_Image
	{
		
		function __construct(){
		
			$upload_url = TCVM::GetInstance()->config->product->image->upload_url;
			
			$resizes    = array();
			if( TCVM::GetInstance()->config->product->image->resize ){
				foreach( TCVM::GetInstance()->config->product->image->resize as $resize ){
					$resize_temp = explode( '|' , $resize );
					$resizes []= $resize_temp;
				}
			}
			
			parent::__construct( $upload_url , $resizes );
		}
		
		public function formal( $index , $tempUrl  ){
			
			$imageFileName = $this->_getImageFileName( $tempUrl );
			
			$tempImagePath = WeFlex_Application::GetInstance()->getPublicPath() . $tempUrl;
			$regularDir  = $this->_getRegularPath() . '/' .  $index . '/' ;
			$regularImagePath = $regularDir . $imageFileName;
			$regularImageUrl  = $this->_getRegularUrl() . '/' . $index . '/' . $imageFileName;
			
			$this->_mkDir($regularDir);
			$this->_copy ($tempImagePath , $regularImagePath );
			
			$this->_generStandard($regularImagePath);
			
			return $regularImageUrl;
			
		}
		
		
	}
?>