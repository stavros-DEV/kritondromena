<?php
	header('Content-Type: text/html; charset=utf-8');
	require($_SERVER["DOCUMENT_ROOT"].'/model/clsKdObjekt.php');
	require($_SERVER["DOCUMENT_ROOT"].'/model/clsEvent.php');
	require($_SERVER["DOCUMENT_ROOT"].'/model/clsArticle.php');
	require($_SERVER["DOCUMENT_ROOT"].'/model/clsImages.php');
	
	function translateToGreeklish ($str) {
		$str = trim($str);
		$str = mb_strtolower($str,"UTF-8");
		
		$str = preg_replace('/\s+/', '-', $str);
		$str = preg_replace("/α/", "a", $str);
		$str = preg_replace("/ά/", "a", $str);
		$str = preg_replace("/β/", "v", $str);
		$str = preg_replace("/γ/", "g", $str);
		$str = preg_replace("/δ/", "d", $str);
		$str = preg_replace("/ε/", "e", $str);
		$str = preg_replace("/έ/", "e", $str);
		$str = preg_replace("/ζ/", "z", $str);
		$str = preg_replace("/η/", "h", $str);
		$str = preg_replace("/ή/", "h", $str);
		$str = preg_replace("/θ/", "th", $str);
		$str = preg_replace("/ι/", "i", $str);
		$str = preg_replace("/ί/", "i", $str);
		$str = preg_replace("/κ/", "k", $str);
		$str = preg_replace("/λ/", "l", $str);
		$str = preg_replace("/μ/", "m", $str);
		$str = preg_replace("/ν/", "n", $str);
		$str = preg_replace("/ξ/", "x", $str);
		$str = preg_replace("/ο/", "o", $str);
		$str = preg_replace("/ό/", "o", $str);
		$str = preg_replace("/π/", "p", $str);
		$str = preg_replace("/ρ/", "r", $str);
		$str = preg_replace("/σ/", "s", $str);
		$str = preg_replace("/ς/", "s", $str);
		$str = preg_replace("/τ/", "t", $str);
		$str = preg_replace("/υ/", "y", $str);
		$str = preg_replace("/ύ/", "y", $str);
		$str = preg_replace("/φ/", "f", $str);
		$str = preg_replace("/χ/", "x", $str);
		$str = preg_replace("/ψ/", "ps", $str);
		$str = preg_replace("/ω/", "o", $str);
		$str = preg_replace("/ώ/", "o", $str);
		$str = preg_replace("/&/", "kai", $str);
		
		/*replace anything that isn't a letter, number or space.*/
		$str = preg_replace("/[^a-zA-Z 0-9]+/", "-", $str);
		
		$str = trim($str, "-");
		
		return $str;
	}
	
	function sendMail($to, $subject, $message) {
		$headers = 'From: eyetea@kritondromena.gr' . "\r\n" .
		'Reply-To: eyetea@kritondromena.gr' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		$sent = mail($to, $subject, $message, $headers);
	}
	
	function r($var){
		echo '<textarea cols="60" rows="10">';
		print_r($var);
		echo '</textarea><hr>';
	}
	
	function containsRegion ($str) {
		$str = strtolower(trim($str));
		if (strpos($str, 'ηράκλειο') === false && strpos($str, 'ηρακλειο') === false && strpos($str, 'χανιά') === false &&
			strpos($str, 'χανια') === false && strpos($str, 'ρέθυμνο') === false && strpos($str, 'ρεθυμνο') === false &&
			strpos($str, 'λασίθι') === false && strpos($str, 'λασιθι') === false )
			return false;
		else
			return true;
	}
	
	function addRegionName ( $place, $location ) {
		$contained = containsRegion($place);
		
		if ( !$contained && isset($location) ) {
			$temp = explode(" ", trim($location));
			$location = $temp[1].','.$temp[0];
			$du = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$location."&key=AIzaSyDzO7UQ_c127qzlFbBAHgO2Vg42c99Hdqk&language=el");
			$gapi = json_decode(utf8_encode($du),true);
			r($gapi);
			if( $gapi['status'] = "OK" ) {
				$place = "";
				foreach ($gapi['results'][0]['address_components'] as $entry ){
					if(strpos($place, $entry['short_name']) === false)
						$place = $place . ', ' . $entry['short_name'];
				}
				$place = substr($place, 2);
			}
		}
		elseif ( !$contained && !isset($location) ) {
			$du = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" + trim($place) + "&key=AIzaSyDzO7UQ_c127qzlFbBAHgO2Vg42c99Hdqk&language=el");
			$gapi = json_decode(utf8_encode($du),true);
			r($gapi);
			if( $gapi['status'] = "OK" ) {
				$place = "";
				foreach ($gapi['results'][0]['address_components'] as $entry ){
					if(strpos($place, $entry['short_name']) === false)
						$place = $place . ', ' . $entry['short_name'];
				}
				$place = substr($place, 2);
			}
		}
		
		return $place;
	}
?>