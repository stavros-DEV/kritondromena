<?php
	header('Content-Type: text/html; charset=utf-8');

	require($_SERVER["DOCUMENT_ROOT"]."/model/clsFacebookApi.php");
	require("../inc/common.php");
	include 'Facebook/autoload.php';
	
	$access_token = 'CAABjvDVPLZCwBAOabt9ZCtjMRr5LJ32KsfG1VVNK8BnZBSIoxDfoLJ6vsP6OHdkzZBCMOWgxLVFqqWDtcDH2LKvSR7yZCK7wVR7m7rzX9IV1AYxdSlGYo1PAWvaILeqi2jy7T4fzPcV4BAmIHa01fK8tcsP3LsiYNOZBctChvMkiIfHqeJeuCLkuJgBxmr157KmulgivmG7QZDZD';
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
		
		if( isset( $_GET['id'] ) )	$pages = array( "FacebookID" => $_GET['id'] );
		
		r($pages);

		//foreach($pages as $p){
			
			$response = $fb->get($pages['FacebookID']."/events");
			$resp = json_decode($response->getBody(), true);
			r($resp);
			
			foreach($resp['data'] as $event){
				$exists = Event::fbEventExists($event['id']);
				
				if(!$exists){
					echo '<b style="color:green">'.$event['id'].' exists: '.$exists.' '.$event['start_time'].'<b><br>';
				} else {
					echo '<b style="color:red">'.$event['id'].' exists: '.$exists.'<b><br>';
				}
			}
		//}
		
		exit(); 
	  
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
?>