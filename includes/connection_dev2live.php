<?php
session_start();
ini_set("error_reporting", 1);
//error_reporting(E_ALL);
ob_start();
ini_set('max_execution_time', 0);
$DB_Host = "172.16.16.250";
$DB_Name = "fantasyimmortal";
$DB_Username = "root";
$DB_Password = "root123";
$DB_Host = "localhost";
$DB_Name = "fantasyimmortals";
$DB_Username = "fantasyimmortals";
$DB_Password = "Pxf9C6mRWe6fGujv";
$SITE_URL = "http://dev2.mysticwebdesign.com/SITES/FI/";
//$socialshareurl = "";
$SITE_URL_front = "http://dev2.mysticwebdesign.com/SITES/FI/";
define("SITE_URL_front", "http://dev2.mysticwebdesign.com/SITES/FI/");
define("SITE_URL", "http://dev2.mysticwebdesign.com/SITES/FI/");
define("ROOT_SITE_URL", "http://dev2.mysticwebdesign.com/SITES/FI/");
$SITE_NAME = "FantacyImmortal";
$con = mysql_connect($DB_Host, $DB_Username, $DB_Password) or die(mysql_errno());
$db = mysql_select_db("$DB_Name", $con) or die(mysql_error());
///////// Start Admin Setting
$qry = "SELECT * FROM settings WHERE Id=1";
$rs = mysql_query($qry) or die(mysql_error() . $qry);
if (mysql_num_rows($rs) > 0) {
    $a = mysql_fetch_array($rs);
    $ADMIN_EMAIL = $a["Email"];
    $FROM_EMAIL = $a["From_Email"];
    $FROM_NAME = $a["From_Name"];
} else {
    $ADMIN_EMAIL = "";
    $FROM_EMAIL = "";
    $FROM_NAME = "";
}
/* player avtar */
define("PLAYER_IMAGE_ROOT", ROOT_SITE_URL . "uploads/player/");
define("PLAYER_IMAGE_PATH",  "/www/dev2.mysticwebdesign.com/html/SITES/FI/uploads/player/");
define("PLAYER_DATA_PATH", "/www/dev2.mysticwebdesign.com/html/SITES/FI/uploads/playerData/");

/* player avtar */
/* $qsel_social = "SELECT * FROM social_settings";
$rs_social = mysql_query($qsel_social) or print("can not select");
if (mysql_num_rows($rs_social) > 0) {
    $rec_social = mysql_fetch_array($rs_social);
    $twitter_url = $rec_social["twitter_url"];
    $facebook_url = $rec_social["facebook_url"];
    $instagram_url = $rec_social["instagram_url"];
    $youtube_url = $rec_social["youtube_url"];
    $youtube_url = $rec_social["youtube_url"];
    $google_url = $rec_social["google_url"];
    $fbshare_image = "upload/" . $rec_social["share_image"];
} else {
    $twitter_url = "https://twitter.com/login";
    $facebook_url = "https://www.facebook.com/";
    $instagram_url = "https://instagram.com/";
    $youtube_url = "https://youtube.com/";
    $google_url = "https://plus.google.com/";
    $fbshare_image = "images/site-logo.jpg";
}*/
///////// End Admin Setting
define("ImagePath", "images/");
define("LogoPath", "images/logo-images/");
define("LevelPath", "level-images/");
define("CharacterPath", "character-images/");
define("VideoPath", "upload-videos/");
define("AdvertisePath", "advertisment-image/");
?>
