<?php 
/********************************************************
Date Created : September 14, 2009, 12:06 pm
Date Modified : September 14, 2009, 12:06 pm 
File Comment : This file used to show detail of record from Table:fd_business_product using MySql
********************************************************/
require_once "../config/functions.inc.php";
validate_admin();
$product_id=$_GET['product_id'];
$sql="select * from fd_business_product where product_id='$product_id'";
$result=executequery($sql);
$num=mysql_num_rows($result);

?>
<HTML>
<HEAD>
<link rel="stylesheet" href="css/css.css" type="text/css">
<TITLE> <?php print $ADMIN_HTML_TITLE?> </TITLE>
</HEAD>
<body  topmargin="0" leftmargin="0" rightmargin="0">
<table width="65%" border="0" cellspacing="1" cellpadding="4" align="center" bgcolor="#D8D8D8">
<TR bgcolor="#638EC0" align="left"> 
<TD colspan="2" height="25" class="white_txt">View fd_business_product 
Details </TD>
</TR>
<?php 
while($line=mysql_fetch_array($result)){
?>
<TR class='oddRow'><TD width='49%' align='right'>Business id<TD width='51%'><?=$line[business_id]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product category id<TD width='51%'><?=$line[product_category_id]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>User id<TD width='51%'><?=$line[user_id]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product name<TD width='51%'><?=$line[product_name]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Productdesc<TD width='51%'><?=$line[productdesc]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product storename<TD width='51%'><?=$line[product storename]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product status<TD width='51%'><?=$line[product_status]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Productprice<TD width='51%'><?=$line[productprice]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Productadd date<TD width='51%'><?=$line[productadd_date]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product image<TD width='51%'><?=$line[product_image]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product location address<TD width='51%'><?=$line[product_location_address]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product city<TD width='51%'><?=$line[product_city]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product state<TD width='51%'><?=$line[product_state]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product country<TD width='51%'><?=$line[product_country]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Product zipcode<TD width='51%'><?=$line[product_zipcode]?></TD></TR>
<?php }?>
</table>
</body>
</HTML>
