<?php
	include "config.php";

	if (isset($_SESSION['username'])) {
        if($_SESSION['username'] != "") {
			header('Location: banknbook.php');
		}
    }
	
	if(isset($_POST['login'])) {
		$username = mysqli_real_escape_string($conn,$_POST['l_user']);
		$password = mysqli_real_escape_string($conn,$_POST['l_password']);

		if ($username != "" && $password != "") {

			$query = "select count(*) as chckUser from users where username='".$username."' and bb_password='".$password."'";
			$result = mysqli_query($conn,$query);
			$row = mysqli_fetch_array($result);

			$count = $row['chckUser'];

			if($count > 0) {
				$_SESSION['username'] = $username;

				$id_query = "select user_id as user_id from users where username='".$_SESSION['username']."'";
				$result = mysqli_query($conn,$id_query);
				$row = mysqli_fetch_assoc($result);
				$user_id = $row['user_id'];
				$_SESSION['user_id'] = $user_id;

				$id_query = "select intrst_rate as intrst_rate from users where username='".$_SESSION['username']."'";
				$result = mysqli_query($conn,$id_query);
				$row = mysqli_fetch_assoc($result);
				$intrst_rate = $row['intrst_rate'];
				$_SESSION['intrst_rate'] = $intrst_rate;
				header('Location: bankbook.php');
			} 
			else {
				echo "Wrong Username or Password";
			}

		}
	}
	if(isset($_POST['l_signup'])) {
		header('Location: signup.php');
	}
	
	

?>
<html>
	<head>
		<title>MyBankBook Login Page</title>
		<link rel="stylesheet" type="text/css" href="index.css">
	</head>
	<body>
		<p class = "title"> My BankBook </p>
		<div class = "content">
			<p>Login</p>
			<form method = "post" action = "" >
				<div class = "prmpt"> Username: <input type = "text" name = "l_user" class = "prompt"> </div>
				<div class = "prmpt"> Password: <input type = "password" name = "l_password" class = "prompt"> </div>
				<div class = "button"> <input type = "submit" name = "login" value = "Login"> <input type = "submit" name = "l_signup" value = "Signup"> </div>
			</form>
		</div>
	</body>
</html>