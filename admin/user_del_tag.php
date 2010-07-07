<?php 



/********************************************************



Date Created : September 15, 2009, 8:28 am



Date Modified : September 15, 2009, 8:28 am 



File Comment : This file used to delete/activate/deactivate/featured 



entry from Table:gb_tags using MySql



********************************************************/



require_once "../config/functions.inc.php";



validate_admin();



$arr =$_POST['ids'];



$Submit =$_POST['Submit'];



if(count($arr)>0){



	$str_rest_refs=implode(",",$arr);



	if($Submit=='Delete')



	{



	$sql="delete from gb_tags where tag_id in ($str_rest_refs)"; 



	executeUpdate($sql);



	$sess_msg="Selected Record(s) Deleted Successfully";



	$_SESSION['sess_msg']=$sess_msg;







	}



	elseif($Submit=='Activate')



	{



	$sql="update gb_tags set status='Active' where tag_id in ($str_rest_refs)";



	executeUpdate($sql);



	$sess_msg="Selected Record(s) Activated Successfully";



	$_SESSION['sess_msg']=$sess_msg;



	}



	elseif($Submit=='Deactivate')



	{



	$sql="update gb_tags set status='Inactive' where tag_id in ($str_rest_refs)"; 



	executeUpdate($sql);



	$sess_msg="Selected Record(s) Deactivated Successfully";



	$_SESSION['sess_msg']=$sess_msg;



	}



	elseif($Submit=='Featured')



	{



	$sql="update gb_tags set featured=0"; 



	executeUpdate($sql);



	$sql="update gb_tags set featured=1 where tag_id in ($str_rest_refs)"; 



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







header("Location: category_addf.php");



exit();



?>