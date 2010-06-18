<?php 
/********************************************************
Date Created : September 14, 2009, 7:00 am
Date Modified : September 14, 2009, 7:00 am 
File Comment : This submit file used to input a record in 
Table:fd_business using MySql
********************************************************/
require_once "../config/functions.inc.php";
//validate_admin();
@extract($_POST);

if ($_POST['submitForm'] == "yes") {
	$file_upload_folder="../uploaded_files/news_image/";
	if(is_uploaded_file($HTTP_POST_FILES['business_logo']['tmp_name'])){
$business_logo		=	$_FILES['business_logo']['name'];
$ext	=	strtolower(strrchr($business_logo,'.'));
$random_number		=	date("U");
$business_logo			=	"business_logo_".$random_number.$ext;
$file_upload_path = $file_upload_folder.$business_logo;
copy($HTTP_POST_FILES['business_logo']['tmp_name'], $file_upload_path);
}
if(is_array($business_logo)) $business_logo='';
if(is_uploaded_file($HTTP_POST_FILES['business_image']['tmp_name'])){
$business_image		=	$_FILES['business_image']['name'];
$ext	=	strtolower(strrchr($business_image,'.'));
$random_number		=	date("U");
$business_image			=	"business_image_".$random_number.$ext;
$file_upload_path = $file_upload_folder.$business_image;
copy($HTTP_POST_FILES['business_image']['tmp_name'], $file_upload_path);
}
if(is_array($business_image)) $business_image='';

	if($business_id==''){
	$sql="insert into fd_business(user_id,cat_id,business_name,country,state,zip_code,hometown,skyper_address,email_address,phone_no,fax_no,website_address,opening_hours,business_description,business_logo,business_image,business_add_date,business_updated_date)values
	('$user_id','$cat_id','$business_name','$country','$state','$zip_code','$hometown','$skyper_address','$email_address','$phone_no','$fax_no','$website_address','$opening_hours','$business_description','$business_logo','$business_image','$business_add_date','$business_updated_date')";
	executeUpdate($sql);
	}else{
	$sql="update fd_business set user_id='$user_id',cat_id='$cat_id',business_name='$business_name',country='$country',state='$state',zip_code='$zip_code',hometown='$hometown',skyper_address='$skyper_address',email_address='$email_address',phone_no='$phone_no',fax_no='$fax_no',website_address='$website_address',opening_hours='$opening_hours',business_description='$business_description',business_logo='$business_logo',business_image='$business_image',business_add_date='$business_add_date',business_updated_date='$business_updated_date' ";
	if(is_uploaded_file($HTTP_POST_FILES['business_logo']['tmp_name'])){
$sql_pre="select business_logo from fd_business where business_id='$business_id'";
$prefile=getSingleResult($sql_pre);
@unlink($file_upload_folder.$prefile);
$sql.=" , business_logo='$business_logo'"; 
}
if(is_uploaded_file($HTTP_POST_FILES['business_image']['tmp_name'])){
$sql_pre="select business_image from fd_business where business_id='$business_id'";
$prefile=getSingleResult($sql_pre);
@unlink($file_upload_folder.$prefile);
$sql.=" , business_image='$business_image'"; 
}

	$sql.=" where business_id='$business_id'";
	//echo "<br> $sql <br>";
	executeUpdate($sql);
	}
	$_SESSION['frm_arr']='';
	header("Location: manage_business_list.php");
	exit();
}
$business_id=$_REQUEST['business_id'];
if (is_array($_POST) && count($_POST)>0) {
	@extract($_POST);
}
elseif (trim($business_id) != "") {
	$sql="select * from fd_business where business_id='$business_id'";
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
	if(trim(objfrm.business_id.value)=='')	msg+='- Please Enter Business id \n';
if(trim(objfrm.user_id.value)=='')	msg+='- Please Enter User id \n';
if(trim(objfrm.cat_id.value)=='')	msg+='- Please Enter Cat id \n';
if(trim(objfrm.business_name.value)=='')	msg+='- Please Enter Business name \n';
if(trim(objfrm.country.value)=='')	msg+='- Please Enter Country \n';
if(trim(objfrm.state.value)=='')	msg+='- Please Enter State \n';
if(trim(objfrm.zip_code.value)=='')	msg+='- Please Enter Zip code \n';
if(trim(objfrm.hometown.value)=='')	msg+='- Please Enter Hometown \n';
if(trim(objfrm.skyper_address.value)=='')	msg+='- Please Enter Skyper address \n';
if(trim(objfrm.email_address.value)=='')	msg+='- Please Enter Email address \n';
if(trim(objfrm.phone_no.value)=='')	msg+='- Please Enter Phone no \n';
if(trim(objfrm.fax_no.value)=='')	msg+='- Please Enter Fax no \n';
if(trim(objfrm.website_address.value)=='')	msg+='- Please Enter Website address \n';
if(trim(objfrm.opening_hours.value)=='')	msg+='- Please Enter Opening hours \n';
if(trim(objfrm.business_description.value)=='')	msg+='- Please Enter Business description \n';
if(trim(objfrm.business_logo.value)=='')	msg+='- Please Enter Business logo \n';
if(trim(objfrm.business_image.value)=='')	msg+='- Please Enter Business image \n';
if(trim(objfrm.business_add_date.value)=='')	msg+='- Please Enter Business add date \n';
if(trim(objfrm.business_updated_date.value)=='')	msg+='- Please Enter Business updated date \n';


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


</script>
<!-- JS files for left menu -->
<script type='text/javascript' src='js/menu/jsdomenu.js'></script>
<script type='text/javascript' src='js/menu/data.inc.js'></script>

<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script language="javascript">
window.onload = function() 
{
	
	var sBasePath = "FCKeditor/";
	var oFCKeditor = new FCKeditor('article_intro_text','550','250') ;
	var oFCKeditor1 = new FCKeditor('article_main_text','550','400') ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.ReplaceTextarea() ;
	oFCKeditor1.BasePath = sBasePath ;
	oFCKeditor1.ReplaceTextarea() ;
	initjsDOMenu();
}
</script> 
</HEAD>
<body  topmargin="0" leftmargin="0" rightmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><? include("header.inc.php");?></td>
  </tr>
  <tr>
    <td width="20%" bgcolor="#f2f2f2"><? include("left.inc.php");?></td>
    <td width="93%"><table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1">
      <tr>
        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>
            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">BusinessManager</span></span></td>
                <td width="24%" align="right"><a href="[ADDF FILE]">Add New Record</a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="347" align="center" valign="top" bgcolor="#EEEEEE"><BR>
          
<form action="manage_business_addf.php" method="post" enctype="multipart/form-data" name="form1"  onSubmit="return validate_form(this)">
<input type="hidden" name="submitForm" value="yes">
<table width="80%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">
<TR bgcolor="#638EC0" align="left"> 
<TD height="25" colspan="2" class="header_bg"><?php if($business_id==''){?>Add New<?php }else{?>Edit<?php }?> 
fd_business Details</TD>
</TR>
<?php if($_SESSION['sess_msg']!=''){?>
<tr>
<td colspan="2" align="center"  class="sess_msg_red" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?>
</td>
</tr>
<?php }?>
<input type="hidden" name=business_id class=textfield value="<?=$business_id?>"><TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>User id</TD><TD width='78%'><input type='text' size=35 name=user_id class=textfield value="<?=$user_id?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Cat id</TD><TD width='78%'><input type='text' size=35 name=cat_id class=textfield value="<?=$cat_id?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Business name</TD><TD width='78%'><input type='text' size=35 name=business_name class=textfield value="<?=$business_name?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Country</TD><TD width='78%'><input type='text' size=35 name=country class=textfield value="<?=$country?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>State</TD><TD width='78%'><input type='text' size=35 name=state class=textfield value="<?=$state?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Zip code</TD><TD width='78%'><input type='text' size=35 name=zip_code class=textfield value="<?=$zip_code?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Hometown</TD><TD width='78%'><input type='text' size=35 name=hometown class=textfield value="<?=$hometown?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Skyper address</TD><TD width='78%'><input type='text' size=35 name=skyper_address class=textfield value="<?=$skyper_address?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Email address</TD><TD width='78%'><input type='text' size=35 name=email_address class=textfield value="<?=$email_address?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Phone no</TD><TD width='78%'><input type='text' size=35 name=phone_no class=textfield value="<?=$phone_no?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Fax no</TD><TD width='78%'><input type='text' size=35 name=fax_no class=textfield value="<?=$fax_no?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Website address</TD><TD width='78%'><input type='text' size=35 name=website_address class=textfield value="<?=$website_address?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Opening hours</TD><TD width='78%'><input type='text' size=35 name=opening_hours class=textfield value="<?=$opening_hours?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Business description</TD><TD width='78%'><textarea name=business_description id=business_description cols='60' rows='7' class=textfield><?=$business_description?></textarea></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Business logo</TD><TD width='78%'><?if($business_logo!=''){?><img src='<?=$path.$business_logo?>' width=100 border='0'><?}?><br><input type="file" name=business_logo class=textfield ></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Business image</TD><TD width='78%'><?if($business_image!=''){?><img src='<?=$path.$business_image?>' width=100 border='0'><?}?><br><input type="file" name=business_image class=textfield ></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Business add date</TD><TD width='78%'><input type='text' size=35 name=business_add_date class=textfield value="<?=$business_add_date?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Business updated date</TD><TD width='78%'><input type='text' size=35 name=business_updated_date class=textfield value="<?=$business_updated_date?>"></TD></TR>

<tr  class="evenRow">
<td align="center">&nbsp;</td><td><input name="Submit" type="submit" class="buttons" value="<?php if($business_id==''){?>Add<?php }else{?>Edit<? }?> fd_business Details"></td></tr>
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
