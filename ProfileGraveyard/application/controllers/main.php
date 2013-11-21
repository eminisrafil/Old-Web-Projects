<?php

class Main extends CI_Controller {

	function index()
	{
		$this->home();
	}

	function home()
	{
		if ($this->uri->segment(3) == "best")
		{
			$this->load->model('topmodel');
			$this->load->library('pagination');
			$this->load->library('sitevar');

			
			$baseurl = site_url('main/home/best/');
			
			$config['base_url'] = $baseurl;
			$config['total_rows'] = $this->topmodel->postCount(0, 'positive', 0);
			$config['per_page'] = $this->sitevar->get('per_page');
			$config['num_links'] = $this->sitevar->get('num_links');
			$config['next_link'] ='&gt;&gt; Next Page';
			$config['next_tag_open'] ='<span class="page_dir">';
			$config['next_tag_close'] = '</span>';
			$config['prev_link'] ='Previous Page &lt&lt';
			$config['prev_tag_open'] ='<span class="page_dir">';
			$config['prev_tag_close'] = '</span>';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config);
			
			$oData['per_page'] = $config['per_page'];
			$oData['offset'] = $this->uri->segment(4);
			$oData['when'] = 0;
			$oData['sort'] = 'positive';
			$oData['cat'] = 0;
			
			$vData['data'] = $this->topmodel->getO($oData);
			$vData['head'] = array(
					'title' => 'Best'
				);
			$this->load->view('mainview', $vData);
		} else {
			$this->load->model('mainmodel');
			$this->load->library('pagination');
			
			$config['base_url'] = site_url('main/home/');
			$config['total_rows'] = $this->mainmodel->totalPosts();
			$config['per_page'] = $this->sitevar->get('per_page');
			$config['num_links'] = $this->sitevar->get('num_links');
			$config['next_link'] ='&gt;&gt; Next Page';
			$config['next_tag_open'] ='<span class="page_dir">';
			$config['next_tag_close'] = '</span>';
			$config['prev_link'] ='Previous Page &lt&lt';
			$config['prev_tag_open'] ='<span class="page_dir">';
			$config['prev_tag_close'] = '</span>';
			
			
			$this->pagination->initialize($config);
			
			$blogD['per_page'] = $config['per_page'];
			$blogD['offset'] = $this->uri->segment(3);
			
			$data['data'] = $this->mainmodel->getBlog($blogD);
			$data['head'] = array(
					'title' => 'Home'
				);
			$this->load->view('mainview', $data);
		}
	}
	
	function cat()
	{
		$this->load->model('mainmodel');
		$this->load->library('pagination');
		
		if (!$this->uri->segment(3))
		{
			$seg3 = '0';
		}
		else
		{
			$seg3 = $this->uri->segment(3);
		}
		
		$baseurl = site_url('main/cat/') . "/" . $seg3;
		
		$config['base_url'] = $baseurl;
		$config['total_rows'] = $this->mainmodel->totalPostsCat($seg3);
		$config['per_page'] = $this->sitevar->get('per_page');
		$config['num_links'] = $this->sitevar->get('num_links');
		$config['next_link'] ='&gt;&gt; Next Page';
		$config['next_tag_open'] ='<span class="page_dir">';
		$config['next_tag_close'] = '</span>';
		$config['prev_link'] ='Previous Page &lt&lt';
		$config['prev_tag_open'] ='<span class="page_dir">';
		$config['prev_tag_close'] = '</span>';
		$config['uri_segment'] = 4;
		
		
		$this->pagination->initialize($config);
		
		$blogD['per_page'] = $config['per_page'];
		$blogD['offset'] = $this->uri->segment(4);
		
		$data['data'] = $this->mainmodel->getBlogCat($blogD, $seg3);
		$data['head'] = array(
				'title' => $this->mainmodel->getCatName($seg3)
			);
		
		$this->load->view('mainview', $data);
	}

	function random()
	{
		$this->load->model('mainmodel');
		
		$data['data'] = $this->mainmodel->getBlogRand();
		$data['head'] = array(
				'title' => 'Random'
			);
		
		$this->load->view('mainview', $data);
		
	}
	function stats()
	{
		$this->load->model('mainmodel');
		$data['data'] = $this->mainmodel->getAllStatsLocation();
		$this->load->view('statsview', $data);
	}

}