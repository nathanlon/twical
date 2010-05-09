<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  header('Location: ./clearsessions.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $access_token;

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  // Write Session informtaion into a DB.
  require_once ('MDB2.php');
include_once('includes/db_conn.inc.php');

$dsn = "mysqli://twical:7z3g4sYvqU43Nk@localhost/twical";
$conn = MDB2::connect ($dsn);
   if (MDB2::isError ($conn)){
       die ("PearDB Error - Cannot connect: " . $conn->getMessage () . "\n");
       }
 $qry = "insert into Person VALUES ('',".$_SESSION['oauth_token'].",".$_SESSION['oauth_token_secret'].",".$_SESSION['user_id'].",".$_SESSION['screen_name'].");"
 
 $conn->query($qry);
  header('Location: ./index.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  header('Location: ./clearsessions.php');
}
