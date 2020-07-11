<?php
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

			// YOUR APPLICATION CODE HERE, e.g.
			$base_price = 12; // Your price in USD
			$EUR_price = round(($base_price * $response->conversion_rates->EUR), 2);

		}

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }

}
?>