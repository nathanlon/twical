<?php
class defaultActions extends sfActions {

  public function executeIndex(sfWebRequest $request)
  {
    
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