<?php 

include('config.php');

if(isset($_POST['ok'])){
		if(isset($_POST['regterms'])){
			$db=new Database();

			if(!empty($_POST['regfirst'])) {

				$firstname=ucfirst($_POST['regfirst']);

				if(!empty($_POST['reglast'])) {

					$lastname=ucfirst($_POST['reglast']);

					if(!empty($_POST['regemail']) && !empty($_POST['regpass'])) {

						$email = $_POST['regemail'];
						$gender = $_POST['gender'];
						$classOf = $_POST['class_of'];
						$password = $_POST['regpass'];

						$reg=new Register($email, $firstname, $lastname, $password, $gender, $classOf);

						if(!$reg->userExists()) {

							if(!$reg->tempEmailExists()) {

								$password=$reg->encryptPassword();
								$reg->generateActivationKey();
								$reg->saveTempUser();

	echo'<div class="alert alert-success">Registration Complete! Please go to your email and click the link supplied to activate your account!</div>';
							
						 #else echo "Email already exists.Please check your email for the activation link if you've not already activated your account!";
					} else echo '<div class="alert alert-warning">Account has not yet been activated!</div>';
					} else echo '<div class="alert alert-warning">Email already exists</div>';

				} else echo '<div class="alert alert-warning">All fields are required</div>';
			} else echo '<div class="alert alert-warning">Lastname is empty!</div>';
		} else echo '<div class="alert alert-warning">Firstname is empty!</div>';
	} else echo '<div class="alert alert-danger">You have to agree to the terms and conditions to create an account</div>';

}

?>


<form action="register.php" method="post" class="form-signin">
 <h1 class="form-signin-heading"> Register</h1>
 <input type="text" class="form-control" placeholder="First name" name="regfirst">
 <input type="text" class="form-control" placeholder="Last name" name="reglast">
 <input type="email" class="form-control" placeholder="Email" name="regemail">
 <input type="password" class="form-control" placeholder="password" name="regpass">
 
 <select name="class_of" class="form-control">
 <option>------ Class of ------</option>

 <?php 

 for($i=2011; $i<=date('Y'); $i++){

 	echo '<option value="'.$i.'">'.$i.'</option>';

 }
 	?>
</select>

<select name="gender" class="form-control">
 <option>------ Gender ------</option>
 <option value="Male">Male</option>
 <option value="Female">Female</option>
</select>

<label class="checkbox">
 I accept the terms and conditions <input type="checkbox" name="regterms" />
</label>

<button type="submit" class="btn btn-lg btn-ghost btn-block" name="ok">Create account</button>
</form>