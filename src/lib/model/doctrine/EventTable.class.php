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
     * @return integer The number of events saved.
     */
    public function setEventsFromICal($fullDir, $fullFileName, $personId)
    {
      //start parse of local file
      $v = new vcalendar();
      // set directory
      $v->setConfig( 'directory', $fullDir);
      // set file name
      $v->setConfig( 'filename', $fullFileName);

      $v->parse();
      $count = 0;
      
      foreach($v->components as $component=>$info){
        # get first vevent
        $comp = $v->getComponent("VEVENT");

        $summary_array = $comp->getProperty("summary", 1, TRUE);
        //$summary_array = $vevent->getProperty("summary", 1, TRUE);
        //echo "Event: ", $summary_array["value"], "\n";

        $dtstart_array = $comp->getProperty("dtstart", 1, TRUE);
        //$dtstart_array = $vevent->getProperty("dtstart", 1, TRUE);

        $dtstart = $dtstart_array["value"];
        $startDate = "{$dtstart["year"]}-{$dtstart["month"]}-{$dtstart["day"]}";
        $startTime = "{$dtstart["hour"]}:{$dtstart["min"]}:{$dtstart["sec"]}";

        $dtend_array = $comp->getProperty("dtend", 1, TRUE);
        //$dtend_array = $vevent->getProperty("dtend", 1, TRUE);

        $dtend = $dtend_array["value"];
        $endDate = "{$dtend["year"]}-{$dtend["month"]}-{$dtend["day"]}";
        $endTime = "{$dtend["hour"]}:{$dtend["min"]}:{$dtend["sec"]}";

        //echo "start: ",  $startDate,"T",$startTime, "\n";
        //echo "end: ",  $endDate,"T",$endTime, "\n";

        $location_array = $comp->getProperty("location", 1, TRUE);
        //$location_array = $vevent->getProperty("location", 1, TRUE);

        //echo "Location: ", $location_array["value"], "\n <br>";

        $myString = "bandfuture ,". $summary_array["value"].",".$startDate .",".$startTime .",". $endDate . "," . $endTime . "," . $location_array["value"] . "<br>";

        $qry = "insert into `twical`.`events` (`twitter_userid`, `event`,`startDate`, `startTime`, `endDate`, `endTime`, 'location')
        values ($myString) ";
        //echo $qry;

        $event = new Event();
        $event->setPersonId($personId);
        $event->setName($summary_array["value"]);
        $event->setStartTime($startDate."T".$startTime);
        $event->setEndTime($endDate."T".$endTime);
        $event->setLocation($location_array["value"]);
        $event->save();

        $count++;
      }

      return $count;

    }

}