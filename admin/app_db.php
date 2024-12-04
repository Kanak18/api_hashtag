<?php
include("../includes/connection.php");
include("../includes/functions.php");

$action = setGPC($_REQUEST["myaction"], "");
if ($action == "delete") {
    if (isset($_POST["users_id"]) && is_array($_POST["users_id"]) && count($_POST["users_id"]) > 0) {
        #START CODE DELETE FROM userss table
        $qry = "DELETE FROM app WHERE id IN (" . implode(",", $_POST["users_id"]) . ")";
        mysqli_query($con,$qry);
        #END CODE DELETE FROM userss table

        $_SESSION['success_message'] = "App deleted successfully";
        header("Location: applist.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Error while deleting app please try again.";
        header("Location: applist.php");
        exit;
    }
}


$app_name = setGPC($_REQUEST["app_name"], "");
$package_name = setGPC($_REQUEST["package_name"], "");
$youtube_keyword = setGPC($_REQUEST["youtube_keyword"], "");
$ad_network = setGPC($_REQUEST["ad_network"], "");

if(isset($_REQUEST["show_banner"]))
{
    $show_banner = 1;    
}
else
{
    $show_banner = 0;
}

if(isset($_REQUEST["show_inter"]))
{
    $show_inter = 1;    
}
else
{
    $show_inter = 0;
}

if(isset($_REQUEST["show_native"]))
{
    $show_native = 1;    
}
else
{
    $show_native = 0;
}


if(isset($_REQUEST["show_reward"]))
{
    $show_reward = 1;    
}
else
{
    $show_reward = 0;
}
if(isset($_REQUEST["show_open_ads_admob"]))
{
    $show_open_ads_admob = 1;    
}
else
{
    $show_open_ads_admob = 0;
}



$banner_ad_id = setGPC($_REQUEST["banner_ad_id"], "");
$interstitial_ad_id = setGPC($_REQUEST["interstitial_ad_id"], "");
$native_ad_id = setGPC($_REQUEST["native_ad_id"], "");
$reward_ad_id = setGPC($_REQUEST["reward_ad_id"], "");
$open_ad_id = setGPC($_REQUEST["open_ad_id"], "");



$max_banner_ad_id = setGPC($_REQUEST["max_banner_ad_id"], "");
$max_interstitial_ad_id = setGPC($_REQUEST["max_interstitial_ad_id"], "");
$max_native_ad_id = setGPC($_REQUEST["max_native_ad_id"], "");
$max_reward_ad_id = setGPC($_REQUEST["max_reward_ad_id"], "");
$max_open_ad_id = setGPC($_REQUEST["max_open_ad_id"], "");

$interstitial_show_count = setGPC($_REQUEST["interstitial_show_count"], "");



if(isset($_REQUEST["app_update_status"]))
{
    $app_update_status = 1;    
}
else
{
    $app_update_status = 0;
}

$app_new_version = setGPC($_REQUEST["app_new_version"], "");
$app_update_desc = setGPC($_REQUEST["app_update_desc"], "");
$app_redirect_url = setGPC($_REQUEST["app_redirect_url"], "");
$cancel_update_status = setGPC($_REQUEST["cancel_update_status"], "");

$google_key = setGPC($_REQUEST["google_key"], "");
$privacy_policy = setGPC($_REQUEST["privacy_policy"], "");
$dynamic_banner_count = setGPC($_REQUEST["dynamic_banner_count"], "");
$status = 1;

if ($action == "edit")
    $qryd = "SELECT package_name from app where package_name='".$package_name."' AND id!='" . $_REQUEST['aid'] . "' ";
else
    $qryd = "SELECT package_name from app where package_name='".$package_name."'";
$resd = mysqli_query($con,$qryd);
if (mysqli_num_rows($resd) > 0) {
    $msg = "Package '".$package_name."' is already exist.";
    $response['status'] = 0;
    $response['html'] = $msg;
} else {
 	
    if ($action == 'add') {
        $qry = "INSERT INTO app SET app_name = '" . $app_name . "', package_name = '" . $package_name . "', youtube_keyword = '" . $youtube_keyword . "',  ad_network = '" . $ad_network . "', show_banner = '" . $show_banner . "',show_inter = '" . $show_inter . "',show_native = '" . $show_native . "',show_reward = '" . $show_reward . "',show_open_ads_admob = '" . $show_open_ads_admob . "',banner_ad_id = '" . $banner_ad_id . "', interstitial_ad_id = '" . $interstitial_ad_id . "', native_ad_id = '" . $native_ad_id . "', reward_ad_id = '" . $reward_ad_id . "', open_ad_id = '" . $open_ad_id . "',max_banner_ad_id = '" . $max_banner_ad_id . "', max_interstitial_ad_id = '" . $max_interstitial_ad_id . "', max_native_ad_id = '" . $max_native_ad_id . "', max_reward_ad_id = '" . $max_reward_ad_id . "', max_open_ad_id = '" . $max_open_ad_id . "', interstitial_show_count = '" . $interstitial_show_count . "', app_update_status = '" . $app_update_status . "', app_new_version = '" . $app_new_version . "', app_update_desc = '" . $app_update_desc . "', app_redirect_url = '" . $app_redirect_url . "', cancel_update_status = '" . $cancel_update_status . "', google_key = '".$google_key."', privacy_policy = '".$privacy_policy."', status = '".$status."' ";
		
        mysqli_query($con,$qry) or die ("can not insert in to app table.".mysqli_error());
		$mid = mysqli_insert_id();
		
        $response['status'] = 1;
        $response['msg'] = "New app added successfully.";

    } else {
        $qry = "UPDATE app SET app_name = '" . $app_name . "', package_name = '" . $package_name . "', youtube_keyword = '" . $youtube_keyword . "',  ad_network = '" . $ad_network . "', show_banner = '" . $show_banner . "',show_inter = '" . $show_inter . "',show_native = '" . $show_native . "',show_reward = '" . $show_reward . "',show_open_ads_admob = '" . $show_open_ads_admob . "', banner_ad_id = '" . $banner_ad_id . "', interstitial_ad_id = '" . $interstitial_ad_id . "', native_ad_id = '" . $native_ad_id . "', reward_ad_id = '" . $reward_ad_id . "', open_ad_id = '" . $open_ad_id . "',max_banner_ad_id = '" . $max_banner_ad_id . "', max_interstitial_ad_id = '" . $max_interstitial_ad_id . "', max_native_ad_id = '" . $max_native_ad_id . "', max_reward_ad_id = '" . $max_reward_ad_id . "', max_open_ad_id = '" . $max_open_ad_id . "', interstitial_show_count = '" . $interstitial_show_count . "', app_update_status = '" . $app_update_status . "', app_new_version = '" . $app_new_version . "', app_update_desc = '" . $app_update_desc . "', app_redirect_url = '" . $app_redirect_url . "', cancel_update_status = '" . $cancel_update_status . "', google_key = '".$google_key."', privacy_policy = '".$privacy_policy."', status = '".$status."' where id='" . $_REQUEST['aid'] . "'";		
        
        
        mysqli_query($con,$qry) or die ("can not update in to app table.".mysqli_error());		
		$mid = $_REQUEST['aid'];
        $response['status'] = 1;
        $response['msg'] = "App updated successfully.";
    }
    $response['urlfilename'] = ROOT_SITE_URL . "admin/applist.php";
}
echo json_encode($response);
exit;
?>