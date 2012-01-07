<?php 
require_once "Adaptive/NVP_SampleConstants.php";

	class WeFlex_Api_Paypal_Adaptive{
		
		const API_ENDPOINT_DEVELOPMENT 	  = "https://svcs.sandbox.paypal.com/";
		const URL_PAYPAL_DEVELOPMENT	  = "https://www.sandbox.paypal.com/webscr&cmd=";
		
		
		const API_ENDPOINT_PRODUCTION = "https://svcs.paypal.com/";
		const URL_PAYPAL_PRODUCTION	  = "https://www.paypal.com/webscr&cmd=";
		
		
		
		
		private $_username;
		
		private $_password;   
		
		private $_signature;
		
		private $_subject;
		
		private $_token;
		
		private $_apiEndPoint;
		
		private $_urlPaypal;
		
		private $_appId;
		
		private $_deviceIp;
		
		
		
		public function __construct( $username , $password , $signature , $appId, $deviceIp, $evn = "production" , $subject = '' ){
			
			$this->_username = $username;
			$this->_password = $password;
			$this->_signature = $signature;
			$this->_appId     = $appId;
			$this->_deviceIp  = $deviceIp;
			
			
			switch( $evn ){
				
				case "production":
					$this->_apiEndPoint = self::API_ENDPOINT_PRODUCTION;
					$this->_urlPaypal   = self::URL_PAYPAL_PRODUCTION;
					break;
				case "development":
					$this->_apiEndPoint = self::API_ENDPOINT_DEVELOPMENT;
					$this->_urlPaypal   = self::URL_PAYPAL_DEVELOPMENT;
					
					break;
				default:
					throw new Exception("Nvp no evn");
				
			}
			
			
			
		}
		
		/**
		 * 
		 * Enter description here ...
		 * @param unknown_type $nvp (
		 * 
		 * "returnURL"
		 * "cancelURL"
		 * 
		 * ["receiverEmail"]
		 * 
		 * 
		 * )
		 */
		public function pay( $nvp ){
			

			$returnURL = $nvp["returnURL"];
			$cancelURL = $nvp["cancelURL"] ;
			$preapprovalKey="";
			//$senderEmail  = $nvp["senderEmail"];
			$request_array= array(
				Pay::$actionType => $nvp["actionType"],
				Pay::$cancelUrl  => $cancelURL,
				Pay::$returnUrl=>   $returnURL,
				Pay::$currencyCode  => $nvp['currencyCode'],
		
				Pay::$clientDetails_deviceId  => $nvp["clientDeviceId"],
				Pay::$clientDetails_ipAddress  => $nvp["clientIp"],
				Pay::$clientDetails_applicationId =>$nvp["appId"],
				RequestEnvelope::$requestEnvelopeErrorLanguage => 'en_US',
				Pay::$memo => $nvp["memo"],
				Pay::$feesPayer => $nvp["feesPayer"]
		
			);
		
			if(isset($nvp['receiverEmail']))
			{
				$i = 0;
				$j = 0;
				$k = 0;
		
				foreach ($nvp['receiverEmail'] as $value)
				{
						
					$request_array[Pay::$receiverEmail[$i]] = $value;
					$i++;
						
				}
				foreach ($nvp['receiverAmount'] as $value)
				{
						
					$request_array[Pay::$receiverAmount[$j]] = $value;
					$j++;
						
				}
				foreach ($nvp['primaryReceiver'] as $value)
				{
						
					$request_array[Pay::$primaryReceiver[$k]] = $value;
					$k++;
						
				}
			}
		
			if($preapprovalKey!= "")
			{
				$request_array[Pay::$preapprovalKey] = $preapprovalKey;
			}
			
//			if($senderEmail!= "")
//			{
//				$request_array[Pay::$senderEmail]  = $senderEmail;
//			}
		
			$nvpStr=http_build_query($request_array, '', '&');
		
			/* Make the call to PayPal to get the Pay token
			 If the API call succeded, then redirect the buyer to PayPal
			 to begin to authorize payment.  If an error occured, show the
			 resulting errors
			 */
		
			$resArray= $this->_hash_call('AdaptivePayments/Pay',$nvpStr);
			
			
			
			/* Display the API response back to the browser.
			 If the response from PayPal was a success, display the response parameters'
			 If the response was an error, display the errors received using APIError.php.
			 */
			$ack = strtoupper($resArray['responseEnvelope.ack']);
		
			if($ack!="SUCCESS"){
				
				$error = "";
				throw new Exception( serialize( $resArray ) );
				
			}
			else
			{
				
				$payKey=$resArray['payKey'];
				if(($resArray['paymentExecStatus'] == "COMPLETED" ))
				{
					$resArray["case"] = 1;
				}
				else if(($nvp["actionType"] == "PAY") && ($resArray['paymentExecStatus'] == "CREATED" ))
				{
					$resArray["case"] ="2";
						
				}
				else if(($preapprovalKey!=null ) && ($nvp['actionType']== "CREATE") && ($resArray['paymentExecStatus'] == "CREATED" ))
				{
					$resArray["case"] ="3";
				}
				else if(($nvp['actionType']== "PAY_PRIMARY"))
				{
					$resArray["case"] ="4";
						
				}
				else if(($nvp['actionType']== "CREATE") && ($resArray['paymentExecStatus'] == "CREATED" ))
				{
					$temp1=API_USERNAME;
					$temp2=str_replace('_api1.','@',$temp1);
					if($temp2==$_REQUEST["email"])
					{
						$resArray["case"] ="3";
					}
					else{
						$resArray["case"] ="2";
					}
				}
			}
			
			
			return $resArray;
			
			
			
		}
		
		public function redirect( $rtn ){
			
			if( $rtn["case"] == 2 ){
				$payPalURL = $this->_urlPaypal . '_ap-payment&paykey='.$rtn["payKey"];
				header("Location: ".$payPalURL);
				exit();
			}else{
				throw new Exception( "can't redirect to paypal" );
			}
			
		}
		
		public function paymentDetail( $payKey ){
			
			$request_array = array (
			"payKey" => $payKey,
			"requestEnvelope.errorLanguage"=> 'en_US'
			);
			
			$nvpStr=http_build_query($request_array, '', '&');
			$resArray=$this->_hash_call("AdaptivePayments/PaymentDetails",$nvpStr);
			
			
			return $resArray;
			
		}
		
		
		private function _hash_call($methodName,$nvpStr,$sandboxEmailAddress = '')
		{
			//declaring of global variables
			
			$URL= $this->_apiEndPoint .$methodName;
			//setting the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$URL);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
			//turning off the server and peer verification(TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
		    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
		   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
			//if(USE_PROXY)
			//curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT); 
		
			$headers_array = $this->_setupHeaders();
		    if(!empty($sandboxEmailAddress)) {
		    	$headers_array[] = "X-PAYPAL-SANDBOX-EMAIL-ADDRESS: ".$sandboxEmailAddress;
		    }
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
		    curl_setopt($ch, CURLOPT_HEADER, false);
			//setting the nvpreq as POST FIELD to curl
			curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpStr);
		
			
			//getting response from server
			$response = curl_exec($ch);
		 	
			//convrting NVPResponse to an Associative Array
			$nvpResArray= $this->_deformatNVP($response);
			//$nvpReqArray=deformatNVP($nvpreq);
			//$_SESSION['nvpReqArray']=$nvpReqArray;
		
			if (curl_errno($ch)) {
				throw new Exception(curl_error($ch));
				// moving to display page to display curl errors
			 } else {
				 //closing the curl
					curl_close($ch);
			  }
		
			return $nvpResArray;
		}
		
		
		private function _deformatNVP($nvpstr)
		{
		
			$intial=0;
		 	$nvpArray = array();
		
		
			while(strlen($nvpstr)){
				//postion of Key
				$keypos= strpos($nvpstr,'=');
				//position of value
				$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
		
				/*getting the Key and Value values and storing in a Associative Array*/
				$keyval=substr($nvpstr,$intial,$keypos);
				$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
				//decoding the respose
				$nvpArray[urldecode($keyval)] =urldecode( $valval);
				$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
		     }
			return $nvpArray;
		}
		
		
		
		private function _setupHeaders() {
		    $headers_arr = array();
		
			
		    $headers_arr[]="X-PAYPAL-SECURITY-SIGNATURE: ".$this->_signature;
			$headers_arr[]="X-PAYPAL-SECURITY-USERID:  ".$this->_username;
			$headers_arr[]="X-PAYPAL-SECURITY-PASSWORD: ".$this->_password;
			$headers_arr[]="X-PAYPAL-APPLICATION-ID: ".$this->_appId;
		    $headers_arr[] = "X-PAYPAL-REQUEST-DATA-FORMAT: "."NV";
		    $headers_arr[] = "X-PAYPAL-RESPONSE-DATA-FORMAT: " ."NV";
			$headers_arr[]="X-PAYPAL-DEVICE-IPADDRESS: ". $this->_deviceIp; 
			$headers_arr[]="X-PAYPAL-REQUEST-SOURCE: "."PHP_NVP_SDK_V1.1";
		
				
			return $headers_arr;
		  
		}
		
		
	}

?>