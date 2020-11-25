<?php
namespace ContaAzul\Helpers;


class ApiRequests{
  
	private $headers;
	private $baseUrl;
	
	public function __construct($headers){
 		$this->setHeader($headers);
 		$this->baseUrl="https://api.contaazul.com/";

	}

	public function setHeader($header){
		$this->headers=$header;
	}
	
	public function getHeader(){
		return $this->headers;
	}
	
	public function get($endpoint,$parametros){	
		$parametros=http_build_query($parametros);
		$url_feed=$this->baseUrl.$endpoint."?".$parametros; 
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL,$url_feed);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch , CURLOPT_HTTPHEADER, $this->getHeader());
		$result=json_decode(curl_exec($ch),true) ;
		curl_close($ch);
		Helpers::isJson($result)==0 ? $result = json_decode($result) :null;
		return $result;
	}
	

	public function post($endpoint,$parametros){

			$url_feed=$this->baseUrl.$endpoint;
			
			$curlp = curl_init(); 
			curl_setopt_array($curlp, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url_feed,
			 // CURLOPT_USERAGENT => 'Codular Sample cURL Request',
				CURLOPT_POST =>true,
				CURLOPT_POSTFIELDS => http_build_query($parametros),
				CURLOPT_VERBOSE=> true,
				CURLOPT_HTTPHEADER =>$this->getHeader()

			)); 
			// Send the request & save response to $resp
			$result = curl_exec($curlp);;
			curl_close($curlp);
			Helpers::isJson($result)==0 ? $result = json_decode($result) :null;
			return $result;
		//	return $resp;
	}
	
	public function postjson($endpoint,$parametros){
			$header=$this->headers;
			$header[]='Content-Type:application/json';
			$url_feed=$this->baseUrl.$endpoint;
			
			$curlp = curl_init(); 
			curl_setopt_array($curlp, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url_feed,
			 // CURLOPT_USERAGENT => 'Codular Sample cURL Request',
				CURLOPT_POST =>true,
				CURLOPT_POSTFIELDS => json_encode($parametros),
				CURLOPT_VERBOSE=> true,
				CURLOPT_HTTPHEADER =>$header

			)); 
			// Send the request & save response to $resp
			$result = curl_exec($curlp);;
			curl_close($curlp);
			Helpers::isJson($result)==0 ? $result = json_decode($result) :null;
			return $result;
		//	return $resp;
	}


	public function putjson($endpoint,$parametros){
			$header=$this->headers;
			$header[]='Content-Type:application/json';
			$url_feed=$this->baseUrl.$endpoint;

			$curlp = curl_init();
			curl_setopt_array($curlp, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url_feed,
			 // CURLOPT_USERAGENT => 'Codular Sample cURL Request',
				CURLOPT_POST =>true,
                CURLOPT_CUSTOMREQUEST => "PUT",
				CURLOPT_POSTFIELDS => json_encode($parametros),
				CURLOPT_VERBOSE=> true,
				CURLOPT_HTTPHEADER =>$header

			));
			// Send the request & save response to $resp
			$result = curl_exec($curlp);;
			curl_close($curlp);
			Helpers::isJson($result)==0 ? $result = json_decode($result) :null;
			return $result;
		//	return $resp;
	}

	public function put($endpoint,$parametros){

			$url_feed=$this->baseUrl.$endpoint;
		//echo http_build_query($parametros);die;
			$curlp = curl_init(); 
		// Set some options - we are passing in a useragent too here
			curl_setopt_array($curlp, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url_feed,
			 // CURLOPT_USERAGENT => 'Codular Sample cURL Request',
				CURLOPT_CUSTOMREQUEST => "PUT",
				CURLOPT_POSTFIELDS => http_build_query($parametros),
				CURLOPT_HTTPHEADER => $this->getHeader()
			)); 
			// Send the request & save response to $resp
		 $result = curl_exec($curlp);
		 curl_close($curlp);
		 Helpers::isJson($result)==0 ? $result = json_decode($result) :null;
		 return $result;
	}

	public function delete($endpoint,$parametros){

			$url_feed=$this->baseUrl.$endpoint;
		//echo http_build_query($dados);die;
			$curlp = curl_init(); 
		// Set some options - we are passing in a useragent too here
			curl_setopt_array($curlp, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url_feed,
			 // CURLOPT_USERAGENT => 'Codular Sample cURL Request',
				CURLOPT_CUSTOMREQUEST => "DELETE",
				CURLOPT_POSTFIELDS => http_build_query($parametros),
				CURLOPT_HTTPHEADER => $this->getHeader()

			)); 
			// Send the request & save response to $resp
		 $result = curl_exec($curlp);
		 curl_close($curlp);
		 Helpers::isJson($result)==0 ? $result = json_decode($result) :null;
		 return $result;
	}
  
}
