<?php //require_once('../../../Connections/conn.php'); ?>
<?
$fullpath_new = "http://www.dailysms.com/public/editorimage/";
			$uploaddir=$fullpath_new;		// The Upload Part
			if(is_uploaded_file($_FILES["img"]['tmp_name']))
			{
				move_uploaded_file($_FILES["img"]['tmp_name'],$uploaddir.$_FILES["img"]['name']);
			}
			
		$pathArr=$fullpath_new.$_FILES["img"]['name'];

	echo $pathArr;
//$GLOBALS[$pathArr];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
function insertPath()
{
	document.forms[0].src.value = "<?=$pathArr?>";
}
</script>
</head>

<body >
<form action="" name="aa" method="post" enctype="multipart/form-data" onSubmit="insertPath();">
<input type="file" name="img"><br/>
<input type="submit" name="btnsubmit">
</form>
</body>
</html>
