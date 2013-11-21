<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$head['title'] = "About Us";
	$this->load->view('header', $head);
	echo "<div id = aboutHeader> About ProfileGraveyard.com </div> ";
	echo "<p id=\"about-us\">\n";
	?>
	<div class = "aboutText"> Profile Graveyard helps you manage your social networking profile when you are ready to deactivate or just need a break. We have three goals:  </div><br /><br />

	<div class = "aboutH2"> 
	Keep you from falling off the face off the Earth
        </div>


<div class = "aboutText">
We give your friends a way to contact you after you have deactivated your profile. You do not have to miss the epic bachelor party because your college roommate lost your number. Or spend the rest of your life alone because the love of your life tried to message you the day after you closed your online dating profile.<br />
<a href = " " > Read more about how it works: Here </a>

 <br /> <br />
<span class = "aboutH2">Brighten up your day </span><br />
By posting the funny reasons and horror stories that caused people to deactivate their Facebook, Twitter and other social networks...with their permission of course. 

 <br /> <br />
<span class = "aboutH2">Help you discover new social networks that fit your personality</span><br />
Soon we will start offering voluntary surveys to our users that will match you with new networks on a personal level.  These surveys will also help us update you on trends in social media. We can help people see which social networks are up and coming and which are digging their own grave.
 
<br /> <br />
...Maybe if we were around 6 years ago we could have warned old News Corp about Myspace

</div>

<?php echo "</p>\n";
	
	$data['sideBar'] = "\t<div id=\"categories\">\n";
	$data['sideBar'] .= "\t\t<ul>\n";
	$data['sideBar'] .= "\t\t\t<li>" . anchor('/about/us/' , 'About Us') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li>" . anchor('/about/contact/' , 'Contact Us') . "</li>\n";
	$data['sideBar'] .= "\t\t\t<li>" . anchor('/about/faq/' , 'FAQ') . "</li>\n";
	$data['sideBar'] .= "\t\t</ul>\n";
	$data['sideBar'] .= "\t</div>\n";
	
	$this->load->view('footer', $data);
?>
