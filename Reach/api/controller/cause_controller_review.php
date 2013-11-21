	<?php
	require_once("../model/group_model.php");
	require_once("../helper_validation.php");
	header('Content-type: application/json');
	//controller
	session_start();

	$group_array = array('msg'          => 'Oops, we messed up. Try again soon.',
				   'success'            => 0,
				   'group_action'       => -1,
				   'session_logged in'  => $_SESSION['logged_in']);
				  

	if (isset($_POST['group_action']) && ($_SESSION['logged_in'] === 1) && isset($_SESSION['user_id'])){
		capture();
	} else{
		echo die(json_encode($group_array));
	} 

	function capture() {
		$group_array['group_action'] = (int)$_POST['group_action'];	
		direct($group_array['group_action']);
	}

	//directs action depending on registration state
	function direct($i) {
		switch ($i) {
			case 0:
				$new_group = new create_group;
				$new_group->create_new_group();
				break;
			case 1:
				$search = new search_group;
				$search->initial_search_group();
				break;
			case 2:
				$join = new join_group;
				$join->start_join_group($join->join_array);
				break;
			case 3:
				$search = new search_group;
				$search->my_search_group();
				break;
			case 4:
				$join = new join_group;
				$join->start_unjoin_group($join->join_array);
				break;
			case 5:
				$search = new search_group;
				$search->show_one();
				break;				
			default: 
				echo die(json_encode($group_array));
		}
	}

	class create_group {

		public $create_group_array = array();

		public function __construct() {
			$this->create_group_array['group_name']      = $this->filter($_POST['group_name']);
			$this->create_group_array['description']     = $this->filter($_POST['description']);
			$this->create_group_array['location_name']   = $this->filter($_POST['location']);
			$this->create_group_array['privacy']         = (int)$this->filter($_POST['privacy']);
			$this->create_group_array['lat']             = $this->filter($_POST['lat']);
			$this->create_group_array['lng']             = $this->filter($_POST['lng']);
			$this->create_group_array['state']           = $this->filter($_POST['state']);
			$this->create_group_array['user_id']         = (int)$this->filter($_SESSION['user_id']);
			$this->create_group_array['created_by_name'] = $this->filter($_SESSION['username']);
			if($_POST['password']!==""){		
				$this->create_group_array['password']        = hash('sha256', $this->filter($_POST['password'].SALT));
			}
		}
	
		public function create_new_group() {	
			//need to add validation with regex
			$this->create_group_array['action'] = 0;
			$create = new create_group_model($this->create_group_array);
			$data = $create->insert_new_group($create->input);
		
			///after group is created, join it
			if($data['success']===1) {
				$join = new join_group;
				$join->start_join_group(array(
					'user_id' => $this->create_group_array['user_id'], 
					'group_id'=> (int)$data['results'][0],
					'privacy' => $this->create_group_array['privacy'],  
					'password'=> @$this->create_group_array['password'],
				));
			}
			echo die(json_encode($data));
		}
	
		public function filter($var) {
			$var = trim($var);	
			return $var;
		}

	}

	class search_group{
		public $search_group_array = array();
	
		public function __construct() {
			//$this->search_group_array['keyword']  = $this->filter($_POST['keyword']);
			@$this->search_group_array['lat']       = $this->filter($_POST['lat']);
			@$this->search_group_array['lng']       = $this->filter($_POST['lng']);		
			$this->search_group_array['user_id']    = (int)$this->filter($_SESSION['user_id']);
			@$this->search_group_array['group_id']  = (int)$this->filter($_POST['group_id']);
		}
	
		public function filter($var) {
			$var = trim($var);	
			return $var;
		}
		//show local groups that i am not a part of
		public function initial_search_group() {
			$this->search_group_array['action']    = 1;
			$search_c = new search_group_model($this->search_group_array);
			$data  = $search_c->default_list_groups();
			echo json_encode($data);
		}
		///show my groups
		public function my_search_group() {
			$this->search_group_array['action']    = 3;
			$search_c = new search_group_model($this->search_group_array);
			$data = $search_c->my_list_groups($search_c->input['user_id']);
			echo json_encode($data);
		}
		//show one group profile
		public function show_one() {
			$this->search_group_array['action']    = 5;
			$this->search_group_array['privacy']   = (int)$this->filter($_POST['privacy']);
			$show = new search_group_model($this->search_group_array);
			$data = $show->show_one($show->input['user_id'],$show->input['group_id'],(int)$show->input['privacy']);
			echo json_encode($data);
		}
	
	
	}

	class join_group {
		public $join_array = array();

		public function __construct() {
			$this->join_array['user_id']     = (int)$this->filter($_SESSION['user_id' ]);
			@$this->join_array['group_id']   = (int)$this->filter($_POST['group_id']);
			$this->join_array['action']      = (int)$_POST['group_action'];
			@$this->join_array['privacy']    = (int)$this->filter($_POST['privacy']);
			if((int)$this->join_array['privacy'] !==0 ){
				$this->join_array['password']   = hash('sha256', $this->filter($_POST['password'].SALT));
			}
		}
	
		public function filter($var) {
			$var = trim($var);	
			return $var;
		}
		//join group, only send info to client if they requested it with corresponding action 2/4
		public function start_join_group($group) {
			$join_c = new join_group_model($group);
			$data = $join_c->join_group();
			if(@$group['action']===2) {
				echo json_encode($data);
			}
		}
	
		public function start_unjoin_group($group) {
			$join_c = new join_group_model($group);
			$data = $join_c->unjoin_group();
			if(@$group['action']===4){
				echo json_encode($data);
			}
		}
	}

	?>
