<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
$content = $connection->get('account/verify_credentials');
$url="http://api.twitter.com/version/friends/ids.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec ($ch);
curl_close ($ch);
print_r( $data);
/*
require_once ('MDB2.php');
$dsn = "mysqli://twical:7z3g4sYvqU43Nk@localhost/twical";
$conn = MDB2::connect ($dsn);
   if (PEAR::isError ($conn)){
       die ("MDB2 Error - Cannot connect: " . $conn->getUserInfo () . "\n");
       }
$qry = "insert into `twical`.`Person` ( `account_name`, `id`, `twitter_userid`, `twitter_secret`, `twitter_token`, `calendar_url`, `is_muted`) values ( '".$_SESSION['access_token']['oauth_token']."', '0', '97', '79797', '96969876', 'jgkjgjgjhgj', '1')";
echo $qry;
 Some example calls */
//
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992)));
//$connection->post('friendships/destroy', array('id' => 9436992)));

/* Include HTML to display on the page */
include('html.inc');
