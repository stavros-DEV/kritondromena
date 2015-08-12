<?php
	header('Content-Type: text/html; charset=utf-8');

	require("../model/clsEvent.php");
	require("../inc/common.php");
	
	function r($var){
		echo '<textarea cols="60" rows="10">';
		print_r($var);
		echo '</textarea><hr>';
	}
	
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
							$date, $arr['id'], $arr['place']['location']['longitude'],
							$arr['place']['location']['latitude'], '');
			
			$fail = $addEvent->save();
			
			if ($fail)
				echo 'failed to upload fb event id:'.$arr['start_time'];
		}
	}
	
	include 'Facebook/autoload.php';
	
	$access_token = 'CAABjvDVPLZCwBALZAZAMdg5ex4VBLxb9n0t2kLcjhQkoZCfr7ctzZBnfRIX5mNs0vCSdcogy5fJEfeW9rMqlHUbfS51pTcohDoOjgCdkZB2ZAGbQ9sPYTp7KDjQUiZC9GaBcqMT0veCxiE4fobkLoZBMMF4coyT2I04oHZBLRTcOzTmavd2gt0Q9odYuEYSmqudUZBb0oRiY3l41wZDZD';
	$app_secret = 'e5f29c24ed4d20e40513c10958b3e9f0';
	//$appsecret_proof = hash_hmac('sha256', $access_token, $app_secret);

	//FacebookSession::enableAppSecretProof(false);
	$fb = new Facebook\Facebook([
	  'app_id' => '109659999383548',
	  'app_secret' => 'e5f29c24ed4d20e40513c10958b3e9f0',
	  'default_graph_version' => 'v2.4'
	  //'appsecret_proof' => $appsecret_proof
	]);
		
	// Sets the default fallback access token so we don't have to pass it to each request
	$fb->setDefaultAccessToken($access_token);
	
	//$params['appsecret_proof'] = $appsecret_proof;
	
	$pages = array( 'fragia' => '1674749916079914', 'roxanh' => '798279260209487',
				   	'tafros' => '567914323321550' , 'xaroul' => '286769964670309',
					'psarog' => '270962486382'    , 'martsa' => '167529253284196'
	);
	
	try {
	  
		foreach($pages as $key => $p){
			$response = $fb->get($p.'/posts');
			$resp = json_decode($response->getBody(), true);
			$ids = getFbEvent($resp);
			
			try {
				
				$response = $fb->get($ids[0]);
				$resp = json_decode($response->getBody(), true);
				saveEvent($resp, $key);
			}catch(Facebook\Exceptions\FacebookResponseException $e) {}
			
		}
		
		exit();
	  
	  
	  $userNode = $response->getGraphUser();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  // When Graph returns an error
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // When validation fails or other local issues
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	echo 'Logged in as ' . $userNode->getName();

?>