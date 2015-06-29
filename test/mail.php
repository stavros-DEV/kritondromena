<?php
	$to      = 'tsoussdsdrdos@hotmail.com';
	$subject = 'the subject';
	$message = 'hello';
	$headers = 'From: info@kritondromena.gr' . "\r\n" .
		'Reply-To: info@kritondromena.gr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

	$sent = mail($to, $subject, $message, $headers);
	
	if ($sent == false){
		print_r(error_get_last());
		echo "false";
	} else {
		print_r(error_get_last());
		echo "hello";
	}
?> 