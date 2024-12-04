<?php
include("../includes/connection.php");
include("../includes/functions.php");

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');


$response = array();
if ($_POST["username"] == "" || strlen($_POST["username"]) == 0) {
    $response['status'] = 0;
    $response['html'] = "Please enter username";
} else {
    $qry = "SELECT * FROM admin WHERE username ='" . $_POST["username"] . "' AND password='" . $_POST["password"] . "'";
    $rs = mysqli_query($con,$qry) or die(mysqli_error() . $qry);
    if (mysqli_num_rows($rs) > 0) {
        $rw = mysqli_fetch_array($rs);
        $_SESSION["Logged_Master_Admin"] = "I Am A Master Admin";
        $_SESSION["Logged_Admin_Name"] = $rw["username"];

        if (isset($_POST['RememberMe']) and $_POST['RememberMe'] == "Yes") {
            setcookie("username", $_POST['username'], time() + 60 * 60 * 24 * 100, "/");
            setcookie("password", $_POST['password'], time() + 60 * 60 * 24 * 100, "/");
        } else {
            setcookie("user_name", "", time() + 60 * 60 * 24 * 100, "/");
            setcookie("password", "", time() + 60 * 60 * 24 * 100, "/");
        }
        $response['status'] = 1;
        $response['urlfilename']=$SITE_URL . "admin/dashboard.php";
    } else {
        $response['status'] = 0;
        $response['html'] = "Incorrect User ID or Password.";
    }
}
echo json_encode($response);
exit;
?>