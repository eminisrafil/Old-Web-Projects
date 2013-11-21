<?php
	function validate_email($email) {
		$regex = '/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
		return preg_match($regex, $email);
	}

	function validate_username($u) {
		$regex = '/^[A-Za-z](?=[A-Za-z0-9_.]{3,20}$)[a-zA-Z0-9_]*\.?[a-zA-Z0-9_]*$/';
		return preg_match($regex, $u);
	}

	function validate_name($name) {
		$regex = '/^[a-zA-Z\-_\.]{1,20}$/';
		return preg_match($regex, $name);
	}

	function validate_password($pass) {
		$regex = '/^.{8,20}$/';
		return preg_match($regex, $pass);
	}
?>
