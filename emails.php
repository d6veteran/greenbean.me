<?php
session_start();
$request = trim(strtolower($_REQUEST['user_email']));

mysql_connect("mysql50-46.wc2.dfw1.stabletransit.com", "452917_gb", "Gr33nB3an52556") or
    die("Could not connect: " . mysql_error());
mysql_select_db("452917_gb");

$valid = 'true';
$result_same = mysql_query("SELECT user_email FROM gb_users WHERE user_userid='".$_SESSION['userid']."'");
$result = mysql_query("SELECT user_email FROM gb_users WHERE user_email='".$request."'");
$user_email=mysql_fetch_row($result_same);
if ($request==$user_email[0]){
$valid = 'true';
}else{
$num_value=mysql_num_rows($result);

if ($num_value>0){
	$valid="false";
}
}
echo $valid;
?>