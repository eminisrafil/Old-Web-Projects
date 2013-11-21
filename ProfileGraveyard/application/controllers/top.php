<?php

class Top extends CI_Controller {
	
	function index()
	{
		$this->mourned();
	}
	
	function mourned()
	{
		$this->load->model('topmodel');
		$this->load->library('pagination');
		$this->load->library('sitevar');
		
		switch ($this->uri->segment(3)) {
			case 24:
				$when = 1;
				$s3 = 24;
				break;
			case 168:
				$when = 7;
				$s3 = 168;
				break;
			case 720:
				$when = 30;
				$s3 = 720;
				break;
			default:
				$when = 0;
				$s3 = 0;
				break;
		}
		if ($this->uri->segment(4) > 0)
		{
			$s4 = $this->uri->segment(4);
		}
		else
		{
			$s4 = 0;
		}
		
		$baseurl = site_url('top/mourned/') . '/' . $s3 . '/' . $s4;
		
		$config['base_url'] = $baseurl;
		$config['total_rows'] = $this->topmodel->postCount($when, 'positive', $s4);
		$config['per_page'] = $this->sitevar->get('per_page');
		$config['num_links'] = $this->sitevar->get('num_links');
		$config['next_link'] ='&gt;&gt; Next Page';
		$config['next_tag_open'] ='<span class="page_dir">';
		$config['next_tag_close'] = '</span>';
		$config['prev_link'] ='Previous Page &lt&lt';
		$config['prev_tag_open'] ='<span class="page_dir">';
		$config['prev_tag_close'] = '</span>';
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$oData['per_page'] = $config['per_page'];
		$oData['offset'] = $this->uri->segment(5);
		$oData['when'] = $when;
		$oData['sort'] = 'positive';
		$oData['cat'] = $s4;
		
		$vData['data'] = $this->topmodel->getO($oData);
		
		$this->load->view('topview', $vData);
	}
	
	function burned()
	{
		$this->load->model('topmodel');
		$this->load->library('pagination');
		$this->load->library('sitevar');
		
		switch ($this->uri->segment(3)) {
			case 24:
				$when = 1;
				$s3 = 24;
				break;
			case 168:
				$when = 7;
				$s3 = 168;
				break;
			case 720:
				$when = 30;
				$s3 = 720;
				break;
			default:
				$when = 0;
				$s3 = 0;
				break;
		}
		if ($this->uri->segment(4) > 0)
		{
			$s4 = $this->uri->segment(4);
		}
		else
		{
			$s4 = 0;
		}
		
		$baseurl = site_url('top/burned/') . '/' . $s3 . '/' . $s4;
		
		$config['base_url'] = $baseurl;
		$config['total_rows'] = $this->topmodel->postCount($when, 'negative', $s4);
		$config['per_page'] = $this->sitevar->get('per_page');
		$config['num_links'] = $this->sitevar->get('num_links');
		$config['next_link'] ='&gt;&gt; Next Page';
		$config['next_tag_open'] ='<span class="page_dir">';
		$config['next_tag_close'] = '</span>';
		$config['prev_link'] ='Previous Page &lt&lt';
		$config['prev_tag_open'] ='<span class="page_dir">';
		$config['prev_tag_close'] = '</span>';
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$oData['per_page'] = $config['per_page'];
		$oData['offset'] = $this->uri->segment(5);
		$oData['when'] = $when;
		$oData['sort'] = 'negative';
		$oData['cat'] = $s4;
		
		$vData['data'] = $this->topmodel->getO($oData);
		
		$this->load->view('topview', $vData);
	}
	
	function commented()
	{
		$this->load->model('topmodel');
		$this->load->library('pagination');
		$this->load->library('sitevar');
		
		switch ($this->uri->segment(3)) {
			case 24:
				$when = 1;
				$s3 = 24;
				break;
			case 168:
				$when = 7;
				$s3 = 168;
				break;
			case 720:
				$when = 30;
				$s3 = 720;
				break;
			default:
				$when = 0;
				$s3 = 0;
				break;
		}
		if ($this->uri->segment(4) > 0)
		{
			$s4 = $this->uri->segment(4);
		}
		else
		{
			$s4 = 0;
		}
		
		$baseurl = site_url('top/commented/') . '/' . $s3 . '/' . $s4;
		
		$config['base_url'] = $baseurl;
		$config['total_rows'] = $this->topmodel->postCountbyC($when, $s4);
		$config['per_page'] = $this->sitevar->get('per_page');
		$config['num_links'] = $this->sitevar->get('num_links');
		$config['next_link'] ='&gt;&gt; Next Page';
		$config['next_tag_open'] ='<span class="page_dir">';
		$config['next_tag_close'] = '</span>';
		$config['prev_link'] ='Previous Page &lt&lt';
		$config['prev_tag_open'] ='<span class="page_dir">';
		$config['prev_tag_close'] = '</span>';
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$oData['per_page'] = $config['per_page'];
		$oData['offset'] = $this->uri->segment(5);
		$oData['when'] = $when;
		$oData['cat'] = $s4;
		
		$vData['data'] = $this->topmodel->getObyC($oData);
		
		$this->load->view('topview', $vData);
	}

}
