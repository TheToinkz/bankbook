<?php
    session_start();
	$server = "localhost";
	$username = "root";
	$password = "";
	$dbname = "bankbookdb";

    $conn = new mysqli($server, $username, $password, $dbname);
?>