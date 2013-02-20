<?php
/**
 * $Id: notificare.php
 */
/**
 * A class to handle Notificare api calls
 *
 * @author Joel Oliveira <joel@notifica.re>
 *
 * @version 1.0
 * @copyright &copy; 2012-2013 Notificare
 */

require_once('utils/rest.php');
require_once('utils/response.php');

class NotificareApi extends HandlerApiRest {
	
	/**
	 * constructor
	 */
	public function __construct(){
		$this->setUsername('APPLICATION_KEY_HERE');
		$this->setPassword('APPLICATION_MASTERSECRET_HERE');
	}
	
	/**
	 * pushToUser
	 * Push to a specific user
	 * @param string $id
	 * @param array $body
	 */
	public function pushToUser($id,$body){
		$this->setResource("/notification/user/".$id);
		$this->setMethod("POST");
		$this->setBody($body);
		return $this->call();
	}

	/**
	 * pushToDevice
	 * Push to a specific device
	 * @param string $id
	 * @param array $body
	 */
	public function pushToDevice($id,$body){
		$this->setResource("/notification/device/".$id);
		$this->setMethod("POST");
		$this->setBody($body);
		return $this->call();
	}
	
	/**
	 * broadcast
	 * Push to all users and devices of an application
	 * @param array $body
	 */
	public function broadcast($body){
		$this->setResource("/notification/broadcast");
		$this->setMethod("POST");
		$this->setBody($body);
		return $this->call();
	}
}