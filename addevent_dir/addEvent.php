<?php 
	
	/*Get post Parameters. Add the event. */
	if(!empty($_FILES["eventImageN"]["name"])) 
		$vanity = translateToGreeklish($_POST["eventTitleN"]);
	else 
		$vanity = '';
		
	$event = array ('TITLE' 		=> $_POST["eventTitleN"],
					'PLACE'			=> $_POST["eventPlaceN"],
					'EVENTDATE' 	=> $_POST["dateSelector"],
					'DESCRIPTION' 	=> $_POST["summernote"],
					'EMAIL' 		=> $_POST["eventEmailN"],
					'PLACELNGLAT'   => $_POST["eventLngN"].' '.$_POST["eventLatN"],
					'URL'			=> $vanity,
					'FACEBOOKID'	=> '',
					'FACEBOOKEVENTID' => ''
	);
	$addEvent = new Event();
	$ret_id = $addEvent->create($event);
	
	/*Upload the images. */
	if(!empty($_FILES["eventImageN"]["name"])) {
		$url = PHP_EOL.'RewriteRule ^events/'.$vanity."[/]*$ events_dir/event_details.php?id=".$ret_id;
		file_put_contents("../.htaccess", $url, FILE_APPEND);
		
		$errorMsg = "";
		$target_dir = "../resources/images/";
		$formName = "eventImageN";
		require("../inc/uploadImage.php");
	
		/*Store image in the DB */
		$addImage = new Image();
		$addImage->create(basename($_FILES[$formName]["name"]), "", "/resources/images/".basename($_FILES[$formName]["name"]), $ret_id);
	} else 
		$errorMsg = "";
?>
