<?php
	require_once("database.php");

	class Auth_model {
		public $db;

		public function __construct() {
			$this->db = new MySQLDatabase();
		}

	}

	class Registration_model extends Auth_model {
		
		public $success = 'Error, try again soon.';
	  	public $result;
	  	private $data = array();


		public function __construct($a,$b,$c,$d,$e) {
			parent::__construct();
			$this->data['username']   = $db->escape($a);		
			$this->data['password']   = $db->escape($b);	
			$this->data['email']      = $db->escape($c);	
			$this->data['first_name'] = $db->escape($d);	
			$this->data['last_name']  = $db->escape($e);	

			
			$this->run_register();
		}

		public function run_register() {
			
			if ($db->exists('username','users', "email = '" . $this->data['email'] . "'")===0){
				if ($db->exists('username','users', "username = '" . $this->data['username'] . "'")!==0){
		 	 		$this->data['username'] = 'yellow';
		 		} 
				$this->result = $db->insert_array('users', $this->data);
				if ($this->result['mysql_affected_rows']===1){
					$_SESSION['user_id']  = $this->result['mysql_insert_id'];
					$_SESSION['username'] = $this->data['username'] ;
					$_SESSION['email']    = $this->data['email'];
					$_SESSION['logged_in'] = 1;
					return $this->success = 1;
				}
		 	} else {
		 		return $this->success= 'This email is already registered';
		 	}		
		}
	}

	class Login_model extends Auth_model {
		public $identity_type;
		public $identity;
		private $password;
		public $success;
		public $msg;

		public function __construct($a,$b,$c) {
			parent::__construct();
			$this->identity_type   = $this->db->escape($a);		
			$this->identity        = $this->db->escape($b);	
			$this->password        = $this->db->escape($c);
			
			$this->run_login();
		}
		
		public function run_login() {

			$where = sprintf("%s = '%s' AND password = '%s'", $this->identity_type, $this->identity,
					 $this->password);
					 
			$result = $this->db->exists('*','users', $where);	 
			if ($result !== 0){
					while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						 $_SESSION['user_id']   = $row['user_id'];
						 $_SESSION['username']  = $row['username'];
						 $_SESSION['email']     = $row['email'];
						 $_SESSION['logged_in'] = 1;
					}
					return $this->success = 1;
		 	} else {
		 		session_destroy();
		 		$_SESSION['logged_in'] = 0;
		 		return $this->success = 0;
			}
		}
	}

	class Forgot_model {
	//forgot password
	}

?>
