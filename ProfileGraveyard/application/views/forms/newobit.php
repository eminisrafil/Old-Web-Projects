<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		$catData = $this->footer->catDropdown();
		for($i=date('Y');$i>1999;$i--)
			$years[$i] = $i;
		
		echo "<div id=\"newObit\" class=\"submitpost post span-17\">\n";

		echo "\t<div id=\"xtra\"></div>\n";
		echo "\t<form method=\"post\" onSubmit=\"return validate();\" id=\"new_obit\">\n";
		
		echo "\t\t" . form_label('Profile:', 'category') . "\n";
		echo "\t\t" . form_dropdown('category', $catData, '0') . "\n";
		
		$js = 'id="birthy" onChange="deathdate();"';
		$years[0] = "Born";
		echo "\t\t" . form_label('Account Life:', 'birthy') . "\n";
		echo "\t\t" . form_dropdown('birthy', $years, '0', $js) . "\n";
		
		$js2 = 'id="deathy"';
		$year[0] = "Died";
		echo "\t\t" . form_label(':', 'deathy') . "\n";
		echo "\t\t" . form_dropdown('deathy', $year, '0', $js2) . "\n";

		$hw = 'id="hourswasted"';
		echo "\t\t" . form_label('Hours Wasted/Week:', 'hourswasted') . "\n";
		echo "\t\t" . form_input('hourswasted', '', $hw) . "\n";

		$textarea = array(
			'name' => 'obit_text',
			'id' => 'obit_text',
			'placeholder' => 'Get the guts to deactivate...',
			'class' => 'left postBody'
		);
		$textareaLabel = array(
			'class' => 'left post-label'
		);
		echo "\t\t<div id=\"obitDiv\" style=\"margin-top:1.5em;\">\n";
		echo "\t\t\t" . form_label('Obituary:', 'obit_text', $textareaLabel) . "\n";
		echo "\t\t\t" . form_textarea($textarea) . "\n";
		echo "\t\t</div>\n";
		
		$email = array(
			'name' => 'email',
			'id' => 'email',
			'value' => set_value('email'),
			'class' => 'left email',
			'placeholder' => 'Email',
			'style' => 'margin-left: 2em;'
		);
		$emailLabel = array(
			'class' => 'left post-label'
		);
		$uname = array(
			'name' => 'nickname',
			'id' => 'nickname',
			'value' => set_value('nickname'),
			'class' => 'left',
			'placeholder' => 'Nickname',
			'style' => 'margin-left: 2em;'
		);
		$unameLabel = array(
			'class' => 'left post-label'
		);
		echo "\t\t<div id=\"emailDiv\">\n";
		echo "\t\t\t" . form_label('Email (optional):', 'email', $emailLabel) . "\n";
		echo "\t\t\t" . form_input($email) . "\n";
		echo "\t\t\t" . form_label('Nickname (optional):', 'nickname', $unameLabel) . "\n";
		echo "\t\t\t" . form_input($uname) . "\n";

		$js = 'onClick="return validate();" id="newO"';
		echo "\t\t\t<span class=\"right\" style=\"margin-right:30px;\">\n";
		echo "\t\t\t\t" . form_button('submit', 'Submit', $js) . "\n";
		echo "\t\t\t</span>\n";
		echo "\t\t</div>\n";

		echo "\t" . form_close() . "\n";
		echo "\t</div>\n";
?>