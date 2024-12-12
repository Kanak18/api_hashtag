<?php
ignore_user_abort(false);
set_time_limit(0);

$myVals = array();

include("../includes/connection.php");
include("../includes/functions.php");

$aid = setGPC($_REQUEST["lid"], "");
$qry = "SELECT c.*,CONCAT(u.first_name,' ',u.last_name) as post_by FROM coin_link c LEFT JOIN user u ON c.user_id=u.id WHERE c.id=$aid";
$result = mysqli_query($con,$qry) or die("can not select ec");
while($rw=mysqli_fetch_array($result))
{
	$Link_Title = $rw["link_title"];
	$Link_Desc = $rw["link_source"];
	$Link_Author = $rw["user_id"];	
	$Link_Date = date("Y-m-d H:i",strtotime($rw["date_added"]));
}



$qry_keys = "SELECT * FROM fcm_key";
$rs_keys = mysqli_query($con,$qry_keys) or die("can not select ec");

while($rw_keys=mysqli_fetch_array($rs_keys))
{

		
					$appId = $rw_keys["topic_name"]; // Replace with your OneSignal App ID
					$apiKey = $rw_keys["fcm_key"];    // Replace with your OneSignal REST API Key

					$content = [
						"en" => $Link_Desc
					];
				
					$headings = [
						"en" => $Link_Title
					];
				
					
					
					$fields = [
						'app_id' => $appId,
						'included_segments' => ['All'], // Target all users
						'headings' => $headings,
						'contents' => $content
					];
				
					$fieldsJson = json_encode($fields);

					
				
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://api.onesignal.com/notifications");
					curl_setopt($ch, CURLOPT_HTTPHEADER, [
						'Content-Type: application/json; charset=utf-8',
						'Authorization: Key ' . $apiKey
					]);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsJson);
					
					// Debug the request
					echo "Request Payload: " . $fieldsJson . "<br>";
					
					$response = curl_exec($ch);
					
					if ($response === FALSE) {
						die('Curl failed: ' . curl_error($ch));
					} else {
						echo "Response: " . $response;
					}
					
					curl_close($ch);
					
					


				
} 			
 
?>