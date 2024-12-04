<?php include '../includes/connection.php'; ?>
<?php
if (empty($_SESSION["Logged_Admin_Name"])) {
    header("Location:" . ROOT_SITE_URL . "admin");
}
$qry = "select *from settings";
$rs = mysqli_query($con,$qry);
$rslt = mysqli_fetch_assoc($rs);
?>
<?php include '../includes/admintop.php'; ?>
<?php include '../includes/adminheader.php'; ?>
<?php
$PageTitle = "Change Password";
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
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="dashboard.php">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="changepass.php"><?php echo $PageTitle; ?></a>
                    </li>
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
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">Change Password</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <?php
                                            if (isset($_REQUEST['tab']) && !empty($_REQUEST['tab'])) {
                                                $tab = $_REQUEST['tab'];
                                            } else {
                                                $tab = "";
                                            }
                                            ?>
<!--                                            <li class="<?php echo ($tab == 2) ? "active" : ""; ?>">
                                                <a href="#tab_1_2" data-toggle="tab">Settings</a>
                                            </li>-->
                                            <li class="<?php echo ($tab == 1 || empty($tab)) ? "active" : ""; ?>">
                                                <a href="#tab_1_1" data-toggle="tab">Change Password</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
<!--                                            <div class="tab-pane <?php echo ($tab == 2 || empty($tab)) ? "active" : ""; ?>" id="tab_1_2">
                                                <form role="form" action="#" id="changesetting" method='POST' class="form-horizontal">
                                                    <div class="alert alert-danger display-hide">
                                                        <button class="close" data-close="alert"></button>
                                                        You have some form errors. Please check below.
                                                    </div>
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
                                                        <label class="control-label">Referral Salary</label>
                                                        <input type="text" name="fi_salary_referrals" id="fi_salary_referrals" value="<?php echo $rslt['fi_salary_referrals']; ?>" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Challenge countdown</h5>
                                                        <input type="text" name="invite_countdown" id="invite_countdown" value="<?php echo $rslt['invite_countdown']; ?>" class="form-control"/>
                                                        <?php $msi = explode(":", $rslt["invite_countdown"]); ?>
                                                        <div class="col-md-4 ">
                                                            <label class="control-label smallFont">
                                                                Minute<span class="required">
                                                                    * </span>
                                                            </label>
                                                            <input name="invite_countdown_minute" id='invite_countdown_minute' max="59" type="text" value='<?php echo isset($msi[0]) ? $msi[0] : ""; ?>' class="form-control"/>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label class="control-label smallFont">Second <span class="required">
                                                                    * </span>
                                                            </label>
                                                            <input name="invite_countdown_second" id='invite_countdown_second' max="59" type="text" value='<?php echo isset($msi[1]) ? $msi[1] : ""; ?>' class="form-control"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Draft Room Countdown</h5>
                                                        <input type="text" name="draft_countdown" id="draft_countdown" value="<?php echo $rslt['draft_countdown']; ?>" class="form-control"/>
                                                        <?php $msd = explode(":", $rslt["draft_countdown"]); ?>

                                                        <div class="col-md-4">
                                                            <label class="control-label smallFont">
                                                                Minute<span class="required">
                                                                    * </span>
                                                            </label>
                                                            <input name="draft_countdown_minute" id='draft_countdown_minute' max="59" type="text" value='<?php echo isset($msd[0]) ? $msd[0] : ""; ?>' class="form-control"/>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label smallFont">Second <span class="required">
                                                                    * </span>
                                                            </label>
                                                            <input name="draft_countdown_second" id='draft_countdown_second' max="59" type="text" value='<?php echo isset($msd[1]) ? $msd[1] : ""; ?>' class="form-control"/>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <h5>Tier challenge countdown</h5>
                                                        <input type="text" value="<?php echo $rslt["king_of_tier_time"]; ?>" name="king_of_tier_time" id="king_of_tier_time" value="" class="form-control"/>
                                                        <?php $hm = explode(":", $rslt["king_of_tier_time"]); ?>


                                                        <div class="col-md-4">
                                                            <label class="control-label col-md-3 smallFont">
                                                                Hours<span class="required">
                                                                    * </span>
                                                            </label>
                                                            <input name="win_king_tier_hour" id='win_king_tier_hour' maxLength="2" type="text" value='<?php echo isset($hm[0]) ? $hm[0] : ""; ?>' class="form-control"/>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="control-label col-md-3 smallFont">Minute <span class="required">
                                                                    * </span>
                                                            </label>
                                                            <input name="win_king_tier_minute" id='win_king_tier_minute' max="59" type="text" value='<?php echo isset($hm[1]) ? $hm[1] : ""; ?>' class="form-control"/>
                                                        </div>
                                                    </div>
                                                                                                        <div class="form-group sound_class">
                                                                                                            <label class="control-label">Winner Sound</label>
                                                    <?php if (isset($rslt["win_sound"]) && !empty($rslt["win_sound"])) { ?>
                                                                                                                        <audio controls>
                                                                                                                            <source src="<?php echo WHEEL_WIN_SOUND_ROOT . $rslt["win_sound"]; ?>" type="audio/ogg">
                                                                                                                            <source src="<?php echo WHEEL_WIN_SOUND_ROOT . $rslt["win_sound"]; ?>" type="audio/mpeg">
                                                                                                                        </audio> 
                                                    <?php } ?>
                                                                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                                <input type="hidden" readonly="readonly" name="oldwin_sound" id="oldwin_sound" value="<?php echo $rslt["win_sound"]; ?>"/>
                                                                                                                <span class="btn default btn-file">
                                                                                                                    <span class="fileinput-new">
                                                                                                                        Select file </span>
                                                                                                                    <span class="fileinput-exists">
                                                                                                                        Change </span>
                                                                                                                    <input type="file" name="win_sound" id="win_sound">
                                                                                                                </span>
                                                                                                                <span class="fileinput-filename">
                                                                                                                </span>
                                                                                                                &nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput">
                                                                                                                </a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group sound_class">
                                                                                                            <label class="control-label">Loser Sound</label>
                                                                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <?php if (isset($rslt["loose_sound"]) && !empty($rslt["loose_sound"])) { ?>
                                                                                                                            <audio controls>
                                                                                                                                <source src="<?php echo WHEEL_LOOSE_SOUND_ROOT . $rslt["loose_sound"]; ?>" type="audio/ogg">
                                                                                                                                <source src="<?php echo WHEEL_LOOSE_SOUND_ROOT . $rslt["loose_sound"]; ?>" type="audio/mpeg">
                                                                                                                            </audio> 
                                                    <?php } ?>
                                                                                                                <input type="hidden" readonly="readonly" name="oldloose_sound" id="oldloose_sound" value="<?php echo $rslt["loose_sound"]; ?>"/>
                                                                                                                <span class="btn default btn-file">
                                                                                                                    <span class="fileinput-new">
                                                                                                                        Select file </span>
                                                                                                                    <span class="fileinput-exists">
                                                                                                                        Change </span>
                                                                                                                    <input type="file" name="loose_sound" id="loose_sound">
                                                                                                                </span>
                                                                                                                <span class="fileinput-filename">
                                                                                                                </span>
                                                                                                                &nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput">
                                                                                                                </a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group sound_class">
                                                                                                            <label class="control-label">Wheel Spin Sound</label>
                                                                                                            <div class="col-md-3">
                                                    <?php if (isset($rslt["spin_sound"]) && !empty($rslt["spin_sound"])) { ?>
                                                                                                                        <audio controls>
                                                                                                                            <source src="<?php echo WHEEL_SPIN_SOUND_ROOT . $rslt["spin_sound"]; ?>" type="audio/ogg">
                                                                                                                            <source src="<?php echo WHEEL_SPIN_SOUND_ROOT . $rslt["spin_sound"]; ?>" type="audio/mpeg">
                                                                                                                        </audio> 
                                                    <?php } ?>
                                                                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                                <input type="hidden" readonly="readonly" name="oldspin_sound" id="oldspin_sound" value="<?php echo $rslt["spin_sound"]; ?>"/>
                                                                                                                <span class="btn default btn-file">
                                                                                                                    <span class="fileinput-new">
                                                                                                                        Select file </span>
                                                                                                                    <span class="fileinput-exists">
                                                                                                                        Change </span>
                                                                                                                    <input type="file" name="spin_sound" id="spin_sound">
                                                                                                                </span>
                                                                                                                <span class="fileinput-filename">
                                                                                                                </span>
                                                                                                                &nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput">
                                                                                                                </a>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group sound_class">
                                                                                                            <label class="control-label">Immortal Player Sound</label>
                                                                                                            <div class="col-md-3">
                                                    <?php if (isset($rslt["immortal_player_sound"]) && !empty($rslt["immortal_player_sound"])) { ?>
                                                                                                                        <audio controls>
                                                                                                                            <source src="<?php echo WHEEL_IPLAYER_SOUND_ROOT . $rslt["immortal_player_sound"]; ?>" type="audio/ogg">
                                                                                                                            <source src="<?php echo WHEEL_IPLAYER_SOUND_ROOT . $rslt["immortal_player_sound"]; ?>" type="audio/mpeg">
                                                                                                                        </audio> 
                                                    <?php } ?>
                                                                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                                <input type="hidden" readonly="readonly" name="oldimmortal_player_sound" id="oldimmortal_player_sound" value="<?php echo $rslt["immortal_player_sound"]; ?>"/>
                                                                                                                <span class="btn default btn-file">
                                                                                                                    <span class="fileinput-new">
                                                                                                                        Select file </span>
                                                                                                                    <span class="fileinput-exists">
                                                                                                                        Change </span>
                                                                                                                    <input type="file" name="immortal_player_sound" id="immortal_player_sound">
                                                                                                                </span>
                                                                                                                <span class="fileinput-filename">
                                                                                                                </span>
                                                                                                                &nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput">
                                                                                                                </a>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                        </div>
                                                    <div class="margin-top-10 form-group">
                                                        <input type="hidden" name="tab" id="tab" value="2"/>
                                                        <input type="hidden" name="myaction" value="changesetting"/>
                                                        <input type="submit" class="btn green-haze" value="Change Setting"  name="Submit"/>
                                                        <input type="button" onclick="window.location = 'dashboard.php'" class="btn default" name="cancel" value="Cancel" />
                                                    </div>

                                                </form>
                                            </div>-->
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane <?php echo ($tab == 1 || empty($tab)) ? "active" : ""; ?>" id="tab_1_1">
                                                <form role="form" action="#" id="changepass" method='POST' class="form-horizontal">
                                                    <div class="alert alert-danger display-hide">
                                                        <button class="close" data-close="alert"></button>
                                                        You have some form errors. Please check below.
                                                    </div>
                                                    <div class="alert alert-success display-hide">
                                                        <button class="close" data-close="alert"></button>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Current Password<span class="required" aria-required="true">
                                                                * </span></label>
                                                        <input type="password" name="currentpass" id="currentpass" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">New Password<span class="required" aria-required="true">
                                                                * </span></label>
                                                        <input type="password" name="newpass" id="newpass" class="form-control"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Re-type New Password<span class="required" aria-required="true">
                                                                * </span></label>
                                                        <input type="password" name="newpass_confirm" id="newpass_confirm" class="form-control"/>
                                                    </div>
                                                    <div class="margin-top-10 form-group">
                                                        <input type="hidden" name="myaction" value="changepass"/>
                                                        <input type="hidden" name="tab" id="tab" value="1"/>
                                                        <input type="submit" class="btn green-haze" value="Change Password"  name="Submit"/>
                                                        <input type="button" onclick="window.location = 'dashboard.php'" class="btn default" name="cancel" value="Cancel" />
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->

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
<?
include('../includes/adminbottom.php');
?>