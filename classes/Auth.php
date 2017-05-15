<?php

abstract class Auth{

	public abstract function getAuthUrl();

	public abstract function checkRedirectCode();
	
	/**
	* check if the user logged in
	*/
	public function isLoggedIn() {
		return isset($_SESSION['access_token']);
	}	


	/**
	* just sign the logout form the app
	*/
	public function logout(){
		unset($_SESSION['access_token']);
	}
}