<?php

	$this->load->view('header');
	
	echo '<div id="moderate_form">';

	echo form_fieldset('Moderate - [id = ' . $o->oid . ']');
	echo '<div id="moderate_error">';
	echo validation_errors();
	echo '</div>';
	echo form_open('PGadmin/moderate');
	echo anchor('PGadmin/odelete/' . $o->oid, 'Delete Entire Post');
	$categories = $this->footer->catDropdown();
	echo form_label('Profile:', 'category');
	echo form_dropdown('category', $categories, $o->cid);

	echo form_label('Location:', 'location');
	echo form_input('location', $o->location);
	echo form_label('Region:', 'region');
	echo form_input('region', $o->region);

	echo form_label('Born:', 'born');
	echo form_input('born', $o->dob_y);
	echo form_label('Died:', 'died');
	echo form_input('died', $o->dod_y);
	
	echo form_label('Hours Wasted:', 'hourswasted');
	$hourW = $o->hourswasted / (($o->dod_y - $o->dob_y + 1) * 52);
	echo form_input('hourswasted', $hourW);
	
	echo form_label('Nickname:', 'nickname');
	echo form_input('nickname', $o->nickname);
	
	echo form_label('Email:', 'email');
	echo form_input('email', $o->email);
	
	echo form_label('Obituary:', 'obit');
	echo form_textarea('obit', $o->cause_death);
	echo form_hidden('oid', $o->oid);
	echo form_submit('submit', 'Update');
	echo form_close();
	echo form_fieldset_close();
	
	$this->load->view('footer');
	
?>
