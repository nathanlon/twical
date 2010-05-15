<?php

class ICalUploadForm extends sfForm
{

  public function configure()
  {
    
    $this->widgetSchema['upload'] = new sfWidgetFormInputFile();
  }



}
