<?php include '../includes/connection.php'; 
include '../includes/functions.php';?>
<?php
if (empty($_SESSION["Logged_Admin_Name"])) {
    header("Location:" . ROOT_SITE_URL . "admin");
}
$qry = "select * from users order by username asc";
$rs = mysql_query($qry);
$cnt = mysql_num_rows($rs);
if($cnt > 0){
	 $paginationCount=getPagination($cnt);
}
$recordsPerPage = PAGE_PER_NO;

$page = (int) (!isset($_REQUEST['pageId']) ? 1 :$_REQUEST['pageId']);
$page = ($page == 0 ? 1 : $page);

$start = ($page-1) * $recordsPerPage;
$adjacents = "2";
 
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($cnt/$recordsPerPage);
$lpm1 = $lastpage - 1;   
$pagination = "";
$pagination = pagination($_REQUEST['pageId'],$cnt);

$query="select * from users order by username asc
limit $start,".$recordsPerPage;
$res=mysql_query($query);
$count=mysql_num_rows($res);
$HTML='';
if($count > 0){?>
	  <table class="table table-striped table-bordered table-hover" id="UsersTable">
                                        <thead>
                                            <tr>
                                                <th class="table-checkbox">
                                                    <input name="CheckAll_users_id"  class="group-checkable" data-set="#UsersTable .checkboxes" type="checkbox" id="CheckAll_users_id" >
                                                    <!--<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>-->
                                                </th>
                                                <th>
                                                    UserName
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Phone No
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($rslt = mysql_fetch_assoc($res)) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <input type="checkbox" class="checkboxes" name="users_id[]" value="<?php echo $rslt['users_id']; ?>">
                                                        <!--<input type="checkbox" class="checkboxes" value="<?php echo $rslt['users_id']; ?>"/>-->
                                                    </td>
                                                    <td>
                                                        <a href="javascript:setAction('edit','<?php echo $rslt["users_id"] ?>');">
                                                            <?php echo $rslt['username']; ?>
                                                        </a>
                                                    </td>
                                                    <td>

                                                        <?php echo $rslt['email']; ?>

                                                    </td>
                                                    <td>
                                                        <?php echo $rslt['phoneno']; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($rslt['status'] == 1) { ?>
                                                            <span  class="glyphicon glyphicon-ok changestatus" id="<?php echo $rslt['users_id'] ?>"></span>
                                                        <?php }if ($rslt['status'] == 0) { ?>
                                                            <span class="glyphicon glyphicon-remove changestatus" id="<?php echo $rslt['users_id'] ?>"></span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
<?php
	echo $pagination;
}else{
    $HTML='No Data Found';
}
echo $HTML;
?>
