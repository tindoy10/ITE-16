<?php

@include 'config.php';

session_start();

if(isset($_POST['login'])){

   $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
   $pass = md5($_POST['password']);

   $error = array();

    if (empty($user_id)) {
        $error[] = "Student ID is required.";
    }

    if (empty($pass)) {
        $error[] = "Password is required.";
    }

   $select = " SELECT * FROM users WHERE user_id = '$user_id' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'instructor'){

         $_SESSION['instructor_name'] = $row['user_id'];
         header('location:admin_index.php');

      }elseif($row['user_type'] == 'student'){

         $_SESSION['student_name'] = $row['user_id'];
         header('location:user_index.php');

      }
     
   }else{
      $error[] = 'Incorrect email or password!';
   }

}

elseif(isset($_POST['register'])){

	$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = md5($_POST['password']);
	$cpass = md5($_POST['cpassword']);
	$user_type = $_POST['user_type'];

	$error = array();

    if (empty($user_id)) {
        $error[] = "Student ID is required.";
    }

    if (empty($email)) {
        $error[] = "Email is required.";
    }

    if (empty($pass)) {
        $error[] = "Password is required.";
    }

    if (empty($cpass)) {
        $error[] = "Confirm Password is required.";
    }

 
	$select = " SELECT * FROM users WHERE user_id = '$user_id' && password = '$pass' ";
 
	$result = mysqli_query($conn, $select);
 
	if(mysqli_num_rows($result) > 0){
 
	   $error[] = 'User already exist!';
 
	}else{
 
	   if($pass != $cpass){
		  $error[] = 'Passwords do not match.';
	   }else{
		  $insert = "INSERT INTO users(user_id, email, password, user_type) VALUES('$user_id','$email','$pass','$user_type')";
		  mysqli_query($conn, $insert);
		  echo '<script type="text/JavaScript"> 
			container.classList.remove("right-panel-active");
			</script>';
	   }
	}
 
 }

if (isset($error) && count($error) > 0) {
	echo '<div class="error-container">';
	foreach ($error as $errorMsg) {
	echo '<div class="error-msg">' . $errorMsg . '</div>';
	}
	echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="css/form.css">

</head>
<body>
	<div id="particles-js"></div>

	<div class="container" id="container">

		<div class="form-container sign-up-container">
			<form action="" method="post">
				<h1>Create Account</h1>
				<input type="text" name="user_id" placeholder="ID" required/>
				<input type="email" name="email" placeholder="Email" required/>
				<input type="password" name="password" placeholder="Password" required/>
				<input type="password" name="cpassword" placeholder="Confirm Password" required/>
				<select class="userType" name="user_type">
					<option value="instructor">Instructor</option>
					<option value="student">Student</option>
				</select>
				<button type="submit" name="register">Sign Up</button>
			</form>
		</div>

		<div class="form-container sign-in-container">
			<form action="" method="post">
				<h1>Sign in</h1>
				<input type="text" name="user_id" placeholder="ID"  required/>
				<input type="password" name="password" placeholder="Password"  required/>
				<a href="#">Forgot your password?</a>
				<button type="submit" name="login">Sign In</button>
			</form>
		</div>

		<div class="overlay-container">

			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Hello!</h1>
					<p>Enter your personal details and start journey with us</p>
					<button class="ghost" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Welcome Back!</h1>
					<p>To keep connected with us please login with your personal info</p>
					<button class="ghost" id="signUp">Sign Up</button>
				</div>
			</div>
			
		</div>
	</div>
	<script src="js/particles.js"></script>
	<script src="js/app.js"></script>
	<script src="js/form.js"></script>
</body>
</html>