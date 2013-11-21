<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Sitevar {
	
	function get($type)
	{
		$gConf = array(
			'per_page' => 10, //pagination, links per page
			'num_links' => 10, //pagination, number of links to list
			'front_vote' => 500,	 //required number of approves to post on frontpage
			'front_reject' => 300 //number of reject votes before rejecting from frontpage moderate views
		);
		
		return $gConf[$type];
	}
	
}
