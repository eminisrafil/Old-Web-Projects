<?php

class About extends CI_Controller {
	
	function us()
	{
		$this->load->view('aboutusview');
	}

	function faq()
	{
		$this->load->model('aboutmodel');
		$dataFaq['data'] = $this->aboutmodel->getFaq();
		$this->load->view('faqview', $dataFaq);
	}	
	
	function contact()
	{
		$this->load->model('aboutmodel');
		if ($this->input->post('email'))
		{
			$data['success'] = '1';
			$this->load->view('contactview', $data);
		}
		else {
			$this->load->view('contactview');
		}
	}
}
?>