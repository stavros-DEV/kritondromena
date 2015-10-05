<?php
	header('Content-Type: text/html; charset=utf-8');

	require($_SERVER["DOCUMENT_ROOT"]."/model/clsFacebookApi.php");
	require("../inc/common.php");
	include 'Facebook/autoload.php';
	
	function saveEvent($arr, $name)
	{
		$now = new DateTime();
		
		if (strtotime($arr['start_time']) > $now->getTimestamp())
		{
			r($arr);
			$date  = date('Y-m-d', strtotime($arr['start_time']));
			
			$event = array(	'TITLE' 			=> $arr['name'],
							'DESCRIPTION'		=> $arr['description'],
							'PLACE'				=> $arr['place']['name'],
							'EVENTDATE'			=> $date,
							'PLACELNGLAT'		=> $arr['place']['location']['longitude'].' '.$arr['place']['location']['latitude'],
							'FACEBOOKID'		=> $id,
							'EMAIL'				=> "",
							'FACEBOOKEVENTID'	=> $arr['id'],
							'FACEBOOKID'		=> $name
			);
			$addEvent = new Event();
			$addEvent->create( $event );
		}
	}
	
	$access_token = 'CAABjvDVPLZCwBAODzwfpfDxppU209mwgmwpkTKur9nA9sbRuAgmtP12dO7GaSX0pZA1BXqMR1ZAsS6zc6ZA2iNCm7CHUrsQNLbxZAhoNiixGsmdZBHYQHjQhFUDZAEZAdvbZCgMlGZAlUhvbenVngk4lpO0gGOyxndxWTXUaSfVTxGjC7NVLSucCCHPbQyuCtqjnVVFKbLDZA0eG5wyt4YOy7WG';
	if ( isset( $_GET['ac'] ) )		$access_token = $_GET['ac']; 
	
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
		//r($pages);

		foreach($pages as $p){
			
			$response = $fb->get($p['FacebookID']."/events");
			$resp = json_decode($response->getBody(), true);
			//r($resp);
			echo $p['Name'].'<hr/>';
			foreach($resp['data'] as $event){
				$exists = Event::fbEventExists($event['id']);
				
				if (!$exists) {
					echo '<b style="color:green">'.$event['id'].' doesnt exist:</b> '.$event['start_time'].'<br/>';
					saveEvent($event, $p['Name']);
				} else {
					echo '<b style="color:red">'.$event['id'].' already exists:</b> '.$event['start_time'].'<br/>';
				}
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