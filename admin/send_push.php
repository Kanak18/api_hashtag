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
				
					$apiKey = $rw_keys["fcm_key"];
					$topic =  "'".$rw_keys["topic_name"]."' in topics";
					
					//echo "<br>".$topic." ".$apiKey;
					//exit;
					
					$url = 'https://fcm.googleapis.com/fcm/send';
					$headers = array(
						'Authorization: key=' . $apiKey,
						'Content-Type: application/json'
					);
					
					$notification_data = array(    //// when application open then post field 'data' parameter work so 'message' and 'body' key should have same text or value
						'message' => $Link_Title
					);
			
					$notification = array(       //// when application close then post field 'notification' parameter work
						'body'  => $Link_Desc,
						'sound' => 'default'
					);
			
					$post = array(
						'condition'         => $topic,
						'notification'      => $notification,
						"content_available" => true,
						'priority'          => 'high',
						'data'              => $notification_data
					);
					
				
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
					$result = curl_exec($ch);
					print_r($result);
					curl_close($ch);
				
} 			
 
?>