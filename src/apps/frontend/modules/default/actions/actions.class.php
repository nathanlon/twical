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
    $this->message = '';
    
    $this->loggedIn = false;
    if ($this->getUser()->isAuthenticated() == true)
    {
      $this->loggedIn = true;

      $this->form = new ICalUploadForm();

      //if it was a post, we may have just uploaded something.
      if ($request->isMethod(sfWebRequest::POST))
      {
        $this->form->bind($request->getParameter('calload'), $request->getFiles('calload'));
        if ($this->form->isValid())
        {
          $this->message = $this->eventCount . " events were loaded.";
          $this->processUpload($this->form);
        } else {
          //there were errors.
          $this->message = "Errors: ".$form->renderGlobalErrors();
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
    $user = $this->getUser();
    $personId = $user->getPersonId();

    //get the file from the upload.
    $file = $form->getValue('upload');

    //get the extension and set the file name based on person logged in.
    $extension = $file->getExtension($file->getOriginalExtension());
    $filename = 'uploaded_'.$personId;

    //save the file on disk, for reading next.
    $fullDir = sfConfig::get('sf_upload_dir').'/ical';
    $fullFileName = $filename.$extension;
    $fullFilePath = $fullDir.'/'.$fullFileName;
    $file->save($fullFilePath);

    //after the file has been saved, go and read it into the events table.
    $this->eventCount = EventTable::getInstance()
      ->setEventsFromICal($fullDir, $fullFileName, $personId);

    // We should probably remove the file here.

  }

}