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

      $this->form = new ICalUploadForm();

      if ($request->isMethod(sfWebRequest::POST))
      {
        $form->bind($request->getParameter('calload'), $request->getFiles('calload'));
        if ($form->isValid())
        {
          $this->processUpload($form);
        } else {
          //there were errors.
        }
      }


   }

  }

  public function executeLogin(sfWebRequest $request)
  {
    
  }

  /**
   * Create the person or find it.
   */
  public function executeTwitterCallback(sfWebRequest $request)
  {
    $user = $this->getUser();

    $this->isAuthenticated = false;

    if ($user->isAuthenticated() == true)
    {
      $this->isAuthenticated = true;

      $guardUser = $user->getGuardUser();
      $guardUserId = $guardUser->getId();

      $token = $user->getAttribute('sfTwitterAuth_oauth_access_token');
      $secret = $user->getAttribute('sfTwitterAuth_oauth_access_token_secret');

      //look for a person with this guard user id already.
      $q = Doctrine_Query::create()
        ->from('Person p')
        ->where('p.sf_guard_user_id = ?', $guardUserId);
      //$q->getSqlQuery();
      $person = $q->fetchOne();

      $personTable = Doctrine_Core::getTable('Person');

      $person = $personTable->findOneBy('sf_guard_user_id', $guardUserId);

      $this->addedPerson = false;
      $this->personSQLQuery = "GuardUserID=$guardUserId " . $q->getSqlQuery();// . "params = " . print_r($q->getParams(), true);

      if ($person === false)
      {
        $person = new Person();
        $person->setSfGuardUserId($guardUserId);
        $person->setTwitterToken($token);
        $person->setTwitterSecret($secret);
        $person->save();
        $this->addedPerson = true;
      }

      $personId = $person->getId();
      $user->setPersonId($personId);

      $this->personId = $personId;

      $this->redirect('@homepage');
    }
  }

  /**
   * Receives the uploaded file and processes it as events for the logged in person.
   * @param sfWebRequest $request
   */
  private function processUpload(& $form)
  {
    $file = $form->getValue('upload');

    $filename = 'uploaded_'.$this->getUser()->getPersonId();
    $extension = $file->getExtension($file->getOriginalExtension());
    $file->save(sfConfig::get('sf_upload_dir').'/ical/'.$filename.$extension);

  }

}