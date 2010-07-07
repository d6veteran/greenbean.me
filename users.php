<?php
session_start();
$request = trim(strtolower($_REQUEST['username']));
//sleep(2);
usleep(150000);

mysql_connect("mysql50-46.wc2.dfw1.stabletransit.com", "452917_gb", "Gr33nB3an52556") or
    die("Could not connect: " . mysql_error());
mysql_select_db("452917_gb");


$result_same = mysql_query("SELECT user_username FROM gb_users WHERE user_userid='".$_SESSION['userid']."'");
$user_username= mysql_fetch_row($result_same);
if ($request==strtolower($user_username[0])){
$valid = 'true';
}elseif(preg_match('/^[a-z0-9\_]+$/',$request)){
$valid = 'true';	
$result = mysql_query("SELECT user_userid FROM gb_users WHERE user_username='".$request."'");
$num_value=mysql_num_rows($result);

if ($num_value>0){
	$valid="false";
}
}else{
	$valid="false";
}
echo $valid;
?>