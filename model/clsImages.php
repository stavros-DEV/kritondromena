<?php 
	class Image {
		public $eventID;
        public $description;
        public $title;
        public $location;
			
        public function __construct($title = null, $description = null, $location = null, $eventID = null) {
			$this->title = $title;
            $this->description = addslashes($description);
            $this->location = $location;
			$this->eventID = $eventID;
        }
		
		public function save() {
			require("../inc/mysqlConnect.php");
			
            $sql = "INSERT INTO Images (EventID, Title, Description, Location) VALUES ('".
			$this->eventID."', '".$this->title."', '".$this->description."', '".$this->location."')" ;

			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			
			if ($result) {
				
			} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
			$con->close();
			return $result;
        }
		
		public function getImages() {
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
	}
?>
