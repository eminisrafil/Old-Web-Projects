<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$head['title'] = "Contact Us";
	$this->load->view('header', $head);
	
	echo "<h2>Contact Us</h2>\n";
	
	if (isset($success))
	{
		echo "<div class=\"success\">Thanks for the message! Unfortunatley we haven't gotten around to implementing a contact system yet so we won't get it, but it's the thought that counts and we're greatful!</div>\n";
	}
	else {
		$fId['id'] = 'contactf';
		echo form_open('about/contact', $fId) . "\n";
		echo form_label('Name:', 'name') . "\n";
		echo form_input('name') . "\n";
		echo form_label('Email:', 'email') . "\n";
		echo form_input('email') . "\n";
		echo form_label('Subject:', 'subject') . "\n";
		echo form_input('subject') . "\n";
		echo form_label('Message:', 'message') . "\n";
		echo form_textarea('message') . "\n";
		echo form_submit('submit', 'Send') . "\n";
		echo form_close();
	}
	
	$data['sideBar'] = "\t<div id=\"categories\">\n";
	$data['sideBar'] .= "\t\t<ul>\n";
	$data['sideBar'] .= "\t\t\t<li>" . anchor('/about/us/' , 'About Us') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li>" . anchor('/about/contact/' , 'Contact Us') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li>" . anchor('/about/faq/' , 'FAQ') . "</li>\n";
	$data['sideBar'] .= "\t\t</ul>\n";
	$data['sideBar'] .= "\t</div>\n";
	
	$this->load->view('footer', $data);
?>
