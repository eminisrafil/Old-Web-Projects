<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Geo Location Plugin
 *
 * @package        CodeIgniter
 * @subpackage        System
 * @category        Plugin
 */

// ------------------------------------------------------------------------

/*    
Instructions:

Load the plugin using:

     $this->load->plugin('geo_location');

Once loaded you can get user's geo location details by IP address
    
    $ip = $this->input->ip_address();
    $geo_data = geolocation_by_ip($ip);
    
    echo "Country code : ".$geo_data['country_name']."\n";
    echo "Country name : ".$geo_data['city']."\n";
    ...
    

NOTES:
    
    The get_geolocation function will use current IP address, if IP param is not given.

RETURNED DATA

The get_geolocation() function returns an associative array with this data:

  [array]
  (
    'ip'=>$ip, 
    'country_code'=>$result->CountryCode, 
    'country_name'=>$result->CountryName, 
    'region_name'=>$result->RegionName, 
    'city'=>$result->City, 
    'zip_postal_code'=>$result->ZipPostalCode, 
    'latitude'=>$result->Latitude, 
    'longitude'=>$result->Longitude, 
    'timezone'=>$result->Timezone, 
    'gmtoffset'=>$result->Gmtoffset, 
    'dstoffset'=>$result->Dstoffset
  )
*/


/**
 * Get Geo Location by Given/Current IP address
 *
 * @access    public
 * @param    string
 * @return    array
 */
if (!function_exists('get_geolocation')) {
    
    function get_geolocation($ip) {
		$apiKey = '99fe9e04686c4b3d71a25abe3d076c372263604725666e6c04a5411c2063461e';
		$d = file_get_contents('http://api.ipinfodb.com/v2/ip_query.php?key=' . $apiKey . '&'.'ip=' . $ip); 
        //Use backup server if cannot make a connection
        if (!$d) {
            $backup = file_get_contents('http://api.ipinfodb.com/v2/ip_query.php?key=' . $apiKey . '&'.'ip=' . $ip); 
            $result = new SimpleXMLElement($backup);
            if (!$backup)
                return false; // Failed to open connection
        } else {
            $result = new SimpleXMLElement($d);
        }
        //Return the data as an array
        return array('ip'=>$ip, 'country_code'=>$result->CountryCode, 'country_name'=>$result->CountryName, 'region_name'=>$result->RegionName, 'city'=>$result->City, 'zip_postal_code'=>$result->ZipPostalCode, 'latitude'=>$result->Latitude, 'longitude'=>$result->Longitude, 'timezone'=>$result->Timezone, 'gmtoffset'=>$result->Gmtoffset, 'dstoffset'=>$result->Dstoffset);
    }
}
/* End of file geo_location_pi.php */
/* Location: ./system/plugins/geo_location_pi.php */ 