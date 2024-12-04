<?php
include("../includes/connection.php");
include("../includes/functions.php");


$action = setGPC($_REQUEST["myaction"], "");
if ($action == "delete") {
    if (isset($_POST["users_id"]) && is_array($_POST["users_id"]) && count($_POST["users_id"]) > 0) {
        #START CODE DELETE FROM userss table
        $qry = "DELETE FROM coin_link WHERE id IN (" . implode(",", $_POST["users_id"]) . ")";
        mysqli_query($con,$qry);
        #END CODE DELETE FROM userss table

        $_SESSION['success_message'] = "link deleted successfully";
        header("Location: coinlist.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Error while deleting link please try again.";
        header("Location: coinlist.php");
        exit;
    }
}

$myTxtFlds = array("link_title","link_desc","link_source");
$myNumFlds = array();
//print_r($_REQUEST);
//exit;


$link_title = setGPC($_REQUEST["link_title"], "");
$link_desc = setGPC($_REQUEST["link_desc"], "");
$link_source = setGPC($_REQUEST["link_source"], "");
$reward_type = setGPC($_REQUEST["reward_type"], "");


$users = rand(0,25);

/* End Code for send mail to ConstantContact */
if ($action == "edit")
    $qryd = "SELECT link_desc from coin_link where link_desc='" . $link_desc . "' AND id!='" . $_REQUEST['aid'] . "' ";
else
    $qryd = "SELECT link_desc from coin_link where link_desc='" . $login_username . "'";
$resd = mysqli_query($con,$qryd);
if (mysqli_num_rows($resd) > 0 && !empty($_REQUEST["email"])) {
    $msg = "Link is already exist.";
    $response['status'] = 0;
    $response['html'] = $msg;
}
else { 	
    if ($action == 'add') {		
        $qry = "INSERT INTO coin_link SET link_title = '".$link_title."',link_desc= '" . $link_desc . "', link_source = '".$link_source."', user_id = '" .$users. "', reward_type = '" .$reward_type. "'";		
        mysqli_query($con,$qry) or die ("can not insert in to link table.".mysqli_error());
		$mid = mysqli_insert_id();
	
        $response['status'] = 1;
        $response['msg'] = "New link added successfully.";

    } else {
       
       $qry = "UPDATE coin_link SET link_title = '".$link_title."',link_desc= '" . $link_desc . "', link_source = '".$link_source."', reward_type = '".$reward_type."' where id='" . $_REQUEST['aid'] . "'";
 		
        mysqli_query($con,$qry) or die ("can not update in to link table.".mysqli_error());		
		$mid = $_REQUEST['aid'];
        $response['status'] = 1;
        $response['msg'] = "LInk updated successfully.";
    }
    $response['urlfilename'] = ROOT_SITE_URL . "admin/coinlist.php";
}
echo json_encode($response);
exit;
?>