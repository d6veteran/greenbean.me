<?php


require_once "../config/functions.inc.php";
if($_SESSION['username'] == '' ){
		$msg= "Entered Username or password is invalid";
		header("location:index.php");
	}
@extract($_POST);



$column="SELECT COUNT(*) AS totalbeanrequested,
gb_tags_relation.tag_id,gb_tags.label,gb_tags.tag_id,gb_tags.added_by,gb_tags.status";

$sql_user_tags=" FROM gb_tags_relation
LEFT JOIN gb_tags
ON gb_tags_relation.tag_id=gb_tags.tag_id
WHERE gb_tags.added_by='gb_user'";



$sql_user_tags1="select count(*) ".$sql_user_tags;

$sql_user_tags=$column.$sql_user_tags;

$sql_user_tags.="GROUP BY gb_tags_relation.tag_id
ORDER BY totalbeanrequested DESC LIMIT 10";

$result_user_tags=executequery($sql_user_tags);
$result_user_rows=getSingleResult($sql_user_tags1); // for number of rows 
?>





<form name="frm_del_user" method="post" >

  <table width="54%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">

    

	<?php if($result_user_rows>0){?>
	
   <tr><TD style="font-size:16px">User Tags</TD></tr>
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

	$index_user_tags=0;

	while($line_user_tags=mysql_fetch_array($result_user_tags))

	{

	$className = ($className == "evenRow")?"oddRow":"evenRow";

	$index_user_tags++;

	

	$temp_user_tags=$line_user_tags[tag_id];

	$result5_user_tags=mysql_query("select count(*) as no_of_users from gb_tags where tag_id='$temp_user_tags'");

	$data_user_tags=mysql_fetch_assoc($result5_user_tags);

		?>

    <tr class="<?php print $className?>"> 

      <TD ><?php print $index_user_tags?>.</TD>

      <TD><?=$line_user_tags[label]?></TD>

      <TD><?=$line_user_tags[added_by]?></TD>

      <TD align="center"><a href="tag_add_edit.php?tag_id=<?php echo $line_user_tags[tag_id];?>">Edit</a></TD>
     <TD><?php if($line_user_tags[status]=="Active")
	             {
				   echo "Active";
				 }else
				   { echo "Inactive";}
				   
		   ?>
		   
	</TD>
      <td width="16%" valign="middle" align="center"> 

        <input type="checkbox" name="ids[]" value="<?php print $line_user_tags[1]?>">      </td>
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