<?php 

class Mainmodel extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function totalPosts(){
		$this->db->where('frontpage_time >', '0');
		$this->db->where('verify', '1');
		return $this->db->get('obits')->num_rows();
	}
	
	function totalPostsCat($catId){
		if ($catId > 0)
		{
			$this->db->where('cid', $catId);
		}
		$this->db->where('frontpage_time >', '0');
		
		$this->db->from('obits');
		return $this->db->count_all_results();
	}
	
	function countComment($oidIn)
	{
		$this->db->from('comments');
		$this->db->where('oid', $oidIn);
		
		return $this->db->count_all_results();
	}
	
	function getCatName($cidIn)
	{
		$this->db->from('categories');
		$this->db->where('cid', $cidIn);
		$this->db->limit('1');
		$q = $this->db->get();
		
		if($q->num_rows() > 0) {
			$qRet = $q->row();
			return $qRet->name;
		}		
	}
	
	function getBlog ($dataIn){
		$this->db->from('obits');
		$this->db->where('frontpage_time >', '0');
		$this->db->where('verify', '1');
		
		$this->db->join('categories', 'categories.cid = obits.cid');
		$this->db->limit($dataIn['per_page'], $dataIn['offset']);
		$this->db->order_by('frontpage_time', 'DESC');
		
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$row->comments = $this->countComment($row->oid);
				$data[] = $row;
			}
			return $data;
		}
	}
	
	function getBlogCat ($dataIn, $catIn){
		if ($catIn > 0)
		{
			$this->db->where('obits.cid', $catIn);
		}
		$this->db->where('frontpage_time >', '0');
		$this->db->where('verify', '1');	
		$this->db->from('obits');
		$this->db->join('categories', 'categories.cid = obits.cid');

		$this->db->limit($dataIn['per_page'], $dataIn['offset']);
		$this->db->order_by('frontpage_time', 'DESC');
		
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$row->comments = $this->countComment($row->oid);
				$data[] = $row;
			}
			return $data;
		}
	}
	
	function getBlogRand (){
		$this->db->from('obits');
		$this->db->join('categories', 'categories.cid = obits.cid');

		$this->db->limit($this->sitevar->get('per_page'));
		$this->db->order_by('oid', 'RANDOM');
		
		$q = $this->db->get();
		
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$row->comments = $this->countComment($row->oid);
				$data[] = $row;
			}
			return $data;
		}
	}
	
	function getAllStatsLocation(){
		$this->db->from('obits');
		$this->db->group_by('region');
		$this->db->select_sum('hourswasted');
		$this->db->order_by('location, region', 'ASC');
		$this->db->select('location, region');
		
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

}
