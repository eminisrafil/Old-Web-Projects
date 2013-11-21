<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
	    	$update = array();
		    $u = $this->db->where('id', '1')->select('username, email, description, privacy')->get('users')->row();
		    if ('adminine' != $u->username)
		    {
			    $update['username'] = 'adminin';
		    }
		    echo '<pre>';
		    print_r($update);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */