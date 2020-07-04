<?php
	include "config.php";
	$user_id = $_SESSION['user_id'];
	// Check user login or not
	if(!isset($_SESSION['username'])) {
		header('Location: login.php');
	}

	// logout
	if(isset($_POST['logout'])) {
		session_destroy();
		header('Location: login.php');
	}
	//edit user info
	if(isset($_POST['edit'])) {
		header('Location: edit.php');
	}
	//check past transactions
	if(isset($_POST['history'])) {
		header('Location: history.php');
	}
	//calculate the balance of the user after a certain amount of months or years in accordance to their interest rate
	if(isset($_POST['calc_intrst'])) {
		header('Location: calc.php');
	}

	if(isset($_POST['withdraw'])) {
		$curr_bal = $_SESSION['balance'];
		$pre_bal = $curr_bal;
		$withdrawn_amnt = $_POST['wd_field'];

		$curr_bal = $curr_bal - $withdrawn_amnt;
		$_SESSION['balance'] = $curr_bal;
		$sql = "UPDATE users SET curr_bal = '$curr_bal' where user_id = '$user_id'";

		$balance_edit = "-".$withdrawn_amnt;
		$post_bal = $curr_bal;
		$trans_date = date('Y/m/d');
		$trans_sql = "INSERT INTO transactions (user_id, pre_bal, balance_edit, post_bal, trans_date) VALUES ('$user_id', '$pre_bal', '$balance_edit', '$post_bal', '$trans_date')";

		if(mysqli_query($conn, $sql)) {
			//echo "Withdrawal successful";
		} 
		else {
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
		}

		if(mysqli_query($conn, $trans_sql)) {
			//echo "Transfer successful";
		} 
		else {
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
		}
	}
	elseif(isset($_POST['deposit'])) {
		$curr_bal = $_SESSION['balance'];
		$pre_bal = $curr_bal;
		$deposited_amnt = $_POST['dp_field'];

		$curr_bal = $curr_bal + $deposited_amnt;
		$_SESSION['balance'] = $curr_bal;
		$sql = "UPDATE users SET curr_bal = '$curr_bal' where user_id = '$user_id'";

		$balance_edit = "+".$deposited_amnt;
		$post_bal = $curr_bal;
		$trans_date = date('Y/m/d');
		$trans_sql = "INSERT INTO transactions (user_id, pre_bal, balance_edit, post_bal, trans_date) VALUES ('$user_id','$pre_bal', '$balance_edit', '$post_bal', '$trans_date')";

		if(mysqli_query($conn, $sql)) {
			//echo "Deposit successful";
		} 
		else {
			echo "ERROR: Could not able to execute $trans_sql. " . mysqli_error($conn);
		}

		if(mysqli_query($conn, $trans_sql)) {
			//echo "Transfer successful";
		} 
		else {
			echo "ERROR: Could not able to execute $trans_sql. " . mysqli_error($conn);
		}
	}
	elseif(isset($_POST['intrst_incrs'])) {
		$curr_bal = $_SESSION['balance'];
		$pre_bal = $curr_bal;
		$intrst_rate = $_SESSION['intrst_rate'];

		$bal_query = "select amnt_for_intrst as amnt_for_intrst from users where username='".$_SESSION['username']."'";
		$result = mysqli_query($conn,$bal_query);
		$row = mysqli_fetch_assoc($result);
		$min_amnt = $row['amnt_for_intrst'];
		$_SESSION['min_amnt'] = $min_amnt;

		if($curr_bal >= $_SESSION['min_amnt']) {
			$curr_bal = $_SESSION['balance'];
			$increment = $curr_bal * ($intrst_rate / 100);
			$curr_bal = $curr_bal + $increment;
			$_SESSION['balance'] = $curr_bal;
			$sql = "UPDATE users SET curr_bal = '$curr_bal' where user_id = '$user_id'";

			$balance_edit = "+".$increment;
			$post_bal = $curr_bal;
			$trans_date = date('Y/m/d');
			$trans_sql = "INSERT INTO transactions (user_id, pre_bal, balance_edit, post_bal, trans_date) VALUES ('$user_id','$pre_bal', '$balance_edit', '$post_bal', '$trans_date')";


			if(mysqli_query($conn, $sql)) {
				//echo "Deposit successful";
			} 
			else {
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
			}

			if(mysqli_query($conn, $trans_sql)) {
				//echo "Transfer successful";
			} 
			else {
				echo "ERROR: Could not able to execute $trans_sql. " . mysqli_error($conn);
			}
		}
		else {
			$insuf_bal = "You do not have sufficient balance to increase through interest rate. (Press OK to go back)";
			echo "<script type='text/javascript'>alert('$insuf_bal');</script>";
		}
	}
	
	$bal_query = "select curr_bal as curr_bal from users where username='".$_SESSION['username']."'";
	$result = mysqli_query($conn,$bal_query);
	$row = mysqli_fetch_assoc($result);
	$curr_bal = $row['curr_bal'];
	$_SESSION['balance'] = $curr_bal;


?>
<html>
	<head>
		<title>MyBankBook Home</title>
		<link rel="stylesheet" type="text/css" href="bankbook.css">
		<script>
			function show_deposit_field() {
				document.getElementById("dp_field").type = "text";
				document.getElementById("deposit").type = "submit";
				document.getElementById("show_dep").type = "hidden";
			}
			function show_withdraw_field() {
				document.getElementById("wd_field").type = "text";
				document.getElementById("withdraw").type = "submit";
				document.getElementById("show_with").type = "hidden";
			}
		</script>
	</head>
	<body>
		<form method = "post" action = "" class = "navbar">
			<img src="b.png" class = "logo" alt="MyBankBook">
			<input type = "submit" name = "logout" id = "logout" value = "Logout">
			<input type = "submit" id = " edit" name = "edit" value = "Edit">
			<input type = "submit" id = "history" name = "history" value = "History">
			<input type = "submit" name = "calc_intrst" value = "Calculate Balance By Interest Rate"> 
		</form>

		<div class = "content">
			<p class = "title"> 
				<?php 
					echo $_SESSION['username']."'s BankBook";
				?> 
			</p>
			<div class = "data"> 
				<p id = "header">Your Current Balance Is:</p> 
				<div id = "balance"> 
					<?php
						echo 'PHP '.number_format($_SESSION['balance'],2,".",",")
					?>
				</div> 
			</div>
			<div class = "wd_dp_ir">
				<form method = "post" action = "" class = "button">
					<input type = "hidden" id = "wd_field" name = "wd_field" placeholder = "Amount to withdraw">
					<input type = "hidden" id = "withdraw" name = "withdraw" value = "Withdraw" onclick = "show_withdraw_field()">
					<input type = "button" id = "show_with" value = "Show Withdraw" onclick = "show_withdraw_field()">
				</form>

				<form method = "post" action = "" class = "button">
					<input type = "hidden" id = "dp_field" name = "dp_field" placeholder = "Amount to deposit">
					<input type = "hidden" id = "deposit" name = "deposit" value = "Deposit" onclick = "show_deposit_field()">
					<input type = "button" id = "show_dep" value = "Show Deposit" onclick = "show_deposit_field()"> 
				</form>
				
				<form method = "post" action = "" class = "button">
					<input type = "submit" name = "intrst_incrs" value = "Add Balance by Interest" onclick = "return confirm('Do you want to increase balance through interest? If cancel button does not work wait for a few seconds before clicking');"> 
				</form>

				
			</div>
		</div>
	</body>
</html>