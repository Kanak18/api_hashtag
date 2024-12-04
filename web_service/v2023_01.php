<?php
$input = @file_get_contents("php://input");
$event_json = json_decode($input,true);

//header("Content-type: application/json;");

include_once '../includes/connection.php';
include_once '../includes/functions.php';


//$json = new Services_JSON();


$action = isset($event_json['service_type']) ? strtolower(trim($event_json['service_type'])) : '';
$type = isset($event_json['type']) ? strtolower(trim($event_json['type'])) : '';
$app_id = isset($event_json['app_id']) ? strtolower(trim($event_json['app_id'])) : '';


// select Services Here ..!!! 
switch ($action) {
    case 'get_rewards':
        $arrResult = get_rewards($app_id);
        break;    
    case 'get_settings':
        $arrResult = get_settings($app_id);
        break;    
    case 'get_videos':
        $arrResult = get_videos();
        break;    
	 default :
        $arrResult = sorry();
}

$output = json_encode($arrResult);
print_r($output);

/* ############# ALL FUNCTION DECLARE BELOW ############### */
function sorry(){	
	$arrSorry = array();	
	$arrSorry["status"] = "0";
    $arrSorry["message"] = "Ohh..! Sorry Please pass correct parameters to get response.";
	return $arrSorry;
}

function get_rewards($app_id)
{
    global $con;
    global $arrResult;
	extract($_REQUEST);

	$linkQuery = "SELECT c.id,link_title as title,link_desc as link,CONCAT(u.first_name,' ',u.last_name) as author_name,u.avatar as avatar,date_added as post_date,link_source as post_desc from coin_link c LEFT JOIN user u ON c.user_id=u.id order by c.id desc";
	
	
	$rsLinkQuery = mysqli_query($con,$linkQuery) or die ("could not found link deatil".mysql_error());
	$rowCounter = 0;
	$arrTemp = array();

	while($rw1=mysqli_fetch_array($rsLinkQuery))
	{
		
		$arrTemp[$rowCounter]['id'] = $rw1["id"];
		$arrTemp[$rowCounter]['title'] = $rw1["title"];
		$arrTemp[$rowCounter]['link'] = $rw1["link"];
		$arrTemp[$rowCounter]['author_name'] = $rw1["author_name"];		
		$arrTemp[$rowCounter]['post_date'] = date("F j, Y, g:i a",strtotime($rw1["post_date"])); // $rw1["post_date"];				
		$arrTemp[$rowCounter]['post_desc'] = $rw1["post_desc"];				
		$arrTemp[$rowCounter]['author_pic'] = "http://api.hashtagwebhub.com/users/".$rw1["avatar"];				
		$rowCounter ++;
	}

			

		//https://spinforcoinmasterdailylink.blogspot.com/2020/04/click-to-download-application.html
	
    /*
	if($app_id==2002)
	{
		$arrTemp = array();
		$arrTemp[0]['id'] = 0;
		$arrTemp[0]['title'] = "Data Availabe Soon";
		$arrTemp[0]['link'] = "";
		$arrTemp[0]['author_name'] = "Administrator.";		
		$arrTemp[0]['post_date'] = date("Y-m-d H:i");
		$arrTemp[0]['post_desc'] = "There were no current post available. it will be available soon";		
		$arrTemp[0]['author_pic'] = "";		
			
		$rowCounter ++;

	} */
	
	
	if(count($arrTemp) > 0)
	{
			$arrResult['code'] = "200";					
			$arrResult['msg'] = $arrTemp;			
	}
	else
	{
			$arrResult['status'] = "failed";
			$arrResult['message'] = "User not found.";
	}		
	
    return $arrResult;	

}

function get_settings($app_id)
{
    global $con;
    global $arrResult;
    
		
	$selQuery = "SELECT * from app where id=".$app_id."";
	$rsQuery =  mysqli_query($con,$selQuery) or die ("could not found app deatil".mysql_error());
	
	if($rwQuery=mysqli_fetch_array($rsQuery))
	{

	   if($rwQuery['ad_network']=="admob")
	   {
	   		$banner_ad_id = $rwQuery['banner_ad_id'];
	   		$interstitial_ad_id = $rwQuery['interstitial_ad_id'];
	   		$native_ad_id = $rwQuery['native_ad_id'];
	   		$reward_ad_id = $rwQuery['reward_ad_id'];
	   		$open_ad_id = $rwQuery['open_ad_id'];	
	   }	
	   else	if($rwQuery['ad_network']=="applovins")
	   {
	   		$banner_ad_id = $rwQuery['max_banner_ad_id'];
	   		$interstitial_ad_id = $rwQuery['max_interstitial_ad_id'];
	   		$native_ad_id = $rwQuery['max_native_ad_id'];
	   		$reward_ad_id = $rwQuery['max_reward_ad_id'];
	   		$open_ad_id = $rwQuery['max_open_ad_id'];	
	   }	

	   $arrResult=array(
            "status" => 1,
            "publisher_id" => $admob_publisher_id,
            "ad_network"=> $rwQuery['ad_network'],

            "show_open_ads_admob" => $rwQuery['show_open_ads_admob'],
            "show_banner" => $rwQuery['show_banner'],
            "show_inter" => $rwQuery['show_inter'],
            "show_native" => $rwQuery['show_native'],
            "show_reward" => $rwQuery['show_reward'],

            "banner_ad_id" => $banner_ad_id,
            "interstitial_ad_id" => $interstitial_ad_id,
            "native_ad_id" => $native_ad_id,
            "reward_ad_id" => $reward_ad_id,
            "open_ad_id" => $open_ad_id,
            
            "interstitial_show_count" => $rwQuery['interstitial_show_count'],
            "native_show_count" => 5, 

            "app_update_status" => $rwQuery['app_update_status'],
            "app_new_version" => $rwQuery['app_new_version'],
            "app_update_desc" => $rwQuery['app_update_desc'],
            "app_redirect_url" => $rwQuery['app_redirect_url'],
            "cancel_update_status" => $rwQuery['cancel_update_status'],

            "app_privacy_policy" => $rwQuery['privacy_policy'],
         );


		/*$arrResult['status']   = "ok";
		$arrResult['message']  = "App Setting Found Successfully.";
		$arrResult['category'] = $rwQuery;*/						
		
	}	
	else
	{
			$arrResult['status'] = "0";
			$arrResult['message'] = "User not found.";
	}		
	
    return $arrResult;	

}




?>
