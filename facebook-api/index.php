<?php
	header('Content-Type: text/html; charset=utf-8');

	$_SERVER['DOCUMENT_ROOT'] = '/home/kritondr/public_html';
	require($_SERVER['DOCUMENT_ROOT']."/inc/common.php");
	include $_SERVER['DOCUMENT_ROOT'].'/facebook-api/Facebook/autoload.php';
	
	function saveEvent($arr, $name)
	{
		$now = new DateTime();
		
		if (strtotime($arr['start_time']) > $now->getTimestamp())
		{
			echo $arr['name'].', ';
			var_dump($arr);
			$date  = date('Y-m-d', strtotime($arr['start_time']));
			if ( !isset($arr['place']['location']['longitude']) || !isset($arr['place']['location']['latitude']) ){
				$loc = getLngLat($arr['place']['name']);
			} else {
				$loc = getPlaceName ($arr['place']['location']['longitude'].' '.$arr['place']['location']['latitude']);
			}
	
			if ($loc) {
				$lnglat = $loc['lng'].' '.$loc['lat'];
				$place = $loc['place'];
			} else {
				$place = $arr['place']['name'];
				$loc = $arr['place']['location']['longitude'].' '.$arr['place']['location']['latitude'];
			}
			
			$event = array(	'TITLE' 			=> $arr['name'],
							'DESCRIPTION'		=> $arr['description'],
							'PLACE'				=> $place,
							'EVENTDATE'			=> $date,
							'PLACELNGLAT'		=> $lnglat,
							'FACEBOOKID'		=> $id,
							'EMAIL'				=> '',
							'URL'				=> '',
							'FACEBOOKEVENTID'	=> $arr['id'],
							'FACEBOOKID'		=> $name
			);
			$addEvent = new Event();
			$addEvent->create( $event );
		}
	}
	
	$access_token = FB_ACCESS_TOKEN;

	if ( isset( $_GET['ac'] ) )		$access_token = $_GET['ac']; 	
	if ( isset( $argv[1] ) )		$access_token = $argv[1];

	$fb = new Facebook\Facebook([
	  'app_id' => FB_APP_ID,
	  'app_secret' => FB_APP_SECRET,
	  'default_graph_version' => 'v2.4'
	]);
		
	$fb->setDefaultAccessToken($access_token);
	
	try {
		$facebookApi = new FacebookCustomApi();
		$pages = $facebookApi->getFacebookCustomApi();

		foreach($pages as $p){
			
			$response = $fb->get($p['FacebookID']."/events");
			$resp = json_decode($response->getBody(), true);
			
			foreach($resp['data'] as $event){
				$exists = Event::fbEventExists($event['id']);
				
				if (!$exists) {
					saveEvent($event, $p['FacebookID']);
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