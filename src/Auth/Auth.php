<?php
namespace ContaAzul\Auth;
use ContaAzul\Helpers\ApiRequests;

class Auth{
	private $request;
	private $apiRequest;
	
	public function __construct($request){
	
		$this->request=$request;
		$this->apiRequest=new ApiRequests($request->authHeader);

	}
	
	public function getToken(){

		$params=["grant_type"=>"authorization_code",
							 "redirect_uri"=>$this->request->redirect_uri,//$_SERVER['SCRIPT_URI'],
							 "code"=>$this->request->authCode
							];
			$getToken=$this->apiRequest->post("oauth2/token",$params);
			return json_decode($getToken);
		
// 			if(isset($getToken->access_token)):
// 				$this->setAccessToken($getToken->access_token);
// 				$this->setExpiresIn($getToken->expires_in);
// 				$this->setRefreshToken($getToken->refresh_token);
// 				$this->setDRegister(date("Y-m-d H:i:s"));
// 			endif;
// 			return $getToken;
	}
	
	public function refreshToken($resfreh_token){
			$params=["grant_type"=>"refresh_token",//$_SERVER['SCRIPT_URI'],
							 "refresh_token"=>$resfreh_token
							];
			
			$getToken=$this->apiRequest->post("oauth2/token",$params);
		return json_decode($getToken);
	}
}