<?php 
/********************************************************
Date Created : September 15, 2009, 8:28 am
Date Modified : September 15, 2009, 8:28 am 
File Comment : This file used to show detail of record from Table:fd_user using MySql
********************************************************/
require_once "../config/functions.inc.php";
validate_admin();
$user_id=$_GET['user_id'];
$sql="select * from fd_user where user_id='$user_id'";
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
<TD height="25" colspan="2" align="center" class="white_txt"><strong>View User 
Details </strong></TD>
</TR>
<?php 
while($line=mysql_fetch_array($result)){
?><TR class='oddRow'><TD width='46%' align='left'>User name<TD width='54%'><?=$line[user_name]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Account type<TD width='54%'><?=$line[account_type]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Emailid<TD width='54%'><?=$line[emailid]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Password<TD width='54%'><?=$line[password]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>First name<TD width='54%'><?=$line[first_name]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Last name<TD width='54%'><?=$line[last_name]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Company name<TD width='54%'><?=$line[company_name]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Address<TD width='54%'><?=$line[address]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>City<TD width='54%'><?=$line[city]?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>State<TD width='54%'><?php $state=$line['state'];
							$result5=mysql_query("select countryname from fd_country where id='$state'"); 
							$row5=mysql_fetch_assoc($result5);
							echo $row5[countryname];?></TD></TR><TR class='oddRow'>
 <TD width='46%' align='left'>Country
 Name<TD width='54%'><?php $country=$line['countryid'];
							$result5=mysql_query("select countryname from fd_country where id='$country'"); 
							$row5=mysql_fetch_assoc($result5);
							echo $row5[countryname];?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Description<TD width='54%'><?php echo substr($line[description],0,120);?></TD></TR><TR class='oddRow'><TD width='46%' align='left'>User picture<TD width='54%'><img src="<?php echo "http://ajaxdesigners.com/frendli/uploads/user/".$line[user_picture];?>" alt="" width="48" height="48" border="0"></TD></TR><TR class='oddRow'><TD width='46%' align='left'>Status<TD width='54%'><?php if($line[status]==1)echo 'Active';else echo 'Inactive';?></TD></TR>
<?php }?>
</table>
</body>
</HTML>
