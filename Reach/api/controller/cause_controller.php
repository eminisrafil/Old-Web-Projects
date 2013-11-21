<?php
session_start();
require_once("../model/cause_model.php");
require_once("../helper_validation.php");
header('Content-type: application/json');
//controller

if (isset($_POST['cause_action']) && ($_SESSION['logged_in'] === 1) && isset($_SESSION['user_id'])){
	capture();
} else{
	$cause_array = array(
			   'msg'                => 'Oops, we messed up. Try again soon.',
			   'success'            => 0,
			   'cause_action'       => -1,
			   'session_logged_in'  => $_SESSION['logged_in']
			   );
	echo die(json_encode($cause_array));
} 

function capture() {
	$cause_array['cause_action'] = (int)$_POST['cause_action'];	
	direct($cause_array['cause_action']);
}

//directs action depending on registration state
function direct($i) {
	switch ($i) {
		case 0:
			$new_cause = new create_cause;
			$new_cause->create_new_cause();
		    break;
		case 1:
			$search = new search_cause;
			$search->initial_search_cause();
		    break;
		case 2:
			$join = new join_cause;
			$join->start_join_cause($join->join_array);
		    break;
		case 3:
			$search = new search_cause;
			$search->my_search_cause();
			break;
		case 4:
			$unjoin = new join_cause;
			$unjoin->start_unjoin_cause($unjoin->join_array);
		    break;
		case 5:
			$search = new search_cause;
			$search->show_one();
		    break;				
		default: 
			echo die(json_encode($cause_array));
	}
}

class create_cause {

	public $create_cause_array = array(
		'cause_name'      => $this->filter($_POST['cause_name']),
		'description'     => $this->filter($_POST['description']),
		'location_name'   => $this->filter($_POST['location']),
		'privacy'         => (int)$this->filter($_POST['privacy']),
		'lat'             => $this->filter($_POST['lat']),
		'lng'             => $this->filter($_POST['lng']),
		'state'           => $this->filter($_POST['state']),
		'user_id'         => (int)$this->filter($_SESSION['user_id']),
		'created_by_name' => $this->filter($_SESSION['username']),
	);

	public function __construct() {
		if($_POST['password']!==""){		
			$this->create_cause_array['password'] = hash('sha256', $this->filter($_POST['password'].SALT));
		}
	}
	
	public function create_new_cause() {	
		//need to add validation with regex
		$this->create_cause_array['action'] = 0;
		$create = new create_cause_model($this->create_cause_array);
		$data = $create->insert_new_cause($create->input);
		
		///after cause is created, join it
		if($data['success']===1) {
			$join = new join_cause;
			$join->start_join_cause(array(
				'user_id' => $this->create_cause_array['user_id'], 
				'cause_id'=> (int)$data['results'][0],
				'privacy' => $this->create_cause_array['privacy'],  
				'password'=> @$this->create_cause_array['password'],
			));
		}
		echo die(json_encode($data));
	}
	
	public function filter($var) {
		$var = trim($var);	
		return $var;
	}
}

class search_cause{
	public $search_cause_array = array();
	
	public function __construct() {
		//$this->search_cause_array['keyword']  = $this->filter($_POST['keyword']);
		@$this->search_cause_array['lat']       = $this->filter($_POST['lat']);
		@$this->search_cause_array['lng']       = $this->filter($_POST['lng']);		
		$this->search_cause_array['user_id']    = (int)$this->filter($_SESSION['user_id']);
		@$this->search_cause_array['cause_id']  = (int)$this->filter($_POST['cause_id']);
	}
	
	public function filter($var) {
		$var = trim($var);	
		return $var;
	}
	
	public function initial_search_cause() {
		$this->search_cause_array['action']    = 1;
		$search_c = new search_cause_model($this->search_cause_array);
		$data  = $search_c->default_list_causes();
		echo json_encode($data);
	}
	
	public function my_search_cause() {
		$this->search_cause_array['action']    = 3;
		$search_c = new search_cause_model($this->search_cause_array);
		$data = $search_c->my_list_causes($search_c->input['user_id']);
		echo json_encode($data);
	}
	
	public function show_one() {
		$this->search_cause_array['action']    = 5;
		$this->search_cause_array['privacy']   = (int)$this->filter($_POST['privacy']);
		$show = new search_cause_model($this->search_cause_array);
		$data = $show->show_one($show->input['user_id'],$show->input['cause_id'],(int)$show->input['privacy']);
		echo json_encode($data);
	}
}

class join_cause {
	public $join_array = array();

	public function __construct() {
		$this->join_array['user_id']     = (int)$this->filter($_SESSION['user_id' ]);
		@$this->join_array['cause_id']   = (int)$this->filter($_POST['cause_id']);
		$this->join_array['action']      = (int)$_POST['cause_action'];
		@$this->join_array['privacy']    = (int)$this->filter($_POST['privacy']);
		if((int)$this->join_array['privacy'] !==0 ){
			$this->join_array['password']   = hash('sha256', $this->filter($_POST['password'].SALT));
		}
	}
	
	public function filter($var) {
		$var = trim($var);	
		return $var;
	}
	
	public function start_join_cause($cause) {
		$join_c = new join_cause_model($cause);
		$data = $join_c->join_cause();
		if(@$cause['action']===2) {
			echo json_encode($data);
		}
	}
	
	public function start_unjoin_cause($cause) {
		$join_c = new join_cause_model($cause);
		$data = $join_c->unjoin_cause();
		if(@$cause['action']===4){
			echo json_encode($data);
		}
	}
}

?>
