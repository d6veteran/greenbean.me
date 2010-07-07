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

if($_GET['id']==1)
{
$page_name="About Us";
$count=1;
}
else if($_GET['id']==2)
{
$page_name="Contact Us";
$count=2;
}
else if($_GET['id']==3)
{
$page_name="Terms & Conditions";
$count=3;
}
else if($_GET['id']==4)
{
$page_name="Faq's";
$count=4;
}
else if($_GET['id']==5)
{
$page_name="Privacy Policy";
$count=5;
}
else if($_GET['id']==6)
{
$page_name="Newsletter";
$count=5;
}


?>

<HTML>

<HEAD>

<link rel="stylesheet" href="css/css.css" type="text/css">

<!-- Css file for left menu -->

<link rel='stylesheet' type='text/css' href='js/menu/css/office_xp.css'>

<TITLE> <?=$ADMIN_HTML_TITLE?> </TITLE>
<!-- JS files for left menu -->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.tablednd_0_5.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type='text/javascript' src='js/menu/jsdomenu.js'></script>
<script type='text/javascript' src='js/menu/data.inc.js'></script>

<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>

<script language="javascript">

window.onload = function() 

{
var sBasePath = 'FCKeditor/' ;
var oFCKeditor = new FCKeditor('textarea_name') ;
oFCKeditor.BasePath	= sBasePath ;
oFCKeditor.Width = '800px';
oFCKeditor.Height = '400px';
oFCKeditor.ReplaceTextarea() ;

}


function cancel_me()
{
window.location="manage_cms.php";	
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

    <td width="93%"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:24px 0 0 5px;">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Edit <?=$page_name?></span></span></td>

                <td width="24%" align="right"><a href="[ADDF FILE]"></a></td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>
<table cellpadding="10" cellpadding="0" border="0">
<tr>
<td class="header_bg">Page Title</td><td class="evenRow"><?=$page_name?></td>
</tr>
<tr>
<td class="header_bg" valign="top">Page Description</td><td><textarea id="textarea_name" name="textarea_name" ></textarea></td>
</tr>
<tr>
<td colspan="2">
<p align="left">
<input type="button" name="update" id="update" value="Update" />
<input type="button" name="cancel" id="cancel" value="Cancel" onClick="return cancel_me();" />
</p>
</td>
</tr>
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

