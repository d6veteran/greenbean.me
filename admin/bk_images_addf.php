<?php 

/********************************************************

Date Created : September 15, 2009, 5:38 am

Date Modified : September 15, 2009, 5:38 am 

File Comment : This submit file used to input a record in 

Table:fd_backgroundimages using MySql

********************************************************/

require_once "../config/functions.inc.php";

//validate_admin();

@extract($_POST);



if ($_POST['submitForm'] == "yes") {

	$file_upload_folder="../uploaded_files/news_image/";

	if(is_uploaded_file($HTTP_POST_FILES['name']['tmp_name'])){

$name		=	$_FILES['name']['name'];

$ext	=	strtolower(strrchr($name,'.'));

$random_number		=	date("U");

$name			=	"name_".$random_number.$ext;

$file_upload_path = $file_upload_folder.$name;

copy($HTTP_POST_FILES['name']['tmp_name'], $file_upload_path);

}

if(is_array($name)) $name='';



	if($id==''){

	$sql="insert into fd_backgroundimages(name,extra)values

	('$name','$extra')";

	executeUpdate($sql);

	}else{

	$sql="update fd_backgroundimages set name='$name',extra='$extra' ";

	if(is_uploaded_file($HTTP_POST_FILES['name']['tmp_name'])){

$sql_pre="select name from fd_backgroundimages where id='$id'";

$prefile=getSingleResult($sql_pre);

@unlink($file_upload_folder.$prefile);

$sql.=" , name='$name'"; 

}



	$sql.=" where id='$id'";

	//echo "<br> $sql <br>";

	executeUpdate($sql);

	}

	$_SESSION['frm_arr']='';

	header("Location: bk_images_list.php");

	exit();

}

$id=$_REQUEST['id'];

if (is_array($_POST) && count($_POST)>0) {

	@extract($_POST);

}

elseif (trim($id) != "") {

	$sql="select * from fd_backgroundimages where id='$id'";

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
<script type="text/javascript" src="js/ajaxfileupload.js"></script>
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

	if(trim(objfrm.id.value)=='')	msg+='- Please Enter Id \n';
if(trim(objfrm.name.value)=='')	msg+='- Please Enter Name \n';
if(trim(objfrm.extra.value)=='')	msg+='- Please Enter Extra \n';




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


function save_image()
{
//alert("calling");	
//var path=document.getElementById('images').value;
//alert(path);

$("#busy").ajaxStart(function(){
			//$("#busy").show();
		}).ajaxComplete(function(){
			  //$("#busy").hide();
		});
		$.ajaxFileUpload
		({
				
				url:'site_photo_function.php?action=upload',
				secureuri: false,
				fileElementId: 'images',
				dataType: 'json',
				
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							//document.getElementById("error_msg_photo").innerHTML=data.error;
							//$("#error_msg_photo").show();
							alert(data.error);
							return false;
						}
					}
					alert("msg "+data.msg);
					//var myimagepath="../uploads/"+abc;
					
					
				}
		})


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

    <td width="93%"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:8px 0 0 4px;">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Site Background Images</span></span></td>

                <td width="24%" align="right"><a href="[ADDF FILE]"><!--Add New Record--></a></td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>

          

<form action="bk_images_addf.php" method="post" enctype="multipart/form-data" name="form1"  onSubmit="return validate_form(this)">

<input type="hidden" name="submitForm" value="yes">

<table width="80%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">

<TR bgcolor="#638EC0" align="left"> 

<TD height="25" colspan="2" class="header_bg"><?php if($id==''){?>Add New<?php }else{?>Edit<?php }?> 

Image</TD>

</TR>

<?php if($_SESSION['sess_msg']!=''){?>

<tr>

<td colspan="2" align="center"  class="sess_msg_red" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?>

</td>

</tr>

<?php }?>

<input type="hidden" name=id class=textfield value="<?=$id?>">
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Name</TD><TD width='78%'><?if($name!=''){?><img src='<?=$path.$name?>' width=100 border='0'><?}?><br><input type="file" name="images" id="images" class=textfield ></TD></TR>

<!--<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Extra</TD><TD width='78%'><input type='text' size=35 name=extra class=textfield value="<?//=$extra?>"></TD></TR>-->


<tr  class="evenRow">

<td align="center">&nbsp;</td><td><input name="Submit" type="button" class="buttons" value="<?php if($id==''){?>Add<?php }else{?>Edit<? }?> " onClick="return save_image();"></td></tr>

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
</body>

</HTML>

