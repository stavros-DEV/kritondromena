<?php 
	class Article {
		public $id;
		public $title;
        public $text;
        	
        public function __construct($title = null, $text = null) {
			$this->title = addslashes($title);
            $this->text = addslashes($text);
		}
		
		public function save() {
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			
            $sql = "INSERT INTO Articles (Title, Text) VALUES ('".$this->title."', '".$this->text."')" ;

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
		
		public function getArticleById($id, $substr = false) {
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			if($substr)
				$sql = "SELECT *, SUBSTR(`Text`,1,500) as substrText FROM Articles WHERE ID='".mysql_escape_string($id)."'";
            else
				$sql = "SELECT * FROM Articles WHERE ID='".mysql_escape_string($id)."'";
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
