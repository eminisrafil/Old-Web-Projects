<?php

class Topmodel extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function postCount($dataIn, $sort, $cat)
	{
		if ($dataIn != 0)
		{
			$time = now() - ($dataIn * 86400);
			$this->db->where('time >', $time);
		}
		
		if ($cat != 0)
			$this->db->where('cid', $dataIn['cat']);
		
		
		$this->db->where($sort . ' >', '0');
		$this->db->from('obits');

		return $this->db->count_all_results();
	}
	
	function postCountbyC($dataIn, $cat)
	{
		if ($dataIn != 0)
		{
			$time = now() - ($dataIn * 86400);
			$this->db->where('obits.time >', $time);
		}
		if ($cat != 0)
			$this->db->where('obits.cid', $dataIn['cat']);
		
		$this->db->from('obits');
		$this->db->join('comments', 'comments.oid = obits.oid');
		$this->db->group_by('obits.oid');

		$q =  $this->db->get();
		return $q->num_rows();
	}
	
	function countComment($oidIn)
	{
		$this->db->from('comments');
		$this->db->where('oid', $oidIn);
		
		return $this->db->count_all_results();
	}
	
	function getO($dataIn)
	{
		if ($dataIn['when'] != 0)
		{
			$time = now() - ($dataIn['when'] * 86400);
			$this->db->where('time >', $time);
		}
		if ($dataIn['cat'] != 0)
			$this->db->where('obits.cid', $dataIn['cat']);
		
		$this->db->where($dataIn['sort'] . ' >', '0');
		$this->db->from('obits');
		$this->db->join('categories', 'categories.cid = obits.cid');

		$this->db->limit($dataIn['per_page'], $dataIn['offset']);
		$this->db->order_by($dataIn['sort'], 'DESC');
		
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$row->comments = $this->countComment($row->oid);
				$data[] = $row;
			}
			return $data;
		}
	}
	
	function getObyC($dataIn)
	{
		if ($dataIn['when'] != 0)
		{
			$time = now() - ($dataIn['when'] * 86400);
			$this->db->where('obits.time >', $time);
		}
		if ($dataIn['cat'] != 0)
		{
			$this->db->where('obits.cid', $dataIn['cat']);
		}

		$this->db->from('obits');
		$this->db->join('categories', 'categories.cid = obits.cid');

		$this->db->join('comments', 'comments.oid = obits.oid');
		$this->db->group_by('obits.oid');
		$this->db->limit($dataIn['per_page'], $dataIn['offset']);
		$this->db->order_by('count(com_id)', 'DESC');
		
		$q = $this->db->get();

		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$row->comments = $this->countComment($row->oid);
				$data[] = $row;
			}
			return $data;
		}
	}
	
}
