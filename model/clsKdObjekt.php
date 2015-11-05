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
		$spatial = "";
		if ($this->tablename == 'Events')
			$spatial = ", x(PlaceLngLat) AS Lng, y(PlaceLngLat) AS Lat ";
		
		$sql = sprintf( "SELECT *".$spatial." FROM %s", $this->tablename );
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
		$spatial = "";
		if ($this->tablename == 'Events')
			$spatial = ", x(PlaceLngLat) AS Lng, y(PlaceLngLat) AS Lat ";
		
		$sql = sprintf( "SELECT *".$spatial." FROM %s WHERE %s = '%s'", $this->tablename, $this->table_pk, $id);
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
				else {
					if (strpos($v,'LngLat') !== false){
						$value = "GeomFromText('POINT(".$this->data[$k].")')";
						$sql[] = sprintf(' %s=%s ', $v , $value );
					}else{
						$value = addslashes( $this->data[$k] );
						$sql[] = sprintf(' %s=\'%s\' ', $v , $value );
					}
				}
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
	
	function prepared_save() {
		$type = "prepared";
		require($_SERVER["DOCUMENT_ROOT"]."/inc/mysqlConnect.php");
		$columns = '';
		$question = '';
		foreach ( $this->keymap as $k => $v ) {
			if ($v == 'ID')
				continue;
			$columns .= "{$v},";
			if (strpos($v,'LngLat') !== false)
				$question .= "GeomFromText(?),";
			else
				$question .= "?,";
		}
		$columns = rtrim($columns, ",");
		$question = rtrim($question, ",");
		$stmt_names = $con->prepare('SET NAMES utf8');
		$stmt = $con->prepare(sprintf("INSERT INTO %s (%s) VALUES (%s)", $this->tablename, $columns, $question));
		
		$params = array_values($this->data);
		
		$param_type = '';
		foreach($this->data as $dt){
			$param_type .= 's';
		}
		
		$a_params[] = & $param_type;
		
		for($i = 0; $i < count($params); $i++) {
			$a_params[] = & $params[$i];
		}
		
		call_user_func_array(array(&$stmt, 'bind_param'), $a_params);
		
		$stmt_names->execute();
		$result = $stmt->execute();
		$this->id = $stmt->insert_id;
		
		return $result;
	}
	
	function now(){
		return date( "Y-m-d H:i:s" );
	}
	
}