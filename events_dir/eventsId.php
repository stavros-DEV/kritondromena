<?php
	require("../model/clsEvent.php");
	header('Content-Type: text/html; charset=utf-8');
	$id = $_GET['id'];
		
	$events = new Event();
	$res = $events->getEventsById($id);
	if ($res->num_rows > 0) {
		/*redirect to 404*/
	}
	$row = $res->fetch_assoc();
	print_r($row);
?>