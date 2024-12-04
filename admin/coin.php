<?php include '../includes/connection.php'; ?>
<?php
    if (empty($_SESSION["Logged_Admin_Name"])) {
        header("Location:" . ROOT_SITE_URL . "admin");
    }
?>
<?php include '../includes/admintop.php'; ?>
<?php include '../includes/adminheader.php'; ?>
<?php
$PageTitle = "Add App";

$myaction = isset($_REQUEST["myaction"]) ? strtolower(trim($_REQUEST["myaction"])) : "";
$aid = isset($_REQUEST["aid"]) ? intval($_REQUEST["aid"]) : 0;

$err = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$errfld = isset($_REQUEST["errfld"]) ? $_REQUEST["errfld"] : "";

if ($myaction == "edit")
    $PageTitle = "Update App";

if ($myaction == "edit" && $aid == 0) {
    header("Location: applist.php");
    exit;
}

$myTxtFlds = Array("link_title","link_desc","link_source","reward_type");
$myNumFlds = Array();

//$myVals=array();
$myVals['status'] = 1;
if (strlen($err) > 0 && $err != "none") {
    $myVals = populateFields("GPC", $myTxtFlds, "");
    $myVals['users_id'] = $_REQUEST['users_id'];
    $sub_result_rec=array();
} elseif ($myaction == "edit") {
    $qry = "SELECT * FROM coin_link WHERE id=$aid";
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
                                <form action="#" id="coinlink" method='POST' class="form-horizontal">
                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide">
                                            <button class="close" data-close="alert"></button>
                                            You have some form errors. Please check below. </div>
                                        <div class="alert alert-success display-hide">
                                            <button class="close" data-close="alert"></button>
                                            New users added successfully. </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Link Text</label>
                                            <div class="col-md-4">
                                                <input type="text" name="link_title" id='link_title' value='<?php echo $myVals["link_title"]; ?>' class="form-control" />
                                                <i>(e.g. Todays 1st Link For 2.8M Coins)</i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Link</label>
                                            <div class="col-md-4">
                                                <input name="link_desc" id='link_desc' type="text" value='<?php echo $myVals["link_desc"]; ?>' class="form-control" />
                                                <i>(e.g. https://static.moonactive.net/static/coinmaster/reward/reward2.html)</i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Link Description</label>
                                            <div class="col-md-4">
                                                <textarea name="link_source" id="link_source" class="form-control"><?php echo $myVals["link_source"]; ?></textarea>
                                                <i>(e.g. Wow!!! Received again Todays 1st Link For 2.8M Coins. you can also collect.)</i>
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="control-label col-md-3">Reward Type</label>
                                            <div class="col-md-4">
                                                 <select name="reward_type" id="reward_type" class="form-control">
                                                    <option value="">-Select-</option>
                                                    <option value="0" <?php if($myVals["reward_type"] == 0) print "selected"; ?>>Coin Master</option>
                                                    <option value="1" <?php if($myVals["reward_type"] == 1) print "selected"; ?>>8 Ball Pool</option>

                                                </select>
                                                <i>(e.g. Wow!!! Received again Todays 1st Link For 2.8M Coins. you can also collect.)</i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Submit</button>
                                                <button type="button" class="btn default" onclick="window.location = 'coinlist.php'">Cancel</button>
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