<?php
	include "config.php";

	if(array_key_exists('edit', $_POST)) { 
		edit_data(); 
	} 
	if(isset($_POST['cancel'])) {
		header('Location: bankbook.php');
	}
	function edit_data() {
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

		$user_id = $_SESSION['user_id'];
		
		for($i = 0; $i < 7; $i++) {
			//edit username
			if($i == 0 && $s_username != "") {
				if(is_string($s_username)) {
					$sql = "UPDATE users SET username = '$s_username' where user_id = '$user_id'";
					if(mysqli_query($conn, $sql)) {
						//echo "Edit successful";
						$_SESSION['username'] = $s_username;
					} 
					else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
				else {
					echo "Please follow correct format for Username.\n";
				}
			}
			//edit password
			elseif($i == 1 && $s_password != "") {
				if(is_string($s_password)) {
					$sql = "UPDATE users SET bb_password = '$s_password' where user_id = '$user_id'";
					if(mysqli_query($conn, $sql)) {
						//echo "Edit successful";
					} 
					else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
				else {
					echo "Please follow correct format for Password.\n";
				}
			}
			//edit current balance
			elseif($i == 2 && $curr_bal != "") {
				if (is_numeric($curr_bal)) {
					$sql = "UPDATE users SET curr_bal = '$curr_bal' where user_id = '$user_id'";
					if(mysqli_query($conn, $sql)) {
						//echo "Edit successful";
					} 
					else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
				else {
					echo "Please follow correct format for Current Balance.\n";
				}
			}
			//edit interest rate
			elseif($i == 3 && $int_rate != "") {
				if( is_numeric($int_rate) ) {
					$sql = "UPDATE users SET intrst_rate = '$int_rate' where user_id = '$user_id'";
					if(mysqli_query($conn, $sql)) {
						//echo "Edit successful";
					} 
					else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
				else {
					echo "Please follow correct format for Interest Rate.\n";
				}
			}
			//edit minimum amount to trigger interest rate
			elseif($i == 4 && $min_amnt != "") {
				if( is_numeric($min_amnt)) {
					$sql = "UPDATE users SET amnt_for_intrst = '$min_amnt' where user_id = '$user_id'";
					if(mysqli_query($conn, $sql)) {
						//echo "Edit mnamnt successful";
					} 
					else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
				else {
					echo "Please follow correct format for Minimum Amount for Interest.\n";
				}
			}
			//edit whether increase is monthly or yearly
			elseif($i == 5 && $increase != "") {
				if( is_string($increase)) {
					$sql = "UPDATE users SET when_to_increase = '$increase' where user_id = '$user_id'";
					if(mysqli_query($conn, $sql)) {
						//echo "Edit successful";
					} 
					else {
						echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
					}
				}
				else {
					echo "Please follow correct format for Monthly/Yearly Increase.\n";
				}
			}
			//edit date of account creation
			elseif($i == 6 && $date != "") {
				$sql = "UPDATE users SET date_of_increase = '$date' where user_id = '$user_id'";
				if(mysqli_query($conn, $sql)) {
					//echo "Edit successful";
				} 
				else {
					echo "Please follow correct format for date";
				}
			}
		}
	}

	if ($conn->connect_error)
   		die("Connection Failed");

	//echo "Database Connection Successful!";


?>
<html>
	<head>
		<title>MyBankBook Edit Page</title>
		<link rel="stylesheet" type="text/css" href="signup.css">
	</head>
	<body>
		<p class = "title"> Edit My Info </p>
		<div class = "content">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class = "prmpt"> Username: <input type = "text" name = "s_username" class = "prompt" placeholder = "username"> </div>
					<div class = "prmpt"> Password: <input type = "password" name = "s_password" class = "prompt" > </div>
					<div class = "prmpt"> Current Balance: <input type = "text" name = "curr_bal" class = "prompt" placeholder = "Current Balance"> </div>
					<div class = "prmpt"> Interest Rate: <input type = "text" name = "int_rate" class = "prompt" placeholder = "Number only without %"> </div>
					<div class = "prmpt"> Minimum Amount for Interest: <input type = "text" name = "min_amnt" class = "prompt" placeholder = "2000"> </div>
					<div class = "prmpt"> Yearly/Monthly Increase: <input type = "text" name = "increase" class = "prompt" placeholder = "Monthly"> </div>
					<div class = "prmpt"> Date Account was made: <input type = "text" name = "date" class = "prompt" placeholder = "2020-12-25"> </div>
					<div class = "button"> 
						<input type = "submit" name = "edit" value = "Confirm"> 
						<input type = "submit" name = "cancel" value = "Go Back to BankBook">
					</div>
			</form>
			
		</div>
	</body>
</html>