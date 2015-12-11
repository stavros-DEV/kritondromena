<?php 
	
	class Message extends KdObject{
        
		public $keymap = array(
				'ID'			=> 'ID',
				'NAME'			=> 'Name',
				'EMAIL'			=> 'Email',
				'MESSAGE'		=> 'Message',
				'LASTUPDATEON'	=> 'LastUpdateOn'
		);
		
        public function __construct() {
			$this->tablename = "messages";
			$this->table_pk = "ID";
		}
		
		public function getMessages() {
			return KdObject::fetchAll();
		}
		
		public function getMessageById ( $id ) {
			return KdObject::fetchObjectByID( $id );
		}
		
		public function create( $name, $email, $message ) {
			$msg = new Message();
		
			$msg->data['NAME'] 			= $name;
			$msg->data['EMAIL'] 		= $email;
			$msg->data['MESSAGE']	 	= $message;
			$msg->data['LASTUPDATEON'] 	= KdObject::now();
			
			$msg->prepared_save();
			return $msg->id;
        }
		
	}
?>
