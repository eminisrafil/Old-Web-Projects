<?php

class Verifymodel extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	
	function checkObit($oidIn)
	{
		$this->db->from('obits');
		$this->db->where('oid', $oidIn);
		$this->db->select('uid, time, verify');
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			$data = $q->row();
			$returnData['uid'] = $data->uid;
			$returnData['time'] = $data->time;
			$returnData['ver'] = $data->verify;
			return $returnData;
		}
	}
	
	function checkComment($cidIn)
	{
		$this->db->from('comments');
		$this->db->where('com_id', $cidIn);
		$this->db->select('uid, time, verify');
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			$data = $q->row();
			$returnData['uid'] = $data->uid;
			$returnData['time'] = $data->time;
			$returnData['ver'] = $data->verify;
			return $returnData;
		}
	}
	
	function checkVer($uidIn)
	{
		$this->db->from('users');
		$this->db->where('uid', $uidIn);
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			$data = $q->row();
			return $data->password;
		}
	}
	
	function verify($type, $idIn)
	{
		if ($type == 'obit')
		{
			$uData = array(
				'verify' => '1',
				'time' => now()
			);
			$this->db->where('oid', $idIn);
			return $this->db->update('obits', $uData);
		}
		elseif ($type == 'comment')
		{
			$uData = array(
				'verify' => '1',
				'time' => now()
			);
			$this->db->where('com_id', $idIn);
			return $this->db->update('comments', $uData);
		}
	}

}