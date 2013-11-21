<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
	<head>


<!-- E1Ui-QoEufZ19fwT6sUZ5XDVDts --><!-- Alexa ID -->
<meta property="og:image" content="http://www.profilegraveyard.com/images/fbkitler.png" />
<meta property="og:image" content="http://www.profilegraveyard.com/images/jesus-friday-night-100-x-100.png" />
<meta property="og:site_name" content="Profilegraveyard" />
<meta property="fb:admins" content="8111333, 8111020" />

		<title>Profile Graveyard - Where your social networking profiles go to die.
			<?php
				if (isset($title))
				{
					echo " - " . $title;
				}
			?>
				</title>
				<?php
if ($this->uri->segment(1) == "post")
{
?>
<meta property="og:type" content="article" />
<meta property="og:url" content="http://www.profilegraveyard.com/post/view/<?php echo $this->uri->segment(3);?>" />
<?php
	if (isset($description))
	{
		echo '<meta property="og:description" content="' . $description . '" />';
	}
?>
<?php
} else {
?>
<meta property="og:url" content="http://www.profilegraveyard.com" />
<meta property="og:type" content="blog" />
<meta property="og:description" content="Profile Graveyard - Where social networking profiles go to die."/>
<?php
}
				?>
<meta property="og:title" content="Get the guts to deactivate..." />
		<link rel="icon" type="image/png" href="<?php echo base_url()?>images/fav.png">
<link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo base_url()?>css/screen.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url()?>css/style.css?v=5" type="text/css" media="screen" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript" charset="UTF-8"></script>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.flipCounter.1.1.pack.js"></script>
                <script type="text/javascript" src="<?php echo base_url()?>js/jquery.webticker.js"></script>
<script src="https://www.google.com/jsapi?key=ABQIAAAAkiDMXYba0DucD-fADTVXLxTGyPnrOta1Pbc4_K2z8dGwwU6SbBR2oKhC1fhp8W8U0eeahqM7cvfBGA" type="text/javascript"></script>    <script type="text/javascript">
    $(window).scroll(function(){
    		if(document.body.scrollTop > '200')
    		{
    			$('#likeus').slideUp(1000);
    		}
    });
    </script>
		<script type="text/javascript">


               
			function vote(voteVal, obId){
				
				$.ajax({
					url: "<?php echo site_url('post/vote/')?>" + "/" + obId + "/" + voteVal,
					type: 'POST',
					success: function(data){
						$('#' + obId).html(data);
					}
				});
				return false;
			}
			var togval = 0;
			function togglesubmit()
			{
				if (togval == 0)
				{
					$('#newObit').slideDown(1000);
					togval = 1;
				} else {
					$('#newObit').slideUp(1000);
					togval = 0;
				}
				return false;
			}
			
			function deathdate()
			{
				$('#deathy')
				    .find('option')
				    .remove()
				    .end()
				    .append('<option value="0">Died</option>')
				    .val('0')
				;
				var ddl = $('#deathy');
				for (i = $('#birthy').val(); i <= 2011; i++)
				{
					ddl.append("<option value='" +i+ "'>" + i + "</option>");
				}
			}

	function validate(){
		$.ajax({url: "<?php echo site_url('post/newobit/')?>",
			data: $('form').serialize(),type: 'POST',
			success: function(data){$('#xtra').html(data);
				}
		});
		return false;
	}
	
</script>
<script type="text/javascript">jQuery(function(){
	jQuery("#webticker").webTicker();
});</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1735810-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</head>
	<body>
		
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>			
		<div id="container" class="container">
			<div id="header">
				<div id="headimg">
					<?php echo anchor('main/index', '<img src="' . base_url() . 'images/head.jpg">', 'title="Home"');?>
				</div>
				<div id="headlinks">
					<?php echo anchor('main', 'HOME')?><span class="postblue">t</span><?php echo anchor('top/', 'RANKING')?><span class="postblue">t</span><?php echo anchor('main/random', 'RANDOM')?><span class="postblue">t</span><?php echo anchor('moderate', 'MODERATE')?><span class="postblue">t</span><a href="javascript:void();" onclick="return togglesubmit();">SUBMIT</a>
					<?php
						if ($this->ion_auth->is_admin())
						{
							echo '<span class="postblue">t</span>' . anchor('PGadmin/admin', 'ADMIN');
						}
					?>
				<img id="timesaved" src="<?php echo base_url()?>images/timesaved.jpg">
				</div>
				<div id="headstats">
					<div id="countries_scroll">
					<ul id="webticker">
					<?php
					$data = $this->footer->getHeadStats();
					if ($data != 0)
					{
						foreach ($data as $row)
						{
							echo "<li>" . ucwords($row->region) . ": " . $row->hourswasted . "</li><li><span class=\"postblue\">t</span></li> ";
						}
					}
					?>
					</ul>
					</div>
					<?=anchor('main/stats', 'Map')?>
<span id="hour_counter"><input type="hidden" name="counter-value" value="0" /><span style="padding:5px;float:right"> 
	<form>
	<select on onchange="time_change()" id="time_type">
		<option value="hours" selected="selected">hours</option>
		<option value="days">days</option>
		<option value="years">years</option>
	</select>
	</form>
	</span></span>

				</div>
			</div>
			<div id="wrapper">
				<?php 
				$this->load->view('forms/newobit');

				if (!isset($bodyClass))
				{
					echo "<div id=\"body\" class=\"span-18 left\">";
				} else {
					echo "<div id=\"body\" class=\"" . $bodyClass . "\">";
				}
				?>