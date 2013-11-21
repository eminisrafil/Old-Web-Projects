<?php

	$this->load->view('header');
	
	if (isset($message))
	echo '<div id="message">' . $message . '</div>';
	
	echo '<div id="moderate_form">';
	
	echo form_fieldset('Edit Obituary');
	echo form_open('PGadmin/moderate');

	echo form_label('Enter Obituary ID:', 'modoid');
	echo form_input('modoid');
	
	echo form_submit('submit', 'Edit');
	
	echo form_close();
	echo form_fieldset_close();
	
	
	echo '</div>';
	$this->load->view('footer');
	
?>
	