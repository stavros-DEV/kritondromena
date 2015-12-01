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
        	$ev->data['PLACE']				= $dt['PLACE'];
        	$ev->data['EVENTDATE']			= $dt['EVENTDATE'];
        	$ev->data['DESCRIPTION']		= $dt['DESCRIPTION'];
        	$ev->data['EMAIL']				= $dt['EMAIL'];
        	$ev->data['PLACELNGLAT']		= 'POINT('.$dt['PLACELNGLAT'].')';
        	$ev->data['URL']				= translateToGreeklish($dt['TITLE']);
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
			$type = "prepared";
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			if(isset($date)) {
				$day1 = date('Y-m-d', strtotime($date. ' - 7 days'));
				$day2 = date('Y-m-d', strtotime($date. ' + 7 days'));
			}
			
			if(isset($place) && isset($date)) {
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE Place LIKE 
						? AND (EventDate BETWEEN ? AND ?) ORDER BY EventDate ASC";
				
				$stmt = $con->prepare($sql);
				$place = '%'.mysql_escape_string($place).'%';
				$stmt->bind_param('sss', $place, $day1, $day2);
				
			} elseif(isset($place) && !isset($date)) {
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE Place LIKE 
						? ORDER BY EventDate ASC";
				
				$stmt = $con->prepare($sql);
				$place = '%'.mysql_escape_string($place).'%';
				$stmt->bind_param('s', $place);
				
			} elseif(!isset($place) && isset($date)) {
				$sql = "SELECT *, x(PlaceLngLat) as Lng, y(PlaceLngLat) as Lat FROM Events WHERE (EventDate BETWEEN
						? AND ?) ORDER BY EventDate ASC";
				echo "hello3";
				$stmt = $con->prepare($sql);
				$stmt->bind_param('ss', $day1, $day2);
				
			} else
				return false;
			
			$stmt_names = $con->prepare('SET NAMES utf8');
			$stmt_names->execute();
			$stmt->execute();
			
			$meta = $stmt->result_metadata();
			while ($field = $meta->fetch_field()) {
				$params[] = &$row[$field->name];
			}

			//[28-Oct-2015 23:37:16 UTC] PHP Fatal error:  Allowed memory size of 268435456 bytes exhausted (tried to allocate 4294967296 bytes) in /home/kritondr/public_html/model/clsEvent.php on line 119
			call_user_func_array(array($stmt, 'bind_result'), $params);
			while ($stmt->fetch()) {
				foreach($row as $key => $val) {
					$c[$key] = $val;
				}
				$result[] = $c;
			}
			
			if ($stmt->num_rows > 0)
				return $result;
			else
				return array();
		}
		
		public static function fbEventExists($evId){
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			
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
	}
?>
