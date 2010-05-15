<?php


class EventTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Event');
    }

    /**
     * The file contents is looked at and events are created here.
     * @param string $fileContents
     */
    public function setEventsFromICal($fileContents)
    {
      echo $fileContents;
    }

}