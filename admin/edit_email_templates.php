<?php 
/********************************************************
Date Created : August 18, 2009, 7:14 am
Date Modified : August 18, 2009, 7:14 am 
File Comment : This file used for show list of records from Table:protected_usernames
********************************************************/
require_once "../config/functions.inc.php";


if($_SESSION['username'] == '' ){
		$msg= "Entered Username or password is invalid";
		header("location:index.php");
		
	}
//validate_admin();
?>
<html>
<head>
<title><?php print $ADMIN_HTML_TITLE?></title>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>

<!-- JS files for left menu -->
<script type='text/javascript' src='js/menu/jsdomenu.js'></script>
<script type='text/javascript' src='js/menu/data.inc.js'></script>
<script type="text/javascript">
function from()
{
	$("#from").show();
	$("#registration").hide();
	$("#forgot_password").hide();
}

function verification()
{
	$("#from").hide();
	$("#verification").show();
	$("#forgot_password").hide();
}

function forgot_password()
{
	$("#from").hide();
	$("#verification").hide();
	$("#forgot_password").show();
}

var a="";
var b="";

function save_me(val, field1, field2)
{
	var subject=document.getElementById(field1).value;
	var text=document.getElementById(field2).value;
	//alert(val+"  "+subject+"  "+text);
	if(!val){ return false; }
	else{
		$.post("save.php", {mname: val, subj: subject, data: text, task: "yes"}, function(response){
		alert(response);
		});
	}
	
}

</script>

</head>
<style>

</style>
<!-- Css file for left menu -->
<link rel='stylesheet' type='text/css' href='js/menu/css/office_xp.css'>

<link rel="stylesheet" href="css/css.css" type="text/css">
<body  topmargin="0" leftmargin="0" rightmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><? include("header.inc.php");?></td>
  </tr>
  <tr>
    <td width="0%" bgcolor="#f2f2f2"  valign="top" align="left" style="padding-top:15px;"><? include("left.inc.php");?></td>
    <td width="93%"><table width="96%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1"  style="margin:23px 0 0 20px">
      <tr>
        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>
            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="76%" class="h1"><img src="images/email.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Email Manager</span></span></td>
                <td width="24%" align="right"><a href="p_usernames_addf.php"><!--Add New Record--></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>



<div id="menu">  
  
    <ul>  
  
        
        <li class="selected"><a href="javascript:void(0)" onClick="return verification();"><img src="user.png" id="verification_email1" width="32" height="32" alt="Verification" title=""></a></li>  
        <li><a href="javascript:void(0)" onClick="return forgot_password();"><img src="bookmark.png" id="forgot_password_email" width="32" height="32" alt="Forgot Password" title=""></a></li>  
  
        
  
    </ul>  
  
    <!-- If you want to make it even simpler, you can append these html using jquery -->  
    <div id="box"><div class="head"></div></div>  
      
</div>  


<br /><br /><br /><br />

<form name="form1">
<div id="main">         

<!--######################################################################-->
<?
$query="select systemmail_subject, systemmail_body from system_email where systemmail_name='verification'";
$res=mysql_fetch_row(mysql_query($query));
?>

<table id="verification" cellspacing="6" cellpadding="5" border="0" align="left" width="70%" style="padding:0 0 0 256px;">
<tr>
	<td colspan="3" style="background-color:#d5d5d5"><strong>Verification email</strong></td>
</tr>
<tr>
    <td colspan="3">This is the email sent when user needs to get verified on the website.</td>
</tr>
<tr>
    <td valign="top">Subject</td><td valign="top"> : </td><td><input type="text" id="from-subject" name="from-subject" value="<?=$res[0]?>" size="68px" /></td>
</tr>
<tr>
    <td valign="top">Message</td><td valign="top"> : </td><td><textarea id="from-body" name="from-body" style="width:434px; height:162px" ><? echo stripslashes(html_entity_decode($res[1])); ?></textarea></td>
</tr>

<tr>

	<td colspan="3" style="background-color:#d5d5d5"><span id="save" style="float:right"><a href="javascript:void(0)" onClick="return save_me('verification','from-subject', 'from-body')" class="savelink">Save Changes</a></span></td>
</tr>
<tr>
	<td>[username]</td><td>:</td><td>Replaced with the username of the recipient.</td>
</tr>
<tr>
	<td>[links]</td><td>:</td><td>Replaced with the link to the user's profile</td>
</tr>
</table>

<!--######################################################################-->
<?
$query="select systemmail_subject, systemmail_body from system_email where systemmail_name='forgot_password'";
$res=mysql_fetch_row(mysql_query($query));
?>

<table id="forgot_password" cellspacing="6" cellpadding="5" border="0" align="left" width="70%" style="padding:0 0 0 256px; display:none"">
<tr>
	<td colspan="3" style="background-color:#d5d5d5"><strong>Feed Post email</strong></td>
</tr>
<tr>
    <td colspan="3">This is the email sent when user requests for new password.</td>
</tr>
<tr>
    <td valign="top">Subject</td><td valign="top"> : </td><td><input type="text" id="ff_subject" name="ff_subject" value="<?=$res[0]?>" size="68px" /></td>
</tr>
<tr>
    <td valign="top">Message</td><td valign="top"> : </td><td><textarea id="ff_body" name="ff_body" style="width:434px; height:162px" ><?=$res[1]?></textarea></td>
</tr>

<tr>
	<td colspan="3" style="background-color:#d5d5d5"><span id="save" style="float:right"><a href="javascript:void(0)" onClick="return save_me('forgot_password','ff_subject','ff_body')" class="savelink">Save Changes</a></span></td>
</tr>
<tr>
	<td>[username]</td><td>:</td><td>Replaced with the username of the recipient.</td>
</tr>
<tr>
	<td>[links]</td><td>:</td><td>Replaced with the link to the user's profile</td>
</tr>
</table>

<!--######################################################################-->


</div>
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
</html>

<script type="text/javascript">
	
$(document).ready(function () {

	//transitions
	//for more transition, goto http://gsgd.co.uk/sandbox/jquery/easing/
	var style = 'easeOutExpo';
	var default_left = Math.round($('#menu li.selected').offset().left - $('#menu').offset().left);
	var default_top = $('#menu li.selected').height();

	//Set the default position and text for the tooltips
	$('#box').css({left: default_left, top: default_top});
	$('#box .head').html($('#menu li.selected').find('img').attr('alt'));				
		
	//if mouseover the menu item
	$('#menu li').hover(function () {
		
		//get the left pos	
		left = Math.round($(this).offset().left - $('#menu').offset().left);

		//Set it to current item position and text
		$('#box .head').html($(this).find('img').attr('alt'));
		$('#box').stop(false, true).animate({left: left},{duration:500, easing: style});	

		
	//if user click on the menu
	}).click(function () {
		
		//reset the selected item
		$('#menu li').removeClass('selected');	
		
		//select the current item
		$(this).addClass('selected');

	});
	
	//If the mouse leave the menu, reset the floating bar to the selected item
	$('#menu').mouseleave(function () {

		//get the left pos
		default_left = Math.round($('#menu li.selected').offset().left - $('#menu').offset().left);

		//Set it back to default position and text
		$('#box .head').html($('#menu li.selected').find('img').attr('alt'));				
		$('#box').stop(false, true).animate({left: default_left},{duration:1500, easing: style});	
		
	});
	
});


</script>