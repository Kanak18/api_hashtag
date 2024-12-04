<?php
if(isset($CheckSession) && $CheckSession=="Yes")
{
	if(!isset($_SESSION["Loggedin"]) || $_SESSION["Loggedin"] != "I am The User Logged In" || !isset($_SESSION["Loggedin_Id"]) || intval($_SESSION["Loggedin_Id"])==0)
	{
		header("Location: index.php?err=expired");
		exit;
	}
}
?>