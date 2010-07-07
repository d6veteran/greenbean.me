<?php
if($_FILES)
{
	$fullpath_new = "http://www.dailysms.com/public/editorimage/";	

	$file_name=$_FILES["img"]['name'];	
					
	if(is_uploaded_file($_FILES["img"]['tmp_name']))
	{
		copy($_FILES["img"]['tmp_name'],"../../../../editorimage/$file_name");							
	}							
	$pathArr=$fullpath_new.$_FILES["img"]['name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Upload File</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
if($_POST)
{
?>
	<script>
	opener.document.forms[0].src.value='<?php echo $pathArr?>';
	self.close();
	</script>
<?php
}
?>
</head>
<body>
<form action="" name="aa" method="post" enctype="multipart/form-data">
<table align="center">
<tr><td>
  <input type="file" name="img"></td>
</tr>
<tr><td>
<input type="submit" name="btnsubmit" value="Upload">
</td></tr>
</table>

</form>
</body>
</html>
