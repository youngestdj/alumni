<?php
include('config.php');

if(!empty($_GET['email']) && !empty($_GET['activation_key'])) {

	$email = $_GET['email'];
	$activationKey = $_GET['activation_key'];

	$activate = new Activate($email, $activationKey);
	
	if($activate->userHasRegistered()) {

		if($activate->keyIsCorrect()) {

			$activate->moveUserDetails();
			$activate->deleteUserFromTemp();
			echo "Account activated successfully. Click here to log in";

		} else echo "Invalid activation code";
	
	} else echo "No pending accounts with this email was found";

}

?>