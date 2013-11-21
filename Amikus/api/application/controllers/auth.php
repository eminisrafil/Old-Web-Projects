<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Auth extends REST_Controller
{

	function login_post()
    {
    	$error = array();
	    $this->load->model('ion_auth_model');
	    if ((filter_var( $this->post('identity'), FILTER_VALIDATE_EMAIL ) == false) && $this->ion_auth_model->identity_check($this->post('identity')))
	    {
		    if ($this->ion_auth_model->login($this->post('identity'), $this->post('password'), false, 'username'))
		    {
			    $id = $this->ion_auth_model->user()->id;
			    $key = self::_generate_key();
			    self::_insert_key($key, $id);
		    } else {
			    //invalid pass
			    array_push($error, 'invalid_password');
		    }
	    } elseif ($this->ion_auth_model->email_check($this->post('identity'))){
		    if ($this->ion_auth_model->login($this->post('identity'), $this->post('password'), false, 'email'))
		    {
			    $id = $this->ion_auth_model->user()->id;
			    $key = self::_generate_key();
			    self::_insert_key($key, $id);
		    } else {
			    //invalid pass
			    array_push($error, 'invalid_password');
		    }
	    } else {
		    array_push($error, 'identity_not_found');
	    }
	    
    	if (count($error) == 0)
    	{
			$message = array('response' => 'success', 'id' => $id, 'key' => $key);
	    } else {
		    $message = array('response' => 'error', 'error' => $error);
	    }
	    
	    $this->response($message, 200);

    }
    
    function register_post()
    {
	    $this->load->model('ion_auth_model');
    	$error = array();
    	//require username, email, password1 password2
    	//is email set
    	if (strlen($this->post('email')) == 0)
    	{
	    	array_push($error, 'email_missing');
    	}
    	//is username set
    	if (strlen($this->post('username')) == 0)
    	{
	    	array_push($error, 'username_missing');
    	}
    	//is pass1 set
    	if (strlen($this->post('password'))== 0)
    	{
	    	array_push($error, 'password_missing');
    	}

    	//if email valid
    	if (filter_var( $this->post('email'), FILTER_VALIDATE_EMAIL ) == false)
    	{
	    	array_push($error, 'email_invalid');
    	}
    	
    	//check if email unique
    	if ($this->ion_auth_model->email_check($this->post('email')))
    	{
	    	array_push($error, 'email_taken');
    	}
    	//if username is valid (no invalid characters
    	//if username valid size
    	if ((strlen($this->post('username')) < 5) || (strlen($this->post('username')) > 25))
    	{
	    	array_push($error, 'username_size');
    	}
    	//check if username unique
    	if ($this->ion_auth_model->identity_check($this->post('username')))
    	{
	    	array_push($error, 'username_taken');
    	}
    	//check if password1 valid size
    	if ((strlen($this->post('password')) < 6) || (strlen($this->post('password')) > 25))
    	{
	    	array_push($error, 'password_size');
    	}

    	
    	
    	if (count($error) == 0)
    	{
	    	$id = $this->ion_auth_model->register($this->post('username'), $this->post('password'), $this->post('email'), $additional_data = array(), $groups = array());
	    	if ($id != false)
	    	{
		    	$message = array('response' => 'success', 'id' => $id);
	    	} else {
		    	$message = array('response' => 'error', 'error' => 'registration');
	    	}
	    
	    } else {
		    $message = array('response' => 'error', 'error' => $error);
	    }
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function user_get()
    {
	    //send username, full_name, description, privacy, email
	    $id = $this->get('id');
	    $uid = $this->get('u');
	    //verify user
	    if (self::_verify_key($id, $key))
	    {
		    $u = $this->db->where('id', $id)->select('username, email, description, privacy')->get('users')->row();
		    $message = array('response' => 'success', 'user' => $u);
		    
	    } else {
	    	$error = array('not_logged_in');
		    $message = array('response' => 'error', 'error' => $error);
	    }
	}
	function update_post()
	{
	    //send username, full_name, description, privacy, email
	    $id = $this->get('id');
	    $uid = $this->get('u');
	    //verify user
	    if (self::_verify_key($id, $key))
	    {
	    	$u_list = array();
	    	$update = array();
		    $u = $this->db->where('id', $id)->select('username, email, description, privacy')->get('users')->row();

		    if ($this->post('email') != $u->email)
		    {
			    $update['email'] = $this->post('email');
			    array_push($u_list, 'email');
		    }
		    if ($this->post('description') != $u->description)
		    {
			    $update['description'] = $this->post('description');
			    array_push($u_list, 'description');
		    }
		    if ($this->post('privacy') != $u->privacy)
		    {
			    $update['privacy'] = $this->post('privacy');
			    array_push($u_list, 'privacy');
		    }
		    if ((strlen($this->post('old_password')) > 0) && (strlen($this->post('new_password1')) > 0) && (strlen($this->post('new_password2')) > 0))
		    {
		    	//write later
			    $message = array('response' => 'error', 'error' => $error);
		    }///added select here
		    if ($this->db->where('id', $id)->select('users', $update))
		    {
			    $message = array('response' => 'success', 'updated' => $u_list);
		    } else {
	    		$error = array('unknown');
	    		$message = array('response' => 'error', 'error' => $error);
		    }
	    } else {
	    	$error = array('not_logged_in');
		    $message = array('response' => 'error', 'error' => $error);
	    }
	    $this->response($message, 200);
	}


	// --------------------------------------------------------------------

	/* Helper Methods */
	
	private function _generate_key()
	{
		//$this->load->helper('security');
		
		do
		{
			$salt = do_hash(time().mt_rand());
			$new_key = substr($salt, 0, 33);
		}

		// Already in the DB? Fail. Try again
		while (self::_key_exists($new_key));

		return $new_key;
	}


	// --------------------------------------------------------------------

	/* Private Data Methods */
	private function _verify_key($uid, $key)
	{//added ; here 
		return ($this->db->where('key', $id)->where('user_id', $u)->count_all_results('user_tokens') > 0);
	}
	
	private function _get_key($key)
	{
		return $this->db->where('key', $key)->get('user_tokens')->row();
	}

	// --------------------------------------------------------------------

	private function _key_exists($key)
	{
		return $this->db->where('key', $key)->count_all_results('user_tokens') > 0;
	}

	// --------------------------------------------------------------------

	private function _insert_key($key, $id)
	{
		$data['user_id'] = $id;
		$data['key'] = $key;
		$data['date_created'] = function_exists('now') ? now() : time();

		return $this->db->set($data)->insert('user_tokens');
	}

	// --------------------------------------------------------------------

	private function _update_key($key, $data)
	{
		return $this->db->where('key', $key)->update('user_tokens', $data);
	}

	// --------------------------------------------------------------------

	private function _delete_key($key)
	{
		return $this->db->where('key', $key)->delete('user_tokens');
	}

}
