<?php
require_once('../config/config.php');

class MySQLDatabase {
	
	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	
  function __construct() {
    $this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
  }

	public function open_connection() {
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this->connection) {
			die("Database connection failed: " . mysql_error());
		} else {
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if (!$db_select) {
				die("Database selection failed: " . mysql_error());
			}
		}
	}

	public function close_connection() {
		if(isset($this->connection)) {
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}
	
	public function escape($q) {
	
		if(is_array($q)) 
		    foreach($q as $k => $v) 
		        $q[$k] = $this->escape($v); 
		else if(is_string($q)) {
		    $q = mysql_real_escape_string($q);
		}    
		return $q;
	}
	
	private function confirm_query($result) {
		if (!$result) {
	    $output = "Database query failed: " . mysql_error() . "<br /><br />";
	    die( $output );
		}
	}
	
	public function exists($s,$f, $w) { 
		//rewrite bottom 2 functions rid of this function
		$q = sprintf("SELECT %s FROM %s WHERE %s LIMIT 1",$s,$f, $w);
		//echo $q;
		$result = $this->query($q);
		if (mysql_num_rows($result)===0) {
			return 0;
		} else if (mysql_num_rows($result)===1) {
			return $result;
		} else{
			return 0;
		}
		
	}
	
	public function pass_check($t, $id, $p) {
		if ($p==='NULL'){
			$q = sprintf("SELECT * FROM %s WHERE %s_id = %s AND password is NULL", $t,$t,$id); 
		}
		else{
			$q = sprintf("SELECT * FROM %s WHERE %s_id = %s AND password = '%s'", $t,$t,$id,$p);
		}
		$result = $this->query($q);
		if (mysql_num_rows($result)===0) {
			return (int)0;
		} else if (mysql_num_rows($result)>0) {
			return $result;
		}
	}

	
	public function insert_array($table, $data, $exclude = array()) {
	 
		$fields = $values = array();
		if( !is_array($exclude) ) $exclude = array($exclude);
	 
		foreach( array_keys($data) as $key ) {
		    if( !in_array($key, $exclude) ) {
		        $fields[] = "`$key`";
		        $values[] = "'" .$data[$key] . "'";
		    }
		}
	 
		$fields = implode(",", $fields);
		$values = implode(",", $values);
		
		if( mysql_query("INSERT INTO `$table` ($fields) VALUES ($values)") ) {
		    return array( "mysql_error" => false,
		                  "mysql_insert_id" => mysql_insert_id(),
		                  "mysql_affected_rows" => mysql_affected_rows(),
		                  "mysql_info" => mysql_info()
		                );
		} else {
			echo print_r(array( "mysql_error" => mysql_error() ));
		    return 0;
		}
	}
	
	public function def_c_list($lat, $lng, $table, $dist, $limit, $id, $whos='all') {
		//either refactor to make this function more flexible or get rid of table variable
		$where = '';
		if(is_int($id) && $id>0 && $id < 100000 && $whos == 'all'){
			//subquery used to display only causes the user is NOT IN- probably a better way to do this
			$where = sprintf("
				t2.cause_id NOT IN (
				SELECT user_cause_rel.cause_id
				FROM user_cause_rel
				WHERE user_cause_rel.user_id =%d)",
			(int)$id);
		} else if (is_int($id) && $id>0 && $id < 100000 && $whos == 'mine') {
			$where = 't3.user_id = '  . (int)$id;
		} else {
			echo 'fail!';
			return 0;
		}
		$d_formula = $this->distance_formula($lat, $lng, 't1');
		//sorry for this query
		$q = sprintf("
			SELECT
				t1.cause_id, t1.cause_name, t1.location_name, t1.description, t1.lat, t1.lng, 						  t1.privacy,t2.peeps, %s
			FROM %s AS t1
			JOIN (SELECT cause_id, count(cause_id) as peeps
				  FROM user_cause_rel
				  GROUP BY cause_id) t2
				  ON t1.cause_id = t2.cause_id			
			JOIN (SELECT user_cause_rel.cause_id, user_cause_rel.user_id
			      FROM user_cause_rel ) t3
			      ON t1.cause_id = t3.cause_id
			WHERE %s 
			GROUP BY t1.cause_id
			HAVING distance < %s
			ORDER BY distance
			LIMIT %s",
		$d_formula, $table, $where,$dist, $limit );

		$result = $this->query($q);
		if (mysql_num_rows($result)===0) {
			return 0;
		} else if (mysql_num_rows($result)>0) {
			return $result;
		}
	}	
	
	function delete($table,$uid,$cid) {
		$q = sprintf('
			DELETE FROM `Reachly`.`%s`
			WHERE `%s`.`user_id` = %d
			AND `%s`.`cause_id` = %d
			',$table, $table, $uid,$table, $cid
		); 
		//echo $q;
		$result = $this->query($q);
		if ($result===0) {
			return 0;
		} else if ($result===1) {
			return $result;
		}	
	}
	
	public function distance_formula($lat, $lng, $table) {
		//get rid of the round after'SELECT *,' for more accurate results
		$q = sprintf("round(3956 * 2 * ASIN(SQRT( POWER(SIN((%s -abs(%s.lat)) * pi()/180 / 2),2) + COS(%s * pi()/180 ) * COS(abs(%s.lat) *  pi()/180) * POWER(SIN((%s - %s.lng) *  pi()/180 / 2), 2) )),2) as distance ", $lat, $table, $lat, $table, $lng, $table);
		return $q;
	}	

}
	$database = new MySQLDatabase();
	$db =& $database;