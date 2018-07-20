<?php
	include "include/function_pack.php";
	$salt = KeyGenerator();
	$password = hashword('parolarandom', $salt);
	echo "Salt: $salt <br> Parola: $password";
?>