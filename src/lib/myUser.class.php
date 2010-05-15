<?php

class myUser extends sfGuardSecurityUser
{

  /**
   * When the person is authenticated, a person object is found or added, and
   * this needs to be set here for retrieval later.
   * @param integer $v
   */
  public function setPersonId($v)
  {
    $this->setAttribute('person_id', $v, 'person');
  }

  /*
   * Gets the person id which was set when logging in via twitter oauth.
   * @return integer The person id.
   */
  public function getPersonId()
  {
    return $this->getAttribute('person_id', null, 'person');
  }

}
