<?php

class Moderate extends CI_Controller {

	function index()
	{
		$this->load->model('moderatemodel');
		
		$obit = $this->moderatemodel->getObit();
		$tags = $this->moderatemodel->getTags();
		
		$data['obit'] = $obit;
		$data['tags'] = $tags;
		
		$this->load->view('moderateview', $data);
	}
	
	function submit()
	{
		if ($this->input->is_ajax_request())
		{
			$this->load->model('moderatemodel');
			
			$oid = $this->input->post('oid');
			$val = $this->input->post('val');

			if ($this->moderatemodel->checkOid($oid))
			{
				if ($this->moderatemodel->checkIfMod($oid))
				{
					if ($this->moderatemodel->commitMod($oid, $val))
					{
						$success = 1;
					} else {
						$fail = "Failed processing request";
					}
				} else {
					$fail = "Already voted for this post";
				}
			} else {
				$fail = "Obit not valid";
			}
			
			$obit = $this->moderatemodel->getObit();
			$tags = $this->moderatemodel->getTags();
			
			$data['obit'] = $obit;
			$data['tags'] = $tags;
			if (isset($success))
			{
				$data['success'] = 1;
				$this->load->view('nextmodview', $data);
			} elseif(isset($fail)) {
				$data['fail'] = $fail;
				$this->load->view('nextmodview', $data);
			} else {
				$this->load->view('nextmodview', $data);
			}
		}
	}
	
	function tag()
	{
		if ($this->input->is_ajax_request())
		{
			$this->load->model('moderatemodel');
			$oid = $this->input->post('oid');
			$tagid = $this->input->post('tag');
			if ($this->moderatemodel->checkOid($oid))
			{
				if ($this->moderatemodel->checkTag($tagid))
				{
					if ($this->moderatemodel->addTag($oid, $tagid))
					{
						echo "Thanks!";
					} else {
						echo "Error";
					}
				} else {
					echo "Error";
				}
			} else {
				echo "Error";
			}
		}
	}
	
}
?>