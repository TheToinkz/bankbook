<?php
	include "config.php";

	if(isset($_POST['back'])) {
		header('Location: bankbook.php');
	}
	
	if(isset($_POST['edit'])) {
		header('Location: edit.php');
	}
?>
<html>
	<head>
		<title>MyBankBook History</title>
		<link rel="stylesheet" type="text/css" href="signup.css">
	</head>
	<body>
		<p class = "title"> My Account </p>
		<form method = "post" action = "" >
				<input type = "submit" name = "edit" value = "Edit">
                <input type = "submit" name = "back" value = "Back to BankBook">
		</form>
		<div>
        <?php 
            $withdraw = 0;
            $deposit = 0;
            $total = 0;
            $transdate = date('Y-m-d', time());
            $current_month = date('m', strtotime($transdate));
            $trans_query = "SELECT * FROM transactions ORDER BY transaction_id DESC";
            if ($trans_result = $conn->query($trans_query)) {
				while ($trans_row = $trans_result->fetch_assoc()) {
                    $trans_date = $trans_row["trans_date"];
                    $trans_month = date('m', strtotime($trans_date));
                    if($trans_month == $current_month) {
                        if($trans_row["trans_type"] == "Withdraw") {
                            $withdraw++;
                            $total++;
                        }
                        elseif($trans_row["trans_type"] == "Deposit") {
                            $deposit++;
                            $total++;
                        }
                    }
                    else {
                        break;
                    }
                }
                $withdraw_percentage = ($withdraw/$total) * 100;
                $deposit_percentage = ($deposit/$total) * 100;
				$trans_result->free();
			} 
			$query = "SELECT * FROM users where user_id =" . $_SESSION['user_id'];
			if ($result = $conn->query($query)) {
                $row = $result->fetch_assoc();
                $user = $row["username"];
                $pass = $row["bb_password"];
                $curr_bal = $row["curr_bal"];
                $intrst_rate = $row["intrst_rate"];
                $amnt_for_intrst = $row["amnt_for_intrst"];
                $when_to_increase = $row["when_to_increase"];
                $date_of_increase = $row["date_of_increase"];
                echo '
                <script>
                    function show_password() {
                        document.getElementById("user_pass").style.display = "";
                        document.getElementById("hide_pass").type = "button";
                        document.getElementById("show_pass").type = "hidden";
                    }
                    function hide_password() {
                        document.getElementById("user_pass").style.display = "none";
                        document.getElementById("hide_pass").type = "hidden";
                        document.getElementById("show_pass").type = "button";
                    }
                </script>
                <table border = "1px" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #fffef0; border: solid 1px black;" width = "1000px" height = "350px">
                    <tr>
                        <td>
                            <table border = "1px" cellspacing="2" cellpadding="2" align = "center" style = "background: #fffef0; border: solid 1px black; border-collapse: collapse;" width = "700px" height = "350px"> 
                                <tr> 
                                    <td style = "width: 200px"> Username </td>
                                    <td style = "width: 500px">'.$user.'</td>
                                </tr>

                                <tr> 
                                    <td style = "width: 200px"> Password </td>
                                    <td style = "width: 500px">
                                        <form method = "post" action = "" style = "margin: 0px; padding: 0px;">
                                            <p id = "user_pass" style = "display: none;">'.$pass.'
                                            <input type = "hidden" id = "hide_pass" value = "Hide Password" onclick = "hide_password()" style = "float: right;"></p>
                                            <input type = "button" id = "show_pass" value = "Show Password" onclick = "show_password()" style = "float: right;">
                                        </form>
                                    </td>
                                </tr>

                                <tr> 
                                    <td style = "width: 200px"> Current Balance </td>
                                    <td style = "width: 500px"> PHP '.$curr_bal.'</td>
                                </tr>

                                <tr> 
                                    <td style = "width: 200px"> Interest Rate </td> 
                                    <td style = "width: 500px"> '.$intrst_rate.'% </td> 
                                </tr>

                                <tr> 
                                    <td style = "width: 200px"> Minimum Amount for Interest</td>
                                    <td style = "width: 500px"> PHP '.$amnt_for_intrst.'</td>
                                </tr>

                                <tr> 
                                    <td style = "width: 200px"> Yearly/Monthly Increase </td>
                                    <td style = "width: 500px">'.$when_to_increase.'</td>
                                </tr>

                                <tr> 
                                    <td style = "width: 200px"> Date Account was Made (Bank Account) </td>
                                    <td style = "width: 500px">'.$date_of_increase.'</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <img src = "https://image-charts.com/chart?chs=300x350&chtt=Monthly%20Transactions&chd=t:'.$deposit_percentage.','.$withdraw_percentage.'&cht=p3&chl=Deposit%7CWithdraw&chan&chf=ps0-0,lg,45,ffeb3b,0.2,f44336,1|ps0-1,lg,45,8bc34a,0.2,009688,1">
                        </td>
                    </tr>
                </table>';
                $result->free();
            }
        ?>
		</div>
	</body>
</html>