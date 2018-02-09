<?php
/**
* 
*/
class Login extends Database {

	public static $email;
	private $password;
	
	function __construct($email, $password) {
		
		parent::__construct();
		if (session_status() == PHP_SESSION_NONE)session_start();
		Login::$email = $email;
		$this->password=$password;

	}

	//this function checks if user is logged in
    static function isLoggedIn() {
    	if (session_status() == PHP_SESSION_NONE)session_start();
    	return(isset($_SESSION['alum_email']))?true:false;

    }

    public function verifyLogin() {

    	$db=parent::select("password")->from("users")->where(array("email" =>self::$email))->result();

   		$db->setFetchMode(PDO::FETCH_OBJ);
   		
   		if($result = $db->fetch()) {

   			return(password_verify($this->password, $result->password))?TRUE:FALSE;
   		
   		}
    	
    }

    static function logUserIn() {

    	$_SESSION['alum_email'] = self::$email;

    }

    private function getRank() {

    	$db=parent::select("rank")->from("users")->where(array("email" => self::$email));

   		$db->setFetchMode(PDO::FETCH_OBJ);

   		$result = $db->fetch();
   		return $result->rank;

    }


    static function isAnAdmin() {

    	$rank = self::getRank();
    	return($rank=="ADMIN")?TRUE:FALSE;

    }


    public function keepUserLoggedIn(){

    	setcookie("alum_email",self::$email,time()+60*60*24*30);

    }


    static function cookieDey() {

    	if(isset($_COOKIE['alum_email'])) {

    		self::$email = $_COOKIE['alum_email'];
    		return TRUE;

    	} else return FALSE;

    }


    static function logout() {

    	session_destroy();
    	if(self::cookieDey())
    		setcookie("alum_email", "", time()-3600);

    }


}
