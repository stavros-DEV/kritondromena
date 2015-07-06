<?php 
	require("../model/clsEvent.php");
	require("../model/clsImages.php");
	require("../inc/common.php");
	
	/*Get post Parameters. */
	$title = $_POST["eventTitleN"];
	$place = $_POST["eventPlaceN"];
	$date  = $_POST["dateSelector"];
	$descr = $_POST["summernote"];
	$email = $_POST["eventEmailN"];
	$lng   = $_POST["eventLngN"];
	$lat   = $_POST["eventLatN"];
	
	/*Add the event. */
	$vanity = translateToGreeklish($title);
	$addEvent = new Event($title, $descr, $place, $date, $email, $lng, $lat, $vanity);
	$fail = $addEvent->save();
	if ($fail)
		sendMail($email, $addEvent->id);
		
	$url = PHP_EOL.'RewriteRule ^events/'.$vanity."[/]*$ events_dir/eventsId.php?id=".$addEvent->id;
	file_put_contents("../.htaccess", $url, FILE_APPEND);
	
	/*Upload the images. */
	$errorMsg = "";
	$target_dir = "../resources/images/";
	$formName = "eventImageN";
	require("../inc/uploadImage.php");
	
	/*Store image in the DB */
	$addImage = new Image(basename($_FILES[$formName]["name"]), "", "/resources/images/".basename($_FILES[$formName]["name"]), $addEvent->id);
	$addImage->save();
	
?>
