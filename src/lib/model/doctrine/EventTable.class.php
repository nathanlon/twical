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
      //echo "Event: ", $summary_array["value"], "\n";

      $dtstart_array = $comp->getProperty("dtstart", 1, TRUE);

      $dtstart = $dtstart_array["value"];
      $startDate = "{$dtstart["year"]}-{$dtstart["month"]}-{$dtstart["day"]}";
      $startTime = "{$dtstart["hour"]}:{$dtstart["min"]}:{$dtstart["sec"]}";

      $dtend_array = $comp->getProperty("dtend", 1, TRUE);

      $dtend = $dtend_array["value"];
      $endDate = "{$dtend["year"]}-{$dtend["month"]}-{$dtend["day"]}";
      $endTime = "{$dtend["hour"]}:{$dtend["min"]}:{$dtend["sec"]}";

      //echo "start: ",  $startDate,"T",$startTime, "\n";
      //echo "end: ",  $endDate,"T",$endTime, "\n";

      $location_array = $comp->getProperty("location", 1, TRUE);

      //echo "Location: ", $location_array["value"], "\n <br>";

      //TODO: Check that this event does not already exist.

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

  /**
   * Finds the events that are between X minutes before the time passed in, and X minutes after
   * the time passed in. If no time is passed in, uses the current time.
   * @param integer $minutesBefore
   * @param integer $minutesAfter
   * @param integer $time
   * @return Array of events
   */
  public function getEventsWithin($minutesBefore = 5, $minutesAfter = 0, $time = null)
  {
    if (is_null($time))
    {
      $time = time();
    }

    $timeMin = $time - ($minutesBefore * 60);
    $timeMax = $time + ($minutesAfter * 60);
    $timeMinStr = date('Y-m-d H:i:s', $timeMin);
    $timeMaxStr = date('Y-m-d H:i:s', $timeMax);

    $query = $this->createQuery('e')
      ->where('start_time > ?', $timeMinStr)
      ->andWhere('start_time < ?', $timeMaxStr);

    //echo $query->getSqlQuery();
    //echo "timeMin = $timeMinStr, timeMax = $timeMaxStr";
    $events = $query->execute();

    print_r($events->toArray());

    return $events;
  }
}