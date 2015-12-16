<?php
	require("../inc/common.php");
	require("../model/clsMessage.php");
	
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$body = 'NAME: '.$_POST['name'].'<br>EMAIL: '.$_POST['email'].'<br>MESSAGE: '.$_POST['msg'];
		sendMail("tsourdos@hotmail.com", 'FROM'.$_POST['name'], $body);
		
		$message = new Message();
		$res = $message->create( $_POST['name'], $_POST['email'], $_POST['msg'] );
		
		if (is_numeric($res)) {
			echo '<div class="alert alert-success fade in">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  Λάβαμε το μήνυμά σας! Θα επικοινωνήσουμε σύντομα μαζί σας.
				  <?php echo $errorMsg; ?>
				</div>';
		} else {
			echo '<div class="alert alert-danger fade in">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				  Υπήρξε κάποιο πρόβλημα, κατά την αποστολή του μυνήματος. Ελέξτε τα στοιχεία σας.
				</div>';
		}
	}
?>