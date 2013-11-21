<?php
	require_once("database.php");

	class model {
		public $data = array(
			'success'=>0,
			'msg' =>'There was a small problem, try again soon.',
			'data_type' => 'cause',
			'action' => '',
			'results'=> array(),
			);
		public $input = array();	
		public $exclude =array();

		public function __construct($a) {
			$db = new MySQLDatabase();
			$db->escape($a);
			$this->input = $db->escape($a);
			@$this->data['action'] = $a['action'];
		}
	//move insert and data return up here

	}
			
	class create_cause_model extends model {

		public function insert_new_cause($a) {
			Global $db;
			$b = $db->insert_array('cause', $a, 'action');
			//move standard insert and data return up to model
			if ($b['mysql_affected_rows']===1) {
				$this->data['success'] = 1;
				$this->data['msg'] = 'Congrats, you created a new cause.';
				array_push($this->data['results'], $b['mysql_insert_id']);
				return $this->data;
			} else {
				$this->data['success'] = 0;
				$this->data['msg'] = 'No cause created, try again soon.';
				return $this->data;
			}			
		}
		
	}

	class search_cause_model extends model {

		public function default_list_causes() {
			$this->list_causes($this->input['lat'], $this->input['lng'], 'cause', 10, 30, $this->input['user_id'], 'all' );
			$this->data['msg'] = 'Updated';
			return $this->data;
		}
		
		public function custom_list_causes() {//add custom settings
			$this->list_causes($this->input['lat'], $this->input['lng'], 'cause', 10, 10);
		}
		
		public function my_list_causes($id){
			//fix distance 10000 here, so it doesnt take into account distance
			Global $db;
			$b = $db->def_c_list($this->input['lat'], $this->input['lng'], 'cause', 10000, 30, (int)$id, 'mine');
			
			if ($b !== 0) {
				$this->data['success'] = 1;
				while ($row = mysql_fetch_array($b, MYSQL_ASSOC)) {
					array_push($this->data['results'], $row);
				}
				$this->data['msg'] = 0;
				return ($this->data);		
		 	} else {
		 		$this->data['msg'] = 'There was a small problem, try again soon.';
		 		$this->data['success'] = 0;
		 		return ($this->data);
			}	
		}
		
		public function show_one($user_id, $cause_id, $privacy) {
		Global $db;
			(bool)$confirm = FALSE;
			
			if($privacy === 0){
				$confirm  = TRUE;
			}else {
				$confirm  = FALSE;
				$privacy = 1;
			}

			if(!$confirm){
				$s = 'cause_id';
				$f = 'user_cause_rel';
				$w = sprintf("user_id =%d AND cause_id=%d",$user_id, $cause_id);
				$b = $db->exists($s,$f,$w);
				if(mysql_num_rows($b) ===1 && !is_num($b)) {
					$confirm=true;
				}
			}
			
			
			
			if($confirm){
				$s = 'cause_id,cause_name,location_name,description,
				user_id,lat,lng,created_by_name,state';
				$f = 'cause';
				$w = sprintf("cause_id=%d AND privacy=%d",(int)$cause_id, (int)$privacy);
				$b = $db->exists($s,$f,$w);
				if(mysql_num_rows($b) ===1 && !is_int($b)) {
					$this->data['success'] = 1;
					$this->data['msg'] = 0;
					while ($row = mysql_fetch_array($b, MYSQL_ASSOC)) {
						array_push($this->data['results'], $row);
					}
					//$users = $this->cause_mems($user_id, $cause_id);
					$this->data['results'][0]['peeps']= $this->cause_mems($user_id, $cause_id);
					$this->data['results'][0]['total_peeps']= $this->cause_mems_count($cause_id);
					return ($this->data);
				}
			}
			
			$this->data['msg'] = 'There was a small problem, try again soon.';
		 	$this->data['success'] = 0;
		 	echo 'still going';
		 	return ($this->data);
		}
		
		public function cause_mems($me, $cause_id) {
			$result = array();
			//$num_users = $this->cause_mems_count($cause_id);
			//array_push($this->data['results'], $num_users['results']);
			$q = sprintf("
				SELECT 
					t1.cause_id, t2.user_id, t2.username, t2.first_name, t2.last_name, t2.user_id = %d as me
				FROM user_cause_rel t1
				LEFT JOIN users t2 ON t1.user_id = t2.user_id
				WHERE  cause_id = %d and status = 1
				ORDER BY me desc",
			(int)$me, (int)$cause_id);
			$b = $db->query($q);
			if ($b !== 0 and is_resource($b)) {
				while ($row = mysql_fetch_array($b, MYSQL_ASSOC)) {
						array_push($result, $row);
				}
				return $result;		
		 	} else {
		 		return 'err';
			}
		
		}
		
		public function cause_mems_count($cause_id) {
		Global $db;
			$result = array();
			$q = sprintf("
				SELECT 
				count(t1.user_id) as peeps
				FROM user_cause_rel t1
				WHERE  cause_id = %d and t1.status = 1",
			(int)$cause_id);
			
			$b = $db->query($q);
			if ($b !== 0 and is_resource($b)) {
				while ($row = mysql_fetch_array($b, MYSQL_ASSOC)) {
						array_push($result, $row);
				}
				return $result[0]['peeps'];		
		 	} else {
		 		return 'err';
			}
		
		}
		
		private function list_causes($lat, $lng, $table, $distance, $limit, $id, $whos) {		
		Global $db;
			$b = $db->def_c_list($lat, $lng, $table, $distance, $limit, (int)$id, $whos);
			if ($b !== 0) {
				$this->data['success'] = 1;
				while ($row = mysql_fetch_array($b, MYSQL_ASSOC)) {
					array_push($this->data['results'], $row);
				}
				return ($this->data);		
		 	} else {
		 		$this->data['msg'] = 'There was a small problem, try again soon.';
		 		$this->data['success'] = 0;
		 		return ($this->data);
			}

		}
	}

	class join_cause_model extends model {

		public function join_cause() {
		Global $db;
			$pass = 0;
			if(array_key_exists('password', $this->input) && strlen($this->input['password'])>20) {
				$pass = $db->pass_check('cause', $this->input['cause_id'],$this->input['password'] );
			}
			else {
				$pass = $db->pass_check('cause', $this->input['cause_id'],'NULL' );
			}

			
			if($pass !==0) {	
				array_push($this->exclude, 'password', 'action');
				$b = $db->insert_array('user_cause_rel',$this->input, $this->exclude);
				//echo print_r($b);
				if ($b !== 0) {
					$this->data['success'] = 1;
					$this->data['results'] = $this->input['cause_id'];
					$this->data['msg'] = 'Awesome, you joined a new cause. ';
					return ($this->data);		
			 	} else {
			 		$this->data['msg'] = 'There was a small problem, try again soon.';
			 		$this->data['success'] = 0;
			 		return ($this->data);
				}
			}	
		}
		
		public function unjoin_cause() {
		Global $db;
			$b = $db->delete('user_cause_rel', (int)$this->input['user_id'], (int)$this->input['cause_id']);
			if ($b !== 0) {
				$this->data['success'] = 1;
				$this->data['results'] = $this->input['cause_id'];
				$this->data['msg'] = 'Awesome, you left that cause. Good ridance. ';
				return ($this->data);		
		 	} else {
		 		$this->data['msg'] = 'There was a small problem, try again soon.';
		 		$this->data['success'] = 0;
		 		return ($this->data);
			}
		}
		
		
	}

