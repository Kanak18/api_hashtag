<?php include '../includes/connection.php'; ?>
<?php


if (empty($_SESSION["Logged_Admin_Name"])) {
    header("Location:" . $SITE_URL . "admin");
}
?>
<?php include '../includes/admintop.php'; ?>
<?php include '../includes/adminheader.php'; ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <?php include'../includes/adminleft.php'; ?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
          
            <!-- /.modal -->
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Dashboard <small></small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include '../includes/adminbottom.php'; ?>