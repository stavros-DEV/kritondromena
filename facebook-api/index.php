<?php
	header('Content-Type: text/html; charset=utf-8');

	require("../model/clsEvent.php");
	require($_SERVER["DOCUMENT_ROOT"]."/model/clsFacebookApi.php");
	require("../inc/common.php");
	include 'Facebook/autoload.php';
	
	function getFbEvent($arr){
		$id_list = array();
		$i = 0;
		foreach($arr['data'] as $a){
			if (array_key_exists('story', $a)) {
				$splitted = explode('_', $a['id']);
				$id_list[$i] = $splitted[1];
				$i++;
			}
		}
		return $id_list;
	}
	
	function saveEvent($arr, $name){
		
		$now = new DateTime();
		
		if (strtotime($arr['start_time']) > $now->getTimestamp())
		{
			r($arr);
			
			$title = $name.': '.$arr['name'];
			$date  = date('Y-m-d', strtotime($arr['start_time']));
			
			echo $date.' '.$title.' '.$arr['description'].' '.$arr['place']['name'].' '.$arr['id'].' '.$arr['place']['location']['latitude'].' '.$arr['place']['location']['longitude'];
			
			$addEvent = new Event($arr['name'], $arr['description'], $arr['place']['name'],
							$date, '', $arr['place']['location']['longitude'],
							$arr['place']['location']['latitude'], '', $arr['id']);
			
			$fail = $addEvent->save();
			
			if ($fail)
				echo 'failed to upload fb event id:'.$arr['start_time'];
		}
	}
	
	$access_token = 'CAABjvDVPLZCwBAODzwfpfDxppU209mwgmwpkTKur9nA9sbRuAgmtP12dO7GaSX0pZA1BXqMR1ZAsS6zc6ZA2iNCm7CHUrsQNLbxZAhoNiixGsmdZBHYQHjQhFUDZAEZAdvbZCgMlGZAlUhvbenVngk4lpO0gGOyxndxWTXUaSfVTxGjC7NVLSucCCHPbQyuCtqjnVVFKbLDZA0eG5wyt4YOy7WG';
	if ( isset( $_GET('ac') ) )		$access_token = $_GET('ac'); 
	
	$app_secret = 'e5f29c24ed4d20e40513c10958b3e9f0';

	$fb = new Facebook\Facebook([
	  'app_id' => '109659999383548',
	  'app_secret' => 'e5f29c24ed4d20e40513c10958b3e9f0',
	  'default_graph_version' => 'v2.4'
	]);
		
	$fb->setDefaultAccessToken($access_token);
	
	try {
		$facebookApi = new FacebookCustomApi();
		$pages = $facebookApi->getFacebookCustomApi();
		r($pages);

		foreach($pages as $p){
			
			$response = $fb->get($p['FacebookID']."/events");
			$resp = json_decode($response->getBody(), true);
			r($resp);
			
			foreach($resp['data'] as $event){
				$exists = Event::fbEventExists($event['id']);
				echo '<b>'.$event['id'].' exists: '.$exists.'<b><br>';
				if(!$exists)
					saveEvent($event, $p['Name']);
			}
		}
		
		exit(); 
	  
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
?>