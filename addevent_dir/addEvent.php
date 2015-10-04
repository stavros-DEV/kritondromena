<?php 
	
	/*Get post Parameters. Add the event. */
	$event = array ('TITLE' 		=> $_POST["eventTitleN"],
					'PLACE'			=> $_POST["eventPlaceN"],
					'EVENTDATE' 	=> $_POST["dateSelector"],
					'DESCRIPTION' 	=> $_POST["summernote"],
					'EMAIL' 		=> $_POST["eventEmailN"],
					'PLACELNGLAT'   => $_POST["eventLngN"].' '.$_POST["eventLatN"],
					'FACEBOOKID'	=> '',
					'FACEBOOKEVENTID' => ''
	);
	$addEvent = new Event();
	$ret_id = $addEvent->create($event);
	
	/*$url = PHP_EOL.'RewriteRule ^events/'.$vanity."[/]*$ events_dir/eventsId.php?id=".$addEvent->id;
	file_put_contents("../.htaccess", $url, FILE_APPEND);*/
	
	/*Upload the images. */
	$errorMsg = "";
	$target_dir = "../resources/images/";
	$formName = "eventImageN";
	require("../inc/uploadImage.php");
	
	/*Store image in the DB */
	$addImage = new Image(basename($_FILES[$formName]["name"]), "", "/resources/images/".basename($_FILES[$formName]["name"]), $addEvent->id);
	$addImage->save();
	
	if(empty($_FILES[$formName]["name"]))
		$errorMsg = "";
?>
