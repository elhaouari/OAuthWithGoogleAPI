<?php
if(!session_id()) {
    session_start();
}


//*****************************
// file of google api credintion 
define('GOOGLE_CONFIG_FILE', '/home/web/config/google_client_secret.json');
define('FB_APP_ID', '********');
define('FB_APP_SECRET', '*********');
define('FB_APP_CALLBACK', 'http://localhost:8080/fb2callback.php');

//*********************************
require_once './vendor/autoload.php';
require_once './classes/DB.php';
require_once './classes/User.php';
require_once './classes/Auth.php';
require_once './classes/GoogleAuth.php';
require_once './classes/FbAuth.php';

// create table User if not exists
(new User())->createTableGoogle()->createTableFb();

$client = new Google_Client();
$auth = new GoogleAuth($client);


// create FbAuth object
$fbAuth = new FbAuth([
			'app_id' => FB_APP_ID,
			'app_secret' => FB_APP_SECRET,
			'persistent_data_handler'=>'session',
			'default_graph_version' => 'v2.7'
			]);
$fbAuth->setPermissions(['email', 'user_posts', 'user_photos']);
?>


