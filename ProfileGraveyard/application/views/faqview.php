<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$head['title'] = "Frequently Asked Questions";
	$this->load->view('header', $head);
	
	echo "<h2>F.A.Q</h2>\n";
	
	if (!empty($data)) {
		foreach ($data as $p)
		{
			echo "<h3>" . $p->question . "</h3>\n";
			echo "<p>\n";
			echo "\t" . $p->answer . "\n";
			echo "</p>\n";
		}
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