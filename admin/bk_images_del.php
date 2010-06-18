<?php 
/********************************************************
Date Created : September 15, 2009, 5:38 am
Date Modified : September 15, 2009, 5:38 am 
File Comment : This file used to delete/activate/deactivate/featured 
entry from Table:fd_backgroundimages using MySql
********************************************************/
require_once "../config/functions.inc.php";
validate_admin();
$arr =$_POST['ids'];
$Submit =$_POST['Submit'];
if(count($arr)>0){
	$str_rest_refs=implode(",",$arr);
	if($Submit=='Delete')
	{
	/*$unlink_folder="../uploaded_files/folder/";
	$sql_del="select * from fd_backgroundimages where id in ($str_rest_refs)"; 
	$result_del=executequery($sql_del);
	while($line_del=mysql_fetch_array($result_del))
	{
	$image=$line_del['image'];
	$unlink_path=$unlink_folder.$image;
	@unlink($unlink_path);
	}*/
	$sql="delete from fd_backgroundimages where id in ($str_rest_refs)"; 
	executeUpdate($sql);
	$sess_msg="Selected Record(s) Deleted Successfully";
	$_SESSION['sess_msg']=$sess_msg;

	}
	elseif($Submit=='Activate')
	{
	$sql="update fd_backgroundimages set status=1 where id in ($str_rest_refs)";
	executeUpdate($sql);
	$sess_msg="Selected Record(s) Activated Successfully";
	$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Deactivate')
	{
	$sql="update fd_backgroundimages set status=0 where id in ($str_rest_refs)"; 
	executeUpdate($sql);
	$sess_msg="Selected Record(s) Deactivated Successfully";
	$_SESSION['sess_msg']=$sess_msg;
	}
	elseif($Submit=='Featured')
	{
	$sql="update fd_backgroundimages set featured=0"; 
	executeUpdate($sql);
	$sql="update fd_backgroundimages set featured=1 where id in ($str_rest_refs)"; 
	executeUpdate($sql);
	$sess_msg="Selected Record(s) Made Featured Successfully";
	$_SESSION['sess_msg']=$sess_msg;
	}
}
else{
$sess_msg="Please select Check Box";
$_SESSION['sess_msg']=$sess_msg;
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
}

header("Location: bk_images_list.php");
exit();
?>