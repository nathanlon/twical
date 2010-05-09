<?php
class defaultActions extends sfActions {

  public function executeIndex(sfWebRequest $request)
  {
   $this->test_token =  $this->getUser()->getAttribute('oauth_token');

  }

}