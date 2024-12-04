<?php include '../includes/connection.php'; ?>
<?php
if (empty($_SESSION["Logged_Admin_Name"])) {
    header("Location:" . ROOT_SITE_URL . "admin");
}
$PageTitle = "Manage App";
?>
<?php include '../includes/admintop.php'; ?>
<?php include '../includes/adminheader.php'; ?>
<script language="javascript">
    function sort(a, b)
    {
        document.frm1.aid.value = "";
        document.frm1.sorton.value = a;
        document.frm1.sort.value = b;
        document.frm1.action = "applist.php";
        document.frm1.submit();
    }
    function setAction(action, aid)
    {
        if (action == "delete")
        {

            document.frm1.aid.value = "";
            document.frm1.myaction.value = action;
            document.frm1.action = "app_db.php";
            mycount = 0;
            for (i = 0; i < document.frm1.elements.length; i++)
            {
                if (document.frm1.elements[i].name == "users_id[]" && document.frm1.elements[i].checked)
                    mycount++;
            }
            if (mycount == 0)
            {
                alert("You must check one of the checkboxes.");
                return false;
            }
            if (!confirm("Are you sure you want to " + action + " selected app(s)?"))
                return false;


//            alert(action);
//            return false;


            document.frm1.submit();
        }
        else if (action == "edit")
        {
            document.frm1.action = "app.php";
            document.frm1.myaction.value = action;
            document.frm1.aid.value = aid;
            document.frm1.submit();
        }
        else if (action == "status")
        {
            document.frm1.action = "app_db.php";
            document.frm1.myaction.value = action;
            document.frm1.aid.value = "";
            document.frm1.submit();
        }

        else
        {
            document.frm1.action = "app.php";
            document.frm1.myaction.value = action;
            document.frm1.aid.value = "";
            document.frm1.submit();
        }
    }
</script>
<!-- BEGIN CONTAINER -->
<div class="page-container">
  <?php include'../includes/adminleft.php'; ?>
  <!-- BEGIN CONTENT -->
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">
      <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
      <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body"> Widget settings form goes here </div>
            <div class="modal-footer">
              <button type="button" class="btn blue">Save changes</button>
              <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title"> <?php echo $PageTitle; ?><small></small> </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li> <i class="fa fa-home"></i> <a href="dashboard.php">Home</a> <i class="fa fa-angle-right"></i> </li>
          <li><?php echo $PageTitle; ?></li>
        </ul>
      </div>
      <!-- END PAGE HEADER-->

      <div class="row">
        <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet box grey-cascade">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-globe"></i><?php echo $PageTitle; ?> </div>
            </div>            
            <div class="portlet-body">
              <?php
				if (isset($_REQUEST['global_search_button']) && $_REQUEST['global_search_button'] != '') 
				{
					$search_text = $_REQUEST['global_search'];

					if ($search_text != '')
						$search_query1 = "WHERE app_name LIKE '%" . $search_text . "%' OR package_name LIKE '%" . $search_text . "%'";
					else
						$search_query1 = "WHERE 1";

					$where_con = $search_query1;
				}
				$qry = "select * from app " . $where_con . " order by app_name asc";                
				$rs = mysqli_query($con,$qry);
				$cnt = mysqli_num_rows($rs);
				if ($cnt > 0) {
					$paginationCount = getPagination($cnt);
				}
				$pagination = pagination($pageId, $cnt);
				?>
              <div class="table-toolbar">
                <div class="row">
                  <div class="col-md-6">
                    <?php if ($cnt > 0) { ?>
                    <div class="btn-group">
                      <button type="button" id="sample_editable_1_new" class="btn red" onclick="setAction('delete');"> Delete <i class="fa fa-minus"></i> </button>
                    </div>
                    <?php } ?>
                    <div class="btn-group">
                      <button type="button" id="sample_editable_1_new" class="btn green" onclick="setAction('add');" > Add New <i class="fa fa-plus"></i> </button>
                    </div>
                  </div>
                  <div class="col-md-6"> </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6"> </div>
                <div class="col-md-6" style="float: left; margin-left: 471px;">
               <!--   <form name="frm2" method="post" action="predefined_messages_list.php">
                    <input type="text" class="form-control  input-small input-inline" name="global_search" id="global_search" placeholder='Search message' value="<?php echo $search_text; ?>" style="float:left;clear:both;"/>
                    <input type="submit" data-loading-text="Loading..." class="demo-loading-btn btn btn-primary" name="global_search_button" id="global_search_button" value="Search">
                  </form> -->
                </div>
              </div>
              <form name="frm1" method="post" action="predefined_messages.php">
                <?php
				$sub_qry = "select * from app " . $where_con . " order by app_name asc";
				$sub_rs = mysqli_query($con,$sub_qry);
				$sub_cnt = mysqli_num_rows($sub_rs);
				if ($sub_cnt > 0) 
				{
				?>
                <div id="pageData">
                    


                  <table class="table table-striped table-bordered table-hover" id="UsersTable">
                    <thead>
                         
                      <tr>
                        <th width="5%" class="table-checkbox"><input name="CheckAll_users_id" class="group-checkable" data-set="#UsersTable .checkboxes" type="checkbox" id="CheckAll_users_id" >
                        </th>
                        <th width="30%"> App Name </th>
                        <th width="25%"> Package Name </th>
                        <th width="30%"> Advt Type </th>
                        <th width="10%"> Date</th>
                      </tr>
  

                      
                    </thead>
                    <tbody>
                      <?php while ($rslt = mysqli_fetch_assoc($sub_rs)) { ?>
                      <tr class="odd gradeX">
                        <td><input type="checkbox" class="checkboxes" name="users_id[]" value="<?php echo $rslt['id']; ?>">
                        </td>
                        <td><a href="javascript:setAction('edit','<?php echo $rslt["id"] ?>');"> <?php echo $rslt['app_name']; ?></a></td>
                        <td><?php echo $rslt['package_name']; ?></td>
                        <td><?php echo $rslt['ad_network']; ?></td>
                        <td><?php echo date("Y-m-d",strtotime($rslt['created_at'])); ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <?php //echo $pagination; ?> </div>
                <?php
                                } else {
                                    echo "No Records Found.";
                                }
                                ?>
                <input name="aid" type="hidden" id="aid">
                <input type="hidden" name="myaction">
              </form>
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
        </div>
      </div>
      <!-- END PAGE CONTENT-->
    </div>
  </div>
  <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include '../includes/adminbottom.php'; ?>
