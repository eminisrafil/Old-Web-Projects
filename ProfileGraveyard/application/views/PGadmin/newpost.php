<?php

	$this->load->view('header');
	
	echo '<div id="moderate_form">';

	echo form_fieldset('Insert New Post');
	echo '<div id="moderate_error">';
	echo validation_errors();
	echo '</div>';
	echo form_open('PGadmin/insertnew');
	$categories = $this->footer->catDropdown();
	echo form_label('Profile:', 'category');
	echo form_dropdown('category', $categories, 0);

	echo form_label('Location:', 'location');
	echo form_input('location');
	echo form_label('Region:', 'region');
	echo form_input('region');

	echo form_label('Born:', 'born');
	echo form_input('born');
	echo form_label('Died:', 'died');
	echo form_input('died');
	
	echo form_label('Hours Wasted:', 'hourswasted');
	echo form_input('hourswasted');
	
	echo form_label('Nickname:', 'nickname');
	echo form_input('nickname');
	
	echo form_label('Email:', 'email');
	echo form_input('email');
	
	echo form_label('Likes:', 'likes');
	echo form_input('likes');
	echo form_label('Dislikes:', 'dislikes');
	echo form_input('dislikes');
		
	echo form_label('Obituary:', 'obit');
	echo form_textarea('obit');
	
	echo form_label('Post to homepage', 'posthome');
	echo form_checkbox('posthome', 'accept');
	
	echo form_hidden('oid');
	echo form_submit('submit', 'Insert');
	echo form_close();
	echo form_fieldset_close();
	
	$this->load->view('footer');
	
?>
