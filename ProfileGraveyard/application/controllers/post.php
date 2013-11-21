<?php

class Post extends CI_Controller {
	
	
	function view(){
$this->output->cache(30);
		$this->load->model('postmodel');
		$obit = $this->uri->segment(3);
		$data['data'] = $this->postmodel->getObit($obit);
		
		$this->load->view('postview', $data);
	}
	
	function vote()
	{
		if ($this->input->is_ajax_request())
		{
			$this->load->model('postmodel');
			$obit = $this->uri->segment(3);
			$val = $this->uri->segment(4);

			echo $this->postmodel->updateVote($obit, $val);
		}
		else
		{
			$this->view();
		}
	}

	function newobit()
	{
		$this->load->model('postmodel');
		$this->load->library('form_validation');
		$email = $this->input->post('email');
		
		$errorText = "<div class=\"error\">An error occured during your request, please try again later</div>";
		$hideonSuccess = "\$('#new_obit').hide();";
		$showonFail = "\$('#new_obit').show();";
		$successText = "<div class=\"success\">Thank you for your post, Your post will be reviewed and if accepted, posted on our main page.";
		$successText .= "<script type=\"text/javascript\" charset=\"UTF-8\">" . $hideonSuccess . "</script></div>";
		$message = "Please enter a nickname and your location to continue your submission:";
		$newUserReturn = "<div class=\"notice\">" . $message . "<span style=\"clear:right;\"><form method=\"post\" onSubmit=\"return validate();\">" . form_label('Nickname', 'nname') . form_input('nname') . form_label('Country:', 'country') . form_dropdown('country', $this->postmodel->countryDropdown(), '0') ."</span>";
		$js = "onSubmit=\"return validate();\"";
		$newUserReturn .= "<span class=\"right\">"  . form_submit('subNick', "Submit", $js) . "</form></span><script type=\"text/javascript\" charset=\"UTF-8\">" . $hideonSuccess . "\$('input:text[\"name=nick\"]').focus();</script></div>";
		
		$obitValid = $this->postmodel->submitIsValid('obit');

		if ($obitValid == "true")
		{

			$obitId = $this->postmodel->insertPost('obit');
			if ($obitId > 0)
			{
				//no errors, send email, return success
				echo $successText;
			}
			else
			{
				//unknown error, return error
				echo $errorText . "<script type=\"text/javascript\" charset=\"UTF-8\">" . $showonFail . "</script>";
			}
		}
		else 
		{
			//invalid email/comment return $commentValid
			echo $obitValid . "<script type=\"text/javascript\" charset=\"UTF-8\">" . $showonFail . "</script>";
		}
	}

	function newcomment()
	{
		$this->load->model('postmodel');
		$this->load->library('form_validation');
		$email = $this->input->post('email');
		
		
		$errorText = "<div class=\"error\">An error occured during your request, please try again later</div>";
		$hideonSuccess = "\$('#new_comment').hide();";
		$showonFail = "\$('#new_comment').show();";
		$successText = "<div class=\"success\">Thank you for your post, A verification email has been sent to your address, to finish the post submission, please follow the verification link included in the email. If you are unable to find your confirmation email, please check your spam folder.";
		$successText .= "<script type=\"text/javascript\" charset=\"UTF-8\">" . $hideonSuccess . "</script></div>";
		$message = "Since this is your first time, Please enter a nickname and your home country to continue your submission:";
		$newUserReturn = "<div class=\"notice\">" . $message . "<span style=\"clear:right;\"><form method=\"post\" onSubmit=\"return validate();\">" . form_label('Nickname', 'nname') . form_input('nname') . form_label('Country:', 'country') . form_dropdown('country', $this->postmodel->countryDropdown(), '0') ."</span>";
		$js = "onSubmit=\"return validate();\"";
		$newUserReturn .= "<span class=\"right\">"  . form_submit('subNick', "Submit", $js) . "</form></span><script type=\"text/javascript\" charset=\"UTF-8\">" . $hideonSuccess . "\$('input:text[\"name=nick\"]').focus();</script></div>";
		
		$commentValid = $this->postmodel->submitIsValid('comment');
		//make sure segment 3 is set and valid
		if ($this->postmodel->segmentIsObit($this->uri->segment(3)))
		{
			
			if ($commentValid == "true")
			{
				//call emailCheck return uid
				$uid = $this->postmodel->getUID($email);
				if($uid>0)
				{
					//insert post return id
					$commId = $this->postmodel->insertPost('comment', $uid);
					if ($commId > 0)
					{
						//no errors, send email, return success
						$this->postmodel->sendConfirm('comment', $commId);
						echo $successText;
					}
					else
					{
						//unknown error, return error
						echo $errorText;
					}
				}
				else
				{
					//email not in database, check to see if nick isset
					if ($this->input->post('nname'))
					{
						//validate nickname and country(include check if username is being used)
						$newUV = $this->postmodel->userCheck('newuser');
						if ($newUV == "true")
						{
							$uid = $this->postmodel->insertUser();
							if ($uid > 0)
							{
								$commId = $this->postmodel->insertPost('comment', $uid);
								if ($commId > 0)
								{
									//no errors, send email, return success
									$this->postmodel->sendConfirm('comment', $commId);
									echo $successText;
								}
								else
								{
									//unknown error, return error
									echo $errorText;
								}
							}
							else 
							{
								echo $errorText;
							}
						}
						else 
						{
							echo $newUV . $newUserReturn;
						}
					}
					else
					{
						//nickname not set, show form 2 for user creation
						echo $newUserReturn;
					}
				}
			}
			else 
			{
				//invalid email/comment return $commentValid
				echo $commentValid . "<script type=\"text/javascript\" charset=\"UTF-8\">" . $showonFail . "</script>";
			}
		}
		else 
		{
			$errorText = "The post you are attempting to comment on does not exist";
			echo $errorText;
		}
	}
}
