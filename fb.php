<?php
if(!session_id()) {
    session_start();
}

require_once './init.php';

/**********************************************
*
* I use the $fbAuth object from FbAuth class
* that I already created it in the init.php file
************************************************/

$fb = $fbAuth->getFb();
try{
	// Returns a `Facebook\FacebookResponse` object
  	$response = $fb->get('me?fields=name,photos{images},albums{id,link,name}', $fbAuth->getToken());
}
catch(Facebook\Exceptions\FacebookResponseException $e){
	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
}
catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}


$user = $response->getGraphUser();

echo 'Name: ' . $user['name'] . '<br />';
foreach ($user['albums'] as $key => $value) {
	# code...
	echo $value['id'], ' -- ', $value['name'], ' -- ',$value['link'],'<br>';
}

echo '<br/>';
foreach ($user['photos'] as $key => $value) {
	# code...
	foreach ($value['images'] as $key => $v) {
		# code...
		echo "<img src='{$v['source']}' /> <br />";
	}

	//echo '<pre>', $key, ' - ' , print_r( $value ), '</pre>';
}


