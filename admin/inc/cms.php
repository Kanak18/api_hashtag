<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i><?php echo $PageTitle; ?>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <!--<form action="#" id="cmsForm" method='POST' class="form-horizontal" enctype="multipart/form-data">-->
                <form action="#" name="cmsForm" id="cmsForm" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    <input name="save" value="true" type="hidden">
                    <input name="eid" value="<?php echo $eid; ?>" type="hidden">
                    <input name="process" value="<?php
                    if ($eid > 0) {
                        echo 'Upd';
                    } else {
                        echo 'Ins';
                    }
                    ?>" type="hidden">


                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                        </div>
                        <?php
                        $sts = isset($_GET['sts'])?$_GET['sts']:'';
                        $act = isset($_GET['act'])?$_GET['act']:'';
                        if ($sts == "ok" && $act == "Ins") { ?>
                            <div class="alert alert-success">Details added successfully<button class="close" data-close="alert"></button></div>
                        <?php } else if ($sts == "ok" && $act == "Upd") { ?>
                            <div class="alert alert-success">Details updated successfully<button class="close" data-close="alert"></button></div>
                        <?php } else if ($sts == "ok" && $act == "sorder") { ?>
                            <div class="alert alert-success">Order updated successfully<button class="close" data-close="alert"></button></div>
                        <?php } else if ($sts == "ok" && $act == "Del") { ?>
                            <div class="alert alert-success">Details deleted successfully<button class="close" data-close="alert"></button></div>
                        <?php } else if ($sts == "ok" && $act == "Delimage") { ?>
                            <div class="alert alert-success">Image deleted successfully<button class="close" data-close="alert"></button></div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="control-label col-md-3">Page Name<span class="required">
                                    * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="catname" id='catname' type="text" value='<?php echo $catname; ?>' class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Meta Title
                            </label>
                            <div class="col-md-4">
                                <input name="meta_title" id="meta_title" value='<?php echo $metatitle; ?>' type=text maxlength="250" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Meta Keyword
                            </label>
                            <div class="col-md-4">
                                <input name="meta_keyword" id='meta_keyword' type="text" value='<?php echo $metakeyword; ?>' class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Meta Description
                            </label>
                            <div class="col-md-4">
                                <textarea rows="3" class="form-control" name="meta_desc" id="meta_desc"><?php echo $metadesc; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Parent Pages
                            </label>
                            <div class="col-md-4">
                                <select id="catid" name="catid" class="form-control">
                                    <option value="">-- Parent Pages --</option>
                                    <?php
                                    if ($eid > 0)
                                        $wh = " AND id!=" . $eid;
                                    else
                                        $wh = '';
										
									echo "SELECT * FROM maincategory WHERE parentid=0 AND status=1 $wh ORDER BY catname";	
										
                                    $res = mysql_query("SELECT * FROM maincategory WHERE parentid=0 AND status=1 $wh ORDER BY catname");
                                    while ($rows = mysql_fetch_assoc($res)) {
                                        if ($catid == $rows['id'])
                                            $sel = 'selected';
                                        else
                                            $sel = '';
                                        echo '<option value="' . $rows['id'] . '" ' . $sel . ' >' . $rows['catname'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <textarea name="ndesc" id="ndesc" class="form-control ckeditor" cols="40" rows="6"><?php echo $ndesc; ?></textarea>
                                <div id="editor2_error"></div>
                            </div>
                        </div>

<!--                        <div class="form-group">
                            <label class="control-label col-md-3">Image</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
<?php if ($myaction == "edit" && $myVals["image"] != "none" && !empty($myVals["image"])) { ?>
                                        <div style="width: 200px; height: 150px;" class="fileinput-new thumbnail">
                                            <img alt="<?php echo $myVals["image"] ?>" src="<?php echo SITE_URL; ?>includes/show_image.php?File=../uploads/cmsimage/<?php echo $myVals["image"] ?>&Width=200&Height=150">
                                        </div>
<?php } ?>
                                    <input type="hidden" name="oldimage" id="oldimage" value="<?php echo $myVals["image"]; ?>"/>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new">
                                            Select file </span>
                                        <span class="fileinput-exists">
                                            Change </span>
                                        <input type="file" name="nimg" id="nimg">
                                    </span>
                                    <?php
                                    if ($catimg != "") {
                                        echo "<a href='../images/mainimages/$catimg' target='_blank'>View Image</a>&nbsp;";
                                        echo "&nbsp;&nbsp;<a href='cms.php?process=Delimage&did=$id' >Remove</a>";
                                    }
                                    ?>
                                    <br><br>
                                    <span style="color:#FF0000;">[Note: Image format should be .jpg , .jpeg, .png or .gif]</span>

                                    <span class="fileinput-filename"></span>
                                    &nbsp; <a href="#" class="close fileinput-exists" data-dismiss="fileinput">
                                    </a>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <label class="control-label col-md-3">Link
                            </label>
                            <div class="col-md-4">
                                <input name="calink" id="calink" value='<?php echo $calink ?>' type='text' class="form-control" />&nbsp;&nbsp;<span style="color:#FF0000;"><br>(http://www.example.com/) or (index.html  -  For local pages)</span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Status 
                            </label>
                            <div class="col-md-4">
                                <div class="radio-list" data-error-container="#form_2_status_error">
                                    <label>
                                        <input type="radio" <?php if (empty($status) || $status == 1) { ?>checked="checked" <?php } ?> name="status" value="1"/>
                                        Active</label>
                                    <label>
                                        <input type="radio" <?php if ($status == 0) { ?> checked="checked" <?php } ?> name="status" value="0"/>
                                        Inactive</label>
                                </div>
                                <div id="form_2_status_error">
                                </div>
                            </div>
                        </div>

<!--                        <div class="form-group">
                            <label class="col-md-3 control-label">Display in footer</label>
                            <div class="col-md-9">
                                <div class="checkbox-list">
                                    <label>
                                        <input <?php echo ($status_footer == '1') ? "checked='checked'" : ""; ?> value="1" name="status_footer" type="checkbox"> </label><span style="color:#FF0000;">(Checked if you want display link in footer)</span>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <label class="control-label col-md-3">Add Google Ad
                                (Add #GOOGLEADS# in Editor for display google ads) </label>
                            <div class="col-md-9">
                                <textarea name="gogle_ads" id="gogle_ads" class="form-control" cols="40" rows="6"><?php echo $gogle_ads; ?></textarea>
                                <div id="editor2_error"></div>
                            </div>
                        </div>                                  
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green">Submit</button>
                                <button type="button" class="btn default" onclick="window.location = 'dashboard.php'">Cancel</button>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
            <!-- END FORM-->


            <div class="portlet-body form">
                <!-- BEGIN ANOTHER FORM-->
                <form action="#" name="cmsForm2" id="cmsForm2" method='POST' class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="process" value="sorder" />
                    <div class="form-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">Page\Sub Page Name</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>                                    
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 1;
                                $k = 0;
                                $catname = '';
                                
                                if ($rcnt > 0) {
                                    
                                    while ($clist = mysql_fetch_assoc($result)) {
                                        if ($k == 0)
                                            $bgcol = 'bgcolor="#e8e8e8"';
                                        else
                                            $bgcol = 'bgcolor="#ffffff"';
                                        if ($clist['status'] == 1) {
                                            $aimg = 'images/active.png';
                                            $altxt = "Active";
                                        } else {
                                            $aimg = 'images/deactive.png';
                                            $altxt = "Deactive";
                                        }                                        
                                        
                                        $st = '';
                                        
                                        if ($clist['cname'] != $catname) {
                                            if ($clist['cstatus'] == 1)
                                                $st = 'Enable';
                                            else
                                                $st = 'Disable';
                                            ?>
                                            <tr class="altdark">
                                                <td colspan="2"><div style="font-size:13px; font-weight:bold;"><?php echo $clist['cname']; ?></div></td>
                                                <td align="left"><input type="text" name="sorder[]" value="<?php echo $clist['csorder']; ?>" style="border:#33CCFF 1px solid; width:30px;" /></td>
                                                <td><input type="hidden" name="catids[]" value="<?php echo $clist['cid']; ?>" /><?php echo $st; ?></td>
                                                <td  nowrap="nowrap">
                                                    <a href="cms.php?act=edit&id=<?php echo $clist['cid']; ?>#add">Edit</a>&nbsp;&nbsp;
                                                    <a href="cms.php?process=Del&did=<?php echo $clist['cid']; ?>" onclick="return confirm('Are you sure you want to delete this page?');">Del</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php                                        
                                        if ($clist['catname'] != '' || $clist['catname'] != NULL) {
                                            if ($clist['status'] == 1)
                                                $st = 'Enable';
                                            else
                                                $st = 'Disable';
                                            ?>
                                            <tr class="altdark">
                                                <td>&nbsp;</td>
                                                <td><?php echo $clist['catname']; ?></td>
                                                <td align="right"><input type="text" name="sorder[]" value="<?php echo $clist['sorder']; ?>" style="border:#33CCFF 1px solid; width:20px;" /></td>
                                                <td><input type="hidden" name="catids[]" value="<?php echo $clist['id']; ?>" /><?php echo $st; ?></td>
                                                <td>
                                                    <a href="cms.php?act=edit&id=<?php echo $clist['id']; ?>#add">Edit</a>&nbsp;&nbsp;
                                                    <a href="cms.php?process=Del&did=<?php echo $clist['id']; ?>" onclick="return confirm('Are you sure you want to delete this page?');">Del</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php
                                        if ($clist['pid'] == 0)
                                            $catname = $clist['cname'];
                                    }
                                    ?>
                                <?php } else { ?>
                                    <tr><td colspan="5" align="center"> No Category </td></tr>
<?php } ?>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                    <td><input type="submit" name="submit1" value="Save Order" class="btn green" /></td>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
                <!-- END ANOTHER FORM-->

            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>
<!-- END PAGE CONTENT-->