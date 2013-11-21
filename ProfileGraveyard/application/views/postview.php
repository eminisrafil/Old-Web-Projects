<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$head['title'] = "View Obituaries";
	

	if (!empty($data)) {
$head['description'] = $data->cause_death;
$this->load->view('header', $head);
		$ot['o'] = $data;
		$ot['nocomment'] = 'nocomment';
		$this->load->view('post', $ot);

	
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-comments" data-href="http://profilegraveyard.com/post/view/<?php echo $data->oid?>" data-num-posts="15" data-width="500"></div>
<?php
	}
	else 
	{
$this->load->view('header', $head);
		echo "\t<div class=\"post\">\n";
		echo "\t\tNo results found\n";
		echo "\t</div>";
	}
	$this->load->view('footer');

?>