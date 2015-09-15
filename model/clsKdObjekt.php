<?php

/* An implementation of the Active record pattern.
 * http://stackoverflow.com/questions/12564328/php-parent-subclass-db-operations*/
class KdObject {
	
	protected $tablename;
	protected $table_pk;
	public $id;
	protected $data = array();
	protected $keymap = array();
	
	function fetchAll ()
	{
		require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
		
		$sql = sprintf( "SELECT * FROM %s", $this->tablename );
		$con->query("SET NAMES utf8");
		$result = $con->query($sql);
		
		$res = array();
		while($row = $result->fetch_assoc()){
			$res[] = $row;
		}
		$con->close();
		return $res;
	}
	
	function fetchObjectByID ( $id ) {
		require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
		$sql = sprintf( "SELECT * FROM %s WHERE %s = '%s'", $this->tablename, $this->table_pk, $id);
		$con->query("SET NAMES utf8");
		$result = $con->query($sql);
		
		$row = $result->fetch_assoc();
		$con->close();
		return $row;
	}
	
	function save () {
		require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
		foreach ( $this->keymap as $k => $v ) {
			if( array_key_exists( $k, $this->data ) ) {
				if ( is_null( $this->data[$k] ) ) {
					$sql[] = sprintf(' %s = NULL ', $v );
				}
				else
					$sql[] = sprintf(' %s=\'%s\' ', $v , addslashes( $this->data[$k] ) );
			}
		}
		
		$q = sprintf( "INSERT INTO %s SET %s", $this->tablename, join(",",$sql));
		$con->query("SET NAMES utf8");
		$result = $con->query($q);
		
		$this->id = $con->insert_id;
		
		$con->close();
		
		if ( $result )
			return true;
		else 
			return false;
	}
	
	function now(){
		return date( "Y-m-d H:i:s" );
	}
	
}