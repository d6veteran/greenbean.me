<?php 

/********************************************************

Date Created : September 14, 2009, 12:06 pm

Date Modified : September 14, 2009, 12:06 pm 

File Comment : This submit file used to input a record in 

Table:fd_business_product using MySql

********************************************************/

require_once "../config/functions.inc.php";

//validate_admin();

@extract($_POST);



if ($_POST['submitForm'] == "yes") {

	$file_upload_folder="../uploaded_files/news_image/";

	if(is_uploaded_file($HTTP_POST_FILES['product_image']['tmp_name'])){

$product_image		=	$_FILES['product_image']['name'];

$ext	=	strtolower(strrchr($product_image,'.'));

$random_number		=	date("U");

$product_image			=	"product_image_".$random_number.$ext;

$file_upload_path = $file_upload_folder.$product_image;

copy($HTTP_POST_FILES['product_image']['tmp_name'], $file_upload_path);

}

if(is_array($product_image)) $product_image='';



	if($product_id==''){

	$sql="insert into fd_business_product(business_id,product_category_id,user_id,product_name,productdesc,product storename,product_status,productprice,productadd_date,product_image,product_location_address,product_city,product_state,product_country,product_zipcode)values

	('$business_id','$product_category_id','$user_id','$product_name','$productdesc','$product storename','$product_status','$productprice','$productadd_date','$product_image','$product_location_address','$product_city','$product_state','$product_country','$product_zipcode')";

	executeUpdate($sql);

	}else{

	$sql="update fd_business_product set business_id='$business_id',product_category_id='$product_category_id',user_id='$user_id',product_name='$product_name',productdesc='$productdesc',product storename='$product storename',product_status='$product_status',productprice='$productprice',productadd_date='$productadd_date',product_image='$product_image',product_location_address='$product_location_address',product_city='$product_city',product_state='$product_state',product_country='$product_country',product_zipcode='$product_zipcode' ";

	if(is_uploaded_file($HTTP_POST_FILES['product_image']['tmp_name'])){

$sql_pre="select product_image from fd_business_product where product_id='$product_id'";

$prefile=getSingleResult($sql_pre);

@unlink($file_upload_folder.$prefile);

$sql.=" , product_image='$product_image'"; 

}



	$sql.=" where product_id='$product_id'";

	//echo "<br> $sql <br>";

	executeUpdate($sql);

	}

	$_SESSION['frm_arr']='';

	header("Location: product_list.php");

	exit();

}

$product_id=$_REQUEST['product_id'];

if (is_array($_POST) && count($_POST)>0) {

	@extract($_POST);

}

elseif (trim($product_id) != "") {

	$sql="select * from fd_business_product where product_id='$product_id'";

	$result=executequery($sql);

	$num=mysql_num_rows($result);

	$line=ms_stripslashes(mysql_fetch_array($result));

	@extract($line);



}



//if($frm_arr!='') @extract($frm_arr);



$path="../uploaded_files/news_image/";

?>

<HTML>

<HEAD>

<link rel="stylesheet" href="css/css.css" type="text/css">

<!-- Css file for left menu -->

<link rel='stylesheet' type='text/css' href='js/menu/css/office_xp.css'>

<TITLE> <?=$ADMIN_HTML_TITLE?> </TITLE>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.tablednd_0_5.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script>

function trim(s) {

  while (s.substring(0,1) == ' ') {

    s = s.substring(1,s.length);

  }

  while (s.substring(s.length-1,s.length) == ' ') {

    s = s.substring(0,s.length-1);

  }

  return s;

}



function validate_form(objfrm)

{

	msg="Sorry, we cannot complete your request.\nKindly provide us the missing or incorrect information enclosed below.\n\n";

	if(trim(objfrm.product_id.value)=='')	msg+='- Please Enter Product id \n';
if(trim(objfrm.business_id.value)=='')	msg+='- Please Enter Business id \n';
if(trim(objfrm.product_category_id.value)=='')	msg+='- Please Enter Product category id \n';
if(trim(objfrm.user_id.value)=='')	msg+='- Please Enter User id \n';
if(trim(objfrm.product_name.value)=='')	msg+='- Please Enter Product name \n';
if(trim(objfrm.productdesc.value)=='')	msg+='- Please Enter Productdesc \n';
if(trim(objfrm.product storename.value)=='')	msg+='- Please Enter Product Storename \n';
if(trim(objfrm.product_status.value)=='')	msg+='- Please Enter Product status \n';
if(trim(objfrm.productprice.value)=='')	msg+='- Please Enter Productprice \n';
if(trim(objfrm.productadd_date.value)=='')	msg+='- Please Enter Productadd date \n';
if(trim(objfrm.product_image.value)=='')	msg+='- Please Enter Product image \n';
if(trim(objfrm.product_location_address.value)=='')	msg+='- Please Enter Product location address \n';
if(trim(objfrm.product_city.value)=='')	msg+='- Please Enter Product city \n';
if(trim(objfrm.product_state.value)=='')	msg+='- Please Enter Product state \n';
if(trim(objfrm.product_country.value)=='')	msg+='- Please Enter Product country \n';
if(trim(objfrm.product_zipcode.value)=='')	msg+='- Please Enter Product zipcode \n';




	if(msg!="Sorry, we cannot complete your request.\nKindly provide us the missing or incorrect information enclosed below.\n\n")

	{

		alert(msg)

		return false;

	}

	else

	{

		return true;

	}

}





</script>

<!-- JS files for left menu -->

<script type='text/javascript' src='js/menu/jsdomenu.js'></script>

<script type='text/javascript' src='js/menu/data.inc.js'></script>


</HEAD>

<body  topmargin="0" leftmargin="0" rightmargin="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="2"><? include("header.inc.php");?></td>

  </tr>

  <tr>

    <td width="20%" bgcolor="#f2f2f2" valign="top" align="left" style="padding-top:15px;"><? include("left.inc.php");?></td>

    <td width="93%"><table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#B1B1B1" style="margin:12px 0 0 20px;">

      <tr>

        <td height="40" align="left" background="images/heading_bg.gif" bgcolor="#FFFFFF" class="h1"><span class="verdana_small_white"><span class="white_bold_big"></span></span>

            <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="76%" class="h1"><img src="images/heading_icon.gif" width="16" height="16" hspace="5"><span class="verdana_small_white"><span class="white_bold_big">Product Manager</span></span></td>

                <td width="24%" align="right"><a href="[ADDF FILE]">Add New Record</a></td>

              </tr>

          </table></td>

      </tr>

      <tr>

        <td height="347" align="center" valign="top" bgcolor="#ffffff"><BR>

          

<form action="product_addf.php" method="post" enctype="multipart/form-data" name="form1"  onSubmit="return validate_form(this)">

<input type="hidden" name="submitForm" value="yes">

<table width="80%" border="0" cellspacing="1" cellpadding="4" align=center  bgcolor="#D8D8D8">

<TR bgcolor="#638EC0" align="left"> 

<TD height="25" colspan="2" class="header_bg"><?php if($product_id==''){?>Add New<?php }else{?>Edit<?php }?> 

fd_business_product Details</TD>

</TR>

<?php if($_SESSION['sess_msg']!=''){?>

<tr>

<td colspan="2" align="center"  class="sess_msg_red" bgcolor="#F6F6F6" ><?php print $_SESSION['sess_msg']; session_unregister('sess_msg'); $sess_msg='';?>

</td>

</tr>

<?php }?>

<input type="hidden" name=product_id class=textfield value="<?=$product_id?>"><TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Business id</TD><TD width='78%'><input type='text' size=35 name=business_id class=textfield value="<?=$business_id?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Product category id</TD><TD width='78%'><input type='text' size=35 name=product_category_id class=textfield value="<?=$product_category_id?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>User id</TD><TD width='78%'><input type='text' size=35 name=user_id class=textfield value="<?=$user_id?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Product name</TD><TD width='78%'><input type='text' size=35 name=product_name class=textfield value="<?=$product_name?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Productdesc</TD><TD width='78%'><textarea name=productdesc id=productdesc cols='60' rows='7' class=textfield><?=$productdesc?></textarea></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Product Storename</TD><TD width='78%'><input type='text' size=35 name=product storename class=textfield value="<?=$product_storename?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Product status</TD><TD width='78%'><input type='text' size=35 name=product_status class=textfield value="<?=$product_status?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Productprice</TD><TD width='78%'><input type='text' size=35 name=productprice class=textfield value="<?=$productprice?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Productadd date</TD><TD width='78%'><input type='text' size=35 name=productadd_date class=textfield value="<?=$productadd_date?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Product image</TD><TD width='78%'><?if($product_image!=''){?><img src='<?=$path.$product_image?>' width=100 border='0'><?}?><br><input type="file" name=product_image class=textfield ></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Product location address</TD><TD width='78%'><textarea name=product_location_address id=product_location_address cols='60' rows='7' class=textfield><?=$product_location_address?></textarea></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Product city</TD><TD width='78%'><input type='text' size=35 name=product_city class=textfield value="<?=$product_city?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Product state</TD><TD width='78%'><input type='text' size=35 name=product_state class=textfield value="<?=$product_state?>"></TD></TR>
<TR class='evenRow'><TD width='22%' align='right' class='fields_txt'>Product country</TD><TD width='78%'><input type='text' size=35 name=product_country class=textfield value="<?=$product_country?>"></TD></TR>
<TR class='oddRow'><TD width='22%' align='right' class='fields_txt'>Product zipcode</TD><TD width='78%'><input type='text' size=35 name=product_zipcode class=textfield value="<?=$product_zipcode?>"></TD></TR>


<tr  class="evenRow">

<td align="center">&nbsp;</td><td><input name="Submit" type="submit" class="buttons" value="<?php if($product_id==''){?>Add<?php }else{?>Edit<? }?> fd_business_product Details"></td></tr>

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

</HTML>

