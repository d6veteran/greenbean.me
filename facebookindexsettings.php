<?php 
	ob_start();
	session_start();
	require_once 'database_config.php';
	require_once 'php/facebook.php';
	
	$appapikey = 'e6c164cf398d87e015c3f943cac07617';
	$appsecret = '9091225114bdb7017e6b3c23a09cfb38';
	
	$facebook = new Facebook($appapikey, $appsecret);
		//$facebook->api_client->liveMessage_send('563683308','hi','{message:"chrckdjj nhj ds."}');
	
	if($_GET['auth_token']==''){
	// Names and links
/*$app_name = $siteKey['facebook_appapi_name'];
//$app_url = "http://apps.facebook.com/myonlinegame/"; // Assumes application is at http://apps.facebook.com/app-url/
$invite_href = "http://apps.facebook.com/facebookindexsettings.php"; // Rename this as needed*/
$facebook->require_frame();	
$facebook_userid = $facebook->require_login();
	}
	
	
	
	
	
	$FuserId=$_COOKIE[$appapikey.'_user'];
	$FuserSessionkey=$_COOKIE[$appapikey.'_session_key'];
	$sqlUserPdetails = "SELECT offline_access,publish_stream FROM permissions WHERE uid='$FuserId'";


	$result = $facebook->api_client->fql_query($sqlUserPdetails);
		
	$offlinep=$result[0]['offline_access'];
	$pub_access=$result[0]['publish_stream'];

	if(($offlinep!=1) || ($pub_access!=1))
	{		
	header("location:http://www.facebook.com/connect/prompt_permissions.php?api_key=$appapikey&v=1.0&next=http://greenbean.me/facebookindexsettings.php&fbconnect=true&return_session=true&display=popup&ext_perm=offline_access,publish_stream");
	die;
}
	

$sqlUserDetails = "SELECT uid,first_name,last_name,name,pic_small,pic_big,pic_square,sex,current_location,username  FROM user WHERE uid='$FuserId'";

	$result = $facebook->api_client->fql_query($sqlUserDetails ); 
	
	$facebookid = $result[0]['uid']; 
	$first_name = addslashes($result[0]['first_name']);
	$last_name = addslashes($result[0]['last_name']);
	$name = addslashes($result[0]['name']);
	$pic_small = addslashes($result[0]['pic_small']);
	if($pic_small==''){
	$pic_small=$siteKey['cloud_file_images_path']."no_image.gif";
	}
	$pic_square = addslashes($result[0]['pic_square']);
	$pic_big= addslashes($result[0]['pic_big']);
	$current_location = addslashes($result[0]['current_location']);
	$username = addslashes($result[0]['username']);
	$proxied_email= $result[0]['proxied_email'];
	$email_hashes= $result[0]['email_hashes'];
	$currentTime=time();
	$ipAdd=$_SERVER['REMOTE_ADDR'];
//	$auth_token=$_GET['auth_token'];
	$auth_token=$_COOKIE[$appapikey.'_session_key'];
	$session_expire_time=$_COOKIE[$appapikey.'_expires'];
	
	if($username=='')
	{
	$facebookusername=$first_name;
	}else{
	$facebookusername=$username;
	}

	
		
if($_SESSION['userid']!=''){	
	
	$facebook_user_existance_query_for_registeration= mysql_query("SELECT user_id from gb_twitter_facebook_settings where user_id='".$_SESSION['userid']."'");// CHECKED FOR THAT LOGGEDIN USER EXIST OR NOT IF EXIST THEN UPDATE PROFILE OF USER
		
   $facebook_user_num_rows= mysql_num_rows($facebook_user_existance_query_for_registeration); 
  	
		if($facebook_user_num_rows>0){	
		
		mysql_query("update `gb_twitter_facebook_settings` SET facebook_token='$auth_token',facebook_expire_session_key='$session_expire_time',facebook_id='$facebookid',updatedate='$currentTime',facebook_image_path='$pic_small',facebook_username='$facebookusername' where user_id=".$_SESSION['userid']);
		}else{
	
		mysql_query("INSERT `gb_twitter_facebook_settings` SET `user_id` = '".$_SESSION['userid']."',facebook_token='$auth_token',facebook_expire_session_key='$session_expire_time',facebook_id='$facebookid',facebook_image_path='$pic_small',facebook_username='$facebookusername',add_date='$currentTime' "); 
		
		
		}
		
			mysql_query("update  `gb_users` SET facebook_setting='Y' where user_userid=".$_SESSION['userid']);
			
			}
		//die();
	header("location:".$configuration['url']."user/settings"); exit;	