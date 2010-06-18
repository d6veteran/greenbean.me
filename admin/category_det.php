<?php 
/********************************************************
Date Created : September 14, 2009, 11:44 am
Date Modified : September 14, 2009, 11:44 am 
File Comment : This file used to show detail of record from Table:fd_category using MySql
********************************************************/
require_once "../config/functions.inc.php";
validate_admin();
$categoryId=$_GET['categoryId'];
$sql="select * from fd_category where categoryId='$categoryId'";
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
<TD colspan="2" height="25" class="white_txt">View fd_category 
Details </TD>
</TR>
<?php 
while($line=mysql_fetch_array($result)){
?>
<TR class='oddRow'><TD width='49%' align='right'>Category name<TD width='51%'><?=$line[category_name]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Level<TD width='51%'><?=$line[level]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Path<TD width='51%'><?=$line[path]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Status<TD width='51%'><?=$line[status]?></TD></TR><TR class='oddRow'><TD width='49%' align='right'>Extra1<TD width='51%'><?=$line[extra1]?></TD></TR>
<?php }?>
</table>
</body>
</HTML>
