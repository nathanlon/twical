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

      //look for a person with this guard user id already.
      $q = Doctrine_Query::create()
        ->from('Person p')
        ->where('p.sf_guard_user_id = ?', $guardUserId);

      $person = $q->fetchOne();

      if (is_null($person))
      {
        $person = new Person();
        $person->setSfGuardUserId($guardUserId);
        $person->setTwitterToken($token);
        $person->setTwitterSecret($secret);
        $person->save();
      }

      $this->redirect('@homepage');
    }
  }


}