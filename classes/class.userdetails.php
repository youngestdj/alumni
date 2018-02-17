<?php
/**
* 
*/
class Userdetails extends Database {

	public $firstname, $lastname, $avatar, $gender, $rank, $date, $classOf;
	
	function __construct($email) {
		
		parent::__construct();
		$db = parent::select("firstname, lastname, avatar, gender, rank, date, classOf")->from("users")->where(array('email' => $email))->result();

		$db->setFetchMode(PDO::FETCH_OBJ);
		$result = $db->fetch();

		$this->firstname = $result->firstname;
		$this->lastname = $result->lastname;
		$this->avatar = $result->avatar;
		$this->gender = $result->gender;
		$this->rank = $result->rank;
		$this->date = $result->date;
		$this->classOf = $result->class_of;

	}


	//this function returns the rank of a user
	public function getRank() {

		return $this->rank;

	}


	//this function returns the rank of a user
	public function getFirstname() {

		return $this->firstname;

	}


	//this function gets the last name of a user
	public function getLastname() {

		return $this->lastname;

	}


	//this function gets the avatar of a user
	public function getAvatar() {

		return $this->avatar;

	}


	public function getGender() {

		return $this->gender;

	}

	//this function returns the date user registered
	public function getDate() {
	
		return $this->date;
	
	}

	//this functions returns the year the user graduated
	public function getClassOf() {
	
		return $this->password;
	
	}

	
}