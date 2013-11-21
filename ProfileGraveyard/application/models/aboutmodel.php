<?php

class Aboutmodel extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function getFaq()
	{
		$this->db->from('faq');
		$this->db->order_by('order', 'ASC');
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	
}
?>
