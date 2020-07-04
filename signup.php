<?php
	include "config.php";
	if (isset($_SESSION['username'])) {
        if($_SESSION['username'] != "") {
			header('Location: bankbook.php');
		}
    }
	if(isset($_POST['cancel'])) {
        $_SESSION['est_bal'] = 0;
		header('Location: login.php');
	}
	if(isset($_POST['s_signup'])) { 
		$server = "localhost";
		$username = "root";
		$password = "";
		$dbname = "bankbookdb";
		$conn = new mysqli($server, $username, $password, $dbname);
		$s_username = mysqli_real_escape_string($conn, $_REQUEST['s_username']);
		$s_password = mysqli_real_escape_string($conn, $_REQUEST['s_password']);
		$curr_bal = mysqli_real_escape_string($conn, $_REQUEST['curr_bal']);
		$int_rate = mysqli_real_escape_string($conn, $_REQUEST['int_rate']);
		$min_amnt = mysqli_real_escape_string($conn, $_REQUEST['min_amnt']);
		$increase = mysqli_real_escape_string($conn, $_REQUEST['increase']);
		$date = mysqli_real_escape_string($conn, $_REQUEST['date']);
		$sql = "INSERT INTO users (username, bb_password, curr_bal, intrst_rate, amnt_for_intrst, when_to_increase, date_of_increase) VALUES ('$s_username', '$s_password', '$curr_bal', '$int_rate', '$min_amnt', '$increase', '$date')";

		if(mysqli_query($conn, $sql) && $s_username != "" && is_string($s_username) && $s_password != "" && is_string($s_password) && $curr_bal != "" && is_numeric($curr_bal) && $int_rate != "" && is_numeric($int_rate) && $min_amnt != "" && is_numeric($min_amnt) && $increase != "" && is_string($increase) && $date != "" ) {
			//echo "Records added successfully.";
			$_SESSION['username'] = $s_username;

			$id_query = "select user_id as user_id from users where username='".$_SESSION['username']."'";
			$result = mysqli_query($conn,$id_query);
			$row = mysqli_fetch_assoc($result);
			$user_id = $row['user_id'];
			$_SESSION['user_id'] = $user_id;

			$bal_query = "select curr_bal as curr_bal from users where username='".$_SESSION['username']."'";
			$result = mysqli_query($conn,$bal_query);
			$row = mysqli_fetch_assoc($result);
			$curr_bal = $row['curr_bal'];
			$_SESSION['balance'] = $curr_bal;

			$id_query = "select intrst_rate as intrst_rate from users where username='".$_SESSION['username']."'";
			$result = mysqli_query($conn,$id_query);
			$row = mysqli_fetch_assoc($result);
			$intrst_rate = $row['intrst_rate'];
			$_SESSION['intrst_rate'] = $intrst_rate;

			header('Location: bankbook.php');
		} 
		else {
			$wrong_format = "Please don't leave an area blank and please follow correct format.";
			echo $wrong_format;
		} 
	}

	if ($conn->connect_error)
   		die("Connection Failed");

	//echo "Database Connection Successful!";

	

?>
<html>
	<head>
		<title>MyBankNote SignUp Page</title>
		<link rel="stylesheet" type="text/css" href="signup.css">
	</head>
	<body>
		<p class = "title"> Create My BankBook </p>
		<div class = "content">
			<p>SignUp</p>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class = "prmpt"> Username: <input type = "text" name = "s_username" class = "prompt" placeholder = "username"> </div>
				<div class = "prmpt"> Password: <input type = "password" name = "s_password" class = "prompt" > </div>
				<div class = "prmpt"> Current Balance: <input type = "text" name = "curr_bal" class = "prompt" placeholder = "Current Balance"> </div>
				<div class = "prmpt"> Interest Rate: <input type = "text" name = "int_rate" class = "prompt" placeholder = "Number only without %"> </div>
				<div class = "prmpt"> Minimum Amount for Interest: <input type = "text" name = "min_amnt" class = "prompt" placeholder = "2000"> </div>
				<div class = "prmpt"> Yearly/Monthly Increase: <input type = "text" name = "increase" class = "prompt" placeholder = "Monthly"> </div>
				<div class = "prmpt"> Date Account was made: <input type = "text" name = "date" class = "prompt" placeholder = "2020-12-25"> </div>
				<div class = "button"> <input type = "submit" name = "s_signup" value = "SignUp"> <input type = "submit" name = "cancel" value = "Cancel"></div>
			</form>
		</div>
	</body>
</html>