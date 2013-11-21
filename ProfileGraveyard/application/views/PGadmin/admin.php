<?php

	$this->load->view('header');

	echo '<div id="ad-main">';
	if (isset($message))
		echo '<div id="messages">' . $message . '</div>';
	
	echo '<div id="stats">';
	
	echo '<ul>';
	echo '<li>Stats:</li>';
	echo '<li>Total Posts: ' . $totalPosts . '</li>';
	
	echo '</ul>';
	
	echo '</div>';
	
	$this->load->view('footer');
?>
