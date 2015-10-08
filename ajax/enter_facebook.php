<?php
	header('Content-type: application/json');
	require('../inc/common.php');
	
	$fb = new FacebookCustomApi();
	$new_id = $fb->create($_POST['fb-id'], $_POST['fb-name'], $_POST['kd-name']);
	
	if (is_numeric($new_id) && $new_id != 0)
		$return = array( 'status' => 'OK', 'msg' => 'Data inserted successfully', 'id' => $new_id);
	else 
		$return = array( 'status' => 'FAIL', 'status' => 'Fail while entering data');
	
	echo json_encode($return);