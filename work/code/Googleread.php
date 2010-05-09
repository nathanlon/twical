<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>jhgjghjg</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="John Lunn">
	<!-- Date: 2010-05-08 -->
</head>
<body>



<?php
     		ini_set('display_errors',1);       
            require_once 'iCalcreator.class.php';

			$v = new vcalendar();
			/* start parse of local file */
			$v->setConfig( 'directory', 'uploads' );
			  // set directory
			$v->setConfig( 'filename', 'basic.ics' );
			  // set file name
			$v->parse();
			
			
		
			
			
			
			foreach($v->components as $component=>$info){
			
			
			# get first vevent
			
			
             $comp = $v->getComponent("VEVENT");

			
              
              //print_r($comp);
              $summary_array = $comp->getProperty("summary", 1, TRUE);
			  //$summary_array = $vevent->getProperty("summary", 1, TRUE);
              echo "Event: ", $summary_array["value"], "\n";
            
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

              
              echo "start: ",  $startDate,"T",$startTime, "\n";
              echo "end: ",  $endDate,"T",$endTime, "\n";

			$location_array = $comp->getProperty("location", 1, TRUE);
			//$location_array = $vevent->getProperty("location", 1, TRUE);
			
			echo "Location: ", $location_array["value"], "\n <br>";
			
			$myString = "bandfuture ,". $summary_array["value"].",".$startDate .",".$startTime .",". $endDate . "," . $endTime . "," . $location_array["value"] . "<br>";
			//echo  $myString; 
			
			
			require_once ('MDB2.php');

			$dsn = "mysqli://twical:7z3g4sYvqU43Nk@localhost/twical";
			$conn = MDB2::connect ($dsn);
			   if (PEAR::isError ($conn)){
			       die ("MDB2 Error - Cannot connect: " . $conn->getUserInfo () . "\n");
			       }
			$qry = "insert into `twical`.`events` (`twitter_userid`, `event`,`startDate`, `startTime`, `endDate`, `endTime`, 'location') 
				values ($myString) ";
			echo $qry;
			$conn->query($qry);
			   if (PEAR::isError ($conn)){
			       die ("MDB2 Error - Cannot connect: " . $conn->getUserInfo () . "\n");
			       }
			
			
			
			
			
			
			
		
		}


			/*


				$filename = fopen('uploads/basic.ics' , 'r') or die ('cant find file');
            
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
            
			*/
			



            ?>




</body>
</html>
