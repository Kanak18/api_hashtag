<?php
ignore_user_abort(false);
set_time_limit(0);

$myVals = array();

include("../includes/connection.php");
include("../includes/functions.php");



$str = file_get_contents('http://hashtagwebhub.com/services/get_all.php?cat_id=94&type=t');
$arrData = json_decode($str);





for($i=count($arrData->link_details)-1;$i>=0;$i--)
{
	echo "<br><hr>";
	echo "<br>".$arrData->link_details[$i]->title." -> ".$arrData->link_details[$i]->link;	
	echo "<br>".$arrData->link_details[$i]->post_date." -> ".$arrData->link_details[$i]->author_name;
	echo "<br>".$arrData->link_details[$i]->post_desc;
	echo "<br><hr>";

	echo $arrData->link_details[$i]->post_date = date("Y-m-d H:i",strtotime($arrData->link_details[$i]->post_date));

	
	
	$inserQury = "INSERT INTO `coin_link` (`user_id`, `link_title`, `link_desc`, `link_source`, `date_added`) VALUES ('".rand(0,25)."', '".$arrData->link_details[$i]->title."', '".$arrData->link_details[$i]->link."', '".$arrData->link_details[$i]->post_desc."', '".$arrData->link_details[$i]->post_date."')";
	mysql_query($inserQury);
} 
?>