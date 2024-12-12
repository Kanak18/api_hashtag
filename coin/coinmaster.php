<?php
include('simple_html_dom.php');
include('../includes/connection.php');


//$html = file_get_html('https://www.haktuts.in/2018/09/Coin-master-50-free-spin-and-coin-link.html');
$html = file_get_html('https://www.coinmastergame.in/2018/08/coin-master-free-spin-and-coin-link.html');
$links = array();
$index=0;
$today_dt=date('Ymd');

//$today_dt = "20241019";


$search_block_counter = 0;

foreach($html->find('blockquote a') as $item) {
    
	$block_content = $item;
	preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $block_content, $result);
	//print_r($result);
	if (!empty($result)) {	    
	    $link  = $result['href'][0];
	}
	
	preg_match_all('/<a .*?>(.*?)<\/a>/',$block_content,$matches);
	$link_title = $matches[1][0]; //output : Akki Khambhata
	
	//echo "<br>".$link_title;
	$bit_url = $link;


	if (strpos($bit_url, "bit.ly") !== false){
		$context = array
		(
		    'http' => array
		    (
		        'method' => 'GET',
		        'max_redirects' => 1,
		    ),
		);

		@file_get_contents($bit_url, null, stream_context_create($context));

		foreach ($http_response_header as $key => $paramValue) {			
			$word = "Location";
			if(strpos($paramValue, $word) !== false){
			    $bit_url = str_replace('Location: ', '', $http_response_header[$key]);
			}
		}		
	}

    

	$qryd = "SELECT * from coin_link where link_desc='".htmlspecialchars_decode($bit_url)."' ";
	$resd = mysqli_query($con,$qryd);

	if (mysqli_num_rows($resd) == 0) {
		if (strpos($bit_url,$today_dt) !== false) {			
			if(strlen($bit_url) > 5)
			{
				$qry = "INSERT INTO coin_link SET link_title = '".$link_title."',link_desc= '".htmlspecialchars_decode($bit_url)."', link_source = '".$link_title."', user_id = '" .rand(1,25). "', reward_type = '0'";		
		        mysqli_query($con,$qry) or die ("can not insert in to link table.".mysqli_error());
				$mid = mysqli_insert_id($con); 
				sendPush($mid);
				$links[$index]['link'] = $bit_url;
				$links[$index]['html'] = $link_title;
				$index++;
			}
		}
		
	}
	
	
	$search_block_counter++;	
	if($search_block_counter > 25)
	{
		break;
	}
}
echo "Total Record Fetch : ".$index;

/*
$html_second = file_get_html('https://freespinandcoin.blogspot.com/2018/11/coin-master-free-spin-and-coin-links.html');
$links = array();
$index=0;
$today_dt=date('d.m.Y');

$today_dt= "28.01.2021";

preg_match_all('@<p class="plink">(.+)</p>@', $html_second, $matches_second);
$listItems = $matches_second[1];

foreach ($listItems as $item) {

	$block_content = $item;
	preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $block_content, $result);
	//print_r($result);
	if (!empty($result)) {	    
	    $link  = $result['href'][0];
	}

	
	preg_match_all('/<a .*?>(.*?)<\/a>/',$block_content,$matches);
	$link_description = $matches[1][0]; //output : Akki Khambhata

	
	$bit_url = $link;
		
	$qryd = "SELECT * from coin_link where link_desc='".htmlspecialchars_decode($bit_url)."' ";
	$resd = mysql_query($qryd);
	if (mysql_num_rows($resd) == 0) {
		if (strpos($first_step[0],$today_dt) !== false) {
			if(strlen($bit_url) > 5)
			{
				$qry = "INSERT INTO coin_link SET link_title = '".$link_description."',link_desc= '".htmlspecialchars_decode($bit_url)."', link_source = '".$link_description."', user_id = '" .rand(1,25). "', reward_type = '0'";		
		        mysql_query($qry) or die ("can not insert in to link table.".mysql_error());
				$mid = mysql_insert_id();	
				sendPush($mid);
				$links[$index]['link'] = $bit_url;
				$links[$index]['html'] = $link_description;
				$index++;
			}
		}
	}
}

echo "Total Record Fetch Second: ".$index;
*/

function sendPush($aid)
{
		global $con;
		$qry = "SELECT c.*,CONCAT(u.first_name,' ',u.last_name) as post_by FROM coin_link c LEFT JOIN user u ON c.user_id=u.id WHERE c.id=$aid";
		$result = mysqli_query($con,$qry) or die("can not select ec");
		while($rw=mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$Link_Title = $rw["link_title"];
			$Link_Desc = $rw["link_source"];
			$Link_Author = $rw["user_id"];	
			$Link_Date = date("Y-m-d H:i",strtotime($rw["date_added"]));
		}
		
		$qry_keys = "SELECT * FROM fcm_key";
		$rs_keys = mysqli_query($con,$qry_keys) or die("can not select ec");
		while($rw_keys=mysqli_fetch_array($rs_keys, MYSQLI_ASSOC))
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

}

?>