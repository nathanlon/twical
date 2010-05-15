<?php

class ICalUploadForm extends sfForm
{

  public function configure()
  {
    
    $this->widgetSchema['upload'] = new sfWidgetFormInputFile();

    $this->validatorSchema['upload'] = new sfValidatorFile(array(
      'required'   => true,
      'path'       => sfConfig::get('sf_upload_dir').'/ical'
    ));

    
  }



}
