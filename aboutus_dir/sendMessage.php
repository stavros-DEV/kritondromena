<?php
	require("../inc/common.php");
	
	if ( $_SERVER['REQUEST_METHOD'] == 'GET' ){ 
		sendMail("tsourdos@hotmail.com", $_GET);
		echo "message sent";
	}
?>