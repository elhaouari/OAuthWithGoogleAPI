<?php
/***********************************
*
*
*
************************************/
class GoogleAuth extends Auth{

	private $client;

	public function __construct(Google_Client $googleClient = null) {
		$this->client = $googleClient;
		if($this->client) {
			$this->client->setAuthConfig(GOOGLE_CONFIG_FILE);
			$this->client->setScopes('email');
		}
	}

	public function getClient() {
		return $this->client;
	}


	/**
	* create the auth url for sign sign in with Google API
	*/
	public function getAuthUrl() {
		return $this->client->createAuthUrl();
	}

	/**
	* check the response code form Google API loggin page
	*/
	public function checkRedirectCode() {
		if (isset($_GET['code'])) {
			$this->client->authenticate($_GET['code']);
			
			$this->setToken($this->client->getAccessToken(), $_GET['code']);
			
			return true;
		}

		return false;
	}

	/**
	* set the token in the session
	*/
	public function setToken($token, $code = null){
		$_SESSION['access_token'] = $token;
		//$token = $this->client->fetchAccessTokenWithAuthCode($code);
  		$this->client->setAccessToken($token);
	}

	
	public function getData() {
		if ($this->client->getAccessToken()) {
			return $this->client->verifyIdToken();
		}

		return null;
	}
	
}