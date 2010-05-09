<?php
class defaultActions extends sfActions {

  public function executeIndex(sfWebRequest $request)
  {
   $this->test_token =  $this->getUser()->getAttribute('oauth_token');
   
   $this->loggedIn = false;
   if ($this->getUser()->isAuthenticated() == true)
   {
     $this->loggedIn = true;
   }

  }

  public function executeLogin(sfWebRequest $request)
  {
    echo "CHECK AUTH";
    //Create a person mapping to sf_guard_user
   if ($this->getUser()->isAuthenticated() == true)
   {
     echo "AUTHENTICATED SESSION";

print_r($_SESSION); ?>


     //create the person against the user.
     $person = new Person();
     //$person->setSfGuardUserId($this->getUser()->get)
   }

    //$this->forward('default', 'index');
  }

  public function executeLoadData(sfWebRequest $request)
  {
    //get the cookie
    $token = $request->getCookie('oauth_token','123');

    $q = Doctrine_Query::create()
    ->from('Person p')
    ->where('p.twitter_token = ?', $token);

    $person = $q->execute();

    //get the calendar items against this 
    
  }

}