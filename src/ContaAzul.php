<?php
namespace ContaAzul;

use ContaAzul\Helpers\Helpers;
use ContaAzul\Helpers\ApiRequests;
use ContaAzul\Auth\Auth;

class ContaAzul
{
	public $client_id;
	public $client_secret;
	public $redirect_uri;
	public $auth_endpoint;
	public $scope;
	public $state;
	public $apiRequest;
	public $authHeader;
	public $authCode;
	public $access_token;
	public $expires_in;
	public $refresh_token;
	public $date_register;
	
    

public function __construct($client_id,$client_secret,$redirect_uri,$scope,$state)
{ 
	$this->client_id = $client_id;
	$this->client_secret = $client_secret;
	$this->redirect_uri = $redirect_uri;
	$this->scope = $scope;
	$this->state = $state;
	$this->authHeader=["Authorization: Basic ".base64_encode($client_id.":".$client_secret)];
}
		
public function requestToken($code){
	$this->authCode=$code;
	$auth=new Auth($this);
	$token=$auth->getToken();
	return $token;

}
public function requestRefreshedToken($resfreh_token){
	$auth=new Auth($this);
	$token=$auth->refreshToken($resfreh_token);
	return $token;
}

public function request($endpoint,$parametros,$token,$type){
	$apiRequest=new apiRequests(["Authorization: Bearer $token"]);
	return $apiRequest->{$type}($endpoint,$parametros);
}
}

?>
