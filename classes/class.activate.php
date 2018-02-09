<?php
/**
* 
*/

class Activate extends Database {

	public $activationKey, $email, $details;

	function __construct($email, $activationKey)	{

		parent::__construct();
		$this->activationKey=$activationKey;
		$this->email=$email;

	}

	//this function checks if user has registered
	function userHasRegistered() {

		$db = parent::select("id")->from("temp_users")->where(array("email" => $this->email))->result();
		return($db->rowCount()==1)?TRUE:FALSE;

	}

	//this function checks if the registration key is correct
	function keyIsCorrect() {

		$db = parent::select("activation_key")->from("temp_users")->where(array("email" => $this->email))->result();

		$db->setFetchMode(PDO::FETCH_OBJ);

		$result = $db->fetch();
		return($result->activation_key==$this->activationKey)?TRUE:FALSE;

	}


	//this function gets user details from the temp table
	private function getDetails() {

		$db=parent::select("firstname,lastname,password,gender,date,class_of,email")->from("temp_users")->where(array("email" => $this->email))->result();

		$db->setFetchMode(PDO::FETCH_ASSOC);

		$this->details=$db->fetch();

	}

	//this function moves user details from the temp table to the permanent users table
	public function moveUserDetails() {

		$this->getDetails();

		$db=parent::insert($this->details,"users");
		return($db)?true:false;

	}

	//this function deletes user record from the temp table
	public function deleteUserFromTemp(){

		parent::delete("email",array($this->email),"temp_users");

	}

}

?>