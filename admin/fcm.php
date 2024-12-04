<?php include '../includes/connection.php'; ?>
<?php
    if (empty($_SESSION["Logged_Admin_Name"])) {
        header("Location:" . ROOT_SITE_URL . "admin");
    }
?>
<?php include '../includes/admintop.php'; ?>
<?php include '../includes/adminheader.php'; ?>
<?php
$PageTitle = "Add FCM Key";

$myaction = isset($_REQUEST["myaction"]) ? strtolower(trim($_REQUEST["myaction"])) : "";
$aid = isset($_REQUEST["aid"]) ? intval($_REQUEST["aid"]) : 0;

$err = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$errfld = isset($_REQUEST["errfld"]) ? $_REQUEST["errfld"] : "";

if ($myaction == "edit")
    $PageTitle = "Update FCM Key";

if ($myaction == "edit" && $aid == 0) {
    header("Location: fcmlist.php");
    exit;
}

$myTxtFlds = Array("fcm_key","topic_name","app_id");
$myNumFlds = Array();

//$myVals=array();
$myVals['status'] = 1;
if (strlen($err) > 0 && $err != "none") {
    $myVals = populateFields("GPC", $myTxtFlds, "");    
    $sub_result_rec=array();
} elseif ($myaction == "edit") {
    $qry = "SELECT * FROM fcm_key WHERE id=$aid";
    $result = mysqli_query($con,$qry) or die("can not select ec");

    if (!($arow = mysqli_fetch_array($result))) {
        header("Location: error.php");
        exit;
    }

    $myVals = populateFields("DB", $myTxtFlds, $myNumFlds, $arow);
    $myVals['id'] = $arow['id'];

    mysqli_free_result($result);
}

?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php include'../includes/adminleft.php'; ?>
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <h3 class="page-title"> <?php echo $PageTitle; ?> <small></small> </h3>
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li> <i class="fa fa-home"></i> <a href="dashboard.php">Home</a> <i class="fa fa-angle-right"></i> </li>
                        <li><?php echo $PageTitle; ?></li>
                    </ul>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN VALIDATION STATES-->
                        <div class="portlet box purple">
                            <div class="portlet-title">
                                <div class="caption"> <i class="fa fa-gift"></i>
                                    <?php echo $PageTitle; ?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="#" id="fcm" method='POST' class="form-horizontal">
                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide">
                                            <button class="close" data-close="alert"></button>
                                            You have some form errors. Please check below. </div>
                                        <div class="alert alert-success display-hide">
                                            <button class="close" data-close="alert"></button>
                                            New users added successfully. </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">App ID</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="app_id" id='app_id' value="<?php echo $myVals["app_id"]; ?>">
                                                
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3">Topic Name</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="topic_name" id='topic_name' value="<?php echo $myVals["topic_name"]; ?>">
                                                
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label class="control-label col-md-3">FCM Keys</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" cols="80" rows="30" name="fcm_key" id='fcm_key'><?php echo $myVals["fcm_key"]; ?></textarea>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Submit</button>
                                                <button type="button" class="btn default" onclick="window.location = 'fcmlist.php'">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="myaction" id="myaction" value="<?php echo $myaction; ?>">
                                    <input type="hidden" name="aid" value="<?php echo $aid; ?>">
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                        <!-- END VALIDATION STATES-->
                    </div>
                </div>
                <!-- END PAGE CONTENT-->
            </div>
        </div>
        <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php
include('../includes/adminbottom.php');
?>