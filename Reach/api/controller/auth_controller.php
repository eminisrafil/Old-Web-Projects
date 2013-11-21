<?php
	require_once("../model/auth_model.php");
	require_once("../helper_validation.php");
	header('Content-type: application/json');

	session_start();

	//default error message---probably shouldn't use a global--and name it array even less so
	$userLoginArray = array('msg'       => 'Oops, we messed up. Try again soon.',
				   'success'            => 0,
				   'registration_state' => '',
				   'user_id'            => '',
				   'email'              => '',
				   'username'           => '',
				   'token'              => '');

	if ( isset($_POST['registration_state'])){
		capture();
	} else{
		echo die(json_encode($userLoginArray));
	} 

	function capture() {
		$userLoginArray['registration_state'] = (int)$_POST['registration_state'];	
		direct($userLoginArray['registration_state']);
	}

	//directs action depending on registration state
	function direct($i) {
		switch ($i) {
			case 1:
				if (isset($_POST['identity']) && isset($_POST['password2'])) {
					$login = new Login;
			    }
			    break;
			case 2:
			    break;
			case 3:
			    $register = new Registration;
			    break;
			default: 
				echo die(json_encode($userLoginArray));
		}
	}

	class login {
		private $identity_type;
		private $identity;
		private $password;
		public  $msg;
		private $pass_sha;

		public function __construct() {
			$this->identity_type = $this->filter($_POST['identity']);
			$this->password      = $this->filter($_POST['password2']);
			$this->pass_sha      = hash('sha256', $this->password.SALT);
			
			//check if user loged in using a username or email
			if (validate_email($this->identity_type)) {
				$this->identity = $this->identity_type;
				$this->identity_type = 'email';
			} else if (validate_username($this->identity_type)){
				$this->identity = $this->identity_type;
				$this->identity_type = 'username';
			}
			
			$this->login();
		}
		
		public function login() {
			global $userLoginArray;
			//make sure password and identity fields are defined
			if ((validate_password($this->password)===0) || ($this->identity===NULL)) {
				$userLoginArray['msg'] = 'Hmm, doesn\'t seem like a valid login';
				echo json_encode($userLoginArray);
				die;
			}
			///attempt to login
			$login_attempt = new Login_model(
				$this->identity_type,
				$this->identity,
				$this->pass_sha
			);
			
			if ($login_attempt->success ===1){
				$userLoginArray['msg'] = 'loggin in now';
				$userLoginArray['success'] = 1;
				$userLoginArray['user_id'] = $_SESSION['user_id']; 
				echo json_encode($userLoginArray);
			} else {
				$userLoginArray['msg'] = 'Sorry bro, you\'re not on the list';
				$userLoginArray['success'] = 0;
				$userLoginArray['user_id'] = 0; 
				echo json_encode($userLoginArray);
			}

		}
		
		public function filter($var) {
			$var = trim($var);	
			return $var;
		}
	}

	class Registration {

		public $success;
	  	public $username;
	  	private $password;
	  	private $pass_sha;
	  	private $email;
	  	private $first_name;
		private $last_name;

		public function __construct() {

			$this->username   = $this->filter($_POST['new_username']);
			$this->password   = $this->filter($_POST['new_password']);
			$this->email      = $this->filter($_POST['new_email']);
			$this->first_name = $this->filter($_POST['first_name']);
			$this->last_name  = $this->filter($_POST['last_name']);
			$this->pass_sha  = hash('sha256', $this->password.SALT);
			
			$this->register();
		}
		
		public function filter($var) {
			$var = trim($var);	
			return $var;
		}
			
		public function register() {
			$new_entry =  new Registration_model(
				$this->username,
				$this->pass_sha, 
				$this->email,
				$this->first_name,
				$this->last_name	
			);
			
			if ($new_entry->success ===1){
				$userLoginArray['msg'] = 'loggin in now';
				$userLoginArray['success'] = 1;
				$userLoginArray['user_id'] = $_SESSION['user_id']; 
				$_SESSION['logged_in'] = 1;
				echo json_encode($userLoginArray);
			} else {
				$userLoginArray['msg'] = $new_entry->success;
				$userLoginArray['success'] = 0;
				$userLoginArray['user_id'] = 0; 
				echo json_encode($userLoginArray);
			}
		}
	}

?>
