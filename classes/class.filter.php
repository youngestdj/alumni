<?php

/**
* 
*/
class Filter {

	public $arg;

	function __construct($arg) {

		$this->arg=$arg;

	}

	//this function checks if the value entered is more than the required value
	public function moreThan($length) {

		return(strlen($this->arg)>$length)?true:false;

	}

	//this function checks if the value entered is less than the required value
	public function lessThan($length) {
	
		return(strlen($this->arg)<$length)?true:false;
	
	}

	// this function checks if user input is composed of only letters and numbers
	public function isAlphaNumeric() {
	
		return (preg_match('/^[A-Za-z0-9_]+$/',$this->arg))?true:false;
	
	}

	// this function checks if input is an email
	public function isEmail() {
	
		return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $this->arg) ? TRUE : FALSE;
 	
 	}
 	
 	//this function encrypts password
 	public static function encryptPassword($password) {
 	
 		$password=md5(($password),1,20);
 		return $password;
 	
 	}


}
	

?>