<?php 
	class Event {
		public $id;
		public $title;
        public $description;
        public $place;
        public $evdate;
		public $email;
        public $lng;
		public $lat;
		public $url;
			
        public function __construct($title = null, $description = null, $place = null, $evdate = null, $email = null, $lng = null, $lat = null, $url = null) {
			$this->title = addslashes($title);
            $this->description = addslashes($description);
            $this->place = $place;
			$this->evdate = $evdate;
			$this->email = $email;
			$this->lng = $lng;
			$this->lat = $lat;
			$this->url = $url;
        }
		
		public function save() {
			require("../inc/mysqlConnect.php");
			
            $sql = "INSERT INTO Events (Title, EventDate, Description, Place, Url, Email, PlaceLngLat) VALUES ('".
			$this->title."', '".$this->evdate."', '".$this->description."', '".$this->place."', '".$this->url."', '".$this->email."', GeomFromText('POINT(".$this->lng." ".$this->lat.")'))" ;

			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			$this->id = $con->insert_id;
			
			if ($result) {
				print_r($result);
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
			$con->close();
			return $result;
        }
		
		public function getEvents() {
			require("../inc/mysqlConnect.php");
			
            $sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events";
			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			
			if ($result) {
				
			} else {
				
			}
			$con->close();
			return $result;
		}
		
		public function getEventsById($id) {
			require("../inc/mysqlConnect.php");
			
            $sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE ID='".mysql_escape_string($id)."'";
			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			
			if ($result) {
				
			} else {
				
			}
			$con->close();
			return $result;
		}
	}
?>
