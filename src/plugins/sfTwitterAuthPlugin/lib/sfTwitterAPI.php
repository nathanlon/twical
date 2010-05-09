<?php

class sfTwitterAPI
{
  static public function tweet($message)
  {
    // This always tweets as the current user, who must be
    // logged in via Twitter. TODO: support tweeting as any user; 
    // keep twitter access tokens handy in a database table, since they never expire.
    // Break out the parts of this method that are generic to all API calls
    // we might want to make.
    $user = sfContext::getInstance()->getUser();
    if (!$user->isAuthenticated())
    {
      return false;
    }
    /* Create TwitterOAuth with app key/secret and user access key/secret */
    $consumer_key = sfConfig::get('app_sfTwitterAuth_consumer_key');
    $consumer_secret = sfConfig::get('app_sfTwitterAuth_consumer_secret');
    $to = new TwitterOAuth($consumer_key, $consumer_secret,
      $user->getAttribute('sfTwitterAuth_oauth_access_token'),
      $user->getAttribute('sfTwitterAuth_oauth_access_token_secret'));
    /* Run request on twitter API as user. */
    $result = $to->OAuthRequest('http://twitter.com/statuses/update.xml', 
      array("status" => $message), 'POST');
    $xml = simplexml_load_string($result);
    $created_at = $xml->xpath("descendant::screen_name");
    if (!$created_at)
    {
      return false;
    }
    return true;
  }
}

?>