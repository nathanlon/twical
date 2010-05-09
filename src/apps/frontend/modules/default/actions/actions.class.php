<?php
class defaultActions extends sfActions {

  /**
   * Shows the homepage before login. Only option is to log in.
   * @param sfWebRequest $request
   *
   */
  public function executeIndex(sfWebRequest $request)
  {
   $this->test_token =  $this->getUser()->getAttribute('oauth_token');
   
   $this->loggedIn = false;
   if ($this->getUser()->isAuthenticated() == true)
   {
     $this->loggedIn = true;
     $this->redirect('default/secureHome');
   }

  }

  /**
   * Create the person or find it.
   */
  public function executeTwitterCallback(sfWebRequest $request)
  {
    $user = $this->getUser();

    if ($user->isAuthenticated() == true)
    {

      $guardUser = $user->getGuardUser();
      $guardUserId = $guardUser->getId();

      $token = $user->getAttribute('sfTwitterAuth_oauth_access_token');
      $secret = $user->getAttribute('sfTwitterAuth_oauth_access_token_secret');

      $person = new Person();
      $person->setSfGuardUserId($guardUserId);
      $person->setTwitterToken($token);
      $person->setTwitterSecret($secret);
      $person->save();

      $this->redirect('default/secureHome');
    }
  }

  /**
   * User is immediately taken to twitter as this page is secure.
   * @param sfWebRequest $request
   */
  public function executeLogin(sfWebRequest $request)
  {
    //if we get here, we are logged in. Forward to secure area.

    //$this->forward('default', 'index');
  }

  public function executeSecureHome(sfWebRequest $request)
  {
    //Create a person mapping to sf_guard_user
    if ($this->getUser()->isAuthenticated() == true)
    {
      if ($request->isMethod(sfWebRequest::POST))
      {
        //create the person against the user.
        $person = new Person();
        $person->setSfGuardUserId($guardUserId);
        //no save.
      }
    }

  }

}