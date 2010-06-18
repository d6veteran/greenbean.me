<?php 

/********************************************************

Date Created : September 15, 2009, 8:28 am

Date Modified : September 15, 2009, 8:28 am 

File Comment : This file used for show list of records from Table:fd_user

********************************************************/








require_once "../config/functions.inc.php";

					
	
					
@extract($_POST);






$start=0;

if(isset($_GET['start'])) $start=$_GET['start'];
$pagesize=15;
if(isset($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
if($_GET['order_by']=='') $order_by="page_id";
if($_GET['order_by2']=='') $order_by2="desc";
$column="select * ";
$sql=" from gb_pages";


$sql1="select count(*) ".$sql;
$sql=$column.$sql;

$result=executequery($sql);
$reccnt=getSingleResult($sql1);




?>
<html>
<head>
<title><?php print $ADMIN_HTML_TITLE?></title>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript" src="js/jquery.tablednd_0_5.js"></script>

<script type="text/javascript" src="js/jquery.tablesorter.js"></script>

<script language="JavaScript">

function checkall(objForm){
len = objForm.elements.length;
var i=0;
for( i=0 ; i<len ; i++) {
if (objForm.elements[i].type=='checkbox') objForm.elements[i].checked=objForm.check_all.checked;
}
}
function del_prompt_pages(frmobj,comb)
{
if(comb=='Delete'){
	if(confirm ("Are you sure you want to delete Record(s)"))
	{
		frmobj.action = "user_del_page.php";
		frmobj.submit();
	}
	else{ 
	return false;
	}
}

else if(comb=='Deactivate'){

frmobj.action = "user_del_page.php";

frmobj.submit();

}

else if(comb=='Activate'){

frmobj.action = "user_del_page.php";

frmobj.submit();

}

else if(comb=='Featured'){

frmobj.action = "user_del.php";

frmobj.submit();

}

}

</script>

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

    <td width="93%"><table width="97%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:24px 0 0 5px;">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Add Page </span></span></td>
              </tr>

          </table></td>
      </tr>
      <tr>
        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>
		<BR>
		
		<span class="sess_msg_red"><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?></span>









<form name="frm_del" method="post" >

  <table width="54%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">

    

	<?php if($reccnt>0){?>

    <tr>
<tr>
  <TD style="font-size:16px">All Pages  </TD>
</tr>
<TD width="19%"  class="header_bg">S.No.</TD>

<TD width="21%" class='header_bg'>Page Title</TD>

<!--<TD width="23%" class='header_bg'>Added By</TD>-->



<td width="10%" align="center" class='header_bg'>Action</td>
<td width="11%" align="center" class='header_bg'>Status</td>
<td width="16%" align="center" class='header_bg'> 

<input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)"></td>
</tr>

    <?php 

	$i=0;

	while($line=mysql_fetch_array($result))

	{

	$className = ($className == "evenRow")?"oddRow":"evenRow";

	$i++;

	

	$temp=$line[page_id];

	$result5=mysql_query("select count(*) as no_of_users from gb_pages where page_id='$temp'");

	$data=mysql_fetch_assoc($result5);

		?>

    <tr class="<?php print $className?>"> 

      <TD ><?php print $i?>.</TD>

      <TD><?=$line[page_title]?></TD>

 
      <TD align="center"><a href="page_add_edit.php?page_id=<?php echo $line[page_id];?>">Edit</a></TD>
     <TD><?php if($line[status]=="Active")
	             {
				   echo "Active";
				 }else
				   { echo "Inactive";}
				   
		   ?>
		   
	</TD>
      <td width="16%" valign="middle" align="center"> 

        <input type="checkbox" name="ids[]" value="<?php print $line[0]?>">      </td>
    </tr>

    <?php }?>

    <?php 

    $className = ($className == "evenRow")?"oddRow":"evenRow";

    ?>

    <tr align="right" class="<?php print $className?>"> 

  <td colspan="29"><table width="100%"  border="0" cellspacing="0" cellpadding="0">

                          <tr>

                            <td width="45%"  align="center"><?php include("paging.inc.php"); ?></td>

                            <td width="55%"  align="right">
                              <a href="page_add.php">
                              <input type="submit" name="Submit2" value="Add Page" class="buttons">
                              </a>
                              <input type="submit" name="Submit" value="Activate" class="buttons" onClick="return del_prompt_pages(this.form,this.value)">
							  <input type="submit" name="Submit" value="Deactivate" class="buttons" onClick="return del_prompt_pages(this.form,this.value)">
							  <input type="submit" name="Submit" value="Delete" class="buttons" onClick="return del_prompt_pages(this.form,this.value)">							</td>
                          </tr>

                  </table>      </td>
    </tr>

	<?php }else{?>

    <tr align="center" class="oddRow"> 

      <td colspan="29">Sorry, currently there are no Records to display.</td>
    </tr>

	<?php }?>
  </table>

  </form>

   <br>

        </td>

      </tr>

    </table>
	
	</td>

  </tr>

  <tr>

    <td colspan="2"><? include("footer.inc.php");?></td>

  </tr>

</table>

</body>

</html>