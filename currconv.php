<?php
    if(!isset($_SESSION['username'])) {
		header('Location: index.php');
	}
?>
<html>
	<head>
		<title>Currency Exchange</title>
		<link rel="stylesheet" type="text/css" href="history.css">
	</head>
	<body>
		<p class = "title"> Currency Exchange </p>
		<form method = "post" action = "" class = "button">
			<input type = "submit" class = "button" name = "back" value = "Back to BankBook">
		</form>
		<?php
            echo '<p> Current Balance: '.$_SESSION['balance'].'</p>';
            echo '<table border="1" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #FFFFFF;" width = "1000px"> 
            <tr> 
                <td style = "width: 100px"> Currency</td>
                <td style = "width: 300px"> Exchange Rate </td> 
                <td style = "width: 300px"> Current Balance in said Currency </td>
            </tr>';
            //currency exchange api from exchangerate-api.com
            // Fetching JSON
            $req_url = 'https://prime.exchangerate-api.com/v5/0c8d8fe3f79fce7ab4075b67/latest/PHP';
            $response_json = file_get_contents($req_url);

            // Continuing if we got a result
            if(false !== $response_json) {

                // Try/catch for json_decode operation
                try {

                    // Decoding
                    $response = json_decode($response_json);

                    // Check for success
                    if('success' === $response->result) {

                        //Code showing the exhchange rates
                        $base_price = $_SESSION['balance']; 
                        $USD_price = round(($base_price * $response->conversion_rates->USD), 2);
                        $EUR_price = round(($base_price * $response->conversion_rates->EUR), 2);
                        $CAD_price = round(($base_price * $response->conversion_rates->CAD), 2);
                        $SAR_price = round(($base_price * $response->conversion_rates->SAR), 2);
                        $CNY_price = round(($base_price * $response->conversion_rates->CNY), 2);
                        echo '<table border="1" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #FFFFFF;" width = "1000px"> 
                        <tr> 
                            <td style = "width: 100px"> USD (USA)</td>
                            <td style = "width: 300px">' .$response->conversion_rates->USD. '</td> 
                            <td style = "width: 300px">' .$USD_price. '</td>
                        </tr>';
                        echo '<table border="1" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #FFFFFF;" width = "1000px"> 
                        <tr> 
                            <td style = "width: 100px"> EUR (Europe)</td>
                            <td style = "width: 300px">' .$response->conversion_rates->EUR. '</td> 
                            <td style = "width: 300px">' .$EUR_price. '</td>
                        </tr>';
                        echo '<table border="1" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #FFFFFF;" width = "1000px"> 
                        <tr> 
                            <td style = "width: 100px"> CAD (Canada)</td>
                            <td style = "width: 300px">' .$response->conversion_rates->CAD. '</td> 
                            <td style = "width: 300px">' .$CAD_price. '</td>
                        </tr>';
                        echo '<table border="1" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #FFFFFF;" width = "1000px"> 
                        <tr> 
                            <td style = "width: 100px"> SAR (Saudi Arabia)</td>
                            <td style = "width: 300px">' .$response->conversion_rates->SAR. '</td> 
                            <td style = "width: 300px">' .$SAR_price. '</td>
                        </tr>';
                        echo '<table border="1" cellspacing="2" cellpadding="2" align = "center" style = "margin-top: 20px; background: #FFFFFF;" width = "1000px"> 
                        <tr> 
                            <td style = "width: 100px"> CNY (China)</td>
                            <td style = "width: 300px">' .$response->conversion_rates->CNY. '</td> 
                            <td style = "width: 300px">' .$CNY_price. '</td>
                        </tr>';
                    }

                }
                catch(Exception $e) {
                    // Handle JSON parse error...
                }

            }
        ?>
	</body>
</html>