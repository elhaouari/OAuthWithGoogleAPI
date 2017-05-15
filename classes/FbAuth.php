<?php

class FbAuth extends Auth{

	private $fb;
	private $fbHelper;
	private $errors;
	private $accessToken;
	private $permissions = [];

	public function __construct($args) {
		$this->fb = new Facebook\Facebook($args);
		$this->fbHelper   = $this->fb->getRedirectLoginHelper();
	}

	/**
	* return $fb object
	*/
	public function getFb() {
		return $this->fb;
	}


	/**
	* create the auth url for sign sign in with Facebook API
	*/
	public function getAuthUrl($permissions = null) {
		
		if ($permissions != null)
			$this->setPermissions($permissions);

		return $this->fbHelper->getLoginUrl(FB_APP_CALLBACK, $this->permissions);
	}

	/**
	* check the response code form Facebook API loggin page
	*/
	public function checkRedirectCode() {
		$_SESSION['FBRLH_state']=$_GET['state'];
		try {
			$this->accessToken = $this->fbHelper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			$this->errors['graph'] = $e->getMessage();
			return false;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			$this->errors['facebook_sdk'] = $e->getMessage();
			return false;
		}

		if (! isset($this->accessToken) ) {
			if ($this->fbHelper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
		    	echo "Error: " . $this->fbHelper->getError() . "\n";
		    	echo "Error Code: " . $this->fbHelper->getErrorCode() . "\n";
		    	echo "Error Reason: " . $this->fbHelper->getErrorReason() . "\n";
		    	echo "Error Description: " . $this->fbHelper->getErrorDescription() . "\n";
		    } else {
		    	header('HTTP/1.0 400 Bad Request');
		    	echo 'Bad request';
		    }
		    exit;
		}

		$this->setToken($this->accessToken);

		return true;
	}

	/**
	* set the token in the session
	*/
	public function setToken($token) {
		$_SESSION['access_token'] = $token;
		//$token = $this->client->fetchAccessTokenWithAuthCode($code);
  		//$this->client->setAccessToken($token);
	}

	/**
	* get token
	*/
	public function getToken() {
		return isset($_SESSION['fb_access_token']) ? $_SESSION['fb_access_token']: null;
	}

	// The OAuth 2.0 client handler helps us manage access tokens
	public function getMetaData() {
		$oAuth2Client = $this->fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		return $oAuth2Client->debugToken($this->getToken());
	}

	public function isLived() {

		if (! $this->accessToken->isLongLived() )  {
			// Exchanges a short-lived access token for a long-lived one
			try{
				$this->accessToken = $this->fb->getOAuth2Client()->getLongLivedAccessToken($this->accessToken);
			}
			catch(Facebook\Exceptions\FacebookSDKException $e) {
				$this->errors['long_lived'] = "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
				return false;
			}
		}

		return true;
	}

	public function saveSession(){
 		$_SESSION['fb_access_token'] = (string)$this->accessToken;
	}

	/**
	*
	*	set permissions for retvet from the Facebook login
	*/
	public function setPermissions($permissions) {
		$this->permissions = $permissions;
	}

	/**
	* return errors of the auth
	*/
	public function errors() {
		return $this->errors;
	}

}