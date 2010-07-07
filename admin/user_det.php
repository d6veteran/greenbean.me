<?php 
/********************************************************
Date Created : September 15, 2009, 8:28 am
Date Modified : September 15, 2009, 8:28 am 
File Comment : This file used to show detail of record from Table:fd_user using MySql
********************************************************/
require_once "../config/functions.inc.php";
validate_admin();
$user_userid=$_GET['user_userid'];
$sql="select * from gb_users where user_userid='$user_userid'";
$result=executequery($sql);
$num=mysql_num_rows($result);

?>
<HTML>
<HEAD>
<link rel="stylesheet" href="css/css.css" type="text/css">
<TITLE> <?php print $ADMIN_HTML_TITLE?> </TITLE>
</HEAD>
<body  topmargin="0" leftmargin="0" rightmargin="0">
<table width="36%" border="0" cellspacing="1" cellpadding="4" align="center" bgcolor="#D8D8D8">
<TR bgcolor="#638EC0" align="left"> 
<TD height="25" colspan="2" align="center" class="white_txt"><strong>View gb_users 
Details </strong></TD>
</TR>
<?php 
while($line=mysql_fetch_array($result)){
?><TR class='oddRow'><TD width='46%' align='left'>User name<TD width='54%'><?=$line[user_username]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Emailid<TD width='54%'><?=$line[user_email]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Password<TD width='54%'><?=$line[user_password]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>First name<TD width='54%'><?=$line[user_first_name]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Last name<TD width='54%'><?=$line[user_last_name]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Address<TD width='54%'><?=$line[user_location]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Signup date<TD width='54%'><?=date("d M, Y",strtotime("$line[user_sign_date]"))?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>User picture<TD width='54%'><img src="<?php echo "http://ajaxdesigners.com/greenbean/public/user_image/".$line[user_photo];?>" alt="" width="48" height="48" border="0"></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Status<TD width='54%'><?php if($line[user_status]==Active)echo 'Active';else echo 'Inactive';?></TD></TR>
<TR class='oddRow'>
  <TD width='46%' align='left'>Ip add<TD width='54%'><?=$line[user_ip]?></TD>
</TR>
<TR class='oddRow'>
  <TD align='left'>User DOB
  <TD><?=$line[user_date_of_birth]?></TD>
</TR>
<TR class='oddRow'><TD width='46%' align='left'>User Gender<TD width='54%'><?=$line[user_gender]?></TD></TR>
<?php }?>
</table>
</body>
</HTML>
