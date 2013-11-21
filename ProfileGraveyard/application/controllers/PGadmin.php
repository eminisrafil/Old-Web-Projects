<?php

class PGadmin extends CI_Controller {
		
		function index()
		{
			if ($this->ion_auth->is_admin()) {
				redirect('PGadmin/admin', 'refresh');
			} else {
				redirect('PGadmin/login', 'refresh');
			}
		}
		
		function login()
		{
					//validate form input
			$this->form_validation->set_rules('identity', 'Identity', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
	
			if ($this->form_validation->run() == true)
			{ //check to see if the user is logging in
				//check for "remember me"
				$remember = (bool) $this->input->post('remember');
	
				if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
				{ //if the login is successful
					//redirect them back to the home page
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect($this->config->item('base_url'), 'refresh');
				}
				else
				{ //if the login was un-successful
					//redirect them back to the login page
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('PGadmin/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
				}
			}
			else
			{  //the user is not logging in so display the login page
				//set the flash data error message if there is one
				$this->load->view('PGadmin/login');
			}
		}
		
		function logout()
		{
			//log the user out
			$logout = $this->ion_auth->logout();
	
			//redirect them back to the page they came from
			redirect('main', 'refresh');
		}
		
		function admin()
		{
			if ($this->ion_auth->is_admin())
			{
				$this->load->model('adminmodel');
				$data['totalPosts'] = $this->adminmodel->postCount();
				
				$this->load->view('PGadmin/admin', $data);
			}
		}
		
		function moderate()
		{
			if ($this->ion_auth->is_admin())
			{
				$segment = $this->uri->segment(3);
				$this->load->model('adminmodel');
				if ($this->input->post('submit') == "Update")
				{
					$oid = $this->input->post('oid');
					$birth = $this->input->post('born');
					$died = $this->input->post('died');
					$hours = $this->input->post('hourswasted');
					$hourW = ($died - $birth + 1) * 52 * $hours;
					$postData = array(
						'cid' => $this->input->post('category'),
						'dob_y' => $birth,
						'dod_y' => $died,
						'location' => $this->input->post('location'),
						'region' => $this->input->post('region'),
						'hourswasted' => $hourW,
						'nickname' => $this->input->post('nickname'),
						'email' => $this->input->post('email'),
						'cause_death' => $this->input->post('obit')
					);
					$data['message'] = $this->adminmodel->updateObit($postData, $oid);
					$this->load->view('PGadmin/modpost', $data);
				}elseif ($segment){
					$obitData['o'] = $this->adminmodel->getObit($segment);
					$this->load->view('PGadmin/moderatepost', $obitData);
				}elseif ($this->input->post('modoid')){
					$obitData['o'] = $this->adminmodel->getObit($this->input->post('modoid'));
					$this->load->view('PGadmin/moderatepost', $obitData);
				}else{
					$this->load->view('PGadmin/modpost');
				}
			}
		}

		function insertnew()
		{
			$this->load->model('adminmodel');
			if ($this->input->post('submit') == "Insert")
			{
					$oid = $this->input->post('oid');
					$birth = $this->input->post('born');
					$died = $this->input->post('died');
					$hours = $this->input->post('hourswasted');
					$hourW = ($died - $birth + 1) * 52 * $hours;
					$postData = array(
						'cid' => $this->input->post('category'),
						'time' => now(),
						'dob_y' => $birth,
						'dod_y' => $died,
						'location' => $this->input->post('location'),
						'region' => $this->input->post('region'),
						'hourswasted' => $hourW,
						'nickname' => $this->input->post('nickname'),
						'email' => $this->input->post('email'),
						'positive' => $this->input->post('likes'),
						'negative' => $this->input->post('dislikes'),
						'cause_death' => $this->input->post('obit')
					);
					if ($this->input->post('posthome') == 'accept')
					{
						$postData['verify'] = 1;
						$postData['frontpage_time'] = now();
					}
					$data['message'] = $this->adminmodel->insertNew($postData);
					$this->load->view('PGadmin/admin', $data);
			} else {
				$this->load->view('PGadmin/newpost');
			}
		}
}
	