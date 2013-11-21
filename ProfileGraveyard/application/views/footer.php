<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	echo "\t</div>\n";
	
	if (isset($sideBar))
	{
		echo "\t<div id=\"sidebar\" class=\"span-5 right\">\n";
		echo $sideBar;

?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-8992167894741467";
/* Small Square Right Side */
google_ad_slot = "1983947247";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<?php
		echo "\t</div>\n";
	}
	else {
			if ($this->ion_auth->is_admin() && ($this->uri->segment(1) == "PGadmin"))
			{
				echo "\t<div id=\"sidebar\" class=\"span-5 right\">\n";
				echo "<div id=\"amenu\">\n";
				echo "<ul>";
				echo "<li><span class=\"postblue\">Admin</span></li>\n";
				echo "<li>" . anchor('PGadmin/insertnew', 'New Post') . "</li>\n";
				echo "<li>" . anchor('PGadmin/moderate', 'Edit Post') . "</li>\n";
				echo "<li>" . anchor('PGadmin/logout', 'Logout') . "</li>\n";
				echo "</ul>\n";
				echo "</div>\n";
				
			}else{
		
		echo "\t<div id=\"sidebar\" class=\"span-5 right\">\n";
		echo "\t<div id=\"categories\">\n";
		echo "\t\t<ul>\n";
		echo "\t\t\t<li><span class=\"postblue\">Categories:</span></li>\n";
		echo "\t\t\t<li>" . anchor('/main/cat/0/' , 'All') . "</li>\n";
		foreach ($this->footer->getCategories() as $r)
		{
			echo "\t\t\t<li>" . anchor('/main/cat/' . $r->cid, $r->name) . "</li>\n";
		}
		echo "\t\t</ul>\n";
		echo "\t</div>\n";
		
			}
?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-8992167894741467";
/* Small Square Right Side */
google_ad_slot = "1983947247";
google_ad_width = 200;
google_ad_height = 200;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<br>
<br>

<a href="http://www.zazzle.com/profilegraveyard" target="_blank"> <img src="/images/kittytshirt.jpg" id="store_img"></a>

<br>

<a href="http://www.zazzle.com/profilegraveyard" target="_blank"> <center>Occupy Our Store</center></a>



<?php
		echo "\t</div>\n";
	}
	
	echo "</div>\n";
	echo "<div id=\"footer\">\n";
	echo "\t<div id=\"footwhite\"></div>\n";
	echo "\t<div id=\"footgray\">\n";
	echo "\t</div>\n";
	echo "\t<div id=\"footlinks\">\n";
        
	echo "\t\t<span class=\"left\">\n";
	echo "\t\t\t<img src=\"" . base_url() . "images/foot.jpg\">\n";

echo " <div id = \"copyright\"> Copyright &#169; 2012 ProfileGraveyard.com. All rights reserved. </div>" ;

	echo "\t\t</span>\n";
	echo "<div class=\"right\">";
	echo "\t\t<span class=\"right footnav\">\n";
	echo anchor('/main', 'home') . "|";
	echo anchor('/about/us/', 'about us') . "|";
	//echo "<a href=\"javascript:void();\" onclick=\"return togglesubmit();\">submit</a> |";
	echo anchor('/top/', 'top') . "|";
	echo anchor('/moderate', 'moderate') . "";
	//echo anchor('/about/faq/', 'faq') . "|";
	//echo anchor('/about/contact/', 'contact us') . "\n";
	echo "\t\t</span></div>\n";
	echo "<div id=\"sharebox\" class=\"right\">";



?>
<table>
	<tr><td>
<div style="display:block;float:right;">
<div id="fb-root"></div>
<div class="fb-like" data-href="http://www.facebook.com/profilegraveyard" data-send="false" data-layout="box_count" data-width="50" data-show-faces="false"></div>
</div></td><td>
<div style="display:block;float:right;">
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.profilegraveyard.com" data-text="Get the guts to deactivate... #profilegraveyard" data-count="vertical">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
</div>
</td>
<td><div style="display:block;float:right;">
<script src="http://www.stumbleupon.com/hostedbadge.php?s=5&r=http://www.profilegraveyard.com"></script>
</div>
</td>
<td>
<div style="display:block;float:right;">
<!-- Place this tag where you want the +1 button to render -->
<g:plusone size="tall" href="http://www.profilegraveyard.com"></g:plusone>

<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</div></td>
</tr></table>
<?php
	echo "</div>";
	echo "\t\t<div>\n";
	echo "\t\t\t<div id=\"footad\">\n";
	echo "\t\t\t\t<div id=\"adfoot\">\n";
?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-8992167894741467";
/* PrograveLeaderboard */
google_ad_slot = "3692921692";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?php
	echo "\t\t\t\t</div>\n";
	echo "\t\t\t</div>\n";
	echo "\t\t</div>\n";
	echo "\t</div>\n";
?>




		<script type="text/javascript">

        jQuery(document).ready(function($) {
       		 $("#hour_counter").flipCounter({
                	imagePath:"<?php echo base_url()?>images/flipCounter-medium.png",
                	digitHeight:24,
                	digitWidth:18,
                	numIntegralDigits: 15
             });
				$("#hour_counter").flipCounter(
		        "startAnimation", // scroll counter from the current number to the specified number
		        {
		                number: <?php echo $this->footer->totalTime();?>, // the number we want the counter to scroll to
		                easing: jQuery.easing.easeOutCubic, // this easing function to apply to the scroll.
		                duration: 10 // number of ms animation should take to complete
		        });
        });
	
	function time_change(){
		var hour_total = <?php echo $this->footer->totalTime();?>;
		var day_total = <?php echo $this->footer->totalTime()/24;?>;
		var year_total = <?php echo $this->footer->totalTime()/8760;?>;
		switch ($('#time_type').val())
		{
			case 'hours':
				$("#hour_counter").flipCounter(
		        "startAnimation", // scroll counter from the current number to the specified number
		        {
		                number: hour_total, // the number we want the counter to scroll to
		                easing: jQuery.easing.easeOutCubic, // this easing function to apply to the scroll.
		                duration: 1000 // number of ms animation should take to complete
		        });
				break;
			case 'days':
				$("#hour_counter").flipCounter(
		        "startAnimation", // scroll counter from the current number to the specified number
		        {
		                number: day_total, // the number we want the counter to scroll to
		                easing: jQuery.easing.easeOutCubic, // this easing function to apply to the scroll.
		                duration: 1000 // number of ms animation should take to complete
		        });
				break;
			case 'years':
				$("#hour_counter").flipCounter(
		        "startAnimation", // scroll counter from the current number to the specified number
		        {
		                number: year_total, // the number we want the counter to scroll to
		                easing: jQuery.easing.easeOutCubic, // this easing function to apply to the scroll.
		                duration: 1000 // number of ms animation should take to complete
		        });
				break;
			default:
				$("#hour_counter").flipCounter(
		        "startAnimation", // scroll counter from the current number to the specified number
		        {
		                number: hour_total, // the number we want the counter to scroll to
		                easing: jQuery.easing.easeOutCubic, // this easing function to apply to the scroll.
		                duration: 1000 // number of ms animation should take to complete
		        }); 
		}
	}
        </script>

<?
	echo "</body>\n";
	echo "</html>";
