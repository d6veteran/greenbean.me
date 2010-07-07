<?php 
/********************************************************
Date Created : September 14, 2009, 12:06 pm
Date Modified : September 14, 2009, 12:06 pm 
File Comment : This file used for show list of records from Table:fd_business_product
********************************************************/
require_once "../config/functions.inc.php";
//validate_admin();
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
if($_GET['order_by']=='') $order_by="product_id";
if($_GET['order_by2']=='') $order_by2="desc";
$column="select * ";
$sql=" from fd_business_product where 1=1 ";

if($_GET['product_name']!=''){
 $product_name=$_GET['product_name'];
$sql.= " and product_name like '%$product_name%'";
}
if($_GET['product storename']!=''){
 $product_storename=$_GET['product_storename'];
$sql.= " and product storename like '%$product_storename%'";
}


$sql1="select count(*) ".$sql;
$sql=$column.$sql;
$sql.=" order by $order_by $order_by2 ";
$sql.=" limit $start, $pagesize ";
//echo "<br>$sql</br>";
$result=executequery($sql);
$reccnt=getSingleResult($sql1);
?>
<html>
<head>
<title><?php print $ADMIN_HTML_TITLE?></title>
<script language="JavaScript">
function checkall(objForm){
len = objForm.elements.length;
var i=0;
for( i=0 ; i<len ; i++) {
if (objForm.elements[i].type=='checkbox') objForm.elements[i].checked=objForm.check_all.checked;
}
}
function del_prompt(frmobj,comb)
{
if(comb=='Delete'){
	if(confirm ("Are you sure you want to delete Record(s)"))
	{
		frmobj.action = "product_del.php";
		frmobj.submit();
	}
	else{ 
	return false;
	}
}

else if(comb=='Deactivate'){
frmobj.action = "product_del.php";
frmobj.submit();
}
else if(comb=='Activate'){
frmobj.action = "product_del.php";
frmobj.submit();
}
else if(comb=='Featured'){
frmobj.action = "product_del.php";
frmobj.submit();
}
}
</script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.tablednd_0_5.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<!-- JS files for left menu -->
<script type='text/javascript' src='js/menu/jsdomenu.js'></script>
<script type='text/javascript' src='js/menu/data.inc.js'></script>

</head>
<!-- Css file for left menu -->
<link rel='stylesheet' type='text/css' href='js/menu/css/office_xp.css'>

<link rel="stylesheet" href="css/css.css" type="text/css">
<body  topmargin="0" leftmargin="0" rightmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><? include("header.inc.php");?></td>
  </tr>
  <tr>
    <td width="20%" bgcolor="#f2f2f2" valign="top" align="left" style="padding-top:15px;"><? include("left.inc.php");?></td>
    <td width="93%" valign="top"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:24px 0 0 4px;">
      <tr>
        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>
            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Product Manager</span></span></td>
                <td width="24%" align="right"><a href="product_addf.php"><!--Add New Record--></a></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>
          
<form name="frm_search" method="get" action="<?php print $PHP_SELF?>">
  <table width="400" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">
    <tr  align="left"> 
      <td height="25" colspan="2" class="header_bg">Search Record in Table</td>
    </tr>
    <tr  bgcolor = #FFFFFF >
<td width='35%' align='right'>Product name
</td>
<td width='65%'>
<input type='text' name='product_name' value='<?=$product_name?>' class='textfield'>

</td></tr><tr  bgcolor = #F6F6F6 >
<td width='35%' align='right'>Product storename
</td>
<td width='65%'>
<input type='text' name='product_storename' value='<?=$product_storename?>' class='textfield'>

</td></tr>
    <tr class="oddRow"> 
      <td width="35%">&nbsp;</td>
      <td width="65%"> 
        <input type="submit" name="Submit" value="Search Records" class="buttons" >
      </td>
    </tr>
  </table>
</form>

<span class="sess_msg_red"><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></span>

<form name="frm_del" method="post" >
  <table width="98%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">
    
	<?php if($reccnt>0){?>
    <tr>
	<TD  class="header_bg">S.No.</TD>
      <!--<TD class='header_bg'>Product id</TD>
<TD class='header_bg'>Business id</TD>
<TD class='header_bg'>Product category id</TD>
<TD class='header_bg'>User id</TD>-->
<TD class='header_bg'>Product name</TD>
<TD class='header_bg'>Product Category</TD>
<TD class='header_bg'>Productdesc</TD>
<TD class='header_bg'>Product storename</TD>
<TD class='header_bg'>Product status</TD>
<TD class='header_bg'>Productprice</TD>
<TD class='header_bg'>Productadd date</TD>
<!--<TD class='header_bg'>Product image</TD>
<TD class='header_bg'>Product location address</TD>
<TD class='header_bg'>Product city</TD>
<TD class='header_bg'>Product state</TD>
<TD class='header_bg'>Product country</TD>
<TD class='header_bg'>Product zipcode</TD>-->


      <td width="39%"  class='header_bg' align="center" >Detail</td>
      <td width="10%" align="center" class='header_bg'> 
        <input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)">
      </td>
    </tr>
    <?php 
	$i=0;
	while($line=mysql_fetch_array($result))
	{
	$className = ($className == "evenRow")?"oddRow":"evenRow";
	$i++;
	?>
    <tr class="<?php print $className?>"> 
      <TD ><?php print $i?>.</TD>
      <!--<TD><?//=$line[product_id]?></TD>
      <TD><?//=$line[business_id]?></TD>
      <TD><?//=$line[product_category_id]?></TD>
      <TD><?//=$line[user_id]?></TD>-->
      <TD><?=$line[product_name]?></TD>
      <?
	  $query="select categoryname from fd_business_product_category where business_category_id='$line[business_id]'";
	  $catname=mysql_fetch_array(mysql_query($query));
	  ?>
      
      <TD><?=$catname[0]?></TD>
      <TD><?=$line[productdesc]?></TD>
      <TD><?=$line[product_storename]?></TD>
      <TD><? if($line[product_status]==1){echo "Active";}else{echo "Inactive";}?></TD>
      <TD><?=price_format($line[productprice])?></TD>
    <TD><?=$line[productadd_date]?></TD>
    <!--<TD><?//=$line[product_image]?></TD>
    <TD><?//=$line[product_location_address]?></TD>
    <TD><?//=$line[product_city]?></TD>
    <TD><?//=$line[product_state]?></TD>
    <TD><?//=$line[product_country]?></TD>
    <TD><?//=$line[product_zipcode]?></TD>-->

      <td width="39%" valign="middle" align="center"><a href="product_det.php?product_id=<?php print $line[0]?>"> Detail</a> </td>
      <td width="10%" valign="middle" align="center"> 
        <input type="checkbox" name="ids[]" value="<?php print $line[0]?>">
      </td>
    </tr>
    <?php }?>
    <?php 
    $className = ($className == "evenRow")?"oddRow":"evenRow";
    ?>
    <tr align="right" class="<?php print $className?>"> 
      <td colspan="19"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%"  align="center"><?php include("paging.inc.php"); ?></td>
                            <td align="right"><input type="submit" name="Submit" value="Activate" class="buttons" onClick="return del_prompt(this.form,this.value)">
                              <input type="submit" name="Submit" value="Deactivate" class="buttons" onClick="return del_prompt(this.form,this.value)">
                              <input type="submit" name="Submit" value="Delete" class="buttons" onClick="return del_prompt(this.form,this.value)"></td>
                          </tr>
                        </table> 
      </td>
    </tr>
	<?php }else{?>
    <tr align="center" class="oddRow"> 
      <td colspan="19">Sorry, currently there are no Records to display.</td>
    </tr>
	<?php }?>
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
</html>