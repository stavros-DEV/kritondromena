<?php
	require('../model/clsFacebookApi.php');
	
	$fb = new FacebookCustomApi();
	$new_id = $fb->create($_GET['fb_id'], $_GET['name'], $_GET['fb_name']);
	echo $new_id; 