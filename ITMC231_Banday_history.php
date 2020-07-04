<?php
	include "ITMC231_Banday_config.php";

	if(isset($_POST['back'])) {
		header('Location: ITMC231_Banday_banknote.php');
	}
	
	if(isset($_POST['remove'])) {
		$transaction_id = $_POST['tr_id'];
		$rem_sql = "DELETE FROM transactions WHERE transaction_id = $transaction_id";

		if(mysqli_query($conn, $rem_sql)) {
			echo "Removal successful";
		} 
		else {
			echo "ERROR: Could not able to execute $trans_sql. " . mysqli_error($conn);
		}
	}
?>
<html>
	<head>
		<title>MyBankNote History</title>
		<link rel="stylesheet" type="text/css" href="ITMC231_Banday_history.css">
	</head>
	<body>
		<p class = "title"> MyHistory </p>
		<p> *Note: If a transaction is missing it is deleted* </p>
		<form method = "post" action = "" class = "button">
			<input type = "submit" class = "button" name = "back" value = "Back to BankBook">
		</form>
		<form method = "post" action = "" class = "button">
			<input type = "text" name = "tr_id" placeholder = "Transaction ID">
			<input type = "submit" name = "remove" value = "Remove">
		</form>
		<?php 
			$server = "localhost";
			$username = "root";
			$password = "";
			$dbname = "bankbookdb";
			$mysqli = new mysqli($server, $username, $password, $dbname); 
			$query = "SELECT * FROM transactions ORDER BY transaction_id DESC";
			
			
			echo '<table border="1" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #FFFFFF;" width = "1000px"> 
				<tr> 
					<td style = "width: 100px"> Transaction ID </td>
					<td style = "width: 300px"> Balance Before </td> 
					<td style = "width: 200px"> Amount Increased/Decreased </td> 
					<td style = "width: 300px"> Balance After </td> 
					<td style = "width: 100px"> Date Accomplished </td>
				</tr>';
			
			if ($result = $mysqli->query($query)) {
				while ($row = $result->fetch_assoc()) {
					if($row["user_id"] == $_SESSION["user_id"]) {
						$trans_id = $row["transaction_id"];
						$prebal = $row["pre_bal"];
						$incr_decr = $row["balance_edit"];
						$postbal = $row["post_bal"];
						$date_acc = $row["trans_date"];
				
						echo '<tr> 
								<td style="width: 500px">'.$trans_id.'</td>
								<td style="width: 500px"> PHP '.$prebal.'</td> 
								<td style="width: 200px">'.$incr_decr.'</td> 
								<td style="width: 500px"> PHP '.$postbal.'</td> 
								<td style="width: 200px">'.$date_acc.'</td> 
							</tr>';
					}
				}
				$result->free();
			} 
		?>
	</body>
</html>