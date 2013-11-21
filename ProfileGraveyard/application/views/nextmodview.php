<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if (isset($success))
	{
		echo "\t<div class=\"post\">\n";
		echo "\t\tYour vote has been cast succesfully, next post:\n";
		echo "\t</div>\n";
	} elseif (isset($fail)) {
		echo "\t<div class=\"post\">\n";
		echo "\t\tThere was an error proccessing your request (" . $fail . "), please try again with the next post:\n";
		echo "\t</div>\n";
	}

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
		echo "\t\tThere are currently no more posts available for you to moderate, feel free to browse the random section of our site to view all posts, approved and rejected, while you wait for new submissions.\n";
		echo "\t</div>";
	}

?>