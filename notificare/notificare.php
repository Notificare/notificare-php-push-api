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
		$this->setBaseUrl('https://push.notifica.re');
		$this->setUsername('YOUR_API_KEY_HERE');
		$this->setPassword('YOUR_MASTER_SECRET_HERE');
		/*
		 * Uncomment if you need your own CA certificate bundle, change the path to the 
		 * location of your CA bundle. You can use the one provided with this library.
		 */
		//$this->setCABundlePath('/PATH/TO/YOUR/CABUNDLE');
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
	/**
	 * registerDevice
	 * Regsiter a device
	 * @param array $body
	 */
	public function registerDevice($body){
		$this->setResource("/device");
		$this->setMethod("POST");
		$this->setBody($body);
		return $this->call();
	}
	
	/**
	 * getUsers
	 * Get all your users
	 */
	public function getUsers(){
		$this->setResource("/user");
		$this->setMethod("GET");
		return $this->call();
	}

	/**
	 * getUser
	 * Get a user details
	 * @param string $id
	 */
	public function getUser($id){
		$this->setResource("/user/foruserid/".$id);
		$this->setMethod("GET");
		return $this->call();
	}
	
	/**
	 * generateUserToken
	 * Generate a new user token
	 * @param string $user
	 */
	public function generateUserToken($user){
		$this->setResource("/user/foruserid/".$user);
		$this->setMethod("GET");
		return $this->call();
	}
	
	/**
	 * uploadFile
	 * Upload a file
	 * @param string $file
	 */
	public function uploadFile($file){
		$this->setResource("/upload");
		$this->setMethod("POST");
		$this->setFile($file);
		return $this->call();
	}
	
	/**
	 * uploadFile
	 * Upload a file
	 * @param string $file
	 */
	public function deleteFile($file){
		$this->setResource("/upload");
		$this->setMethod("POST");
		$this->setFile($file);
		return $this->call();
	}
	
}