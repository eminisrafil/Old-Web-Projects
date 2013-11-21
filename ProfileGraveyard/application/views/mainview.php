<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//head title passed from conroller
	$this->load->view('header', $head);
	
	$seg['2'] = strtolower($this->uri->segment(2));
	$seg['3'] = strtolower($this->uri->segment(3));

if (($seg['2'] != 'random') && ($seg['2'] != 'cat'))
{
	if ($seg['3'] == 'best')
	{
		echo '<div class="main_links">';
		echo anchor('main', 'Sort: Latest First');
		echo anchor('main/home/best', 'Sort: Best First', 'class="active"');
		echo '</div>';;
	} else {
		echo '<div class="main_links">';
		echo anchor('main', 'Sort: Latest First', 'class="active"');
		echo anchor('main/home/best', 'Sort: Best First');
		echo '</div>';;
	}
}

	if (!empty($data)) {
		foreach ($data as $p)
		{
			$ot['o'] = $p;
			$this->load->view('post', $ot);
		}
		if ($seg['2'] == 'random')
		{
			echo "\t<div id=\"pagination\" class=\"right\">\n";
			echo "\t\t" . anchor('main/random', 'New Random Set') . "\n";
			echo "\t</div>\n";
		} else {
			echo "\t<div id=\"pagination\" class=\"right\">\n";
			echo "\t\t" . $this->pagination->create_links() . "\n";
			echo "\t</div>\n";
		}
	}
	else 
	{
		echo "\t<div class=\"post\">\n";
		echo "\t\tNo results found\n";
		echo "\t</div>\n";
	}
					
	$this->load->view('footer');
?>
