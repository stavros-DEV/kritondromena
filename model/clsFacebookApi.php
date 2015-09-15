<?php
require ('clsKdObjekt.php');
class FacebookCustomApi extends KdObject {
	
	public $keymap = array(
		'ID'			=> 'ID',
		'FACEBOOKID'	=> 'FacebookID',
		'NAME'			=> 'Name',
		'FACEBOOKNAME'	=> 'FacebookName',
		'LASTUPDATEON'	=> 'LastUpdateOn'
	);
	
	public function __construct()
	{
		$this->tablename = "FacebookApi";
		$this->table_pk = "ID";
	}
	
	public function getFacebookCustomApi() {
		return KdObject::fetchAll();
	}
	
	public function getFacebookUserById ( $id ) {
		return KdObject::fetchObjectByID( $id );
	}
	
	public function create ( $fb_id, $name, $fb_name = null ) {
		$fb = new FacebookCustomApi();
		
		$fb->data['FACEBOOKID'] 	= $fb_id;
		$fb->data['NAME'] 			= $name;
		$fb->data['FACEBOOKNAME'] 	= $fb_name;
		$fb->data['LASTUPDATEON'] 	= KdObject::now();
		
		$fb->save();
		return $fb->id;
	}
}