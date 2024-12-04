<?php
function getLocationsTimeZone($lid)
{
	$locTimeZone = getNameFromId("flying_location","location_timezone","id",$lid);
	if(strlen($locTimeZone)==0)
	{
			$selAdd = "SELECT * FROM flying_location WHERE id=".$lid;
			$rsAdd = mysql1_query($con,$selAdd) or die ("could not get location detail".mysqli_error());
			if($rwAdd=mysqli_fetch_array($rsAdd))
			{

				$lat = $rwAdd["location_lat"];
				$long = $rwAdd["location_lng"];
				
				$locTimeZone = get_nearest_timezone($lat, $long,"");
	
				$updTimeZoneqry = "UPDATE flying_location SET location_timezone='".$locTimeZone."' WHERE id=$lid";	
				mysqli_query($con,$updTimeZoneqry) or die("Could not update timezone for location.".mysqli_error());
			}
	}
	
	return  $locTimeZone;

}
function get_nearest_timezone($cur_lat, $cur_long, $country_code = 'US') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                    : DateTimeZone::listIdentifiers();

    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];

                $theta    = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) 
                + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
                // echo '<br />'.$timezone_id.' '.$distance; 

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                } 

            }
        }
        return  $time_zone;
    }
    return 'unknown';
}

function getPagination($count){
//    echo $count;
      $paginationCount= floor($count / PAGE_PER_NO);
      $paginationModCount= $count % PAGE_PER_NO;
      if(!empty($paginationModCount)){
               $paginationCount++;
      }
//      echo $paginationCount;exit;
      return $paginationCount;
}
function pagination($pageId,$cnt){
	$page = (int) (!isset($pageId) ? 1 :$pageId);
	$page = ($page == 0 ? 1 : $page);
	$recordsPerPage = PAGE_PER_NO;
	$start = ($page-1) * $recordsPerPage;
	$adjacents = "2";
	 
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($cnt/$recordsPerPage);
	$lpm1 = $lastpage - 1;   
	$pagination = "";
	if($lastpage > 1)
		{   
			$pagination .= "<ul class='pagination'>";
			if ($page > 1)
				$pagination.= "<li ><a title='First' href=\"#Page=".($prev)."\" onClick='changePagination(".($prev).");'><i class='fa fa fa-angle-left'></i></a></li>";
			else
				$pagination.= "<li class='class='prev disabled''><a title='First' href=\"#Page=".($prev)."\" href=''><i class='fa fa fa-angle-left'></i></a></li>";   
			if ($lastpage < 7 + ($adjacents * 2))
			{   
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='active'><a>$counter</a></li>";
					else
						$pagination.= "<li><a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a></li>";     
	 
				}
			}   
	 
			elseif($lastpage > 5 + ($adjacents * 2))
			{
				if($page < 1 + ($adjacents * 2))
				{
					for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if($counter == $page)
							$pagination.= "<li class='active'><a>$counter</a></li>";
						else
							$pagination.= "<li><a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a></li>";     
					}
					$pagination.= "<li><a>...</a></li>";
					$pagination.= "<li><a href=\"#Page=".($lpm1)."\" onClick='changePagination(".($lpm1).");'>$lpm1</a></li>";
					$pagination.= "<li><a href=\"#Page=".($lastpage)."\" onClick='changePagination(".($lastpage).");'>$lastpage</a></li>";   
	 
			   }
			   elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			   {
				   $pagination.= "<li><a href=\"#Page=\"1\"\" onClick='changePagination(1);'>1</a></li>";
				   $pagination.= "<li><a href=\"#Page=\"2\"\" onClick='changePagination(2);'>2</a></li>";
				   $pagination.= "<li><a>...</a></li>";
				   for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				   {
					   if($counter == $page)
						   $pagination.= "<li class='active'><a>$counter</a></li>";
					   else
						   $pagination.= "<li><a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a></li>";     
				   }
				   $pagination.= "<li><a>..</a></li>";
				   $pagination.= "<li><a href=\"#Page=".($lpm1)."\" onClick='changePagination(".($lpm1).");'>$lpm1</a></li>";
				   $pagination.= "<li><a href=\"#Page=".($lastpage)."\" onClick='changePagination(".($lastpage).");'>$lastpage</a></li?";   
			   }
			   else
			   {
				   $pagination.= "<li><a href=\"#Page=\"1\"\" onClick='changePagination(1);'>1</a></li>";
				   $pagination.= "<li><a href=\"#Page=\"2\"\" onClick='changePagination(2);'>2</a></li>";
				   $pagination.= "<li><a>..</a></li>";
				   for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				   {
					   if($counter == $page)
							$pagination.= "<li class='active'><a href=\"#Page=".($counter)."\" >$counter</a></li>";
					   else
							$pagination.= "<li><a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a></li>";     
				   }
			   }
			}
			if($page < $counter - 1)
				$pagination.= "<li><a href=\"#Page=".($next)."\" onClick='changePagination(".($next).");'><i class='fa fa-angle-right'></i></a></li>";
			else
				$pagination.= "<li class='disabled'><a><i class='fa fa-angle-right'></i></a></li>";
	 
			$pagination.= "</ul>";       
		}
		return $pagination;
}
function findSingleFld($tblname, $fldname, $colnm, $id) {
    $q = "SELECT $fldname FROM $tblname WHERE $colnm=$id ";
    $r = mysqli_query($con,$q) or die("can not select child");
    while ($a = mysqli_fetch_assoc($r)) {
        echo $a[$fldname];
    }
    mysql_free_result($r);
}

function FillCombo($TblName, $DispFld, $IDFld, $SelectedID, $where = '') {
    if ($TblName == "Disciplines")
        $orderBy = $IDFld;
    else
        $orderBy = $DispFld;
    if (substr($TblName, 0, 2) == "-1")
        $qry = substr($TblName, 2);
    else
        $qry = "SELECT DISTINCT $DispFld , $IDFld FROM $TblName $where ORDER BY $orderBy";

//    echo $qry;exit;
    $result = mysqli_query($con,$qry) or die("could not fill combo" . mysqli_error());

    while ($arow = mysqli_fetch_array($result)) {
        echo "<option value='$arow[$IDFld]'";
        if (is_array($SelectedID)) {
            if (in_array($arow[$IDFld], $SelectedID))
                echo " selected";
        }
        elseif ($arow[$IDFld] == $SelectedID)
            echo " selected";
        echo ">$arow[$DispFld]</option>";
    }

    mysql_free_result($result);
}

function FillComboQuestion($TblName, $DispFld, $IDFld, $SelectedID, $limit = '') {
    if ($TblName == "Disciplines")
        $orderBy = $IDFld;
    else
        $orderBy = $DispFld;
    if (substr($TblName, 0, 2) == "-1")
        $qry = substr($TblName, 2);
    else
        $qry = "SELECT DISTINCT $DispFld , $IDFld FROM $TblName $where ORDER BY $orderBy $limit";

//    echo $qry;exit;
    $result = mysqli_query($con,$qry) or die("could not fill combo" . mysqli_error());

    while ($arow = mysqli_fetch_array($result)) {
        echo "<option value='$arow[$IDFld]'";
        if (is_array($SelectedID)) {
            if (in_array($arow[$IDFld], $SelectedID))
                echo " selected";
        }
        elseif ($arow[$IDFld] == $SelectedID)
            echo " selected";
        echo ">$arow[$DispFld]</option>";
    }

    mysql_free_result($result);
}

function FillComboLevel($TblName, $DispFld, $IDFld, $SelectedID, $where = '') {
    if ($TblName == "Disciplines")
        $orderBy = $IDFld;
    else
        $orderBy = $DispFld;
    if (substr($TblName, 0, 2) == "-1")
        $qry = substr($TblName, 2);
    else
        $qry = "SELECT DISTINCT $DispFld , $IDFld,sports_id FROM $TblName $where ORDER BY $orderBy";

//    echo $qry;exit;
    $result = mysqli_query($con,$qry) or die("could not fill combo" . mysqli_error());

    while ($arow = mysqli_fetch_array($result)) {

        $selectSports = "select name from sports where sports_id=" . $arow['sports_id'];
        $selectSportsRs = mysqli_query($con,$selectSports);
        $selectSportsRslt = mysqli_fetch_assoc($selectSportsRs);
        echo "<option value='$arow[$IDFld]'";
        if (is_array($SelectedID)) {
            if (in_array($arow[$IDFld], $SelectedID))
                echo " selected";
        }
        elseif ($arow[$IDFld] == $SelectedID)
            echo " selected";
        echo ">" . $selectSportsRslt['name'] . "-->" . $arow[$DispFld] . "</option>";
    }

    mysql_free_result($result);
}

function ListColumnValue($tbl, $baseField, $where, $seprator, $dispFild, $baseTbl) {

    if (substr($tbl, 0, 2) == "-1")
        $qry = substr($tbl, 2);
    else
        $qry = "SELECT $baseField FROM $tbl $where";
//    echo $qry;
    $result = mysqli_query($con,$qry) or die("could not fill combo" . mysqli_error());

    while ($arow = mysqli_fetch_array($result)) {
//        echo $arow[$baseField];
        if (!empty($arow[$baseField])) {
            $qryData = "select $dispFild from $baseTbl where $baseField=$arow[$baseField]";
            $qryDatars = mysqli_query($con,$qryData);
            while ($qryDataRslt = mysqli_fetch_assoc($qryDatars)) {
                echo $qryDataRslt[$dispFild] . $seprator;
            }
        }
    }

    mysql_free_result($result);
}

///// SITE FUNCTIONS ///////////////
function setGPC($val, $act) {
    # use this function to display/insert values coming from Get/Post/Cookie.
    # parameter "act" should have a value "display" if it is being used for displaying value. 
    # in case of database update/insert the "act" can be left blank.

    if (!get_magic_quotes_gpc())
        $val = addslashes(trim($val));

    if ($act == "display")
        $val = stripslashes($val);

    return $val;
}

function setDB($val, $act) {
    # use this function to display/insert values coming from sources other than Get/Post/Cookie. i.e. database/file etc.
    # parameter "act" should have a value "display" if it is being used for displaying value. 
    # in case of database update/insert the "act" can be left blank.

    if (!get_magic_quotes_runtime())
        $val = addslashes(trim($val));

    if ($act == "display")
        $val = stripslashes($val);

    return $val;
}

function populateFields($src, $txtFlds, $numFlds, $myRow) {
    $myFlds = Array();

    if ($src == "Initialize") {
        for ($b = 0; $b < count($txtFlds) + count($numFlds); $b++) {
            if ($b < count($txtFlds))
                $myFlds[$txtFlds[$b]] = "";
            else
                $myFlds[$numFlds[$b - count($txtFlds)]] = "";
        }
    }
    elseif ($src == "GPC") {
        for ($b = 0; $b < count($txtFlds) + count($numFlds); $b++) {
            if ($b < count($txtFlds)) {
                $myVal = isset($_POST[$txtFlds[$b]]) ? trim($_POST[$txtFlds[$b]]) : "";
                $myFlds[$txtFlds[$b]] = (strlen($myVal) == 0) ? "" : setGPC($myVal, "display");
            } else {
                $myVal = isset($_POST[$numFlds[$b - count($txtFlds)]]) ? trim($_POST[$numFlds[$b - count($txtFlds)]]) : "";
                $myFlds[$numFlds[$b - count($txtFlds)]] = (intval($myVal) == 0) ? "" : setGPC($myVal, "display");
            }
        }
    } elseif ($src == "DB") {
        for ($b = 0; $b < count($txtFlds) + count($numFlds); $b++) {
            if ($b < count($txtFlds)) {
                $myFlds[$txtFlds[$b]] = ((!isset($myRow[$txtFlds[$b]])) || strlen(trim($myRow[$txtFlds[$b]])) == 0) ? "" : setDB($myRow[$txtFlds[$b]], "display");
            }
            else
                $myFlds[$numFlds[$b - count($txtFlds)]] = ((!isset($myRow[$numFlds[$b - count($txtFlds)]])) ||
                        intval(trim($myRow[$numFlds[$b - count($txtFlds)]])) == 0) ? "0" :
                        setDB($myRow[$numFlds[$b - count($txtFlds)]], "display");
        }
    }

    return $myFlds;
}

Function UpdateFlds($myTxtFlds, $myNumFlds) {

    if (!isset($myTxtFlds) || !is_array($myTxtFlds))
        $myTxtFlds = Array();

    if (!isset($myNumFlds) || !is_array($myNumFlds))
        $myNumFlds = Array();

    $qryUpdate = Array();

    for ($b = 0; $b < count($myTxtFlds) + count($myNumFlds); $b++) {
        if ($b < count($myTxtFlds)) {
            $myVal = isset($_POST[$myTxtFlds[$b]]) ? trim($_POST[$myTxtFlds[$b]]) : "";
            $qryUpdate[$b] = $myTxtFlds[$b] . "=";
            $qryUpdate[$b] .= (strlen($myVal) == 0) ? "''" : ("'" . setGPC($myVal, "") . "'");
        } else {
            $myVal = isset($_POST[$myNumFlds[$b - count($myTxtFlds)]]) ? $_POST[$myNumFlds[$b - count($myTxtFlds)]] : 0;
            $qryUpdate[$b] = $myNumFlds[($b - count($myTxtFlds))] . " = ";
            $qryUpdate[$b] .= (intval($myVal) == 0) ? "0" : setGPC($myVal, "");
        }
    }

    $qryUpdate = implode(",", $qryUpdate);

    return $qryUpdate;
}

function myForm($action, $err, $errfld) {
    global $_REQUEST;

    echo "<form name='myfrm' method='post' action='$action'>\n";
    echo "<input type='hidden' name='err' value='$err'>\n";
    echo "<input type='hidden' name='errfld' value='$errfld'>\n";

    foreach ($_REQUEST as $key => $value) {
        if (is_array($value))
            $myValue = implode(",", $value);
        else
            $myValue = $value;
        print "<input type='hidden' name='$key' value='$myValue'>\n";
    }
    echo ".</form>
		<script language='Javascript'>
			document.myfrm.submit();
		</script>";
    exit;
}

Function checkCompulsory($CompulsoryTxtFlds, $CompulsoryNumFlds, $FriendlyNames, $redirection) {
    if (!isset($CompulsoryTxtFlds) || !is_array($CompulsoryTxtFlds))
        $CompulsoryTxtFlds = Array();

    if (!isset($CompulsoryNumFlds) || !is_array($CompulsoryNumFlds))
        $CompulsoryNumFlds = Array();

    for ($c = 0; $c < count($CompulsoryTxtFlds) + count($CompulsoryNumFlds); $c++) {
        if ($c < count($CompulsoryTxtFlds)) {
            if (!isset($_POST[$CompulsoryTxtFlds[$c]]) || strlen(trim($_POST[$CompulsoryTxtFlds[$c]])) == 0) {
                if (isset($FriendlyNames[$c]))
                    $errfld = $FriendlyNames[$c];
                else
                    $errfld = $CompulsoryTxtFlds[$c];

                myForm($redirection, "compulsory", $errfld);
                exit;
            }
        }
        else {
            if (!isset($_POST[$CompulsoryNumFlds[$c - count($CompulsoryTxtFlds)]]) || intval($_POST[$CompulsoryNumFlds[$c - count($CompulsoryTxtFlds)]]) == 0) {
                if (isset($FriendlyNames[$c]))
                    $errfld = $FriendlyNames[$c];
                else
                    $errfld = $CompulsoryTxtFlds[$c - count($CompulsoryTxtFlds)];

                myForm($redirection, "compulsory", $errfld);
                exit;
            }
        }
    }
}

function validateEmail($val) {
    $my = $val;
    $attherate = strpos($my, "@");
    $lastattherate = strrpos($my, "@");
    $dotpos = strrpos($my, ".");
    $posspace = strpos($my, " ");
    $totallen = strlen($my);

    if ($attherate <= 0 || $dotpos <= 0 || $attherate > $dotpos || ($dotpos - $attherate) <= 1 || ($dotpos == $totallen - 1) || $posspace > -1 || $attherate != $lastattherate) {
        return false;
    }
    else
        return true;
}

function phpMailerMail($FromDisplay, $FromEmail, $ReplyTo, $ToName, $ToEmail, $myCCList, $myBCCList, $Subject, $HTMLMsg, $TxtMsg, $AttFile, $AttFileName, $AttFileType)
{
	/*
	if(isset($ToEmail) && validateEmail($ToEmail))
	{
		//mail function for dev5.mysticwebdesign start
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$ToName.' <'.$ToEmail.'>' . "\r\n";
		$headers .= 'From: '.$FromDisplay.' <'.$FromEmail.'>' . "\r\n";
		
		
		$to = $ToEmail;
		$subject = $Subject;
		$message = $HTMLMsg;
		
		@mail($to, $subject, $message, $headers);		
		
		//mail function for dev5.mysticwebdesign end
	}
	*/	

	if(isset($ToEmail) && validateEmail($ToEmail))
	{
		//mail function for dev5.mysticwebdesign end
		require_once("class.phpmailer.php");

		$mail = new PHPMailer();

		# -- prepare mail body
		# --
		$message = strip_tags($HTMLMsg);
		//$myMsg = str_replace("\n","",$message);
		$message = str_replace("\t","",$message);
		$message = str_replace("&nbsp;","",$message);

		if(!isset($FromDisplay) || strlen(trim($FromDisplay))==0)
			$FromDisplay = $FromEmail;
		if(!isset($ToName) || strlen(trim($ToName))==0)
			$ToName = $ToEmail;


		# -- add ccs
		# ---
		if(isset($myCCList) && strlen(trim($myCCList)) > 0)
		{
			$tempCCs = explode(",", $myCCList);
			for($c = 0;$c<count($tempCCs);$c++)
				if(validateEmail($tempCCs[$c]))
					$mail->AddCC($tempCCs[$c]);
		}

		# ---
		# -- add bccs
		# ---

		if(isset($myBCCList) && strlen(trim($myBCCList)) > 0)
		{
			$tempBCCs = explode(",", $myBCCList);
			for($c = 0;$c<count($tempBCCs);$c++)
				if(validateEmail($tempBCCs[$c]))
					$mail->AddBCC($tempBCCs[$c]);
		}

		# --
		$mail->IsSMTP();                                      // set mailer to use SMTP

		$mail->Host = "mail.securenetsystems.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "info@mobileadreach.com";  // SMTP username
		$mail->Password = "mrrrace231"; // SMTP password

		$mail->FromName = $FromDisplay;
		$mail->From = $FromEmail;
		$mail->AddAddress($ToEmail,$ToName);

		# -- if reply to is set, add it.
		if(validateEmail($ReplyTo))
			$mail->AddReplyTo($ReplyTo);

		//$mail->WordWrap = 50;                                 // set word wrap to 50 characters

		if(strlen(trim($HTMLMsg)) > 0)
		{
			$mail->IsHTML(true);                                  // set email format to HTML
			$mail->Body = $HTMLMsg;

			if(strlen(trim($TxtMsg)) >0)
			{
				$mail->AltBody = $TxtMsg;
			}
			else
			{
				$message = strip_tags($HTMLMsg);
				//$myMsg = str_replace("\n","",$message);
				$message = str_replace("\t","",$message);
				$message = str_replace("&nbsp;","",$message);			
				$mail->AltBody = 	$message;
			}
		}
		else
		{
			$mail->IsHTML(false);
			$mail->Body = $TxtMsg;
		}

		$mail->Subject = $Subject;

		if(strlen(trim($AttFile))> 0 && file_exists($AttFile))
		{
			$mail -> AddAttachment($AttFile,$AttFileName);
		}
		
		if(!$mail->Send())
		{
		   echo "Message could not be sent. <p>";
		   echo "Mailer Error: " . $mail->ErrorInfo;
		   exit;
		}		
	}
}


function SendMail($FromDisplay, $FromEmail, $ReplyTo, $ToName, $ToEmail, $CCList, $BCCList, $Subject, $HTMLMsg, $TxtMsg, $AttFile, $AttFileName, $AttFileType) {
    require_once("class.wtd.sendmail.php");

    $myMail = New sendMail();

    $myMail->myName = $FromDisplay;
    $myMail->myFrom = $FromEmail;
    $myMail->ReplyTo = $ReplyTo;
    $myMail->ToName = $ToName;
    $myMail->myTo = $ToEmail;
    $myMail->myCCList = $CCList;
    $myMail->myBCCList = $BCCList;
    $myMail->mySubject = $Subject;
    $myMail->HTMLMsg = $HTMLMsg;
    $myMail->TxtMsg = $TxtMsg;
    $myMail->AttFile = $AttFile;
    $myMail->AttFileName = $AttFileName;
    $myMail->AttFileType = $AttFileType;

    $myMail->Send();
}

function getName($tbl, $dispFld, $IdFld, $val) {
    if ($val == 0)
        $myN = "Site Admin";
    else {
        $myN = "Unknown";

        $qry = "SELECT $dispFld FROM $tbl WHERE $IdFld=$val";
        $result = mysqli_query($con,$qry);

        if ($arow = mysqli_fetch_array($result))
            $myN = $arow[0];

        mysql_free_result($result);
    }

    return $myN;
}

Function DisplayDMY($myDate) {

    $myD = explode(" ", $myDate);
    $myTime = "";

    if (isset($myDate)) {
        if (count($myD) > 1) {
            $myTime = $myD[1];
            $myDate = $myD[0];
        }

        $myD = explode("-", $myDate);

        $myDay = $myD[2];
        $myMonth = $myD[1];
        $myYear = $myD[0];

        if ($myDay > 0 && $myMonth > 0 && $myYear > 0)
            $displayDate = $myDay . "/" . $myMonth . "/" . $myYear;
        else
            $displayDate = "";
    }
    else
        $displayDate = "";

    if ($myTime != "00:00:00")
        $dispTime = $myTime;
    else
        $dispTime = "";

    return $displayDate . " " . $dispTime;
}

Function DisplayPages($CurrentPage, $TotalPages, $formName, $linkClass) {

    # To use this function, there must be a form on the site inside which this functions should be called. 
    # It will submit the form back to the same url and all the data in the form to the next page. 
    # Useful especially if filters are used. All pages will then
    # display filtered data.
    # If form name is not supplied, the function will assume "frm1".

    if (!isset($formName))
        $formName = "frm1";

    if (strlen(trim($linkClass)) > 0)
        $myDispClass = " class=\"" . trim($linkClass) . "\" ";
    else
        $myDispClass = " ";

    $_SERVER["SCRIPT_NAME"];
    $Pagepos = strrpos($_SERVER["SCRIPT_NAME"], "/");

    $keyPage = substr($_SERVER["SCRIPT_NAME"], $Pagepos + 1);

    echo "<script language=\"javascript\">";
    echo "function gotoPage(a,l,frm)";
    echo "{";
    echo "frm = eval(\"document.\"+frm);";
    echo "frm.action=l;";
    echo "frm.cpage.value=a;";
    echo "frm.submit();";
    echo "}";
    echo "</script>";

    if ($TotalPages > 1) {
        echo "<table width=\"99%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" align=\"center\">
		  <tr> 
		    <td align=\"right\"><b><font face=\"Verdana\" size=\"1\">Page $CurrentPage of $TotalPages</font></b></td>
		  </tr>
		</table>
		<br>";

        echo "<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
				<tr> 
					<td valign=\"top\" align=\"center\"><font face=\"verdana\" size=\"2\">";

        if ($CurrentPage > 1) {

            echo "<a" . $myDispClass . "href=\"javascript:gotoPage('1','$keyPage','$formName');\" 
						title=\"Go to first page\"
						onmouseover=\"javascript:return window.status='Go to first page';\"
						onmouseout=\"javascript:return window.status='';\">First</a>&nbsp;|&nbsp;
						<a" . $myDispClass . "href=\"javascript:gotoPage('" . ($CurrentPage - 1) . "','$keyPage','$formName');\" 
						title=\"Go to previous page (" . ($CurrentPage - 1) . ")\"
						onmouseover=\"javascript:return window.status='Go to previous page (" . ($CurrentPage - 1) . ")';\"
						onmouseout=\"javascript:return window.status='';\">Previous</a>&nbsp;|&nbsp;";
        }

        echo "Go to Page 
						<input type=\"text\" name=\"cpage\" size=\"5\" class=\"inputnowidth\">&nbsp;
						<input type=\"button\" class=\"but\" name=\"btngo\" value=\"Go\" onclick=\"gotoPage(this.form.cpage.value,'$keyPage', '$formName');\">&nbsp;&nbsp;";

        if ($CurrentPage < $TotalPages) {
            echo "<a" . $myDispClass . "href=\"javascript:gotoPage('" . ($CurrentPage + 1) . "','$keyPage','$formName');\" 
						title=\"Go to next page (" . ($CurrentPage + 1) . ")\"
						onmouseover=\"javascript:return window.status='Go to next page (" . ($CurrentPage + 1) . ")';\"
						onmouseout=\"javascript:return window.status='';\">Next</a>&nbsp;|&nbsp;
						<a" . $myDispClass . "href=\"javascript:gotoPage('" . $TotalPages . "','$keyPage','$formName');\" 
						title=\"Go to last page\"
						onmouseover=\"javascript:return window.status='Go to last page';\"
						onmouseout=\"javascript:return window.status='';\">Last</a>";
        }

        echo "</font></td>
			</tr>
			</table>	<br>";
    }
}

function escape_string($estr) {
    if (version_compare(phpversion(), '4.3.0') == '-1')
        return(mysql_escape_string(trim($estr)));
    else
        return(mysql_real_escape_string(trim($estr)));
}

function upload_image_M($file_name, $allowedDocExt, $uploadTo, $w, $h, $schema, $op) {
    if (isset($_FILES[$file_name])) {
        $isImageUpload = 0;
        $fileName = $extension = "";
        $userPhoto = stripslashes($_FILES[$file_name][name]);
        if ($userPhoto) {
            $fileName = stripslashes($_FILES[$file_name][name]);
            $extension = strtolower(get_file_extenstion($fileName));
            $imageSName = $schema . "." . $extension;
            $newNameS = $uploadTo . $imageSName;
            $isCopied = copy($_FILES[$file_name][tmp_name], $newNameS);
            if ($isCopied && $op != 0) {
                $isImageUpload = 1;
                $objimage = new SimpleImage();
                $objimage->load($newNameS);

                if ($op == 1) {
                    $objimage->resize($w, $h);
                } else if ($op == 2) {
                    $objimage->resizeToHeight($h);
                } else if ($op == 3) {
                    $objimage->resizeToWidth($w);
                }

                $objimage->save($newNameS);
                $fName = $imageSName;
            } else if ($isCopied && $op == 0) {
                $fName = $imageSName;
            }
        }
    }
    return $fName;
}

function get_file_extenstion($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function formatAllSpecialCharWithJson($val, $act) {
    if ($act == "input")
        $val = htmlentities($val);
    else
        $val = json_encode(utf8_encode(html_entity_decode($val)));

    return $val;
}

function Mydate($format = "Y-m-d") {
    global $var_hr, $var_minit;
    $ext_min = ($var_minit + ($var_hr * 60));
    return gmdate($format, time() + ($ext_min * 60));
}

function Mytime() {
    /* global $var_hr,$var_minit;
      $ext_min=($var_minit+($var_hr*60));
      return time()+($ext_min*60); */
    return mktime(Mydate("H"), Mydate("i"), Mydate("s"), Mydate("n"), Mydate("j"), Mydate("Y"));
}

function extract_youtube_code($video_url) {
    $video_code_start = strpos($video_url, "v=");
    if ($video_code_start === FALSE) {
        $is_error = 5500189;
        return FALSE;
    }
    $video_code = substr($video_url, $video_code_start + 2);
    if (empty($video_code)) {
        return FALSE;
    }
    $video_code_end = strpos($video_code, '&');
    if ($video_code_end) {
        $video_code = substr($video_code, 0, $video_code_end);
    }

    return $video_code;
}

function randomcode($len = 8) {
    $code = NULL;
    for ($i = 0; $i < $len; $i++) {
        $char = chr(rand(48, 122));
        while (!@ereg("[a-zA-Z0-9]", $char)) {
            //while( !preg_replace("/[a-zA-Z0-9]/", $char) )
            if ($char == $lchar)
                continue;
            $char = chr(rand(48, 90));
        }
        $pass .= $char;
        $lchar = $char;
    }
    return $pass;
}

function converttohhmm($valdata) {
    $convertval = 0;
    $remval = ($valdata - floor($valdata / 60) * 60);
    if (strlen($remval) == 1)
        $remval = "0" . $remval;
    $convertval = floor($valdata / 60) . ":" . $remval;
    return $convertval;
}

function SendMailCommon($myName, $myFrom, $myReplyTo, $myTo, $myCCList, $myBCCList, $mySubject, $myMsg, $MailFormat) {
    if (!isset($MailFormat) || ($MailFormat != 0 && $MailFormat != 1))
        $MailFormat = 1;

    if ($MailFormat == 1) {
        $myMsgTop = "<table border='0' cellspacing='0' cellpadding='2' width='95%'>
                    <tr><td><font face='verdana' size='2'>";

        $myMsgBottom = "</font></td></tr></table>";
    } else {
        $myMsg = strip_tags($myMsg);
        //$myMsg = str_replace("\n","",$myMsg);
        $myMsg = str_replace("\t", "", $myMsg);
        $myMsg = str_replace("&nbsp;", "", $myMsg);
        $myMsgTop = "";
        $myMsgBottom = "";
    }

    $headers = "From: $myName < $myFrom >\n";
    $headers .= "X-Sender: < $myFrom >\n";
    $headers .= "X-Mailer: PHP\n"; // mailer
    $headers .= "Return-Path: < $myFrom >\n";  // Return path for errors

    if ($MailFormat == 1)
        $headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type

    if (isset($myCCList) && strlen(trim($myCCList)) > 0)
        $headers .= "cc: $myCCList\n";

    if (isset($myBCCList) && strlen(trim($myBCCList)) > 0)
        $headers .= "bcc: $myBCCList\n";

    if (isset($myReplyTo) && strlen(trim($myReplyTo)) > 0)
        $headers .= "Reply-to: < $myReplyTo >\n";

    $receipient = $myTo;
    $subject = $mySubject;
    $message = $myMsgTop . $myMsg . $myMsgBottom;


    @mail($receipient, $subject, $message, $headers);
}

function DisplayDMY_Date($myDate) {

    $myD = explode(" ", $myDate);
    $myTime = "";

    if (isset($myDate)) {
        if (count($myD) > 1) {
            $myTime = $myD[1];
            $myDate = $myD[0];
        }

        $myD = explode("-", $myDate);

        $myDay = $myD[2];
        $myMonth = $myD[1];
        $myYear = $myD[0];

        if ($myDay > 0 && $myMonth > 0 && $myYear > 0)
            $displayDate = $myMonth . "-" . $myDay . "-" . $myYear;
        else
            $displayDate = "";
    }
    else
        $displayDate = "";

    if ($myTime != "00:00:00")
        $dispTime = $myTime;
    else
        $dispTime = "";

    return $displayDate . " " . $dispTime;
}

function encode5t($str) {
    for ($i = 0; $i < 5; $i++) {
        $str = strrev(base64_encode($str)); //apply base64 first and then reverse the string
    }
    return $str;
}

function decode5t($str) {
    for ($i = 0; $i < 5; $i++) {
        $str = base64_decode(strrev($str)); //apply base64 first and then reverse the string}
    }
    return $str;
}
function set_timezone($timezone)
{
	ini_set("date.timezone", $timezone);	
}

function send_android_notification($deviceKey,$message)
{
    require_once '../android_pushnotification/GCM.php';    
    $gcm = new GCM();
    $registatoin_ids = array($deviceKey);
    $message = array("push" => $message);
    $result = $gcm->send_notification($registatoin_ids, $message);
}

function add_meesage_history($sender_id,$receiver_id,$message_type = "individual",$message="",$send_anonymously=0,$notify_type="", $sender_name =  "Anonymous",$loc_id=0)
{
	 $locationZone = getLocationsTimeZone($loc_id);
	 set_timezone($locationZone);		
	 $send_date = date("Y-m-d H:i:s");

	 $insertHistory = "INSERT INTO message_history (sender_id,receiver_id,message_type,message,send_anonymously,sender_name,notify_type,send_date,location_id) VALUES('".$sender_id."','".$receiver_id."','".$message_type."','".setDB($message,"")."','".$send_anonymously."','".setDB($sender_name,"")."','".$notify_type."','".$send_date."','".$loc_id."')";
	mysqli_query($con,$insertHistory) or die ("could not insert in to message history");
}

function send_iphone_notification($deviceKey,$messageText)
{
	require_once '../iphone_pushnotification/APNSBase.php';
	require_once '../iphone_pushnotification/APNotification.php';
	require_once '../iphone_pushnotification/APFeedback.php';
	try{
	  # Notification Example
	  $notification = new APNotification('production');
	  $notification->setDeviceToken($deviceKey);
	  $notification->setMessage($messageText);
	  $notification->setBadge(1);
	  $notification->setPrivateKey('../iphone_pushnotification/DevAwareAPNS.pem');
	  $notification->setPrivateKeyPassphrase('admin');
	  $notification->send();
	}catch(Exception $e){
	  echo $e->getLine().': '.$e->getMessage();
	}
}



function send_messages($senderid,$custid,$ntype,$message,$message_type,$send_anonymously,$lcid=0)
{
	global $arrPushNotifyIds;

	$arrNtype = explode(",",$ntype);
	
	if($arrNtype[0]==1) // SMS
	{	
		$cell_number = getNameFromId("customer","phone","id",$custid);
		if(strlen($cell_number) > 8)
		{
			if(strlen($cell_number)==10)
			{
				$cell_number = "1".$cell_number;
			}	
			send_coupon_through_sms($cell_number,$message);
			//ADD DATA INTO  MESSAGE HISTORY TABLE START
			//add_meesage_history($senderid,$custid,$message_type,$message,$send_anonymously,"SMS");
			//ADD DATA INTO  MESSAGE HISTORY TABLE END
		}
	}
	if($arrNtype[1]==1) // E-Mail
	{
		send_coupon_through_email($senderid,$custid,$ntype,$message,$send_anonymously);
		//ADD DATA INTO  MESSAGE HISTORY TABLE START
		//add_meesage_history($senderid,$custid,$message_type,$message,$send_anonymously,"EMAIL");
		//ADD DATA INTO  MESSAGE HISTORY TABLE END
		
	}
	if($arrNtype[2]==1) // notification
	{	
		send_coupon_through_noficiation($senderid,$custid,$ntype,$message,$message_type,$send_anonymously);
	}
	
	if($send_anonymously==1)
	{
		$sender_name =  "Anonymous";
	}
	else
	{
		$sender_name = getNameFromId("customer","name","id",$senderid);
	}	
	add_meesage_history($senderid,$custid,$message_type,$message,$send_anonymously,"PUSH",$sender_name,$lcid);
	//ADD DATA INTO  MESSAGE HISTORY TABLE END
	
}

function send_coupon_through_noficiation($send_id,$custid,$ntype,$message,$message_type,$send_anonymously)
{
	
	global $arrPushNotifyIds;
	

	
	$qry = "SELECT * FROM customer_device_info WHERE cust_id=".$custid." and length(device_id) > 8 order by id desc";
	
	$result = mysqli_query($con,$qry) or die("error selecting device");
	$reccnt = mysql_num_rows($result);
	if($reccnt > 0) 
	{
		if($arow=mysqli_fetch_array($result))
		{	
			if(!in_array($arow["device_id"],$arrPushNotifyIds))
			{

				$arrPushNotifyIds[] = $arow["device_id"];
				
				if($send_anonymously==1)
				{
					$sender_name =  "Anonymous";
				}
				else
				{
					$sender_name = getNameFromId("customer","name","id",$send_id);
				}
				
				
				if(trim($arow["device_type"])=="iphone")
				{
						
					if(strlen($arow["device_id"]) > 8)
					{
						//echo "<br/>before:".$custid." ".$arow["device_type"]." ".$arow["device_id"];		
						send_iphone_notification($arow["device_id"],$message);				
						//echo "<br/>success:".$custid." ".$arow["device_type"]." ".$arow["device_id"];		
					}
				}
				else if(trim($arow["device_type"])=="android")
				{	
	
					if(strlen($arow["device_id"]) > 8)
					{		
						//echo "<br/>insdie:".$custid." ".$arow["device_type"]." ".$arow["device_id"];					
							$textMessage["message"] = $message;							
							$textMessage["sender"] = $sender_name;
							$messageText = json_encode($textMessage);
							
						
							send_android_notification($arow["device_id"],$messageText);
						//echo "<br/>success:".$custid." ".$arow["device_type"]." ".$arow["device_id"];
					}
				}	
			}	
			
		}	
	}
	
	// COUPON SEN THROUGH NOTIFICATION 
}

function send_coupon_through_sms($number,$message)
{
	// SMS API CALL
    $user = "AwareApps";
    $password = "PgSZHDif";
    $api_id = "3591277";
    $baseurl ="http://api.clickatell.com";	
  
	$newcontent = preg_replace("/<p[^>]*?>/", "", $message);
	$text = str_replace("</p>", " ", $newcontent);
	 	 
	$arrMsg = array();
	
	if(strlen($text) > 140)
	{
		$arrMsg[] = substr($text,0,140);
		$arrMsg[] = substr($text,140);
	}
	else
	{
		$arrMsg[]  = $text;
	}

	$to = str_replace("-"," ",$number);

	$from="15626615907";
	$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id&from=$from&mo=1";

    // do auth call
    $ret = file($url);
 	
 
    // explode our response. return string is on first line of the data returned
    $sess = explode(":",$ret[0]);
    if ($sess[0] == "OK") {
 
        $sess_id = trim($sess[1]); // remove any whitespace
		for($i=0;$i<count($arrMsg);$i++)
		{
			$text = urlencode($arrMsg[$i]);
   			$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text&from=$from&mo=1"; 

			// do sendmsg call
			$ret = file($url);
			
			$send = explode(":",$ret[0]);
	 
			if ($send[0] == "ID") {
				//echo "successnmessage ID: ". $send[1];
			} else {
				//echo "send message failed";
			}
		}	
    } else {
       // echo "Authentication failure: ". $ret[0];
    }
}

function send_coupon_through_email($sndid,$custid,$ntype,$message,$send_anonymously)
{
	global $SITE_URL;
	
	
	
	$siteowner = "Pilot Aware";
	
	$subject = "Pilot Aware - Received new message"; 	
	

	if($send_anonymously==1)
	{
		$sender_name =  "Anonymous";
		$sender_email =  "info@awareapps.com";
	}
	else
	{
		$sender_name = getNameFromId("customer","name","id",$sndid);
		$sender_email =  getNameFromId("customer","email","id",$sndid);
	}
	
	$receiver_name =  getNameFromId("customer","name","id",$custid);
	$receiver_email =  getNameFromId("customer","email","id",$custid);
	
	$msg = "Dear ".$receiver_name;
	$msg .= "<br/><br/>You have received the following message.<br/>";
	
	$msg .=  $message;
	$msg .=  "<br/><br/>Thanks you";
	$msg .=  "<br/>".$sender_name;
	
  	phpMailerMail($sender_name, $sender_email,$sender_email, $receiver_name, $receiver_email, "","", $subject, $msg,"","","","");
	// SEND MAIL FOR ACTIVATION ACCOUNT END//
}


function getNameFromID($tblname,$fldname,$keyfld,$keyval)
{
	$member_id = 0;
	$qry_get = "SELECT ".$fldname. " FROM ".$tblname." WHERE ".$keyfld."='".$keyval."'";
	$rs_get =mysqli_query($con,$qry_get) or die ("erro in getNameFromID".mysqli_error());
	if($rw_get=mysqli_fetch_array($rs_get))
	{
		$member_id = $rw_get[$fldname];
	}
	return $member_id;
}
function upload_image_general($file_name, $allowedDocExt, $uploadTo, $w, $h, $schema, $op,$isThumb) {
    
	include_once("resizeimage.php");
	list($width, $height, $type, $attr) = getimagesize($_FILES[$file_name][tmp_name]);
	if($isThumb==0)
	{		
		if($width > 1024)
		{
		   $w = 1024;
		   $h = 1024;		
		}
		else
		{
		   $w = $width;
		   $h = $height;		
		}


	}	
	$op = 2;
	
	
    if (isset($_FILES[$file_name]) && is_uploaded_file($_FILES[$file_name][tmp_name])) {
        $isImageUpload = 0;
        $fileName = $extension = "";
        $userPhoto = stripslashes($_FILES[$file_name][name]);
        if ($userPhoto) {
            $fileName = stripslashes($_FILES[$file_name][name]);
            $extension = strtolower(get_file_extenstion($fileName));

            $photoname = str_replace(" ", "_", $_FILES[$file_name][name]);

            //$imageSName = $schema.".".$extension;
            $imageSName = $schema;
            $newNameS = $uploadTo . $imageSName;
            $isCopied = copy($_FILES[$file_name][tmp_name], $newNameS);
            if ($isCopied && $op != 0) {
                $isImageUpload = 1;
                $objimage = new SimpleImage();
                $objimage->load($newNameS);

                if ($op == 1) {
                    $objimage->resize($w, $h, $extension);
                } else if ($op == 2) {
                    $objimage->resizeToHeight($h);
                } else if ($op == 3) {
                    $objimage->resizeToWidth($w);
                }

                $objimage->save($newNameS,$type);
                $fName = $imageSName;
            } else if ($isCopied && $op == 0) {
                $fName = $newNameS;
            }

        }
    }
    return $fName;
}

?>
