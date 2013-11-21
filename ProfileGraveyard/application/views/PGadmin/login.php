<?php

	$this->load->view('header');

	echo '<div id="login_form">';

	echo form_fieldset('Login:');
	echo '<div id="login_error">';
	echo validation_errors();
	echo '</div>';
	echo form_open('PGadmin/login');

	
	echo '<div id="login_items">';
	echo form_label('Email:', 'identity');
	echo form_input('identity');
	
	echo form_label('Password:', 'password');
	echo form_password('password');
	
	echo form_label('Remember Me:', 'remember');
	echo form_checkbox('remember', '1', FALSE);
	
	echo form_submit('submit', 'Login');

	echo '</div>';
	
	echo form_close();
	echo form_fieldset_close();
	
	echo '</div>';

	$this->load->view('footer');
?>

