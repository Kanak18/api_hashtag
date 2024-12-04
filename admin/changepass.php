<?php include '../includes/connection.php'; ?>
<?php
if (empty($_SESSION["Logged_Admin_Name"])) {
    header("Location:" . ROOT_SITE_URL . "admin");
}
$qry = "select * from settings";
$rs = mysql_query($qry);
$rslt = mysql_fetch_assoc($rs);
?>
<?php include '../includes/admintop.php'; ?>
<?php include '../includes/adminheader.php'; ?>
<?php
$PageTitle = "General Settings";
?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
  <?php include'../includes/adminleft.php'; ?>
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">
      <!-- BEGIN PAGE HEADER-->
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li> <i class="fa fa-home"></i> <a href="dashboard.php">Home</a> <i class="fa fa-angle-right"></i> </li>
          <li> <a href="changepass.php"><?php echo $PageTitle; ?></a> </li>
        </ul>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->
      <div class="row margin-top-20">
        <div class="col-md-12">
          <!-- BEGIN PROFILE CONTENT -->
          <div class="profile-content">
            <div class="row">
              <div class="col-md-12">
                <div class="portlet light">
                  <div class="portlet-title tabbable-line">
                    <div class="caption caption-md"> <i class="icon-globe theme-font hide"></i> <span class="caption-subject font-blue-madison bold uppercase">General Settings</span> </div>
                    <ul class="nav nav-tabs">
                      <?php
						if (isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])) {
							$tab = $_REQUEST['tab'];
						} else {
							$tab = "";
						}
						?>
                      <li class="<?php echo ($tab == 2 || empty($tab)) ? "active" : ""; ?>"> <a href="#tab_1_2" data-toggle="tab">Settings</a> </li>
                    </ul>
                  </div>
                  <div class="portlet-body">
                    <div class="tab-content">
                      <!-- PERSONAL INFO TAB -->
                      <div class="tab-pane <?php echo ($tab == 2 || empty($tab)) ? "active" : ""; ?>" id="tab_1_2">
                        <form role="form" action="#" id="changesetting" method='POST' class="form-horizontal">
                          <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below. </div>
                          <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" name="email" id="email" value="<?php echo $rslt['Email']; ?>" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label">From Email</label>
                            <input type="text" name="femail" id="femail" value="<?php echo $rslt['From_Email']; ?>" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label">From Name</label>
                            <input type="text" name="fname" id="fname" value="<?php echo $rslt['From_Name']; ?>" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Radius Search Limit  [in Miles]</label>
                            <input type="text" name="Search_Limit_Radius" id="Search_Limit_Radius" value="<?php echo $rslt['Search_Limit_Radius']; ?>" class="form-control"/>
                          </div>
                          <div class="margin-top-10 form-group">
                            <input type="hidden" name="tab" id="tab" value="2"/>
                            <input type="hidden" name="myaction" value="changesetting"/>
                            <input type="submit" class="btn green-haze" value="Change Setting"  name="Submit"/>
                            <input type="button" onclick="window.location = 'dashboard.php'" class="btn default" name="cancel" value="Cancel" />
                          </div>
                        </form>
                      </div>                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END PROFILE CONTENT -->
        </div>
      </div>
      <!-- END PAGE CONTENT-->
    </div>
  </div>
  <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include('../includes/adminbottom.php');  ?>