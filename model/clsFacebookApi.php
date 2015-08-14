<?php
class FacebookCustomApi{
	public $id;
	public $facebookId;
	public $facebookName;
	public $name;
	
	public function getFacebookCustomApi() {
		require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			
		$sql = "SELECT * FROM FacebookApi";
		$con->query("SET NAMES utf8");
		$result = $con->query($sql);
			
		if ($result) {
	
		} else {
	
		}
		$con->close();
		
		while($row = $result->fetch_assoc()){
			$res[] = $row;
		}
		
		return $res;
	}
}