<?php

/**
 * Person filter form base class.
 *
 * @package    twical
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePersonFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'is_muted'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'twitter_token'    => new sfWidgetFormFilterInput(),
      'twitter_secret'   => new sfWidgetFormFilterInput(),
      'twitter_userid'   => new sfWidgetFormFilterInput(),
      'account_name'     => new sfWidgetFormFilterInput(),
      'calendar_url'     => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'is_muted'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'twitter_token'    => new sfValidatorPass(array('required' => false)),
      'twitter_secret'   => new sfValidatorPass(array('required' => false)),
      'twitter_userid'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'account_name'     => new sfValidatorPass(array('required' => false)),
      'calendar_url'     => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('person_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Person';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'is_muted'         => 'Boolean',
      'twitter_token'    => 'Text',
      'twitter_secret'   => 'Text',
      'twitter_userid'   => 'Number',
      'account_name'     => 'Text',
      'calendar_url'     => 'Text',
      'sf_guard_user_id' => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
