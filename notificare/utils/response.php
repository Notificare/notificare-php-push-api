<?php
/**
 * class for wrapping rest calls
 */

class HandlerApiRestResponse{
	protected $statusCode;
	protected $headers;
	protected $body;

	public function __construct($statusCode = null,$headers = null,$body = null){
		$this->statusCode = $statusCode;

		foreach($headers as $header){
			$exploded = explode(':', $header);

			if(count($exploded) > 2){
				$this->headers[array_shift($exploded)] = trim(implode(':',$exploded));
			}else if(count($exploded) > 1){
				$this->headers[array_shift($exploded)] = trim($exploded[0]);
			}else{
				$this->headers[] = trim($header);
			}
		}
		$this->body = $body;
	}

	public function getStatusCode(){
		return $this->statusCode;
	}

	public function setStatusCode($statusCode){
		$this->statusCode = $statusCode;
	}

	public function getHeaders(){
		return $this->headers;
	}

	public function setHeaders($headers){
		$this->headers = $headers;
	}

	public function getHeader($name){
		return $this->headers[$name];
	}

	public function getBody(){
		return $this->body;
	}

	public function setBody($body){
		$this->body = $body;
	}
}