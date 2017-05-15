<?php

/*******************************************
********************************************
*
*        The logout file
*    this file is set to handle sign out 
*    from the app
*
**********************************************/


require_once './init.php';

$auth->logout();

header('Location: index.php');