<?php
session_start();

//*****************************
define('GOOGLE_CONFIG_FILE', './secret/client_secret.json');


//*********************************
require_once './vendor/autoload.php';
require_once './classes/DB.php';
require_once './classes/User.php';
require_once './classes/GoogleAuth.php';

// create table User if not exists
(new User())->createTable();

$client = new Google_Client();
$auth = new GoogleAuth($client);
?>


