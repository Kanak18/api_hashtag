<?php
include('simple_html_dom.php');
include('../includes/connection.php');


$html_second = file_get_html('https://freespinandcoin.blogspot.com/2018/11/coin-master-free-spin-and-coin-links.html');
$links = array();
$index=0;
$today_dt=date('d.m.Y');

$search_block_counter=0;

foreach($html_second->find('.plink') as $a) {
	
	$first_step = explode('<br />',$a);

	preg_match_all('~<a(.*?)href="([^"]+)"(.*?)>~', $first_step[1], $matches);
	$bit_url = $matches[2][0];

	$strArray = explode(' ',$first_step[0]);	
	$link_date = end($strArray);
	$link_description = str_replace($link_date, "", strip_tags($first_step[0]));

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
	$search_block_counter++;	
	if($search_block_counter>10)
	{
		break;
	}
}

echo "Total Record Fetch Second: ".$index;


function sendPush($aid)
{
    
		global $con;
		$qry = "SELECT c.*,CONCAT(u.first_name,' ',u.last_name) as post_by FROM coin_link c LEFT JOIN user u ON c.user_id=u.id WHERE c.id=$aid";
		$result = mysql_query($qry,$con) or die("can not select ec");
		while($rw=mysql_fetch_array($result))
		{
			$Link_Title = $rw["link_title"];
			$Link_Desc = $rw["link_source"];
			$Link_Author = $rw["user_id"];	
			$Link_Date = date("Y-m-d H:i",strtotime($rw["date_added"]));
		}
		
		
		$qry_keys = "SELECT * FROM fcm_key";
        $rs_keys = mysql_query($qry_keys) or die("can not select ec");
        while($rw_keys=mysql_fetch_array($rs_keys))
        {
        				
        					$apiKey = $rw_keys["fcm_key"];
        					$topic =  "'".$rw_keys["topic_name"]."' in topics";
        					
        					$url = 'https://fcm.googleapis.com/fcm/send';
        					$headers = array(
        						'Authorization: key=' . $apiKey,
        						'Content-Type: application/json'
        					);
        					$notification_data = array(    //// when application open then post field 'data' parameter work so 'message' and 'body' key should have same text or value
        						'message'           => $Link_Title
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

}


?>