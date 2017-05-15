<?php
/*******************************************
********************************************
*
*        The call back file (URL)
*    this file is set to handle the response 
*    of the authenticating by Facebook API
*
**********************************************/


require_once './init.php';

/**********************************************
*
* I use the $fbAuth object from FbAuth class
* that I already created it in the init.php file
************************************************/

if ( $fbAuth->checkRedirectCode() ) {
	$user = new User();
	$user->sotreFb(['token' => $fbAuth->getToken(), 'email' => 'email' ]);
	$fbAuth->saveSession();

	header('Location: fb.php');
}
else {
	echo '<pre>', print_r( $fbAuth->errors() ), '</pre>';
}
