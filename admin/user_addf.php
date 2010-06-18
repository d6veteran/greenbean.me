<?php 

/********************************************************

Date Created : September 15, 2009, 8:28 am

Date Modified : September 15, 2009, 8:28 am 

File Comment : This submit file used to input a record in 

Table:fd_user using MySql

********************************************************/

require_once "../config/functions.inc.php";

//validate_admin();

@extract($_POST);



if ($_POST['submitForm'] == "yes") {

	$file_upload_folder="../uploaded_files/news_image/";

	if(is_uploaded_file($HTTP_POST_FILES['user_picture']['tmp_name'])){

$user_picture		=	$_FILES['user_picture']['name'];

$ext	=	strtolower(strrchr($user_picture,'.'));

$random_number		=	date("U");

$user_picture			=	"user_picture_".$random_number.$ext;

$file_upload_path = $file_upload_folder.$user_picture;

copy($HTTP_POST_FILES['user_picture']['tmp_name'], $file_upload_path);

}

if(is_array($user_picture)) $user_picture='';



	if($user_id==''){

	$sql="insert into fd_user(facebook_id,twitter_id,token,token_secretkey,user_name,account_type,emailid,password,first_name,last_name,company_name,address,city,state,countryid,description,signup_date,last_update_date,user_picture,ip_add,status,zipcode)values

	('$facebook_id','$twitter_id','$token','$token_secretkey','$user_name','$account_type','$emailid','$password','$first_name','$last_name','$company_name','$address','$city','$state','$countryid','$description','$signup_date','$last_update_date','$user_picture','$ip_add','$status','$zipcode')";

	executeUpdate($sql);

	}else{

	$sql="update fd_user set facebook_id='$facebook_id',twitter_id='$twitter_id',token='$token',token_secretkey='$token_secretkey',user_name='$user_name',account_type='$account_type',emailid='$emailid',password='$password',first_name='$first_name',last_name='$last_name',company_name='$company_name',address='$address',city='$city',state='$state',countryid='$countryid',description='$description',signup_date='$signup_date',last_update_date='$last_update_date',user_picture='$user_picture',ip_add='$ip_add',status='$status',zipcode='$zipcode' ";

	if(is_uploaded_file($HTTP_POST_FILES['user_picture']['tmp_name'])){

$sql_pre="select user_picture from fd_user where user_id='$user_id'";

$prefile=getSingleResult($sql_pre);

@unlink($file_upload_folder.$prefile);

$sql.=" , user_picture='$user_picture'"; 

}



	$sql.=" where user_id='$user_id'";

	//echo "<br> $sql <br>";

	executeUpdate($sql);

	}

	$_SESSION['frm_arr']='';

	header("Location: user_list.php");

	exit();

}

$user_id=$_REQUEST['user_id'];

if (is_array($_POST) && count($_POST)>0) {

	@extract($_POST);

}

elseif (trim($user_id) != "") {

	$sql="select * from fd_user where user_id='$user_id'";

	$result=executequery($sql);

	$num=mysql_num_rows($result);

	$line=ms_stripslashes(mysql_fetch_array($result));

	@extract($line);



}



//if($frm_arr!='') @extract($frm_arr);



$path="../uploaded_files/news_image/";

?>

<HTML>

<HEAD>

<link rel="stylesheet" href="css/css.css" type="text/css">

<!-- Css file for left menu -->

<link rel='stylesheet' type='text/css' href='js/menu/css/office_xp.css'>

<TITLE> <?=$ADMIN_HTML_TITLE?> </TITLE>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.tablednd_0_5.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script>

function trim(s) {

  while (s.substring(0,1) == ' ') {

    s = s.substring(1,s.length);

  }

  while (s.substring(s.length-1,s.length) == ' ') {

    s = s.substring(0,s.length-1);

  }

  return s;

}



function validate_form(objfrm)

{

	msg="Sorry, we cannot complete your request.\nKindly provide us the missing or incorrect information enclosed below.\n\n";

	//if(trim(objfrm.user_id.value)=='')	msg+='- Please Enter User id \n';
//if(trim(objfrm.facebook_id.value)=='')	msg+='- Please Enter Facebook id \n';
//if(trim(objfrm.twitter_id.value)=='')	msg+='- Please Enter Twitter id \n';
//if(trim(objfrm.token.value)=='')	msg+='- Please Enter Token \n';
//if(trim(objfrm.token_secretkey.value)=='')	msg+='- Please Enter Token secretkey \n';

if(trim(objfrm.user_name.value)=='')	msg+='- Please Enter User name \n';

//if(trim(objfrm.account_type.value)=='')	msg+='- Please Enter Account type \n';

if(trim(objfrm.emailid.value)=='')	msg+='- Please Enter Emailid \n';
if(trim(objfrm.password.value)=='')	msg+='- Please Enter Password \n';
if(trim(objfrm.first_name.value)=='')	msg+='- Please Enter First name \n';
if(trim(objfrm.last_name.value)=='')	msg+='- Please Enter Last name \n';
if(trim(objfrm.company_name.value)=='')	msg+='- Please Enter Company name \n';

//if(trim(objfrm.address.value)=='')	msg+='- Please Enter Address \n';
//if(trim(objfrm.city.value)=='')	msg+='- Please Enter City \n';
//if(trim(objfrm.state.value)=='')	msg+='- Please Enter State \n';
//if(trim(objfrm.countryid.value)=='')	msg+='- Please Enter Countryid \n';
//if(trim(objfrm.description.value)=='')	msg+='- Please Enter Description \n';
//if(trim(objfrm.signup_date.value)=='')	msg+='- Please Enter Signup date \n';
//if(trim(objfrm.last_update_date.value)=='')	msg+='- Please Enter Last update date \n';
//if(trim(objfrm.user_picture.value)=='')	msg+='- Please Enter User picture \n';
//if(trim(objfrm.ip_add.value)=='')	msg+='- Please Enter Ip add \n';

if(trim(objfrm.status.value)=='')	msg+='- Please Enter Status \n';

//if(trim(objfrm.zipcode.value)=='')	msg+='- Please Enter Zipcode \n';




	if(msg!="Sorry, we cannot complete your request.\nKindly provide us the missing or incorrect information enclosed below.\n\n")

	{

		alert(msg)

		return false;

	}

	else

	{

		return true;

	}

}



function save_user()
{
	var usrname=$("#user_name").val();
	var uemail=$("#emailid").val();
	var upwd=$("#password").val();
	var ufirstName=$("#first_name").val();
	var ulastName=$("#last_name").val();
	var ucompanyName=$("#company_name").val();
	var ustatus=$("#status").val();
	alert(usrname + uemail + upwd + ufirstName + ulastName + ucompanyName + ustatus );
	if(!usrname || !uemail || !upwd || !ufirstName || !ulastName || !ucompanyName || !ustatus )
	{
		alert("please enter all required fields");
		return false;
	}else{
		//alert(usrname + uemail + upwd + ufirstName + ulastName + ucompanyName + ustatus );
		$.post("save.php", {name: usrname, emailid: uemail, pwd: upwd,  fstname: ufirstName, lstname:ulastName, cname: ucompanyName, status: ustatus,  chk: "adduser"}, 							function(response){
			alert(response);
		});
	}
}


</script>

<!-- JS files for left menu -->

<script type='text/javascript' src='js/menu/jsdomenu.js'></script>

<script type='text/javascript' src='js/menu/data.inc.js'></script>

</HEAD>

<body  topmargin="0" leftmargin="0" rightmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2"><? include("header.inc.php");?></td>

  </tr>

  <tr>

    <td width="20%" bgcolor="#f2f2f2" valign="top" align="left" style="padding-top:15px;"><? include("left.inc.php");?></td>

    <td width="93%" valign="top"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:24px 0 0 5px;">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">User Manager</span></span></td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>

          

<form action="user_addf.php" method="post" enctype="multipart/form-data" name="form1"  onSubmit="return validate_form(this)">

<input type="hidden" name="submitForm" value="yes">

<table width="80%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">

<TR bgcolor="#638EC0" align="left"> 

<TD height="25" colspan="2" class="header_bg"><?php if($user_id==''){?>Add New<?php }else{?>Edit<?php }?> 

User</TD>

</TR>

<?php if($_SESSION['sess_msg']!=''){?>

<tr>

<td colspan="2" align="center"  class="sess_msg_red" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?>

</td>

</tr>

<?php }?>

<input type="hidden" name=user_id class=textfield value="<?=$user_id?>">
<!--<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Facebook id</TD><TD width='78%'><input type='text' size=35 name=facebook_id class=textfield value="<?//=$facebook_id?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Twitter id</TD><TD width='78%'><input type='text' size=35 name=twitter_id class=textfield value="<?//=$twitter_id?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Token</TD><TD width='78%'><input type='text' size=35 name=token class=textfield value="<?//=$token?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Token secretkey</TD><TD width='78%'><input type='text' size=35 name=token_secretkey class=textfield value="<?//=$token_secretkey?>"></TD></TR>-->

<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>User name</TD><TD width='78%'><input type='text' size=35 name="user_name" id="user_name" class=textfield value="<?=$user_name?>"></TD></TR>

<!--<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Account type</TD><TD width='78%'><input type='text' size=35 name=account_type class=textfield value="<?//=$account_type?>"></TD></TR>-->

<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Emailid</TD><TD width='78%'><input type='text' size=35 name="emailid" id="emailid" class=textfield value="<?=$emailid?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Password</TD><TD width='78%'><input type='password' size=35 name="password" id="password" class=textfield /></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>First name</TD><TD width='78%'><input type='text' size=35 name="first_name" id="first_name" class=textfield value="<?=$first_name?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Last name</TD><TD width='78%'><input type='text' size=35 name="last_name" id="last_name" class=textfield value="<?=$last_name?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Company name</TD><TD width='78%'><input type='text' size=35 name="company_name" id="company_name" class=textfield value="<?=$company_name?>"></TD></TR>

<!--<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Address</TD><TD width='78%'><textarea name=address id=address cols='60' rows='7' class=textfield><?//=$address?></textarea></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>City</TD><TD width='78%'><input type='text' size=35 name=city class=textfield value="<?//=$city?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>State</TD><TD width='78%'><input type='text' size=35 name=state class=textfield value="<?//=$state?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Countryid</TD><TD width='78%'><input type='text' size=35 name=countryid class=textfield value="<?//=$countryid?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Description</TD><TD width='78%'><input type='text' size=35 name=description class=textfield value="<?//=$description?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Signup date</TD><TD width='78%'><input type='text' size=35 name=signup_date class=textfield value="<?//=$signup_date?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Last update date</TD><TD width='78%'><input type='text' size=35 name=last_update_date class=textfield value="<?//=$last_update_date?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>User picture</TD><TD width='78%'><?if($user_picture!=''){?><img src='<?//=$path.$user_picture?>' width=100 border='0'><?}?><br><input type="file" name=user_picture class=textfield ></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Ip add</TD><TD width='78%'><input type='text' size=35 name=ip_add class=textfield value="<?//=$ip_add?>"></TD></TR>-->

<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Status</TD><TD width='78%'><select name="status" id="status" class=textfield>
<option value="Active" selected>Active</option>
<option value="Inactive">Inactive</option>
</select>
</TD></TR>

<!--<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Zipcode</TD><TD width='78%'><input type='text' size=35 name=zipcode class=textfield value="<?//=$zipcode?>"></TD></TR>-->


<tr  class="evenRow">

<td align="center">&nbsp;</td><td><input name="Submit" type="button" class="buttons" value="<?php if($user_id==''){?>Add<?php }else{?>Edit<? }?> User" onClick="return save_user();"></td></tr>

</table>

</form>

 <br>

        </td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td colspan="2"><? include("footer.inc.php");?></td>

  </tr>

</table>









<body>

</HTML>

