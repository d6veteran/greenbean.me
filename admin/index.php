<?php 

/********************************************************

Date Created : July 18, 2009, 9:53 am

Date Modified : July 18, 2009, 9:53 am 

File Comment : This submit file used to input a record in 

Table:user using MySql

********************************************************/

require_once "../config/functions.inc.php";

//validate_admin();

if($_SESSION['username']=='admin')
{
	header("location: welcome.php");
	exit;
}


if($_POST){

$count=0;
$sql="select * from admin where username='".$_POST['txtUsername']."' and password='".$_POST['txtPassword']."'" ;
$fetch=mysql_query($sql);
$info=mysql_fetch_array($fetch);
$row=mysql_num_rows($fetch);

if($row>0){
		$_SESSION['username']=$_POST['txtUsername'];
		$_SESSION['password']=$_POST['txtPassword'];
		header("location:welcome.php");
		exit;
	}
	
	else{
		$count++;
		$msg= "Entered Username or password is invalid";
		
		//exit;
	}
	

}
?>

<HTML>

<HEAD>

<link rel="stylesheet" href="css/css.css" type="text/css">

<!-- Css file for left menu -->

<link rel='stylesheet' type='text/css' href='js/menu/css/office_xp.css'>

<TITLE> <?=$ADMIN_HTML_TITLE?> </TITLE>

<script>
</script>

<!-- JS files for left menu -->

<script type='text/javascript' src='js/menu/jsdomenu.js'></script>

<script type='text/javascript' src='js/menu/data.inc.js'></script>

<link rel='stylesheet' type='text/css' media='all' href='../js/cal/skins/aqua/theme.css' >

<script type='text/javascript' src='../js/cal/calendar.js'></script>

<script type='text/javascript' src='../js/cal/lang/calendar-en.js'></script>

<script type='text/javascript' src='../js/cal/calendar-setup.js'></script>



</HEAD>

<body  topmargin="0" leftmargin="0" rightmargin="0">


<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2"><? include("header.inc.php");?></td>

  </tr>

  <tr>

    <td width="20%" bgcolor="#f2f2f2"><? //include("left.inc.php");?></td>

    <td width="93%"><table width="98%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1"  style="margin:12px 0 0 20px">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" class="h1"><img src="images/sysinfo.png" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Restricted Area</span></span></td>

                <td width="24%" align="right">&nbsp;</td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>

          

<form name="frmLogin" action="index.php" method="post" >
				<table width="50%" align="center" cellpadding="2" cellspacing="0" border="0">
					
					<tr>
					<td colspan="3" style="padding:0 0 0 75px"><h3 style="font-family:Georgia, 'Times New Roman', Times, serif"><?php if($count>0){echo $msg;} ?></h3></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td align="right"><strong>Username</strong></td>
						<td align="center" width="5%"><strong>:</strong></td>
						<td align="left"><input type="text" name="txtUsername" id="txtUsername" value="" /></td>
					</tr>
					<tr>
						<td align="right"><strong>Password</strong></td>
						<td align="center" width="5%"><strong>:</strong></td>
						<td align="left"><input type="password" name="txtPassword" id="txtPassword" value="" /></td>
					</tr>
					<tr>
						<td style="padding:0 0 0 184px;" colspan="3"><input type="Submit" name="btnSubmit" value="Login" /></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
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

