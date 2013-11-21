<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer extends CI_Model {
	
	function getCategories()
	{
		$this->db->order_by("name", "ASC");
		$q = $this->db->get('categories');
		
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	function isCategories($catIn)
	{
		$this->db->from('categories');
		$this->db->where('cid', $catIn);
		return $this->db->count_all_results();
	}
	
	function catDropdown(){
		$this->db->order_by('name', 'ASC');
		
		$q = $this->db->get('categories');
		
		if ($q->num_rows() > 0) {
			$data['0'] = 'Select...';
			foreach ($q->result() as $row) {
				$data[$row->cid] = $row->name;
			}
			return $data;
		}
	}
	
	function totalTime() {
		$this->db->from('obits');
		$this->db->select_sum('hourswasted', 'totalhours');
		$q = $this->db->get();
		return $q->row()->totalhours;
	}
	
	function getHeadStats()
	{
		$this->db->from('obits');
		$this->db->group_by('region');
		$this->db->select_sum('hourswasted');
		$this->db->order_by('hourswasted', 'DESC');
		$this->db->limit(15);
		$this->db->select('region');
		$q = $this->db->get();
		if ($q->num_rows()>0)
		{
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		} else {
			return 0;
		}
	}
	function likeUs()
	{
		$this->db->from('likeus');
		$this->db->where('ip_addy', $this->input->ip_address());
		$q = $this->db->count_all_results();
		if ($q == 0)
		{
			$upD = array(
				'ip_addy' => $this->input->ip_address()
			);
			$this->db->insert('likeus', $upD);
			return true;
		}
	}
}
