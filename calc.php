<?php
	include "config.php";

    if(isset($_POST['back'])) {
        $_SESSION['est_bal'] = 0;
		header('Location: bankbook.php');
    }

    $date_query = "select date_of_increase as date_of_increase from users where username='".$_SESSION['username']."'";
	$result = mysqli_query($conn,$date_query);
	$row = mysqli_fetch_assoc($result);
	$acc_create_date = $row['date_of_increase'];
    $_SESSION['acc_create_date'] = $acc_create_date;
    
    $accd_day = date('d', strtotime($acc_create_date));

    //echo $accd_day;
    
    if(isset($_POST['calculate'])) {
        $balance = $_SESSION['balance'];
        $intrst_rate = $_SESSION['intrst_rate'];

        $curr_date = strtotime(date('Y-m-d'));
        $curr_day = date('d');
        if($curr_day > $accd_day) {
            $future_date = strtotime($_POST['date']);
            $date_diff = ($future_date - $curr_date)/60/60/24;
            $times = $date_diff / 30;
            
            for($i = 0; $i < $times - 1; $i++) {
                $balance = $balance + ($balance * ($intrst_rate / 100));
            }
            $_SESSION['est_bal'] = $balance;
        }

        elseif($curr_day <= $accd_day) {
            $future_date = strtotime($_POST['date']);
            $date_diff = ($future_date - $curr_date)/60/60/24;
            $times = $date_diff / 30;
            
            for($i = 0; $i < $times; $i++) {
                $balance = $balance + ($balance * ($intrst_rate / 100));
            }
            $_SESSION['est_bal'] = $balance;
        }
    }
?>
<html>
	<head>
		<title>MyBankBook Interest Calculator</title>
		<link rel="stylesheet" type="text/css" href="bankbook.css">
	</head>
	<body>
		<p class = "title"> My BankBook Interest Calculator </p>
		<div class = "content">
            <p> *Note: This is only an estimation of your balance* </p>
            <p>Please input the date you want to estimate the amount of balance.(Please follow the format)</p>
			<form method = "post" action = "" >
				<div class = "prmpt"> Date: <input type = "text" name = "date" class = "prompt" placeholder = "YYYY-MM-DD"> </div>
				<div class = "button"> <input type = "submit" name = "calculate" value = "Calculate Balance" > <input type = "submit" name = "back" value = "Back to Home"> </div>
			</form>
            <div id = "balance"> 
                <?php
                    if (isset($_SESSION['est_bal'])) {
                        echo 'PHP '.number_format($_SESSION['est_bal'],2,".",",");
                    }
                ?>
			</div> 
		</div>
	</body>
</html> 