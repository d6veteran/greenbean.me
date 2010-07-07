<?php 

/********************************************************

Date Created : September 14, 2009, 11:44 am

Date Modified : September 14, 2009, 11:44 am 

File Comment : This submit file used to input a record in 

Table:fd_category using MySql

********************************************************/

require_once "../config/functions.inc.php";


//validate_admin();
$catID=$_GET['cat_id'];

@extract($_POST);



if ($_POST['submitForm'] == "yes") {

	$file_upload_folder="../uploaded_files/news_image/";

	echo $categoryId;exit;

	if($categoryId==''){

	$sql="insert into fd_category(category_name,level,path,status,extra1)values

	('$category_name','$level','$path','$status','$extra1')";

	executeUpdate($sql);

	}else{

	$sql="update fd_category set category_name='$category_name',level='$level',path='$path',status='$status',extra1='$extra1' ";

	

	$sql.=" where categoryId='$categoryId'";

	//echo "<br> $sql <br>";

	executeUpdate($sql);

	}

	$_SESSION['frm_arr']='';

	header("Location: category_list.php");

	exit();

}

$categoryId=$_REQUEST['categoryId'];

if (is_array($_POST) && count($_POST)>0) {

	@extract($_POST);

}

elseif (trim($categoryId) != "") {

	$sql="select * from fd_category where categoryId='$categoryId'";

	$result=executequery($sql);

	$num=mysql_num_rows($result);

	$line=ms_stripslashes(mysql_fetch_array($result));

	@extract($line);



}



//if($frm_arr!='') @extract($frm_arr);



$path="../uploaded_files/news_image/";


function get_category(){
	$sql="select category_name from fd_category where level=0";
	$catName=mysql_fetch_array(mysql_query($sql));
	return $catName['category_name'];
}


function get_subCategory(){
	
}

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

	if(trim(objfrm.categoryId.value)=='')	msg+='- Please Enter CategoryId \n';
if(trim(objfrm.category_name.value)=='')	msg+='- Please Enter Category name \n';
if(trim(objfrm.level.value)=='')	msg+='- Please Enter Level \n';
if(trim(objfrm.path.value)=='')	msg+='- Please Enter Path \n';
if(trim(objfrm.status.value)=='')	msg+='- Please Enter Status \n';
if(trim(objfrm.extra1.value)=='')	msg+='- Please Enter Extra1 \n';




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
<script type="text/javascript">
function save_cat()
{
	var catid=document.getElementById('p_category_name').value;
	var catname=document.getElementById('category_name').value;
	var catstatus=document.getElementById('status').value;
	
	if(!catname)
	{
		alert("Please Enter category Name");
		return false;
	}else{
	$.post("save.php", {cid: catid, name: catname, status: catstatus, edcat: "editcat"}, function(response){
		alert(response);
	});
	}
	//alert(catname);
}
</script>

</HEAD>

<body  topmargin="0" leftmargin="0" rightmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2"><? include("header.inc.php");?></td>

  </tr>

  <tr>

    <td width="20%" bgcolor="#f2f2f2" valign="top" align="left" style="padding-top:15px;"><? include("left.inc.php");?></td>

    <td width="93%" valign="top"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:25px 0 0 4px;">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Category Manager</span></span></td>

                <td width="24%" align="right"><a href="[ADDF FILE]"><!--Add New Record--></a></td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>

          

<form action="category_addf.php" method="post" enctype="multipart/form-data" name="form1"  onSubmit="return validate_form(this)">

<input type="hidden" name="submitForm" value="yes">

<table width="80%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">

<TR bgcolor="#638EC0" align="left"> 

<TD height="25" colspan="2" class="header_bg"><?php if($categoryId==''){?>Add New<?php }else{?>Edit<?php }?> 

Category</TD>

</TR>


<?php if($_SESSION['sess_msg']!=''){?>

<tr>

<td colspan="2" align="center"  class="sess_msg_red" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?>

</td>

</tr>

<?php }?>
 <?php 
 $result=mysql_query("select * from fd_category where categoryId='$catID' ");
	$row=mysql_fetch_assoc($result);
	$catlevel=$row['level'];
	?>
<input type="hidden" name=categoryId class=textfield value="<?=$catID?>">
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Category name</TD><TD width='78%'><select  name="p_category_name" id="p_category_name" class=textfield value="<?=$category_name?>">
<!--<option value="parent">Parent</option>-->


<? $sql="select * from fd_category where level=0";
	$res=mysql_query($sql);
	while($catName=mysql_fetch_array($res))
	{  ?>
<option value="<?=$catName['categoryId']?>"
	<? if($catlevel==0)
	{ if($catID == $catName["categoryId"])
			echo "selected";
	}
	else
	{	if($catlevel == $catName["categoryId"])
			echo "selected";
	}
?> > <?=$catName['category_name']?></option>
		
	<?php 	}
	?>


</select>
</TD></TR>

<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Main/Sub Category name</TD><TD width='78%'><input type='text' size=35 name="category_name" id="category_name" class=textfield value="<?php
															if($catlevel!=0){
															echo $row['category_name'];
															}
															?>" ></TD></TR>
<!--<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Level</TD><TD width='78%'><input type='text' size=35 name=level class=textfield value="<?//=$level?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Path</TD><TD width='78%'><input type='text' size=35 name=path class=textfield value="<?//=$path?>"></TD></TR>-->

<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Status</TD><TD width='78%'>
<select id="status" name="status">
<option value="Active" <?php if($row['status']== 'Active') echo "selected" ?>>Active</option>
<option value="Inactive" <?php if($row['status']== 'Inactive')echo "selected" ?> >Inactive</option>
</select>
</TD></TR>

<!--<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Extra1</TD><TD width='78%'><input type='text' size=35 name=extra1 class=textfield value="<?//=$extra1?>"></TD></TR>-->


<tr  class="evenRow">

<td align="center">&nbsp;</td><td><input name="Submit" id="Submit" type="button" class="buttons" value="<?php if($categoryId==''){?>Add<?php }else{?>Edit<? }?>" onClick="return save_cat();"></td></tr>

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
