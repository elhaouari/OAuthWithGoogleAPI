<?php 
if(!session_id()) {
    session_start();
}
require_once './init.php';

/**********************************************
*
* I use the $auth object from GoogleAuth class
* that I already created it in the init.php file
************************************************/


/************************************************
  If we have an access token, we can make
  requests.
 ************************************************/
if ( !empty($_SESSION['access_token']) 
	 && is_array($_SESSION['access_token']) // not an object of fb api
  	 && isset($_SESSION['access_token']['id_token'])) {

	$auth->setToken($_SESSION['access_token']);
} 

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Website</title>
</head>
<body>

	<?php if (!$auth->isLoggedIn()) : ?>
		<a href='<?= $auth->getAuthUrl() ?>'>Sing in with Google</a>
		<br />
		<a href='<?= $fbAuth->getAuthUrl(); ?>'>Sing in with Facebook</a>
	<?php else:?>
		You are signed in. <br />
		<a href="logout.php">Sign out</a>
		<br />
		<?php
		echo '<pre>', print_r($auth->getData()),'</pre>'; 
		?>
	<?php endif; ?>
</body>
</html>