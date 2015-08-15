<?php
	$host= gethostname();
	$ip = gethostbyname($host);
	
	/*Check if working in local or live server. */
	if (strpos($ip, '192.168.') !== false || strpos($ip, "169.254.155.73") !== false || strpos($ip, "127.0.1.1") !== false) {
		$username = "root";
		$password = "";
		$hostname = "localhost"; 
	} else {
		$username = "kritondr_tooth";
		$password = "pS3Tz(X}S7?)";
		$hostname = "kritondromena.gr"; 
	}
	
	$database = "kritondr_data";

	$con = mysqli_connect($hostname, $username, $password, $database);

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>