<?php
/**
* 
*/
class Register extends Database {

	public $email, $firstname, $lastname, $password, $classOf, $gender, $activationKey;

	function __construct($email, $firstname, $lastname, $password, $gender, $classOf) {

		parent::__construct();
		$this->email=$email;
		$this->classOf = $classOf;
		$this->firstname=$firstname;
		$this->lastname=$lastname;
		$this->password=$password;
		$this->gender=$gender;
		
	}

	//this function checks if email exists in the temp_users table
	function tempEmailExists() {

		$db = parent::select("id")->from("temp_users")->where(array("email" => $this->email))->result();

		$db->setFetchMode(PDO::FETCH_OBJ);
		$result = $db->fetch();

		return($result=="")?false:true;

	}


	//this function checks if the username is already registered and validated
	function userExists() {

		$db = parent::select('id')->from('users')->where(array("email" => $this->email))->result();

		$db->setFetchMode(PDO::FETCH_OBJ);
		$result=$db->fetch();
		
		return($result=="")?false:true;

	}


	//this functions encrypts password
	function encryptPassword() {

		$password = password_hash($this->password, PASSWORD_DEFAULT);
		$this->password = $password;

	}


	//this function generates a key for temporary user
	public function generateActivationKey() {

		$randomno=rand(1,1000);
		$randomno2=rand(2000,3000);
		$emailHash=md5($this->email);
		$this->activationKey = substr(md5($randomno.$emailHash.$randomno2), 1,20);

	}



	//this function saves a user temporarily pending account activation
	public function saveTempUser() {
		$ip = $_SERVER['REMOTE_ADDR'];
		$ua = $_SERVER['HTTP_USER_AGENT'];
		$date = Datemanager::prefDate();
		$db = parent::insert(array("firstname" => $this->firstname,
							 "lastname" => $this->lastname,
							 "gender" => $this->gender,
							 "password" => $this->password,
							 "class_of" => $this->classOf,
							 "activation_key" => $this->activationKey,
							 "ip" => $ip,
							 "date" => $date,
							 "ua" => $ua,
							 "email" => $this->email), "temp_users");
	}

}
?>