<?php

class ICalUploadForm extends sfFormObject
{

  public function configure()
  {
    $this->widgetSchema['upload'] = new sfWidgetFormInputFile();
  }


}
