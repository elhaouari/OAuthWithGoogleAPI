<?php

/*******************************************
********************************************
*
*        The call back file (URL)
*    this file is set to handle the response 
*    of the authenticating by google API
*
**********************************************/


require_once './init.php';

/**********************************************
*
* I use the $auth object from GoogleAuth class
* that I already created it in the init.php file
************************************************/

if ( $auth->checkRedirectCode() ) {
	$user = new User();
	$user->store($auth->getData());
	header('Location: index.php');
}
