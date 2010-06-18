<?php 
/********************************************************
Date Created : September 14, 2009, 11:44 am
Date Modified : September 14, 2009, 11:44 am 
File Comment : This file used for show list of records from Table:fd_category
********************************************************/
require_once "../config/functions.inc.php";
//validate_admin();
$start=0;
 
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
if($_GET['order_by']=='') $order_by="categoryId";
if($_GET['order_by2']=='') $order_by2="desc";
$column="select * ";
$sql=" from fd_category where 1=1 ";

if($_GET['category_name']!=''){
 $category_name=$_GET['category_name'];
$sql.= " and category_name like '%$category_name%'";
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
		frmobj.action = "category_del.php";
		frmobj.submit();
	}
	else{ 
	return false;
	}
}

else if(comb=='Deactivate'){
frmobj.action = "category_del.php";
frmobj.submit();
}
else if(comb=='Activate'){
frmobj.action = "category_del.php";
frmobj.submit();
}
else if(comb=='Featured'){
frmobj.action = "category_del.php";
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
    <td width="20%" bgcolor="#f2f2f2"   valign="top" align="left" style="padding-top:15px;"><? include("left.inc.php");?></td>
    <td width="93%" valign="top"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:24px 0 0 4px;">
      <tr>
        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>
            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Category Manager</span></span></td>
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
<td width='35%' align='right'>Category name
</td>
<td width='65%'>
<input type='text' name='category_name' value='<?=$category_name?>' class='textfield'>

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
	<TD width="12%"  class="header_bg">S.No.</TD>
      <!--<TD class='header_bg'>CategoryId</TD>-->
<TD width="31%" class='header_bg'>Category name</TD>
<TD width="28%" class='header_bg'>Category Level</TD>
<TD width="15%" class='header_bg'>Status</TD>
<TD width="4%" class='header_bg'>Action</TD>
<!--<TD class='header_bg'>Level</TD>-->
<!--<TD class='header_bg'>Path</TD>
<TD class='header_bg'>Status</TD>
<TD class='header_bg'>Extra1</TD>
-->

      <!--<td width="39%"  class='header_bg' align="center" >Edit</td>-->
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
      <TD ><?php print $i?></TD>
      <!--<TD><?//=$line[categoryId]?></TD>-->
      <TD><? echo stripslashes(html_entity_decode($line[category_name]));?></TD>
      <TD>
      <?php
	  if($line['level']!=0)
	  {		$level=$line['level'];
		  $data=mysql_query("select category_name from fd_category where categoryId='$level'");
	  		$row= mysql_fetch_assoc($data);
			echo $row['category_name'];
		  }
		  else { echo 0;
			  }
	  /*$temp=$line['categoryId'];
	  $sql="select category_name from fd_category where level=$temp";
	  $res=mysql_query($sql);
	  while($subcat=mysql_fetch_array($res))
	  {*/
	  ?>
      <?php /*echo $subcat['category_name']."   ";*/?>
      <?php /*} */?>
      
      </TD>
      
      <TD><?php echo $line[status];?></TD>
      <TD><a href="category_editf.php?cat_id=<?php echo $line[categoryId];?>">Edit</a></TD>
      <!--<TD><?//=$line[level]?></TD>-->
      <!--<TD><?//=$line[path]?></TD>
      <TD><?// if($line[status]==1){?>Active<?// }else{ ?>Inactive<?// } ?></TD>
      <TD><?//=$line[extra1]?></TD>-->

     <!-- <td width="39%" valign="middle" align="center"><a href="category_det.php?categoryId=<?//php print $line[0]?>"> Detail</a> </td>-->
      <td width="10%" valign="middle" align="center"> 
        <input type="checkbox" name="ids[]" value="<?php print $line[0]?>">
      </td>
    </tr>
    <?php }?>
    <?php 
    $className = ($className == "evenRow")?"oddRow":"evenRow";
    ?>
    <tr align="right" class="<?php print $className?>"> 
      <td colspan="10"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
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
      <td colspan="10">Sorry, currently there are no Records to display.</td>
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