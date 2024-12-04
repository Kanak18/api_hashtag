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


$myaction = isset($_REQUEST["myaction"]) ? strtolower(trim($_REQUEST["myaction"])) : "add";
$aid = isset($_REQUEST["aid"]) ? intval($_REQUEST["aid"]) : 0;

$err = isset($_REQUEST["err"]) ? strtolower(trim($_REQUEST["err"])) : "";
$errfld = isset($_REQUEST["errfld"]) ? $_REQUEST["errfld"] : "";

if ($myaction == "edit")
    $PageTitle = "Update App";

if ($myaction == "edit" && $aid == 0) {
    header("Location: applist.php");
    exit;
}



  
$myTxtFlds = Array("app_name","package_name","youtube_keyword", "ad_network","show_banner","show_inter","show_native","show_reward","show_open_ads_admob","banner_ad_id", "interstitial_ad_id","native_ad_id","reward_ad_id","open_ad_id","max_banner_ad_id","max_interstitial_ad_id","max_native_ad_id","max_reward_ad_id","max_open_ad_id","interstitial_show_count","app_update_status", "app_new_version","app_update_desc","app_redirect_url","cancel_update_status","google_key","privacy_policy","dynamic_banner_count","status");
$myNumFlds = Array();

//$myVals=array();
$myVals['status'] = 1;
if (strlen($err) > 0 && $err != "none") {
    $myVals = populateFields("GPC", $myTxtFlds, "");
    $myVals['users_id'] = $_REQUEST['users_id'];
    $sub_result_rec=array();
} elseif ($myaction == "edit") {
    $qry = "SELECT * FROM app WHERE id=$aid";
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
                                <form action="#" id="app" method='POST' class="form-horizontal">
                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide">
                                            <button class="close" data-close="alert"></button>
                                            You have some form errors. Please check below. </div>
                                        <div class="alert alert-success display-hide">
                                            <button class="close" data-close="alert"></button>
                                            New users added successfully. </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">App Name<strong style="color: red;">*</strong></label>
                                            <div class="col-md-4">
                                                <input type="text" name="app_name" id='app_name' value='<?php echo $myVals["app_name"]; ?>' class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Package Name<strong style="color: red;">*</strong></label>
                                            <div class="col-md-4">
                                                <input name="package_name" id='package_name' type="text" value='<?php echo $myVals["package_name"]; ?>' class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Youtube Keyword</label>
                                            <div class="col-md-4">
                                                <textarea name="youtube_keyword" id="youtube_keyword" class="form-control"><?php echo $myVals["youtube_keyword"]; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Advertise Type<strong style="color: red;">*</strong></label>
                                            <div class="col-md-4">
                                                <select name="ad_network" id="ad_network" class="form-control">
                                                    <option value="">-Select-</option>
                                                    <option value="admob" <?php if($myVals["ad_network"] == "admob") print "selected"; ?>>admob</option>
                                                    <option value="applovins" <?php if($myVals["ad_network"] == "applovins") print "selected"; ?>>applovins</option>
                                                </select>                                                
                                            </div>
                                        </div>
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Banner Id</label>
                                            <div class="col-md-4">
                                                <input name="banner_ad_id" id='banner_ad_id' type="text" value='<?php echo $myVals["banner_ad_id"]; ?>' class="form-control" />
                                            </div>																					

                                            <div class="col-md-4">
                                                <input name="max_banner_ad_id" id='max_banner_ad_id' type="text" value='<?php echo $myVals["max_banner_ad_id"]; ?>' class="form-control" />
                                            </div>
                                        </div>
										 <div class="form-group">
                                            <label class="control-label col-md-3">Interstitial Id</label>
                                            <div class="col-md-4">
                                                <input name="interstitial_ad_id" id='interstitial_ad_id' type="text" value='<?php echo $myVals["interstitial_ad_id"]; ?>' class="form-control" />
                                            </div>

                                            <div class="col-md-4">
                                                <input name="max_interstitial_ad_id" id='max_interstitial_ad_id' type="text" value='<?php echo $myVals["max_interstitial_ad_id"]; ?>' class="form-control" />
                                            </div>
											
                                        </div>
										
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Native Id</label>
                                            <div class="col-md-4">
                                                <input name="native_ad_id" id='native_ad_id' type="text" value='<?php echo $myVals["native_ad_id"]; ?>' class="form-control" />
                                            </div>

                                             <div class="col-md-4">
                                                <input name="max_native_ad_id" id='max_native_ad_id' type="text" value='<?php echo $myVals["max_native_ad_id"]; ?>' class="form-control" />
                                            </div>
											 
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Reward Id</label>
                                            <div class="col-md-4">
                                                <input name="reward_ad_id" id='reward_ad_id' type="text" value='<?php echo $myVals["reward_ad_id"]; ?>' class="form-control" />
                                            </div>

                                            <div class="col-md-4">
                                                <input name="max_reward_ad_id" id='max_reward_ad_id' type="text" value='<?php echo $myVals["max_reward_ad_id"]; ?>' class="form-control" />
                                            </div>
											
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Open Ad Id</label>
                                            <div class="col-md-4">
                                                <input name="open_ad_id" id='open_ad_id' type="text" value='<?php echo $myVals["open_ad_id"]; ?>' class="form-control" />
                                            </div>

                                            <div class="col-md-4">
                                                <input name="max_open_ad_id" id='max_open_ad_id' type="text" value='<?php echo $myVals["max_open_ad_id"]; ?>' class="form-control" />
                                            </div>
											
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Show Banner Ad</label>
                                            <div class="col-md-4" style="margin-top: 7px !important;">
                                                <input name="show_banner" id='show_banner' <?php if($myVals["show_banner"]==1) { echo ' checked'; } ?> type="checkbox" value='<?php echo $myVals["show_banner"]; ?>' class="form-control col-md-offset-3" />
                                            </div>
											
                                        </div>


                                       <div class="form-group">
                                            <label class="control-label col-md-3">Show Interstitial Ad</label>
                                            <div class="col-md-4" style="margin-top: 7px !important;">
                                                <input name="show_inter" id='show_inter' <?php if($myVals["show_inter"]==1) { echo ' checked'; } ?> type="checkbox" value='<?php echo $myVals["show_inter"]; ?>' class="form-control col-md-offset-3" />
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Show Native Ad</label>
                                            <div class="col-md-4" style="margin-top: 7px !important;">
                                                <input name="show_native" id='show_native' <?php if($myVals["show_native"]==1) { echo ' checked'; } ?> type="checkbox" value='<?php echo $myVals["show_native"]; ?>' class="form-control col-md-offset-3" />
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Show Reward Ad</label>
                                            <div class="col-md-4" style="margin-top: 7px !important;">
                                                <input name="show_reward" id='show_reward' <?php if($myVals["show_reward"]==1) { echo ' checked'; } ?> type="checkbox" value='<?php echo $myVals["show_reward"]; ?>' class="form-control col-md-offset-3" />
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">Show Open Ad</label>
                                            <div class="col-md-4" style="margin-top: 7px !important;">
                                                <input name="show_open_ads_admob" id='show_open_ads_admob' <?php if($myVals["show_open_ads_admob"]==1) { echo ' checked'; } ?> type="checkbox" value='<?php echo $myVals["show_open_ads_admob"]; ?>' class="form-control col-md-offset-3" />
                                            </div>
                                            
                                        </div>     


                                        <div class="form-group">
                                            <label class="control-label col-md-3">Interstitial Ads Show Counter</label>
                                            <div class="col-md-4" >
                                                <input name="interstitial_show_count" id='interstitial_show_count' type="text" value='<?php echo $myVals["interstitial_show_count"]; ?>' class="form-control" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">app_update_status</label>
                                            <div class="col-md-4" style="margin-top: 7px !important;">                    
                                                <input name="app_update_status" id='app_update_status' <?php if($myVals["app_update_status"]==1) { echo ' checked'; } ?> type="checkbox" value='<?php echo $myVals["app_update_status"]; ?>' class="form-control col-md-offset-3" />
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="control-label col-md-3">App New Version</label>
                                            <div class="col-md-4">
                                                <input name="app_new_version" id='app_new_version' type="text" value='<?php echo $myVals["app_new_version"]; ?>' class="form-control" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3">App Update Description</label>
                                            <div class="col-md-4">
                                                <input name="app_update_desc" id='app_update_desc' type="text" value='<?php echo $myVals["app_update_desc"]; ?>' class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">App Redirect URL</label>
                                            <div class="col-md-4">
                                                <input name="app_redirect_url" id='app_redirect_url' type="text" value='<?php echo $myVals["app_redirect_url"]; ?>' class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Cancel Update Status</label>
                                            <div class="col-md-4">
                                                <input name="cancel_update_status" id='cancel_update_status' type="text" value='<?php echo $myVals["cancel_update_status"]; ?>' class="form-control" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Google Developer Key</label>
                                            <div class="col-md-4">
                                                <input name="google_key" id='google_key' type="text" value='<?php echo $myVals["google_key"]; ?>' class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Privacy Policy URL</label>
                                            <div class="col-md-4">
                                                <input name="privacy_policy" id='privacy_policy' type="text" value='<?php echo $myVals["privacy_policy"]; ?>' class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Submit</button>
                                                <button type="button" class="btn default" onclick="window.location = 'applist.php'">Cancel</button>
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