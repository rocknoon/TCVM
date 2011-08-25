<?php 
	class WeFlex_Api_iTune{
		
		const API_VERIFY		 = "https://buy.itunes.apple.com/verifyReceipt";
		const API_VERIFY_SANDBOX = "https://sandbox.itunes.apple.com/verifyReceipt";
		
		private $_api_verify;
		
		public function __construct( $evn = "development" ){
			
			if( $evn == "production" ){
				$this->_api_verify = self::API_VERIFY;
			}else{
				$this->_api_verify = self::API_VERIFY_SANDBOX;
			}
			
			
		}
		
		public function verify( $receiptData ){
			
			// 1. 初始化
			$ch = curl_init();
			
			
			$postFields = '{"receipt-data" : "'.$receiptData.'"}';
			// 2. 设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $this->_api_verify);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postFields);
			
			// 3. 执行并获取HTML文档内容
			$output = curl_exec($ch);
			
			$output = WeFlex_Json::Decode( $output );
			
			
			if (curl_errno($ch)) {
				throw new Exception(curl_error($ch));
			} else {		
				curl_close($ch);
			}
			
			//parse output
			if( $output["status"] != 0 ){
				throw new Exception( $output["exception"] );
			}
			
			return $output['receipt'];
			
		}
		
	}
?>