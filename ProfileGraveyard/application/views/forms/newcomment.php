<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	echo "<div id=\"newComment\" class=\"comm_list info span-16\">\n";
	$dataJS['data'] = array(
		'target' => 'post/newcomment/' . $this->uri->segment(3)
	);
	$this->load->view('js/validate', $dataJS);
	
	echo "\t<div id=\"xtra\"></div>\n";
	echo "\t<form method=\"post\" onSubmit=\"return validate();\" id=\"new_comment\">";
	
	$textarea = array(
		'name' => 'comment_text',
		'id' => 'comment_text',
		'value' => set_value('comment_text'),
		'class' => 'left postBody'
	);
	$textareaLabel = array(
		'class' => 'left post-label'
	);
	echo "\t\t<div id=\"commentDiv\" style=\"margin-top:1.5em;\">\n";
	echo "\t\t\t" . form_label('Comment:', 'comment_text', $textareaLabel) . "\n";
	echo "\t\t\t" . form_textarea($textarea) . "\n";
	echo "\t\t</div>\n";
	
	$email = array(
		'name' => 'email',
		'id' => 'email',
		'value' => set_value('email'),
		'class' => 'left required email',
		'style' => 'margin-left: 2em;'
	);
	$emailLabel = array(
		'class' => 'left post-label'
	);
	echo "\t\t<div id=\"emailDiv\">\n";
	echo "\t\t\t" . form_label('Email:', 'email', $emailLabel) . "\n";
	echo "\t\t\t" . form_input($email) . "\n";

	$js = 'onClick="return validate()" id="newO"';
	echo "\t\t\t<span class=\"right\" style=\"margin-right:30px;\">\n";
	echo "\t\t\t\t" . form_button('submit', 'Submit', $js) . "\n";
	echo "\t\t\t</span>\n";
	echo "\t\t</div>\n";
	
	echo "\t" . form_close() . "\n";
	echo "</div>\n";
?>