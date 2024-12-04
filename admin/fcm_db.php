<?php
include("../includes/connection.php");
include("../includes/functions.php");


$action = setGPC($_REQUEST["myaction"], "");
if ($action == "delete") {
    if (isset($_POST["users_id"]) && is_array($_POST["users_id"]) && count($_POST["users_id"]) > 0) {
        #START CODE DELETE FROM userss table
        $qry = "DELETE FROM fcm_key WHERE id IN (" . implode(",", $_POST["users_id"]) . ")";
        mysqli_query($con,$qry);
        #END CODE DELETE FROM userss table

        $_SESSION['success_message'] = "link deleted successfully";
        header("Location: fcmlist.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Error while deleting link please try again.";
        header("Location: fcmlist.php");
        exit;
    }
}




$myTxtFlds = array("fcm_key","topic_name","app_id");
$myNumFlds = array();
//print_r($_REQUEST);
//exit;


$fcm_key = setGPC($_REQUEST["fcm_key"], "");
$topic_name = setGPC($_REQUEST["topic_name"], "");
$app_id = setGPC($_REQUEST["app_id"], "");
   




/* End Code for send mail to ConstantContact */
if ($action == "edit")
    $qryd = "SELECT fcm_key from fcm_key where fcm_key='" . $fcm_key . "' AND id!='" . $_REQUEST['aid'] . "' ";
else
    $qryd = "SELECT fcm_key from fcm_key where fcm_key='" . $fcm_key . "'";
$resd = mysqli_query($con,$qryd);
if (mysqli_num_rows($resd) > 0 && !empty($_REQUEST["email"])) {
    $msg = "FCM key is already exist.";
    $response['status'] = 0;
    $response['html'] = $msg;
}
else { 	
    if ($action == 'add') {		
        $qry = "INSERT INTO fcm_key SET fcm_key = '".$fcm_key."',topic_name= '" . $topic_name . "', app_id = '".$app_id."'";		
        mysqli_query($con,$qry) or die ("can not insert in to link table.".mysqli_error());
		$mid = mysqli_insert_id();
	
        $response['status'] = 1;
        $response['msg'] = "New key added successfully.";

    } else {
       
       $qry = "UPDATE fcm_key SET fcm_key = '".$fcm_key."',topic_name= '" . $topic_name . "', app_id = '".$app_id."' where id='" . $_REQUEST['aid'] . "'";
 		
        mysqli_query($con,$qry) or die ("can not update in to link table.".mysqli_error());		
		$mid = $_REQUEST['aid'];
        $response['status'] = 1;
        $response['msg'] = "Key updated successfully.";
    }
    $response['urlfilename'] = ROOT_SITE_URL . "admin/fcmlist.php";
}
echo json_encode($response);
exit;


?>