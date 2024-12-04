<?php

include("../includes/connection.php");
include("../includes/functions.php");

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
$action = setGPC($_REQUEST["myaction"], "");
if ($action == "changepass") {
    $qryd = "SELECT password from admin where password='" . $_REQUEST["currentpass"] . "'";
    $resd = mysqli_query($con,$qryd);
    if (mysqli_num_rows($resd) <= 0) {
        $msg = "Current Password Not Matched.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else if ($_REQUEST["newpass"] == "") {
        $msg = "Please Enter New Password.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else if (strlen($_REQUEST["newpass"]) <= 5) {
        $msg = "Please enter at least 5 characters.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else if ($_REQUEST["newpass_confirm"] == "") {
        $msg = "Please Enter New Password.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else if ($_REQUEST["newpass_confirm"] != $_REQUEST["newpass"]) {
        $msg = "Please enter the same value again.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else {
        $qry = "update admin SET password='" . $_REQUEST["newpass"] . "' where id='1'";
        mysqli_query($con,$qry);
        $response['status'] = 1;
        $response['msg'] = "Password updated successfully.";
        $response['urlfilename'] = ROOT_SITE_URL . "admin/changepassUp.php";
    }
    echo json_encode($response);
    exit;
}

if ($action == "changesetting") {
//    print_r($_REQUEST);
//    exit;
    if ($_REQUEST["email"] == "") {
        $msg = "Please enter email address.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else if ($_REQUEST["femail"] == "") {
        $msg = "Please enter from email address.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else if ($_REQUEST["fname"] == "") {
        $msg = "Please enter from name.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else if ($_REQUEST["Search_Limit_Radius"] == "") {
        $msg = "Please enter search radius.";
        $response['status'] = 0;
        $response['html'] = $msg;
    } else {

         $qry = "update settings SET Email='" . $_REQUEST["email"] . "',From_Email='" . $_REQUEST["femail"] . "',From_Name='" . $_REQUEST["fname"] . "',Search_Limit_Radius='" . $_REQUEST["Search_Limit_Radius"] . "' where id='1'"; //,win_sound='" . $win_sound . "',loose_sound='" . $loose_sound . "',spin_sound='" . $spin_sound . "',immortal_player_sound='" . $immortal_player_sound . "'
        mysqli_query($con,$qry);
        $response['status'] = 1;
        $response['msg'] = "Settings updated successfully.";
        $response['urlfilename'] = ROOT_SITE_URL . "admin/changepass.php";
    }
    echo json_encode($response);
    exit;
}
if ($action == "sendmail") {
    if (isset($_REQUEST['email']) && !empty($_REQUEST['email'])) {
        $qry = "select *from user where email='" . $_REQUEST['email'] . "' ";
        $rs = mysqli_query($con,$qry);
        $rscnt = mysqli_num_rows($rs);
        $rslt = mysqli_fetch_assoc($rs);
        if ($rscnt > 0) {
            $logo = str_replace("#SITELOGO#", '<img src="' . ROOT_SITE_URL . 'images/fantasy-logo.png"/>', $_REQUEST['editor2']);
            $name = str_replace("#NAME#", $rslt['username'], $logo);
            $email = str_replace("#EMAIL#", $rslt['email'], $name);
            $phone = str_replace("#PHONE#", $rslt['phoneno'], $email);
            $fb = str_replace("#FACEBOOK#", $rslt['facebook_id'], $phone);
            $twt = str_replace("#TWITTER#", $rslt['twitter_id'], $fb);
            $inst = str_replace("#INSTAGRAM#", $rslt['instagram_id'], $twt);

            $to = $rslt['email'];
            $subject = "Thank you for your registration.";
            $message = '<html><body>';
            $message.=$inst;
            $message .='</body></html>';
            $headers = "From: " . $FROM_NAME . " <" . $FROM_EMAIL . ">" . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $sent = @mail($to, $subject, $message, $headers);
            $response['status'] = 1;
            $response['html'] = "Mail sent successfully.";
        } else {
            $response['status'] = 0;
            $response['html'] = "This email address not available.";
        }
    } else {
        exit;
        $qry = "select *from user";
        $rs = mysqli_query($con,$qry);
        $rscnt = mysqli_num_rows($rs);
        if ($rscnt > 0) {
            while ($rslt = mysqli_fetch_assoc($rs)) {
                $logo = str_replace("#SITELOGO#", '<img src="' . ROOT_SITE_URL . 'images/fantasy-logo.png"/>', $_REQUEST['editor2']);
                $name = str_replace("#NAME#", $rslt['username'], $logo);
                $email = str_replace("#EMAIL#", $rslt['email'], $name);
                $phone = str_replace("#PHONE#", $rslt['phoneno'], $email);
                $fb = str_replace("#FACEBOOK#", $rslt['facebook_id'], $phone);
                $twt = str_replace("#TWITTER#", $rslt['twitter_id'], $fb);
                $inst = str_replace("#INSTAGRAM#", $rslt['instagram_id'], $twt);

                $to = $rslt['email'];
                $subject = "Thank you for your registration.";
                $message = '<html><body>';
                $message.=$inst;
                $message .='</body></html>';
                $headers = "From: " . $FROM_NAME . " <" . $FROM_EMAIL . ">" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $sent = @mail($to, $subject, $message, $headers);
            }
            $response['status'] = 1;
            $response['html'] = "Mail sent successfully.";
        } else {
            $response['status'] = 0;
            $response['html'] = "Any user not available.";
        }
    }
    $response['urlfilename'] = ROOT_SITE_URL . "admin/sendmail.php";
    echo json_encode($response);
}
?>
