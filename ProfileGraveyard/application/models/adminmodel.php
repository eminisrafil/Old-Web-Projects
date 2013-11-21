<?php 

class Adminmodel extends CI_Model {
	
	function getObit($obit_id)
	{
		$this->db->where('oid', $obit_id);
		
		$this->db->from('obits');
		$this->db->join('categories', 'categories.cid = obits.cid');
		$this->db->limit(1);
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			$data = $q->row();
			return $data;
		}
	}
	
	function updateObit($dataIn, $oidIn)
	{
		$this->db->where('oid', $oidIn);
		
		if ($this->db->update('obits', $dataIn))
		{
			return "Update Succesful";
		} else {
			return "Error, not updated";
		}
	}
	function insertNew($dataIn)
	{
		if ($this->db->insert('obits', $dataIn))
		{
			return "post successful";
		} else {
			return "post failed";
		}
	}
	function postCount()
	{
		$this->db->where('frontpage_time >', '0');
		$this->db->where('verify', '1');
		return $this->db->get('obits')->num_rows();
	}
	
}
	