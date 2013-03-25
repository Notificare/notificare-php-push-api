<?php
/**
 * $Id: utils/rest.php
 */
/**
 * A class to handle rest api calls
 *
 * @author Joel Oliveira <joel@notifica.re>
 *
 * @version 1.0
 * @copyright &copy; 2012-2013 Notificare
 */
class HandlerApiRest{
	/**
	 * the base url of the api
	 * @var string
	 */
	protected $baseUrl;
	/**
	 * the final url of the api
	 * @var string
	 */
	protected $translatedUrl;
	/**
	 * the resource URI to follow, use ':variablename' to identify pathparams in you're resource
	 * @var string
	 */
	protected $resource;
	/**
	 * the path parameters to use with the call
	 * @var array
	 */
	protected $pathParams;
	/**
	 * the query parameters to use with the call
	 * @var unknown_type
	 */
	protected $queryParams;
	/**
	 * the body entity to use with the call (only needed with POST or PUT methods)
	 * @var unknown_type
	 */
	protected $body;
	/**
	 * the method to use (GET,POST,PUT,DELETE)
	 * @var string
	 */
	protected $method;
	/**
	 * the handler to handle the response
	 * @var Object
	 */
	protected $handler;
	/**
	 * the stream to use for the call
	 * @var Object
	 */
	protected $stream;
	/**
	 * the response object of the call
	 * @var HandlerApiRestResponse
	 */
	protected $response;
	/**
	 * TODO set errors in response object
	 * the errors from response
	 */
	protected $errors;
	/**
	 * TODO set info in response object
	 * the info from response
	 */
	protected $info;
	/**
	 * the api username if requires authentication
	 * @var String
	 */
	protected $username;
	/**
	 * the api password if requires authentication
	 * @var String
	 */
	protected $password;
	/**
	 * the boolean used to specify if it is a test
	 * @var String
	 */
	protected $test;
	/**
	 * constructor
	 * @param $baseUrl string
	 */
	public function __construct($baseUrl = null){
		if(!is_null($baseUrl)){
			$this->setBaseUrl($baseUrl);
		}else{
			$this->setBaseUrl('https://push.notifica.re');
		}
		$this->test = false;
	}
	/**
	 * setter $this->baseUrl
	 * @param $baseUrl
	 */
	public function setBaseUrl($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	/**
	 * getter $this->baseUrl
	 * @return $this->baseUrl
	 */
	public function getBaseUrl(){
		return $this->baseUrl;
	}
	/**
	 * setter $this->resource
	 * @param $resource
	 */
	public function setResource($resource){
		$this->resource = $resource;
	}
	/**
	 * getter $this->resource
	 * @return unknown_type
	 */
	public function getResource(){
		return $this->resource;
	}
	/**
	 * setter $this->pathParams
	 * @param $pathParams
	 */
	public function setPathParams($pathParams){
		$this->pathParams = $pathParams;
	}
	/**
	 * getter $this->pathParams
	 * @return $this->pathParams
	 */
	public function getPathParams(){
		return $this->pathParams;
	}
	/**
	 * getter $this->translatedUrl
	 * @return $this->translatedUrl
	 */
	public function getTranslatedUrl(){
		return $this->translatedUrl;
	}
	/**
	 * setter $this->translatedUrl
	 * @param $url
	 */
	public function setTranslatedUrl($url){
		$this->translatedUrl = $url;
	}
	
	public function addQueryParam($key, $value){
		$this->queryParams[$key] = $value;
	}
	/**
	 * setter $this->queryParams
	 * @param $queryParams
	 */
	public function setQueryParams($queryParams){
		$this->queryParams = $queryParams;
	}
	/**
	 * getter $this->queryParams
	 * @return $this->queryParams
	 */
	public function getQueryParams(){
		return $this->queryParams;
	}
	/**
	 * setter $this->body
	 * @param $body
	 */
	public function setBody($body){
		$this->body = $body;
	}
	/**
	 * getter $this->body
	 * @return $this->body
	 */
	public function getBody(){
		return $this->body;
	}
	/**
	 * setter $this->method
	 * @param $method
	 */
	public function setMethod($method){
		$this->method = $method;
	}
	/**
	 * getter $this->method
	 * @return $this->method
	 */
	public function getMethod(){
		return $this->method;
	}
	/**
	 * setter $this->handler
	 * @param $handler
	 */
	public function setHandler(&$handler){
		$this->handler = $handler;
	}
	/**
	 * getter $this->handler
	 * @return $this->handler
	 */
	public function getHandler(){
		return $this->handler;
	}
	/**
	 * getter $this->stream
	 * @return $this->stream
	 */
	public function getStream(){
		return $this->stream;
	}

	public function initiate(){
		$this->stream = curl_init();
	}

	public function getErrors(){
		return $this->errors;
	}

	public function getInfo(){
		return $this->info;
	}
	
	public function setUsername($username){
		return $this->username = $username;
	}
	
	public function setPassword($password){
		return $this->password = $password;
	}
	
	public function setTest(){
		return $this->test = true;
	}

	public function call(){
		$this->initiate();

		if(!empty($this->pathParams) && !empty($this->resource)){
			$translatedResource = '';
			foreach($this->pathParams as $key => $value){
				$translatedResource = str_replace(':' . $key, $value, $this->resource);
			}
			$destinationUrl = $this->baseUrl . $translatedResource;
		}else if(!empty($this->resource)){
			$destinationUrl = $this->baseUrl . $this->resource;
		}else {
			$destinationUrl = $this->baseUrl;
		}
		if(!empty($this->queryParams)){
			$destinationUrl = $destinationUrl . '?' . http_build_query($this->queryParams);
		}
		
		if($this->username && $this->password){
			curl_setopt($this->stream, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		}
		
		if($this->body){
			$headers = array('Content-Type: application/json');
		}else{
			$headers = array();			
		}
		
		if($this->test){
			$headers = array('Content-Type: application/json','x-notificare-test: true');	
		}
		
		$this->setTranslatedUrl($destinationUrl);

		$options = array(
			CURLOPT_URL => $this->translatedUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => true,
			CURLOPT_USERAGENT => 'PH8 REST Client 0.01'
		);

		var_dump($options);
		curl_setopt_array($this->stream, $options);
		
		
		
		switch($this->method){
			case 'GET':
				curl_setopt($this->stream, CURLOPT_HTTPGET, true);
				break;
			case 'POST':
				curl_setopt($this->stream, CURLOPT_POST, true);
				curl_setopt($this->stream, CURLOPT_POSTFIELDS, json_encode($this->body));
				curl_setopt($this->stream, CURLOPT_HTTPHEADER,$headers);
				break;
			case 'PUT':
				curl_setopt($this->stream, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($this->stream, CURLOPT_POSTFIELDS, json_encode($this->body));
				curl_setopt($this->stream, CURLOPT_HTTPHEADER,$headers);

				break;
			case 'DELETE':
				curl_setopt($this->stream, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}

		$result = curl_exec($this->stream);
		$this->errors = curl_error($this->stream);
		$this->info = curl_getinfo($this->stream, CURLINFO_HEADER_OUT);
		$statuscode = curl_getinfo($this->stream, CURLINFO_HTTP_CODE);
		curl_close($this->stream);

		$splitted = preg_split('#\r?\n\s+#', $result);
		$this->response = new HandlerApiRestResponse($statuscode, preg_split('#\r?\n#',array_shift($splitted)), implode(' ', $splitted));
		
		if(!empty($this->handler)){
			$action = 'handle' . $this->method;
			$this->handler->$action($this->response, $this);
		}else{
			return $this->response;
		}
	}
}
?>