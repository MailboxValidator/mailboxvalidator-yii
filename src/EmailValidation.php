<?php 
namespace MailboxValidator;

class SingleValidation {
	private $apikey = '';
	private $apiurl = 'http://api.mailboxvalidator.com/v1/validation/single';
	private $apiurl2 = 'http://api.mailboxvalidator.com/v1/email/disposable';
	private $apiurl3 = 'http://api.mailboxvalidator.com/v1/email/free';
	
	public function __construct($key) {
		$this->apikey = $key;
	}
	
	public function __destruct() {
	
	}
	
	public function validateEmail($email) {
		try{
			$params = [ 'email' => $email, 'key' => $this->apikey, 'format' => 'json', 'source' => 'yii' ];
			$params2 = [];
			foreach($params as $key => $value) {
				$params2[] = $key . '=' . rawurlencode($value);
			}
			$params = implode('&', $params2);
			
			$results = file_get_contents($this->apiurl . '?' . $params);
			
			if ($results !== false) {
				return json_decode($results);
			}
			else {
				return false;
			}
		}
		catch(Exception $e) {
			return false;
		}
	}
	
	public function disposableEmail($email) {
		try{
			$params = [ 'email' => $email, 'key' => $this->apikey, 'format' => 'json', 'source' => 'yii' ];
			$params2 = [];
			foreach($params as $key => $value) {
				$params2[] = $key . '=' . rawurlencode($value);
			}
			$params = implode('&', $params2);
			
			$results = file_get_contents($this->apiurl2 . '?' . $params);
			
			if ($results !== false) {
				return json_decode($results);
			}
			else {
				return false;
			}
		}
		catch(Exception $e) {
			return false;
		}
	}
	
	public function freeEmail($email) {
		try{
			$params = [ 'email' => $email, 'key' => $this->apikey, 'format' => 'json', 'source' => 'yii' ];
			$params2 = [];
			foreach($params as $key => $value) {
				$params2[] = $key . '=' . rawurlencode($value);
			}
			$params = implode('&', $params2);
			
			$results = file_get_contents($this->apiurl3 . '?' . $params);
			
			if ($results !== false) {
				return json_decode($results);
			}
			else {
				return false;
			}
		}
		catch(Exception $e) {
			return false;
		}
	}
}
?>