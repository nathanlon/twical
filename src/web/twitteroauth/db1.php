<?php
require_once ('MDB2.php');
$dsn = "mysqli://root:rooroo06@localhost/twical";
$conn = MDB2::connect ($dsn);
   if (PEAR::isError ($conn)){
       die ("MDB2 Error - Cannot connect: " . $conn->getUserInfo () . "\n");
       }
$qry = "insert into `twical`.`person` ( `account_name`, `id`, `twitter_userid`, `twitter_secret`, `twitter_token`, `calendar_url`, `is_muted`) values ( '".$_SESSION['access_token']['oauth_token']."', '0', '97', '79797', '96969876', 'jgkjgjgjhgj', '1')";
$conn->query($qry);
echo $qry;
print_r($_SESSION);
   if (PEAR::isError ($conn)){
       die ("MDB2 Error - Cannot connect: " . $conn->getUserInfo () . "\n");
       }
?>