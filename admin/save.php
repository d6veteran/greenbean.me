<?php 


/********************************************************

Date Created : July 18, 2009, 9:53 am

Date Modified : July 18, 2009, 9:53 am 

File Comment : This submit file used to input a record in 

Table:user using MySql

********************************************************/

require_once "../config/functions.inc.php";

//validate_admin();

@extract($_POST);


if($_POST['task']=='yes')
{
	$mail_name=$_POST['mname'];	
	$subject=$_POST['subj'];	
	$text=htmlspecialchars(addslashes(htmlentities($_POST['data'])));	
	
	$query="update system_email set systemmail_subject='$subject', systemmail_body='$text' where systemmail_name='".$mail_name."'";
	$res=mysql_fetch_row(mysql_query($query));
	echo "Template Editted Successfully";
	exit;
}



//===========================adding category================================
if($_POST['chk']=='addcat')
{
	$catname=addslashes(htmlentities($_POST['name']));
	$catid=addslashes(htmlentities($_POST['cid']));
	$catstatus=$_POST['status'];
	
	$query="insert into gb_tags set label='$label'";
	mysql_query($query) or die(mysql_error());
	echo "Add Tag Added Successfully";
	exit;
}
if($_POST['edcat']=='editcat')
{
	$catname=addslashes(htmlentities($_POST['name']));
	$catid=addslashes(htmlentities($_POST['cid']));
	$catstatus=$_POST['status'];
	$result=mysql_query("select categoryId from fd_category where category_name='$catname'");
	$row=mysql_fetch_assoc($result);
	$id=$row['categoryId'];
	$query="update fd_category set category_name='$catname', status='$catstatus', level='$catid' where categoryId='$id'";
	mysql_query($query) or die(mysql_error());
	echo "Category Edited Successfully";
	exit;
}//=========================end==============================================



//===========================adding user================================
if($_POST['chk']=='adduser')
{
	$username=$_POST['name'];
	$emailid=$_POST['emailid'];
	$password=$_POST['pwd'];
	$firstname=$_POST['fstname'];
	$lastname=$_POST['lstname'];
	$companyname=$_POST['cname'];
	$signupDate=time();
	$ipadd=$_SERVER['REMOTE_ADDR'];
	$status='1';
	if($_POST['status']=='Active'){$status='1';}else{$status='0';}
	
	$query="insert into fd_user(user_name, emailid, password, first_name, last_name, company_name, signup_date, ip_add, status) value('$username','$emailid','$password','$firstname','$lastname','$companyname','$signupDate','$ipadd','$status')";
	mysql_query($query);
	echo "User Added Successfully";
	exit;
}
//=========================end==============================================

?>
