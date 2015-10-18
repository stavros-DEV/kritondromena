<?php
	header('Content-Type: text/html; charset=utf-8');
	require("../inc/common.php");
	$id = $_GET["artId"];
	$event = new Event();
	$evrow = $event->getEventsById('91');
	$event->getRef_Image();
	r($event->data);