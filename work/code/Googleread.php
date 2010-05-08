<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>untitled</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="John Lunn">
	<!-- Date: 2010-05-08 -->
</head>
<body



<?php
            
            require_once 'iCalcreator/iCalcreator.class.php';
            
              $filename = fopen("http://www.google.com/calendar/ical/chillikong@googlemail.com/private-1d40cdd87841e52f7cb5a14d7bf4b8f7/basic.ics", "r");
            
              $v = new vcalendar(); // initiate new CALENDAR
              $v->parse($filename);
            
              # get first vevent
              $comp = $v->getComponent("VEVENT");
              
              #print_r($comp);
              $summary_array = $comp->getProperty("summary", 1, TRUE);
              echo "summary: ", $summary_array["value"], "\n";
            
              $dtstart_array = $comp->getProperty("dtstart", 1, TRUE);
              $dtstart = $dtstart_array["value"];
              $startDate = "{$dtstart["year"]}-{$dtstart["month"]}-{$dtstart["day"]}";
              $startTime = "{$dtstart["hour"]}:{$dtstart["min"]}:{$dtstart["sec"]}";
              
              $dtend_array = $comp->getProperty("dtend", 1, TRUE);
              $dtend = $dtend_array["value"];
              $endDate = "{$dtend["year"]}-{$dtend["month"]}-{$dtend["day"]}";
              $endTime = "{$dtend["hour"]}:{$dtend["min"]}:{$dtend["sec"]}";
              
              echo "start: ",  $startDate,"T",$startTime, "\n";
              echo "end: ",  $endDate,"T",$endTime, "\n";
            
            ?>


?>

</body>
</html>
