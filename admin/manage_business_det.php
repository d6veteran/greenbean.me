<?php 

/********************************************************

Date Created : September 14, 2009, 7:00 am

Date Modified : September 14, 2009, 7:00 am 

File Comment : This file used to show detail of record from Table:fd_business using MySql

********************************************************/

require_once "../config/functions.inc.php";

validate_admin();

$business_id=$_GET['business_id'];

$sql="select * from fd_business where business_id='$business_id'";

$result=executequery($sql);

$num=mysql_num_rows($result);



?>

<HTML>

<HEAD>

<link rel="stylesheet" href="css/css.css" type="text/css">

<TITLE> <?php print $ADMIN_HTML_TITLE?> </TITLE>

</HEAD>

<body  topmargin="0" leftmargin="0" rightmargin="0">

<table width="40%" border="0" cellspacing="1" cellpadding="4" align="center" bgcolor="#D8D8D8">

<TR bgcolor="#638EC0" align="left"> 

<TD height="25" colspan="2" align="center" class="white_txt"><strong>View Business 

Details </strong></TD>

</TR>

<?php 

while($line=mysql_fetch_array($result)){

?>

<TR class='oddRow'>
<TD width='36%' align='left'>User
Name<TD width='64%'><?php 	$user_id=$line['user_id'];
							$result5=mysql_query("select user_name from fd_user where user_id='$user_id'"); 
							$row5=mysql_fetch_assoc($result5);
							echo $row5[user_name];?></TD></TR><TR class='oddRow'>
  <TD width='36%' align='left'>Cat Name<TD width='64%'>
							<?php $cat_id=$line['cat_id'];
							$result5=mysql_query("select category_name from fd_category where categoryId='$cat_id'"); 
							$row5=mysql_fetch_assoc($result5);
							echo $row5[category_name];$line[cat_id]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Business name<TD width='64%'><?=$line[business_name]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Country<TD width='64%'><?php $country=$line['country'];
							$result5=mysql_query("select countryname from fd_country where id='$country'"); 
							$row5=mysql_fetch_assoc($result5);
							echo $row5[countryname];?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>State<TD width='64%'><?php $state=$line['state'];
							$result5=mysql_query("select countryname from fd_country where id='$state'"); 
							$row5=mysql_fetch_assoc($result5);
							echo $row5[countryname];?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Zip code<TD width='64%'><?=$line[zip_code]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Hometown<TD width='64%'><?=$line[hometown]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Skyper address<TD width='64%'><?=$line[skyper_address]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Email address<TD width='64%'><?=$line[email_address]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Phone no<TD width='64%'><?=$line[phone_no]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Fax no<TD width='64%'><?=$line[fax_no]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Website address<TD width='64%'><?=$line[website_address]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Opening hours<TD width='64%'><?=$line[opening_hours]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Business description<TD width='64%'><?=$line[business_description]?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Business logo<TD width='64%'><img src="<?php echo "http://ajaxdesigners.com/frendli/uploads/user/".$line[business_logo];?>" alt="" width="48" height="48" border="0"></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Business image<TD width='64%'><img src="<?php echo "http://ajaxdesigners.com/frendli/uploads/user/".$line[business_image];?>" alt="" width="48" height="48" border="0"></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Business add date<TD width='64%'><?=date("d M, Y",strtotime("$line[business_add_date]"))?></TD></TR><TR class='oddRow'><TD width='36%' align='left'>Business updated date<TD width='64%'><?=date("d M, Y",strtotime("$line[business_updated_date]"))?></TD></TR>
<TR class='evenRow'><TD width='36%' align='left'>Status<TD width='64%'><?php if($line[status]==1)echo 'Active';else echo 'Inactive';?></TD></TR>
<?php }?>

</table>

</body>

</HTML>

