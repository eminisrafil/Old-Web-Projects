<?php

class Postmodel extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function countryDropdown(){
		$this->db->order_by("country_name", "ASC");
		
		$q = $this->db->get('countries');
		
		if ($q->num_rows() > 0) {
			$data['0'] = 'Select...';
			foreach ($q->result() as $row) {
				$data[$row->country_id] = $row->country_name;
			}
			return $data;
		}
	}
	
	function countComment($oidIn)
	{
		$this->db->from('comments');
		$this->db->where('oid', $oidIn);
		
		return $this->db->count_all_results();
	}

	function getObit($obit_id){
		$this->db->where('oid', $obit_id);
		
		$this->db->from('obits');
		$this->db->join('categories', 'categories.cid = obits.cid');
		$this->db->limit(1);
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			$data = $q->row();
			$data->comments = $this->countComment($data->oid);
			return $data;
		}
		
	}
	
	function get_comments($oid){
		$this->db->from('comments');
		$this->db->where('oid', $oid);
		
		$this->db->join('users', 'users.uid = comments.uid');
		$this->db->order_by("time", "ASC");
		$data = $this->db->get();
		return $data;
	}
	
	function countVote($ip, $ob)
	{
		$this->db->from('votes');
		$this->db->where('ip', $ip);
		$this->db->where('oid', $ob);
		return $this->db->count_all_results();
	}
	
	function updateVote($oid, $vote)
	{
		//check to see if ip already voted for this obit
		if (($this->countVote($this->input->ip_address(), $oid)) == 0)
		{
			if ($vote == "1")
			{
				$this->db->set('positive', 'positive+1', FALSE);
			}
			else if ($vote == "2")
			{
				$this->db->set('negative', 'negative+1', FALSE);
			}
			$this->db->where('oid', $oid);
			if ($this->db->update('obits'))
			{
				$dataIn = array(
					'oid' => $oid,
					'time' => now(),
					'ip' => $this->input->ip_address()
				);
				$this->db->insert('votes', $dataIn);
				return "Condolences recieved";
			}
			else{
				return "error";
			}
		}
		else
		{
			return "You may only vote once";
		}
	}

//Get Functions-----------------------------------------------//
	function getUID($email){
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->select('uid');
		$q = $this->db->get();
		if ($q->num_rows()>0){
			$qrow = $q->row();
			return $qrow->uid;
		}
		else
		{
			return 0;
		}
	}
	
	function getVer($uidIn)
	{
		$this->db->from('users');
		$this->db->where('uid', $uidIn);
		$q = $this->db->get();
		
		if ($q->num_rows()>0){
			$qrow = $q->row();
			
			return $qrow->password;
		}
	}
	
	function getObitByID($id, $getVer)
	{
		//get a specific obit and related user data
		$this->db->from('obits');
		$this->db->where('oid', $id);
		$this->db->limit(1);

		$q = $this->db->get();
		
		return $q;
	}
	
	function getCommentByID($id, $getVer)
	{
		//get a specific comment and related user data
		$this->db->from('comments');
		$this->db->where('com_id', $id);
		$this->db->limit(1);
		$this->db->join('users', 'users.uid = comments.uid');

		$q = $this->db->get();
		
		return $q;
	}

//Insert Functions-----------------------------------------------//
	function insertPost($type)
	{
		$this->load->library('ip2location_lite');
		$locations = $this->ip2location_lite->getCity($this->input->ip_address());
		if (!empty($locations) && is_array($locations)) {
				$country = strtolower($locations['countryName']);
				$region = strtolower($locations['regionName']);
		}
		if ($type == 'comment')
		{
			$comment = array(
				'oid' => $this->uri->segment(3),
				'uid' => $uid,
				'time' => now(),
				'comment' => $this->input->post('comment_text')
			);
			$this->db->insert('comments', $comment);
		}
		elseif ($type == 'obit')
		{
			
			$life = $this->input->post('deathy') - $this->input->post('birthy') + 1;
			$wasted = $life * 52 * $this->input->post('hourswasted');
			$newObit = array(
				'cid' => $this->input->post('category'),
				'dob_y' => $this->input->post('birthy'),
				'dod_y' => $this->input->post('deathy'),
				'hourswasted' => $wasted,
				'time' => now(),
				'cause_death' => $this->input->post('obit_text'),
				'nickname' => $this->input->post('nickname'),
				'location' => $country,
				'region' => $region,
				'email' => $this->input->post('email')
			);
			$this->db->insert('obits', $newObit);
		}
		return $this->db->insert_id();
	}
	function insertUser()
	{
		$password = random_string('alnum', 16);
		$data = array(
			'email' => $this->input->post('email'),
			'nickname' => $this->input->post('nname'),
			'country_id' => $this->input->post('country'),
			'password' => $password
		);
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

//Validation Functions-----------------------------------------------//
	function submitIsValid($type)
	{
		$this->load->library('form_validation');
			
		if ($this->form_validation->run($type) == FALSE)
		{
			return "<div class=\"error\">" . validation_errors() . "</div>";
		}
		else
		{
			return "true";
		}
	}

	function userCheck()
	{
		$newName = $this->input->post('nname');
		if($this->nickname_check($newName))
		{
			return "true";
		}
		else {
			return "<div class=\"error\">The nickname you have chosen is already in use, please try another</div>";
		}
	}

	function nickname_check($str)
	{
		$this->db->from('users');
		$this->db->where('nickname', $str);
		$q = $this->db->get();
		if ($q->num_rows()>0)
		{
			$this->form_validation->set_message('nickname_check', 'The nickname you have chosen is already in use, try another');
			return false;
		}
		else
		{
		 return true;
		}
	}
	
	function proAgePositive($str, $param)
	{
		if ($str < $this->input->post($param))
		{
			$this->form_validation->set_message('proAgePositive', 'The year of death must be greater than or equal to the year of birth');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function segmentIsObit($obId)
	{
		$this->db->from('obits');
		$this->db->where('oid', $obId);

		if ($this->db->count_all_results() == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function sendConfirm($type, $id)
	{
		return true;
		/*
		$this->load->library('email');
		if ($type == "obit")
		{
			$data = $this->getObitByID($id, 1);
			if ($data->num_rows() != 0)
			{
				$data = $data->row();
				$email = $data->email;
				$password = $this->getVer($data->uid);
				$verLink = site_url('verify/obit/' . $id . '/' . $password);
				$anchorText = anchor('verify/obit/' . $id . '/' . $password, $verLink);
				$preview = "Obituary:\n\"" . $data->cause_death . "\"";
			}
		}
		elseif ($type == "comment") 
		{
			$data = $this->getCommentByID($id, 1);
			if ($data->num_rows() != 0)
			{
				$data = $data->row();
				$email = $data->email;
				$password = $this->getVer($data->uid);
				$verLink = site_url('verify/comment/' . $id . '/' . $password);
				$anchorText = anchor('verify/comment/' . $id . '/' . $password, $verLink);
				$preview = "Comment:\n\"" . $data->comment . "\"";
			}
		}
		
		$message = "Thank you for posting at profilegraveyard.com, if you did not make a post please delete this email, otherwise please confirm your post below:\n\n";
		$message .= $preview;
		$message .= "\n\nTo confirm that you made this post please visit the confirmation link:\n";
		$message .= $verLink . "\n";
		
		$this->email->from('noreply@insanius.com', 'profilegraveyard.com');
		$this->email->to($email);
		$this->email->subject('Please confirm your post at profilegraveyard.com');
		$this->email->message($message);
		$this->email->send();
		 * 
		 */
	}

}
