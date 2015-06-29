<?php
	require("../model/clsEvent.php");
	
	$events = new Event();
	$res = $events->getEvents();
	if ($res->num_rows > 0) {
		$fail = false;
	} else {
		$fail = true;
	}
?>
