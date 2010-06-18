<?php 
/********************************************************
Date Created : September 14, 2009, 7:00 am
Date Modified : September 14, 2009, 7:00 am 
File Comment : This file used for show list of records from Table:fd_business
********************************************************/
require_once "../config/functions.inc.php";
//validate_admin();
$start=0;
if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
if($_GET['order_by']=='') $order_by="business_review_date";
if($_GET['order_by2']=='') $order_by2="desc";
$column="select * ";
$sql=" from fd_business_review";
$where = " where 1=1 ";

if($_GET['business_name']!=''){
$business_name=$_GET['business_name'];
$search_bussi_name=" left join fd_business on fd_business_review.business_id=fd_business.business_id where fd_business.business_name like '%$business_name%'";	
$sql.=$search_bussi_name;
}
else $sql.= $where;
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
		frmobj.action = "business_post_notes_del.php";
		frmobj.submit();
	}
	else{ 
	return false;
	}
}

else if(comb=='Deactivate'){
frmobj.action = "business_post_notes_del.php";
frmobj.submit();
}
else if(comb=='Activate'){
frmobj.action = "business_post_notes_del.php";
frmobj.submit();
}
else if(comb=='Featured'){
frmobj.action = "business_post_notes_del.php";
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
    <td   valign="top" align="left" style="padding-top:15px;" bgcolor="#f2f2f2"><? include("left.inc.php");?></td>
    <td width="93%"><table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1"  style="margin:24px 0 0 20px;">
      <tr>
        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>
            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">BusinessManager</span></span></td>
                <td width="24%" align="right"><a href="manage_business_addf.php"><!--Add New Record--></a></td>
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
<td width='35%' align='right'>Business name
</td>
<td width='65%'>
<input type='text' name='business_name' value='<?=$business_name?>' class='textfield'>

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
<TD width="6%"  class="header_bg">S.No.</TD>
<TD width="15%" class='header_bg'>User Name</TD>
<TD width="17%" class='header_bg'>Business name</TD>
<TD width="27%" class='header_bg'>Post Notes</TD>
<TD width="10%" class='header_bg'>Review Image</TD>

<!--<TD class='header_bg'>Business add date</TD>-->
<TD width="11%" class='header_bg'>Review Date</TD>
<TD width="8%" class='header_bg'>Review Rating</TD>

<td width="6%" align="center" class='header_bg'> 
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
      <!--<TD><?//=$line[business_id]?></TD>
      <TD><?//=$line[user_id]?></TD>
      <TD><?//=$line[cat_id]?></TD>-->
<?
$query="select user_name from fd_user where user_id='$line[user_id]'";
$userid=mysql_fetch_array(mysql_query($query));
?>
      <TD><a href="user_details.php?user_id=<?php echo $line[user_id];?>" target="_blank"> <?=$userid[0]?></a></TD>
      <TD><?php $row=mysql_fetch_assoc(mysql_query("select business_name from fd_business where business_id='$line[business_id]'"));
	  			echo $row['business_name'];?></TD>
     <TD><?=substr($line[business_review_comment],0,120)?></TD>
     <TD><img src="<?php echo "http://ajaxdesigners.com/frendli/uploads/user/".$line[business_review_image];?>" alt="" width="48" height="48" border="0"></TD>
     <TD><?=date("d M, Y",strtotime("$line[business_review_date]"))?></TD>
     <TD align="center"><?=$line[business_review_rating]?></TD>
   
     <td width="6%" valign="middle" align="center"> 
       <input type="checkbox" name="ids[]" value="<?php print $line[0]?>">
     </td>
    </tr>
    <?php }?>
    <?php 
    $className = ($className == "evenRow")?"oddRow":"evenRow";
    ?>
    <tr align="right" class="<?php print $className?>"> 
      <td colspan="25"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="50%"  align="center"><?php include("paging.inc.php"); ?></td>
                            <td align="right"><input type="submit" name="Submit" value="Delete" class="buttons" onClick="return del_prompt(this.form,this.value)"></td>
                          </tr>
                        </table> 
      </td>
    </tr>
	<?php }else{?>
    <tr align="center" class="oddRow"> 
      <td colspan="25">Sorry, currently there are no Records to display.</td>
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