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
			
        public function __construct() 
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
        	$con = get_mysql_connection();
        		
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
        	$ev->data['PLACE']				= $dt['PLACE'];
        	$ev->data['EVENTDATE']			= $dt['EVENTDATE'];
        	$ev->data['DESCRIPTION']		= $dt['DESCRIPTION'];
        	$ev->data['EMAIL']				= $dt['EMAIL'];
        	$ev->data['PLACELNGLAT']		= 'POINT('.$dt['PLACELNGLAT'].')';
        	$ev->data['URL']				= $dt['URL'];
        	$ev->data['FACEBOOKID']			= $dt['FACEBOOKID'];
        	$ev->data['FACEBOOKEVENTID']	= $dt['FACEBOOKEVENTID'];
        	$ev->data['ACTIVE']				= '1';
        	$ev->data['LASTUPDATEON']		= KdObject::now();
        	
        	$ev_result = $ev->prepared_save();
        	
        	if(!$ev_result)
        		return false;
        	else 
        		return $ev->id;
        }
		
		public function getEventsByParams($place = null, $date = null) {
			/**@todo this is unsafe**/
			$con = get_mysql_connection();
			if(isset($date)) {
				$day1 = date('Y-m-d', strtotime($date. ' - 7 days'));
				$day2 = date('Y-m-d', strtotime($date. ' + 7 days'));
			}
			
			if(isset($place) && isset($date)) {
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE Place LIKE 
						'%".mysql_escape_string($place)."%' AND (EventDate BETWEEN '".mysql_escape_string($day1).
						"' AND '".mysql_escape_string($day2)."') ORDER BY EventDate ASC";
			} elseif(isset($place) && !isset($date)) {
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE Place LIKE 
						'%".mysql_escape_string($place)."%' ORDER BY EventDate ASC";
			} elseif(!isset($place) && isset($date)) {
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE (EventDate BETWEEN 
						'".mysql_escape_string($day1)."' AND '".mysql_escape_string($day2)."') ORDER BY EventDate ASC";
			} else
				return false;
			
			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			
			if ($result) {}
			else {}
			
			$con->close();
			return $result;
		}
		
		public static function fbEventExists($evId){
			$con = get_mysql_connection();
			
			$sql = "SELECT * FROM Events WHERE FacebookId = '".mysql_escape_string($evId)."' OR FacebookEventId = '".mysql_escape_string($evId)."'";
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
	
		function getRef_Image () {
			$img = new Image();
			$this->data['IMAGE'] = $img->fetchObjectByParam( 'EventID', $this->data['ID'] );
		}
	}
?>
