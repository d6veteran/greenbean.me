<?php 

/********************************************************

Date Created : September 15, 2009, 8:28 am

Date Modified : September 15, 2009, 8:28 am 

File Comment : This file used to delete/activate/deactivate/featured 

entry from Table:gb_users using MySql

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

	$sql_del="select * from fd_user where user_id in ($str_rest_refs)"; 

	$result_del=executequery($sql_del);

	while($line_del=mysql_fetch_array($result_del))

	{

	$image=$line_del['image'];

	$unlink_path=$unlink_folder.$image;

	@unlink($unlink_path);

	}*/

	$sql="delete from gb_users where user_userid in ($str_rest_refs)"; 

	executeUpdate($sql);

	$sess_msg="Selected Record(s) Deleted Successfully";

	$_SESSION['sess_msg']=$sess_msg;



	}

	elseif($Submit=='Activate')

	{

	$sql="update gb_users set user_status='Active' where user_userid in ($str_rest_refs)";

	executeUpdate($sql);

	$sess_msg="Selected Record(s) Activated Successfully";

	$_SESSION['sess_msg']=$sess_msg;

	}

	elseif($Submit=='Deactivate')

	{

	$sql="update gb_users set user_status='Inactive' where user_userid in ($str_rest_refs)"; 

	executeUpdate($sql);

	$sess_msg="Selected Record(s) Deactivated Successfully";

	$_SESSION['sess_msg']=$sess_msg;

	}

	elseif($Submit=='Featured')

	{

	$sql="update gb_users set featured=0"; 

	executeUpdate($sql);

	$sql="update gb_users set featured=1 where user_userid in ($str_rest_refs)"; 

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



header("Location: user_list.php");

exit();

?>