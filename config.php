<?php

session_start();
ob_start();


$site_url = '127.3.3.1/'; // this var is used after in this file to create a constant that would access across the whole site.

$admin_email = 'shanuraj715@gmail.com'; // Admin email id to show anywhere in the site. this var will change into a constant.
$admin_mobile = '+918271890685';
$admin_whatsapp = '+919877936035';
$site_title = 'GaanaWorld.in';


/* getting the protocol http:// or https:// */

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	$site_protocol = "https://";
}
else{
	$site_protocol = "http://";
}


date_default_timezone_set('Asia/Kolkata');



$site_dir = __DIR__;
$site_dir = str_replace('\\', '/', $site_dir);
$site_dir .= '/';

$this_page = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


define('SITE_DIR', $site_dir);
define("SITE_URL", $site_protocol . $site_url);
define("SITE_TITLE", $site_title);

define('THIS_PAGE', $site_protocol . $this_page); // defining a constant to get the current 

define("ADMIN_EMAIL", $admin_email);
define("ADMIN_MOBILE", $admin_mobile);
define("ADMIN_WHATSAPP", $admin_whatsapp);


define("NEW_SONG_LIMIT", 20); // number of songs that will display on the new added songs section. This section is visible on homepage
define("SONG_LIMIT", 12);
define("SEARCH_PAGE_SONG_LIMIT", 40);
define("ADMIN_SONG_LIMIT", 80);
define("RELATED_FILES_LIMIT", 10);
define("FILE_UPLOAD_SIZE", 268435456); // in bytes
define("IMAGE_UPLOAD_SIZE", 819200); // in bytes
define("ALBUM_SHOW_LIMIT", 45); // number of albums that will show in albums
define("SINGER_SHOW_LIMIT", 35); // number of singers that will show in singer-list page page

define("TD_INC_TIME", 172800); // in seconds. per ip can change the total downloads number of a particular song.

define("MASTER_PASS", 'gaanaworld_master');
define("VISITOR_LOC", false);
define('UPLOADS_DIR', __DIR__ . '/uploads');


/* for Geolocation API (ip-api.com) */

function APIEndpoint(){
	// $api_key = '70e7da608d97bc78e0baabecd05b8fd5';
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$endpoint = "http://ip-api.com/json/" . $user_ip . "?fields=status,message,continent,country,regionName,city,lat,lon,isp,proxy,query";
	return $endpoint;
}

?>