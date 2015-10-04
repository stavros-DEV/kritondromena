<?php
	$events = new Event();
	$res = $events->getEvents();
	
	if ( count( $res ) > 0 ) {
		$fail = false;
	} else {
		$fail = true;
	}
?>
