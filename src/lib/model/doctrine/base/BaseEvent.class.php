<?php

/**
 * BaseEvent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $location
 * @property float $latitude
 * @property float $longitude
 * @property string $url
 * @property timestamp $start_time
 * @property timestamp $end_time
 * @property integer $person_id
 * @property Person $Person
 * 
 * @method integer   getId()          Returns the current record's "id" value
 * @method string    getName()        Returns the current record's "name" value
 * @method string    getDescription() Returns the current record's "description" value
 * @method string    getLocation()    Returns the current record's "location" value
 * @method float     getLatitude()    Returns the current record's "latitude" value
 * @method float     getLongitude()   Returns the current record's "longitude" value
 * @method string    getUrl()         Returns the current record's "url" value
 * @method timestamp getStartTime()   Returns the current record's "start_time" value
 * @method timestamp getEndTime()     Returns the current record's "end_time" value
 * @method integer   getPersonId()    Returns the current record's "person_id" value
 * @method Person    getPerson()      Returns the current record's "Person" value
 * @method Event     setId()          Sets the current record's "id" value
 * @method Event     setName()        Sets the current record's "name" value
 * @method Event     setDescription() Sets the current record's "description" value
 * @method Event     setLocation()    Sets the current record's "location" value
 * @method Event     setLatitude()    Sets the current record's "latitude" value
 * @method Event     setLongitude()   Sets the current record's "longitude" value
 * @method Event     setUrl()         Sets the current record's "url" value
 * @method Event     setStartTime()   Sets the current record's "start_time" value
 * @method Event     setEndTime()     Sets the current record's "end_time" value
 * @method Event     setPersonId()    Sets the current record's "person_id" value
 * @method Event     setPerson()      Sets the current record's "Person" value
 * 
 * @package    twical
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEvent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('event');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 70, array(
             'type' => 'string',
             'length' => 70,
             ));
        $this->hasColumn('description', 'string', 1500, array(
             'type' => 'string',
             'length' => 1500,
             ));
        $this->hasColumn('location', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('latitude', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('longitude', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('start_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('end_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('person_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Person', array(
             'local' => 'person_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}