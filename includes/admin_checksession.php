<?php 
 $FilePos = strrpos($_SERVER["SCRIPT_NAME"],"/");

if($FilePos!==false)
{
	$FileURL = substr($_SERVER["SCRIPT_NAME"], $FilePos);
	
	if(strpos($FileURL,"index.php")===false)
	{
		if(!isset($_SESSION["logged_admin"]) || $_SESSION["logged_admin"] != "I am The Admin Logged In" /*|| !isset($_SESSION["logged_subadmin"]) || $_SESSION["logged_admin"] != "I am The Sub Admin Logged In"*/ )
		{
			header ("Location:index.php?err=expired");
			exit;
		}
	}
}
?>