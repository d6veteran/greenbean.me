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

</script> 

</HEAD>

<body  topmargin="0" leftmargin="0" rightmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2"><? include("header.inc.php");?></td>

  </tr>

  <tr>

    <td width="20%"  valign="top" align="left" style="padding-top:15px;" bgcolor="#f2f2f2"><? include("left.inc.php");?></td>

    <td width="93%" valign="top"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:24px 0 0 4px;">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Static Page Manager</span></span></td>

                <td width="24%" align="right"><a href="[ADDF FILE]"></a></td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>

<table cellpadding="10" cellspacing="0" border="0">
<tr bgcolor="#CCCCCC">
<td class="header_bg" width="150px">Title</td><td class="header_bg">Edit</td>
</tr>

<tr class="evenRow">
	<td width="50%">About Us</td><td><a href="pagedit.php?id=1">Edit</a></td>
</tr>

<tr class="oddRow">
	<td>Contact Us</td><td><a href="pagedit.php?id=2">Edit</a></td>
</tr>

<tr class="evenRow">
	<td>Terms & Conditions</td><td><a href="pagedit.php?id=3">Edit</a></td>
</tr>

<tr class="oddRow">
	<td>Faqs</td><td><a href="pagedit.php?id=4">Edit</a></td>
</tr>

<tr class="evenRow">
	<td>Privacy Policy</td><td><a href="pagedit.php?id=5">Edit</a></td>
</tr>

</table>



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

