<?php 

/********************************************************

Date Created : September 14, 2009, 7:00 am

Date Modified : September 14, 2009, 7:00 am 

File Comment : This file used to delete/activate/deactivate/featured 

entry from Table:fd_business using MySql

********************************************************/

require_once "../config/functions.inc.php";

validate_admin();

$arr =$_POST['ids'];

$Submit =$_POST['Submit'];

if(count($arr)>0){

	$str_rest_refs=implode(",",$arr);

	if($Submit=='Delete')

	{
	$sql="delete from fd_business_review where business_review_id in ($str_rest_refs)"; 

	executeUpdate($sql);

	$sess_msg="Selected Record(s) Deleted Successfully";

	$_SESSION['sess_msg']=$sess_msg;



	}

}

else{

$sess_msg="Please select Check Box";

$_SESSION['sess_msg']=$sess_msg;

header("Location: ".$_SERVER['HTTP_REFERER']);

exit();

}



header("Location: manage_business_post_notes.php");

exit();

?>