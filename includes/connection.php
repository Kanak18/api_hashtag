<?php
// FI Version 0.0.1
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
session_start();
ini_set("error_reporting", 1);
//error_reporting(E_ALL);
ini_set('max_execution_time', 0);
define('PAGE_PER_NO',10);
define('SITESTATUS', '0');


$DB_Host = "localhost";
$DB_Name = "hashtag9_api";
$DB_Username = "hashtag9_api";
$DB_Password = ".BHd9L(YGn-y";


$SITE_URL = "https://api.hashtagwebhub.com/";
define("ROOT_SITE_URL", $SITE_URL);


define("DB_SERVER", $DB_Host);
define("DB_DATABASE", $DB_Name);
define("DB_USERNAME", $DB_Username);
define("DB_PASSWORD", $DB_Password);

$SITE_NAME = "Con Master Link Apps";



$con = mysqli_connect($DB_Host, $DB_Username, $DB_Password,$DB_Name);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}




///////// Start Admin Setting

$qry = "SELECT * FROM settings WHERE Id=1";
$rs = mysqli_query($con,$qry) or die(mysqli_error() . $qry);

if (mysqli_num_rows($rs) > 0) {
    $a = mysqli_fetch_array($rs);

    $ADMIN_EMAIL = $a["Email"];
    $FROM_EMAIL = $a["From_Email"];
    $FROM_NAME = $a["From_Name"];
	$SEARCH_LIMIT_RADIUS = $a["Search_Limit_Radius"];
} else {
    $ADMIN_EMAIL = "";
    $FROM_EMAIL = "";
    $FROM_NAME = "";
	$SEARCH_LIMIT_RADIUS = 5 ; //MILES
}


$qry = "SELECT * FROM fcm_keys WHERE Id=1";
$rs = mysqli_query($con,$qry) or die(mysqli_error() . $qry);

if (mysqli_num_rows($rs) > 0) {
    $a = mysqli_fetch_array($rs);

    $FCM_KEYS = $a["fcm_key"];
    
} else {
    $FCM_KEYS = "";
   
}
?>
