<?php 

/********************************************************

Date Created : July 18, 2009, 9:53 am

Date Modified : July 18, 2009, 9:53 am 

File Comment : This submit file used to input a record in 

Table:user using MySql

********************************************************/


require_once "../config/functions.inc.php";
if($_SESSION['username'] == '' ){
		$msg= "Entered Username or password is invalid";
		header("location:index.php");
		
	}

//validate_admin();

@extract($_POST);
//if($_SESSION['username'] != 'admin' && $_SESSION['password'] != 'admin'){
//		$msg= "Entered Username or password is invalid";
//		header("location:index.php");
//		exit;
//	}
	
//counting total number of users
/*$users_num="select count(*) from user";
$res=executequery($users_num);
$total_users=mysql_fetch_array($res);

$date_array= array();
// looking for new users
$date_now=time();
$date_nw=(date("Y m d",$date_now));

$sql="select sign_date from user";
$res=mysql_query($sql);
while($result=mysql_fetch_array($res))
{
$r_date=date("Y m d",$result[0]);

	if($r_date==$date_nw)
	{
		$date_array[]=$r_date;		
	}
}

$new_users_count=count($date_array);*/

/*$user_count="select count(*) from user where sign_date='$date_nw'";

$response=executequery($user_count);
$new_users_count=mysql_fetch_array($response);
 */


/*$date_now=date("Y-m-d");
$user_count="select count(username) from user where sign_date='$date_now'";
$response=executequery($user_count);
  $new_users_count=mysql_fetch_array($response);*/

// calculating number of bussiness
/*$business_count="select count(business_id) from fd_business";
$response1=executequery($business_count);
$business=mysql_fetch_array($response1);
$business_num=$business[0];*/



// calculating % of female users
/*$female_user_count="select count(sex) from user where sex='F'";
$response2=executequery($female_user_count);
$female_users=mysql_fetch_array($response2);
$female_users_per=round(($female_users[0]/$total_users[0])*100);*/


// calculating number of active products
/*$prod_count="select count(product_id) from fd_business_product where product_status='1'";
$response3=executequery($prod_count);
$products=mysql_fetch_array($response3);
$products_num=$products[0];*/

	
?>

<HTML>

<HEAD>

<link rel="stylesheet" href="css/css.css" type="text/css">

<!-- Css file for left menu -->

<link rel='stylesheet' type='text/css' href='js/menu/css/office_xp.css'>

<TITLE> <?=$ADMIN_HTML_TITLE?> </TITLE>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

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

    <td width="20%" bgcolor="#f2f2f2" valign="top" style="padding-top:15px;"><? include("left.inc.php");?></td>

    <td width="93%"><table width="98%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:25px 0 0 0">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#eeeeee" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" class="h1"><span class="verdana_small_white"><span class="white_bold_big">Welcome to ADMIN</span></span></td>

                <td width="24%" align="right">&nbsp;</td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#f7f5f5"><BR>

          

<h1 style="text-align:center; color:#000">Admin Dashboard</h1>

 <br>

<table cellspacing="1" cellpadding="5" border="0">
<thead>
<tr>
	<th colspan="3" style="color:#F33">General Info</th>
</tr>
</thead>
<tbody>
	<tr>
    	<td>Registered businesses</td>
        <td>:</td>
        <td>&nbsp;&nbsp;<?=$business_num?></td>
    </tr>
    
    
    <tr>
    	<td>Online businesses</td>
        <td>:</td>
        <td>&nbsp;&nbsp;</td>
    </tr>
    
    <tr>
    	<td>Number of products available</td>
        <td>:</td>
        <td>&nbsp;&nbsp;<?=$products_num?></td>
    </tr>
    
   
</tbody>






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

