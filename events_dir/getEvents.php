<?php
	//require($_SERVER["DOCUMENT_ROOT"]."/model/clsEvent.php");
	//require($_SERVER["DOCUMENT_ROOT"].'/inc/common.php');
	$events = new Event();
	$res = $events->getEvents();
	
	if ( count( $res ) > 0 ) {
		$fail = false;
	} else {
		$fail = true;
	}
?>
