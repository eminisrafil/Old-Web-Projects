<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$head['title'] = "Top Obituaries";
	$this->load->view('header', $head);
	

	
	if (!empty($data)) {
		foreach ($data as $p)
		{
			$ot['o'] = $p;
			$this->load->view('post', $ot);
		}
	}
	else 
	{
		echo "\t<div class=\"post\">\n";
		echo "\t\tNo results found\n";
		echo "\t</div>";
	}
	
	echo "<div id=\"pagination\" class=\"right\">";
	echo "\t" . $this->pagination->create_links();
	echo "</div>";

	//set indexes to prevent undefined
	$selectS2 = array('mourned' => '', 'burned' => '', 'commented' => '');
	$selectS3 = array('0' => '', '24' => '', '168' => '', '720' => '');
	$selectS4['0'] = '';
		
	switch (strtolower($this->uri->segment(2)))
	{
		case 'burned':
			$seg2 = 'burned';
			break;
		case 'commented':
			$seg2 = 'commented';
			break;
		default:
			$seg2 = 'mourned';
	}

	switch ($this->uri->segment(3))
	{
		case 24:
			$seg3 = 24;
			break;
		case 168:
			$seg3 = 168;
			break;
		case 720:
			$seg3 = 720;
			break;
		default:
			$seg3 = 0;
	}
	
	if (($this->uri->segment(4) > 0) && ($this->footer->isCategories($this->uri->segment(4))))
	{
		$seg4 = $this->uri->segment(4);
	}
	else
	{
		$seg4 = 0;
	}
	
	$selectS2[$seg2] = 'id="selected"';
	$selectS3[$seg3] = 'id="selected"';
	$selectS4[$seg4] = 'id="selected"';

	$data['sideBar'] = "\t<div id=\"toptype\" class=\"topSide\">\n";
	$data['sideBar'] .= "\t\t<ul>\n";
	$data['sideBar'] .= "\t\t\t<li><span class=\"postblue\">Type:</span></li>\n";
	$data['sideBar'] .= "\t\t\t<li " . $selectS2['mourned'] . ">" . anchor('top/mourned/' . $seg3 . '/' . $seg4 . '/', 'Most Mourned') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li " . $selectS2['burned'] . ">" . anchor('top/burned/' . $seg3 . '/' . $seg4 . '/', 'Most Burned') . "</li>\n";

	$data['sideBar'] .= "\t\t</ul>\n";
	$data['sideBar'] .= "\t</div>\n";
	$data['sideBar'] .= "\t<div id=\"toptime\" class=\"topSide\">";
	$data['sideBar'] .= "\t\t<ul>\n";
	$data['sideBar'] .= "\t\t\t<li><span class=\"postblue\">Time Frame:</span></li>\n";
	$data['sideBar'] .= "\t\t\t<li " . $selectS3['0'] . ">" . anchor($this->uri->segment(1) . '/' . $seg2 . '/0/' . $seg4 . '/', 'All Time') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li " . $selectS3['24'] . ">" . anchor('top/' . $seg2 . '/24/' . $seg4 . '/', 'Past 24 Hours') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li " . $selectS3['168'] . ">" . anchor('top/' . $seg2 . '/168/' . $seg4 . '/', 'Past 168 Hours') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li " . $selectS3['720'] . ">" . anchor('top/' . $seg2 . '/720/' . $seg4 . '/', 'Past 720 Hours') . "</li>\n";
	$data['sideBar'] .= "\t\t</ul>\n";
	$data['sideBar'] .= "\t</div>";
	$data['sideBar'] .= "\t<div id=\"topcat\" class=\"topSide\">\n";
	$data['sideBar'] .= "\t\t<ul>\n";
	$data['sideBar'] .= "\t\t\t<li><span class=\"postblue\">Categories:</span></li>\n";
	$data['sideBar'] .= "\t\t\t<li " . $selectS4['0'] . ">" . anchor('top/' . $seg2 . '/' . $seg3 . '/0/' , 'All') . "</li>\n";
	foreach ($this->footer->getCategories() as $r)
	{
		if ($r->cid == $seg4)
		{
			$select = 'id="selected"';
		}
		else
		{
			$select = '';
		}
		$data['sideBar'] .= "\t\t\t<li " . $select . ">" . anchor('top/' . $seg2 . '/' . $seg3 . '/' . $r->cid . '/', $r->name) . "</li>\n";
	}
	$data['sideBar'] .= "\t\t</ul>\n";
	$data['sideBar'] .= "\t</div>\n";

	$this->load->view('footer', $data);

?>