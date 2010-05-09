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

    echo "<br />Check for AUTH";
    if ($user->isAuthenticated() == true)
    {
      echo "AUTHENTICATED SESSION";
      //create the person against the user.
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";

      $guardUser = $user->getGuardUser();
      $guardUserId = $guardUser->getId();


      echo "GUARD USER = $guardUserId";

      $token = $user->getAttribute('sfTwitterAuth_oauth_access_token');
      $secret = $user->getAttribute('sfTwitterAuth_oauth_access_token_secret');
      echo "TOKEN = ".$token;

      $person = new Person();
      $person->setSfGuardUserId($guardUserId);
      $person->setTwitterToken($token);
      $person->setTwitterSecret($secret);
      //$person->setTwitterSecret()
      //no save.
      $person->save();

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
        echo "CHECK AUTH";
    //Create a person mapping to sf_guard_user
    if ($this->getUser()->isAuthenticated() == true)
    {
      echo "AUTHENTICATED SESSION";

      print_r($_SESSION);


      echo " GUARD USER IS ".$guardUserId;

      if ($request->isMethod(sfWebRequest::POST))
      {
        //create the person against the user.
        $person = new Person();
        $person->setSfGuardUserId($guardUserId);
        //no save.
      }
    }

    /*
    //get the cookie
    $token = $request->getCookie('oauth_token','123');

    $q = Doctrine_Query::create()
    ->from('Person p')
    ->where('p.twitter_token = ?', $token);

    $person = $q->execute();
    */
    //get the calendar items against this 
    
  }

}