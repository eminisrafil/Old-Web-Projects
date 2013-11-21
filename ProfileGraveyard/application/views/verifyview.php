<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$head['title'] = "Verify";
	$this->load->view('header', $head);
	
	if (isset($success))
	{
		echo "<div class=\"success\">\n";
		echo "Your post has been successfully verified and is now in our database\n";
		echo "</div>";
	} else {
		echo "<div class=\"error\">\n";
		echo $message . "\n";
		echo "</div>";
	}
	
	$this->load->view('footer');
	
?>
