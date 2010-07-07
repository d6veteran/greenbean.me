<?php


require_once "../config/functions.inc.php";
if($_SESSION['username'] == '' ){
		$msg= "Entered Username or password is invalid";
		header("location:index.php");
	}
@extract($_POST);
$column="select * ";
$sql_admin_tags=" from gb_tags where added_by='admin' ";




$sql_admin_tags1="select count(*) ".$sql_admin_tags;
$sql_admin_tags=$column.$sql_admin_tags;

$result_admin_tags=executequery($sql_admin_tags);
$result_rows=getSingleResult($sql_admin_tags1); // for number of rows 
?>




<form name="frm_del_admin" method="post" >

  <table width="54%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">

    

	<?php if($result_rows>0){?>
	
   <tr><TD style="font-size:16px">Admin Tags</TD></tr>
    <tr>

<TD width="19%"  class="header_bg">S.No.</TD>

<TD width="21%" class='header_bg'>Add Tag</TD>

<TD width="23%" class='header_bg'>Added By</TD>



<td width="10%" align="center" class='header_bg'>Action</td>
<td width="11%" align="center" class='header_bg'>Status</td>
<td width="16%" align="center" class='header_bg'> 

<input name="check_all" type="checkbox" id="check_all" value="check_all" onClick="checkall(this.form)"></td>
</tr>

    <?php 

	$index=0;

	while($line_admin_tags=mysql_fetch_array($result_admin_tags))

	{

	$className = ($className == "evenRow")?"oddRow":"evenRow";

	$index++; 
	
	

	

	$temp_admin_tags=$line_admin_tags[tag_id];

	$result5_admin_tags=mysql_query("select count(*) as no_of_users from gb_tags where tag_id='$temp_admin_tags'");

	$data_admin_tags=mysql_fetch_assoc($result5_admin_tags);

		?>

    <tr class="<?php print $className?>"> 

      <TD ><?=$index?>.</TD>

      <TD><?=$line_admin_tags[label]?></TD>

      <TD><?=$line_admin_tags[added_by]?></TD>

      <TD align="center"><a href="tag_add_edit.php?tag_id=<?php echo $line_admin_tags[tag_id];?>">Edit</a></TD>
     <TD><?php if($line_admin_tags[status]=="Active")
	             {
				   echo "Active";
				 }else
				   { echo "Inactive";}
				   
		   ?>
		   
	</TD>
      <td width="16%" valign="middle" align="center"> 

        <input type="checkbox" name="ids[]" value="<?php print $line_admin_tags[0]?>">      </td>
    </tr>

    <?php }?>

    <?php 

    $className = ($className == "evenRow")?"oddRow":"evenRow";

    ?>

    <tr align="right" class="<?php print $className?>"> 

  <td colspan="29"><table width="100%"  border="0" cellspacing="0" cellpadding="0">

                          <tr>

                          <!--  <td width="45%"  align="center"><?php /*include("paging.inc.php");*/ ?></td>-->

                            <td width="55%"  align="right">
                              <a href="tag_add.php">
                              <input type="submit" name="Submit2" value="Add Tag" class="buttons">
                              </a>
                              <input type="submit" name="Submit" value="Activate" class="buttons" onClick="return del_prompt_tags(this.form,this.value)">
							  <input type="submit" name="Submit" value="Deactivate" class="buttons" onClick="return del_prompt_tags(this.form,this.value)">
							  <input type="submit" name="Submit" value="Delete" class="buttons" onClick="return del_prompt_tags(this.form,this.value)">							</td>
                          </tr>

                  </table>      </td>
    </tr>

	<?php }else{?>

    <tr align="center" class="oddRow"> 

      <td colspan="29"><b> Sorry, currently no tag has been added by user ! </b></td>
    </tr>

	<?php }?>
  </table>

  </form>