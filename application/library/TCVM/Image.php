<?php 
	class TCVM_Image extends WeFlex_Image
	{
		
		function __construct(){
		
			$upload_url = '/upload';
			
			$resizes    = array();

			parent::__construct( $upload_url , $resizes );
		}
		
	}
?>