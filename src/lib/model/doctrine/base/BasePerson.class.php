<?php

/**
 * BasePerson
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property boolean $is_muted
 * @property string $twitter_token
 * @property string $account_name
 * @property string $calendar_url
 * @property Doctrine_Collection $Event
 * 
 * @method integer             getId()            Returns the current record's "id" value
 * @method boolean             getIsMuted()       Returns the current record's "is_muted" value
 * @method string              getTwitterToken()  Returns the current record's "twitter_token" value
 * @method string              getAccountName()   Returns the current record's "account_name" value
 * @method string              getCalendarUrl()   Returns the current record's "calendar_url" value
 * @method Doctrine_Collection getEvent()         Returns the current record's "Event" collection
 * @method Person              setId()            Sets the current record's "id" value
 * @method Person              setIsMuted()       Sets the current record's "is_muted" value
 * @method Person              setTwitterToken()  Sets the current record's "twitter_token" value
 * @method Person              setAccountName()   Sets the current record's "account_name" value
 * @method Person              setCalendarUrl()   Sets the current record's "calendar_url" value
 * @method Person              setEvent()         Sets the current record's "Event" collection
 * 
 * @package    twical
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePerson extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('person');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('is_muted', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('twitter_token', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('account_name', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('calendar_url', 'string', 1024, array(
             'type' => 'string',
             'length' => 1024,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Event', array(
             'local' => 'id',
             'foreign' => 'person_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}