<?php
include('config.php');

if (Login::isLoggedIn()) {
	
	header('location: home.php');

} elseif(Login::cookieDey()) {

	Login::LogUserIn();
	header('location: home.php');	

}

if(isset($_POST['submit'])) {

	if(!empty($_POST['alum_email']) && !empty($_POST['alum_password'])) {

		$login = new Login($_POST['alum_email'], $_POST['alum_password']);
		if($login->verifyLogin()) {
			
			$login->LogUserIn();
			if(!empty($_POST['remember-me'])) {

				$login->keepUserLoggedIn();

			}
			header('location: home.php');

		} else echo "Incorrect Password";

	} else echo "Email and password cannot be empty";
}

?>
<form method="post" action="login.php" class="form-signin">

 <h2 class="form-signin-heading"><b class="glyphicon glyphicon-lock"></b> Please Log in</h2>
 <input type="text" class="form-control" placeholder="Email" name="alum_email" autofocus>
 <input type="password"  class="form-control" placeholder="password" name="alum_password">
 <label class="checkbox">
  <input type="checkbox" value="remember-me" name="signed_in"> Remember me
 </label>
 <button type="submit" class="btn btn-lg btn-ghost btn-block" name="submit">Sign in</button>
</form>
<a href="forgot_password.php" class="link-white">Forgot password?</a>
