<?php

/**
 * Person form base class.
 *
 * @method Person getObject() Returns the current form's model object
 *
 * @package    twical
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePersonForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'is_muted'         => new sfWidgetFormInputCheckbox(),
      'twitter_token'    => new sfWidgetFormInputText(),
      'twitter_secret'   => new sfWidgetFormInputText(),
      'twitter_userid'   => new sfWidgetFormInputText(),
      'account_name'     => new sfWidgetFormInputText(),
      'calendar_url'     => new sfWidgetFormTextarea(),
      'sf_guard_user_id' => new sfWidgetFormInputHidden(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'is_muted'         => new sfValidatorBoolean(array('required' => false)),
      'twitter_token'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_secret'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_userid'   => new sfValidatorInteger(array('required' => false)),
      'account_name'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'calendar_url'     => new sfValidatorString(array('max_length' => 1024, 'required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'sf_guard_user_id', 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('person[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Person';
  }

}
