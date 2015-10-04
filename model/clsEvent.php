<?php 
	
	class Event extends KdObject {
		
		public $keymap = array(
				'ID'				=> 'ID',
				'TITLE'				=> 'Title',
				'PLACE'				=> 'Place',
				'EVENTDATE'			=> 'EventDate',
				'DESCRIPTION'		=> 'Description',
				'EMAIL'				=> 'Email',
				'PLACELNGLAT'		=> 'PlaceLngLat',
				'URL'				=> 'Url',
				'FACEBOOKID'		=> 'FacebookID',
				'FACEBOOKEVENTID'	=> 'FacebookEventID',
				'ACTIVE'			=> 'Active',
				'LASTUPDATEON'		=> 'LastUpdateOn'
		);
			
        public function __construct($title = null, $description = null, $place = null, $evdate = null, $email = null,
        		$lng = null, $lat = null, $url = null, $facebookId = null) 
        {
			$this->tablename = 'Events';
			$this->table_pk  = 'ID';
        }
        
        public function getEvents() {
        	//Considers the spatial data of Events table
        	return KdObject::fetchAll();
        }

        public function getEventsById( $id ) {
        	//Considers the spatial data of Events table
        	return KdObject::fetchObjectById( $id );
        }
        
        public function getEventsByDate( $date ) {
        	require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
        		
        	$sql = "SELECT *, x(PlaceLngLat) AS Lng, y(PlaceLngLat) AS Lat FROM Events WHERE EventDate > '".$date."' ORDER BY EventDate ASC";
        	$con->query("SET NAMES utf8");
        	$result = $con->query($sql);
        	while($row = $result->fetch_assoc()){
        		$res[] = $row;
        	}
        	$con->close();
        	if ($result)
        		return $res;
        	else
        		return false;
        }
		
        public function create ( array $dt ) {
        	$ev = new Event();
        	
        	$ev->data['TITLE']				= $dt['TITLE'];
        	$ev->data['DESCRIPTION']		= $dt['DESCRIPTION'];
        	$ev->data['EVENTDATE']			= $dt['EVENTDATE'];
        	$ev->data['EMAIL']				= $dt['EMAIL'];
        	$ev->data['PLACE']				= $dt['PLACE'];
        	$ev->data['PLACELNGLAT']		= $dt['PLACELNGLAT'];
        	$ev->data['URL']				= translateToGreeklish($dt['TITLE']);
        	$ev->data['FACEBOOKID']			= $dt['FACEBOOKID'];
        	$ev->data['FACEBOOKEVENTID']	= $dt['FACEBOOKEVENTID'];
        	$ev->data['ACTIVE']				= '1';
        	$ev->data['LASTUPDATEON']		= KdObject::now();
        	
        	$ev_result = $ev->save();
        	
        	if(!$ev_result)
        		return false;
        	else 
        		return $ev->id;
        }
        
		public function save1() {
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			
            $sql = "INSERT INTO Events (Title, EventDate, Description, Place, Url, Email, FacebookId, PlaceLngLat) VALUES ('".
			$this->title."', '".$this->evdate."', '".$this->description."', '".$this->place."', '".$this->url."', '".$this->email."',
					'".$this->facebookId."', GeomFromText('POINT(".$this->lng." ".$this->lat.")'))" ;

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
		
		public function getEventsByParams($place = null, $date = null) {
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			if(isset($date)) {
				$day1 = date('Y-m-d', strtotime($date. ' - 7 days'));
				$day2 = date('Y-m-d', strtotime($date. ' + 7 days'));
			}
			
			if(isset($place) && isset($date))
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE Place LIKE '%".mysql_escape_string($place)."%' AND (EventDate BETWEEN '".mysql_escape_string($day1)."' AND '".mysql_escape_string($day2)."')";
			elseif(isset($place) && !isset($date))
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE Place LIKE '%".mysql_escape_string($place)."%'";
			elseif(!isset($place) && isset($date))
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE (EventDate BETWEEN '".mysql_escape_string($day1)."' AND '".mysql_escape_string($day2)."')";
			else
				return false;
			
			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			
			if ($result) {
				
			} else {
				
			}
			$con->close();
			return $result;
		}
		
		public static function fbEventExists($evId){
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			
			$sql = "SELECT * FROM Events WHERE FacebookId = '".mysql_escape_string($evId)."'";
			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			
			$con->close();
			if ($result && mysqli_num_rows($result) > 0)
				return true;
			else 
				return false;
		}
		
		function createVanityUrl( $vanity, $id ) {
			$url = PHP_EOL.'RewriteRule ^events/'.$vanity."[/]*$ events_dir/eventsId.php?id=".$id;
			file_put_contents("../.htaccess", $url, FILE_APPEND);
		}
	}
?>
