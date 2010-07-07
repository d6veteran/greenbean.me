<?php 

/********************************************************

Date Created : September 14, 2009, 11:44 am

Date Modified : September 14, 2009, 11:44 am 

File Comment : This submit file used to input a record in 

Table:fd_category using MySql

********************************************************/

require_once "../config/functions.inc.php";

if($_SESSION['username'] == '' ){
		$msg= "Entered Username or password is invalid";
		header("location:index.php");
	}

@extract($_POST);



if ($_POST['submitForm'] == "yes") {

	$file_upload_folder="../uploaded_files/news_image/";
	if($page_title!=''){
		$page_title=$_POST['page_title'];
		$page_content=$_POST['page_content'];
		$page_alias=$_POST['page_alias'];
		$sql="insert into gb_pages(page_title,page_content,page_alias)values('$page_title','$page_content','$page_alias')";
		mysql_query($sql);
		header("location: page_addf.php");
	}

}
?>

<HTML>

<HEAD>

<link rel="stylesheet" href="css/css.css" type="text/css">
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
if(trim(objfrm.page_title.value)=='')	msg+='- Please Enter Page Title \n';
if(trim(objfrm.page_alias.value)=='')	msg+='- Please Enter Page Alias \n';

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
<script type='text/javascript' src='js/menu/jsdomenu.js'></script>
<script type='text/javascript' src='js/menu/data.inc.js'></script>
<script type="text/javascript">
function save_cat()
{
	var catid=document.getElementById('tag_name').value;
	var catname=document.getElementById('add_by').value;
	//var catstatus=document.getElementById('status').value;
	if(!catname)
	{
		alert("Please Enter Tag");
		return false;
	}else{
	$.post("save.php", {cid: catid,chk: "addcat"}, function(response){
		alert(response);
	});
	}
}
</script>
<script type="text/javascript" src="../public/jscripts/tiny_mce/tiny_mce.js"></script>
<script>

tinyMCE.init({

	theme : "advanced",

	plugins : "style,layer,table,save,advhr,preview,flash,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable",

		

	theme_advanced_buttons1_add : "fontselect,fontsizeselect",

	

	theme_advanced_buttons2_add_before: "pasteword,separator,search,replace,separator",

	//content_css : "<?php /*echo base_url();*/?>public/css/dailysms.css",

	

	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",

	external_image_list_url : "example_image_list.js",

	file_browser_callback : "fileBrowserCallBack",

	mode : "textareas"	

});

function fileBrowserCallBack(field_name, url, type, win){}

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
                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Add New Page </span></span></td>
                <td width="24%" align="right"><a href="[ADDF FILE]"><!--Add New Record--></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>
<form action="" method="post" enctype="multipart/form-data" name="form1"  onSubmit="return validate_form(this)">
<input type="hidden" name="submitForm" value="yes">
<table width="80%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">
<TR bgcolor="#638EC0" align="left"> 
<TD height="25" colspan="2" class="header_bg">Add New 
Page</TD>
</TR>
<?php if($_SESSION['sess_msg']!=''){?>
<tr>
<td colspan="2" align="center"  class="sess_msg_red" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></td>
</tr>
<?php }?>
<input type="hidden" name="tag_id" class="textfield" value="<?=$tag_id?>">
<TR class='oddRow'>
  <TD width='22%' align='right' class='fields_txt'>Page Title * : </TD>
  <TD width='78%'><input type='text' size=35 name="page_title" id="page_title" class="textfield" >
</TD></TR>
<TR class='oddRow'>
  <TD width='22%' align='right' class='fields_txt'>Page Alias * : </TD>
  <TD width='78%'><input type='text' size=35 name="page_alias" id="page_alias" class="textfield" >
</TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt' valign="top">Page Content: </TD><TD width='78%'><textarea id="page_content" cols="60" rows="20" name="page_content"  class="textarea"> </textarea>
</TD></TR>
<tr  class="evenRow">
    </tr>
<tr  class="oddRow">
<td align="center">&nbsp;</td><td><input name="Submit" id="Submit" type="submit" value="Add Page" class="buttons"></td></tr>
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

