<?php
ignore_user_abort(false);
set_time_limit(0);


$apiKey = "AAAAxExU3uI:APA91bGQNugxyt9VwTFE24hsCFxhtkPSEpjOUraW-W1Yw13c8H-8yLzE80eh1ZyrqM5g4FcyvtCFV0K1VY9qsGT7632ZK4OR1Le9bzg07QdmeYClq1cAzdtVN-NIQJZpfaFOQ7Sbi2ZL";
$topic =  "'HASHTAG_123' in topics";

//echo "<br>".$topic." ".$apiKey;
//exit;

$url = 'https://fcm.googleapis.com/fcm/send';
$headers = array(
	'Authorization: key=' . $apiKey,
	'Content-Type: application/json'
);

$notification_data = array(    //// when application open then post field 'data' parameter work so 'message' and 'body' key should have same text or value
	'message' => "You have Received Reward as Messsage" 
);

$notification = array(       //// when application close then post field 'notification' parameter work
    'title' => "You have Received Reward", 
	'body'  => "150 Spin Link Available.",
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

		
 
?>