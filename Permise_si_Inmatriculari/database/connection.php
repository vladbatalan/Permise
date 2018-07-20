<?php
	session_start();

	$servername = "localhost";
	$user = "root";
	$password = "";
	$dbname = "permisedb";

	$conn = mysqli_connect($servername, $user, $password, $dbname);
?>