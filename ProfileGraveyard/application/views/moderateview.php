<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$head['title'] = "Moderate";
	$head['bodyClass'] = "span-24";
	$this->load->view('header', $head);

	$this->load->view('js/moderate');
	echo "<h2>Moderate:</h2>\n";
	
	echo "<div id=\"moderateDiv\">\n";

	if (!empty($obit)) {
		$ot['o'] = $obit;
		$this->load->view('postModerate', $ot);
		
		if (!empty($tags)) {
			echo "\t<div id=\"tag_box\">\n";
			echo "<h3>\n";
			echo "Please select any tags you feel are relevant to this post:";
			echo "</h3>";
			echo "<p>";
			foreach ($tags as $t)
			{
				echo "<span id=\"" . $t->tid . "\"><a href=\"JavaScript:void()\" onClick=\"return sendTag(" . $obit->oid . ", " . $t->tid . ")\">" . $t->tag . "</a></span>\n";
			}
			echo "</p>";
			echo "</div>";
		}

		echo "<div id=\"mod_approve\">";
		echo "<h3>Approve for Frontpage?</h3>\n";
		echo "<form method=\"post\" onSubmit=\"return moderate('" . $obit->oid . "');\">";
		echo form_button('yes', 'Yes', 'onClick="return moderate(\'' . $obit->oid . '\', \'1\')"');
		echo form_button('skip', 'Skip', 'onClick="return moderate(\'' . $obit->oid . '\', \'0\')"');
		echo form_button('no', 'No', 'onClick="return moderate(\'' . $obit->oid . '\', \'2\')"');
		echo form_close();	
	}
	else 
	{
		echo "\t<div class=\"post\">\n";
		echo "\t\tThere are currently no posts available for you to moderate, feel free to browse the random section of our site to view all posts, approved and rejected, while you wait for new submissions.\n";
		echo "\t</div>";
	}
	
	echo "</div>\n";
	
	$footer['sideBar'] = "<div><a href=\"http://www.zazzle.com/profilegraveyard\" target=\"_blank\"><img src=\"http://www.profilegraveyard.com/images/kittytshirt.jpg\" id=\"store_img\"></a>

<a href=\"http://www.zazzle.com/profilegraveyard\" target=\"_blank\"> <center>Visit Our Store and Impress Kitler </center></a></div>";
	$this->load->view('footer', $footer);
	
?>