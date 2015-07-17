<?php 
	class Message {
		public $id;
		public $name;
        public $mail;
		public $msg;
        	
        public function __construct($name = null, $mail = null, $msg = null) {
			$this->name = addslashes($name);
            $this->mail = addslashes($mail);
			$this->msg  = addslashes($msg);
		}
		
		public function save() {
			require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
			
            $sql = "INSERT INTO messages (Name, Email, Message) VALUES ('".$this->name."', '".$this->mail."', '".$this->msg."')" ;
			
			$con->query("SET NAMES utf8");
			$result = $con->query($sql);
			$this->id = $con->insert_id;
			
			if ($result) {
				
			} else {
				
			}
			$con->close();
			return $result;
        }
		
	}
?>
