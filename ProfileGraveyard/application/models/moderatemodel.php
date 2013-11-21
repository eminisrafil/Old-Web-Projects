<?php

class Moderatemodel extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function getCatName($cidIn)
	{
		$this->db->from('categories');
		$this->db->where('cid', $cidIn);
		$this->db->limit('1');
		$this->db->select('name');
		$q = $this->db->get();
		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			return $row->name;
		}
	}
	
	function getCountryName($uidIn)
	{
		$this->db->from('users');
		$this->db->where('uid', $uidIn);

		$this->db->limit('1');
		$this->db->select('country_name');
		$q = $this->db->get();
		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			return $row->country_name;
		}
	}
	
	function getObit()
	{
		$ipAdd = $this->input->ip_address();
		$q = $this->db->query('SELECT *, obits.oid AS obitid FROM (obits LEFT JOIN moderate ON moderate.oid = obits.oid) WHERE frontpage_time = 0 GROUP BY obits.oid HAVING COUNT(CASE WHEN ip_address = \'' . $ipAdd . '\' THEN ip_address ELSE NULL END) = 0 ORDER BY RAND() LIMIT 1');
		
		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			$row->oid = $row->obitid;
			$row->name = $this->getCatName($row->cid);
			return $row;
		}
	}
	
	function getTags()
	{
		$this->db->from('tags');
		$q = $this->db->get();
		
		if ($q->num_rows() > 0)
		{
			foreach ($q->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	
	function checkOid($oidIn)
	{
		$this->db->from('obits');
		$this->db->where('oid', $oidIn);
		if ($this->db->count_all_results() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function checkIfMod($oidIn)
	{
		$ipAdd = $this->input->ip_address();
		$this->db->from('moderate');
		$this->db->where('oid', $oidIn);
		$this->db->where('ip_address', $ipAdd);
		if ($this->db->count_all_results() > 0)
		{
			return false;
		} else {
			return true;
		}
	}
	
	function checkTag($tagIn)
	{
		$this->db->from('tags');
		$this->db->where('tid', $tagIn);
		if ($this->db->count_all_results() > 0)
		{
			return true;
		} else {
			return false;
		}
	}
	
	function addTag($oidIn, $tagIn)
	{
		$ipAdd = $this->input->ip_address();
		$nD = '(' . $tagIn . ')';
		$this->db->from('user_tags');
		$this->db->where('oid', $oidIn);
		$this->db->where('ip_address', $ipAdd);
		$q = $this->db->get();
		if ($q->num_rows() > 0)
		{
			$row = $q->row();
			$curTags = $row->tags;
			if (strlen(strstr($curTags, $nD))>0)
			{
				//vote already exits
				return false;
			} else {
				$this->db->from('tag_list');
				$this->db->where('oid', $oidIn);
				$this->db->where('tid', $tagIn);
				$q = $this->db->get();
				if ($q->num_rows() > 0)
				{
					$this->db->set('tcount', 'tcount+1', FALSE);
					$this->db->where('oid', $oidIn);
					if ($this->db->update('tag_list'))
					{
						$updTag = $curTags . $nD;
						$tagUp = array(
							'tags' => $updTag
						);
						$this->db->where('ip_address', $ipAdd);
						$this->db->update('user_tags', $tagUp);
						return true;
					} else {
						return false;
					}
				} else {
					//new tag, insert

					$tagInsert = array(
						'oid' => $oidIn,
						'tid' => $tagIn,
						'tcount' => '1'
					);
					if ($this->db->insert('tag_list', $tagInsert))
					{
						$updTag = $curTags . $nD;
						$tagUp = array(
							'tags' => $updTag
						);
						$this->db->where('ip_address', $ipAdd);
						$this->db->update('user_tags', $tagUp);
						return true;
					} else {
						return false;
					}
				}
			}
		} else {
			//insert tag and ip
			$tagInsert = array(
				'oid' => $oidIn,
				'tid' => $tagIn
			);
			if($this->db->insert('tag_list', $tagInsert))
			{
				$userTIn = array(
					'oid' => $oidIn,
					'ip_address' => $ipAdd,
					'tags' => $nD
				);
				$this->db->insert('user_tags', $userTIn);
				return true;
			} else {
				return false;
			}
		}
	}
	
	function commitMod($oidIn, $valIn)
	{
		$ip_address = $this->input->ip_address();
		$this->db->from('obits');
		$this->db->where('oid', $oidIn);
		$this->db->select('frontpage_vote, frontpage_vote_down');
		$q = $this->db->get();
		if ($q->num_rows()>0)
		{
			$row = $q->row();
			if (($row->frontpage_vote >= ($this->sitevar->get('front_vote') - 1)) && ($valIn == 1))
			{
				$this->db->set('frontpage_time', now());
			} elseif (($row->frontpage_vote_down >= ($this->sitevar->get('front_reject') - 1)) && ($valIn == 2)) {
				$this->db->set('frontpage_time', '-1');
			}
		}
		switch ($valIn) {
			case 1:
				$this->db->set('frontpage_vote', 'frontpage_vote+1', FALSE);
				break;
			case 2:
				$this->db->set('frontpage_vote_down', 'frontpage_vote_down+1', FALSE);
				break;
		}
		if (($valIn == 1) || ($valIn == 2))
		{
			
			$this->db->where('oid', $oidIn);
			if ($this->db->update('obits'))
			{
				$dataInsert = array(
					'oid' => $oidIn,
					'ip_address' => $ip_address,
					'vote' => $valIn
				);
				$this->db->insert('moderate', $dataInsert);
				return true;
			}
		}
		elseif ($valIn == 0) {
			$dataInsert = array(
				'oid' => $oidIn,
				'ip_address' => $ip_address,
				'vote' => $valIn
			);
			$this->db->insert('moderate', $dataInsert);
			return true;
		} 
		return false;
	}
	
}
?>