<?php

class ICalUploadForm extends PersonForm
{

  public function configure()
  {
    unset($this['id'], $this['is_muted'], $this['twitter_token'], $this['twitter_secret'],
      $this['twitter_userid'], $this['account_name'], $this['calendar_url'], $this['sf_guard_user_id'],
      $this['created_at'], $this['updated_at']);
    
    $this->widgetSchema['upload'] = new sfWidgetFormInputFile();
  }


}
