<?php

class sfTwitterAuthActions extends sfActions
{
  public function executeLogin(sfRequest $request)
  {
    /* Consumer key from twitter */
    $consumer_key = sfConfig::get('app_sfTwitterAuth_consumer_key');
    $consumer_secret = sfConfig::get('app_sfTwitterAuth_consumer_secret');
    $user = $this->getUser();
    $module = $request->getParameter('module');
    $action = $request->getParameter('action');
    if ($module !== 'sfTwitterAuth')
    {
      // We were forwarded here to force a login
      $user->setAttribute('sfTwitterAuth_after', "$module/$action");
    }
    /* Set state if previous session */
    $state = $user->getAttribute('sfTwitterAuth_oauth_state');
    /* If oauth_token is missing get it */
    if ($request->hasParameter('oauth_token') && ($state === 'start')) 
    {
      $user->setAttribute('sfTwitterAuth_oauth_state', $state = 'returned');
    }

    /*
     * Switch based on where in the process you are
     *
     * 'default': Get a request token from twitter for new user
     * 'returned': The user has authorized the app on twitter
     */
    switch ($state) {
      default:
        /* Create TwitterOAuth object with app key/secret */
        $to = new TwitterOAuth($consumer_key, $consumer_secret);
        /* Request tokens from twitter */
        $tok = $to->getRequestToken();

        /* Save tokens for later */
        $user->setAttribute('sfTwitterAuth_oauth_request_token', $token = $tok['oauth_token']);
        $user->setAttribute('sfTwitterAuth_oauth_request_token_secret', $tok['oauth_token_secret']);
        $user->setAttribute('sfTwitterAuth_oauth_state', "start");

        /* Build the authorization URL */
        $request_link = $to->getAuthorizeURL($token);
        return $this->redirect($request_link);
        break;
      case 'returned':
        /* If the access tokens are already set skip to the API call */
        if ((!$user->getAttribute('sfTwitterAuth_oauth_access_token')) &&   (!$user->getAttribute('sfTwitterAuth_oauth_access_token_secret')))
        {
          /* Create TwitterOAuth object with app key/secret and token key/secret from default phase */
          $to = new TwitterOAuth($consumer_key, $consumer_secret,
            $user->getAttribute('sfTwitterAuth_oauth_request_token'),
            $user->getAttribute('sfTwitterAuth_oauth_request_token_secret'));
          /* Request access tokens from twitter */
          $tok = $to->getAccessToken();
          /* Save the access tokens. These could be saved in a database as they don't 
            currently expire. But our goal here is just to authenticate the session. */
          $user->setAttribute('sfTwitterAuth_oauth_access_token', $tok['oauth_token']);
          $user->setAttribute('sfTwitterAuth_oauth_access_token_secret', $tok['oauth_token_secret']);
        }
        /* Create TwitterOAuth with app key/secret and user access key/secret */
        $to = new TwitterOAuth($consumer_key, $consumer_secret,
          $user->getAttribute('sfTwitterAuth_oauth_access_token'),
          $user->getAttribute('sfTwitterAuth_oauth_access_token_secret'));
        /* Run request on twitter API as user. */
        $result = $to->OAuthRequest('https://twitter.com/account/verify_credentials.xml', array(), 'GET');
        $xml = simplexml_load_string($result);
        $username = $xml->xpath("descendant::screen_name");
        if (is_array($username) && count($username))
        {
          $username = (string) $username[0];
          $guardUser = Doctrine_Query::create()->from('sfGuardUser u')->where('username = ?', array($username))->fetchOne();
          if (!$guardUser)
          {
            // Make a new user here
            $guardUser = new sfGuardUser();
            $guardUser->setUsername($username);
            // Set a secure, random sfGuard password to ensure that this
            // account is not wide open if conventional logins are permitted
            $guid = "";
            for ($i = 0; ($i < 8); $i++) {
              $guid .= sprintf("%x", mt_rand(0, 15));
            }
            $guardUser->setPassword($guid);
            $guardUser->save();            
          }
          $user->signIn($guardUser);
          $after = $user->getAttribute('sfTwitterAuth_after');
          if (!$after)
          {
            $after = "@homepage";
          }
          return $this->redirect($after);
        }
        else
        {
          $user->setAttribute('sfTwitterAuth_oauth_request_token', null);
          $user->setAttribute('sfTwitterAuth_request_token_secret', null);
          $user->setAttribute('sfTwitterAuth_oauth_state', null);
          $user->setAttribute('sfTwitterAuth_oauth_access_token', null);
          $user->setAttribute('sfTwitterAuth_oauth_access_token_secret', null);
          $this->redirect('sfTwitterAuth/failed');
        }
        break;
    }
  }
  public function executeFailed()
  {
    
  }
}
