<?php

class Verify extends CI_Controller {
	
	function obit()
	{
		$this->load->model('verifymodel');
		if ($this->uri->segment(3) && $this->uri->segment(4))
		{
			//check seg3 (oid) and verify exists
			$seg['3'] = $this->uri->segment(3);
			$seg['4'] = $this->uri->segment(4);
			$obitData = $this->verifymodel->checkObit($seg['3']);
			
			if ($obitData['uid'] > 0)
			{
				if ($obitData['time'] > (now() - 86400))
				{
					if ($obitData['ver'] != 1)
					{ 
						if ($seg['4'] == $this->verifymodel->checkVer($obitData['uid']))
						{
							if ($this->verifymodel->verify('obit', $seg['3']))
							{
								$success['success'] = "1";
								$this->load->view('verifyview', $success);
							}
							else {
								$ermsg = "There was an error processing your request, please try again later";
							}
						}
						else {
							$ermsg = "The verification link you are visiting is invalid";
						}
					}
					else {
						$ermsg = "The post you are trying to verify has already been verified";
					}
				}
				else {
					$ermsg = "The verification link you are visiting has expired, please repost and verify within 24 hours";
				}
			}
			else {
				$ermsg = "The post you are trying to verify is nonexistent";
			}

		} 
		else {
			$ermsg = "The link you have visited is invalid";
		}
		if (isset($ermsg))
		{
			$error = array(
				'error' => '1',
				'message' => $ermsg
			);
			$this->load->view('verifyview', $error);
		}
	}
	
	function comment()
	{
		$this->load->model('verifymodel');
		if ($this->uri->segment(3) && $this->uri->segment(4))
		{
			//check seg3 (oid) and verify exists
			$seg['3'] = $this->uri->segment(3);
			$seg['4'] = $this->uri->segment(4);
			$obitData = $this->verifymodel->checkComment($seg['3']);
			
			if ($obitData['uid'] > 0)
			{
				if ($obitData['time'] > (now() - 86400))
				{
					if ($obitData['ver'] != 1)
					{ 
						if ($seg['4'] == $this->verifymodel->checkVer($obitData['uid']))
						{
							if ($this->verifymodel->verify('comment', $seg['3']))
							{
								$success['success'] = "1";
								$this->load->view('verifyview', $success);
							}
							else {
								$ermsg = "There was an error processing your request, please try again later";
							}
						}
						else {
							$ermsg = "The verification link you are visiting is invalid";
						}
					}
					else {
						$ermsg = "The post you are trying to verify has already been verified";
					}
				}
				else {
					$ermsg = "The verification link you are visiting has expired, please repost and verify within 24 hours";
				}
			}
			else {
				$ermsg = "The post you are trying to verify is nonexistent";
			}

		} 
		else {
			$ermsg = "The link you have visited is invalid";
		}
		if (isset($ermsg))
		{
			$error = array(
				'error' => '1',
				'message' => $ermsg
			);
			$this->load->view('verifyview', $error);
		}
	}
	
}