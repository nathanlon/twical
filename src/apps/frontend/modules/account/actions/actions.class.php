<?php
class accountActions extends sfActions {

  public function executeConnect(sfWebRequest $request)
  {
/**
 * @file
 * Get a request token from twitter and present authorization URL to user
 */
/* Start session and load lib */
//session_start();
//require_once('twitteroauth.php');

/* Check status */
switch ($this->getUser()->getAttribute('oauth_status')) {
  case 'oldtoken':
    $status_text = 'The request was to old. Please try again.';
    $this->getUser()->getAttributeHolder()->remove('oauth_status');
    break;
}
$consumer_key = '';
$consumer_secret = '';



/* Create TwitterOAuth object and get request token */
$connection = new TwitterOAuth($consumer_key, $consumer_secret);

/* Save consumer keys into TwitterOAuth object and SESSION for use on other pages */



/* Get request token */
$request_token_array = $connection->getRequestToken();
if (!isset($request_token_array['oauth_token'])) $request_token_array['oauth_token'] = '';
if (!isset($request_token_array['oauth_token_secret'])) $request_token_array['oauth_token_secret'] = '';
$token = $request_token_array['oauth_token'];
/* Save request token to session */
$this->getUser()->getAttributeHolder()->remove('oauth_token',$token);
$this->getUser()->getAttributeHolder()->remove('oauth_token_secret',$request_token_array['oauth_token_secret']);

/* If last connection fails don't display authorization link */
switch ($connection->last_http_status) {
  case 200:
    /* Build authorize URL */
    $authorize_url = $connection->getAuthorizeURL($token, $oauth_callback);
    $content = '<a href="'.$authorize_url.'"><img src="/connect.gif" alt="Sign in with Twitter"/></a>';
    break;
  default:
    $content = 'Something went wrong please try again later.';
    break;
}

  }

}