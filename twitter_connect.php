<?	ob_start();
	session_start();
 	require_once 'database_config.php';	
	require_once('twitteroauth/twitteroauth.php');
	
session_start();
	if(isset($_GET['act']))
	{
	$_SESSION['TwitterAction']="twitter_setting";
	}
	if(isset($_GET['inv']))
	{
	$_SESSION['TwitterFriendAction']="twitter_friend";
	}

 $consumer_key = 'mtS3R3zUqDDoWG1KDKYbmQ';
 $consumer_secret = 'vdI3PWpIsyGHeQwWGSLBUBxYFh9Slestmabx4ZIGl8';



$content = NULL;
/* Set state if previous session */
$state = $_SESSION['oauth_state'];
/* Checks if oauth_token is set from returning from twitter */
$session_token = $_SESSION['oauth_request_token'];
/* Checks if oauth_token is set from returning from twitter */
$oauth_token = $_REQUEST['oauth_token'];
/* Set section var */
$section = $_REQUEST['section'];



/* Clear PHP sessions */
if ($_REQUEST['test'] === 'clear') {
  session_destroy();
  session_start();
}

/* If oauth_token is missing get it */
if ($_REQUEST['oauth_token'] != NULL && $_SESSION['oauth_state'] === 'start') {
  $_SESSION['oauth_state'] = $state = 'returned';
}

switch ($state) {
  default:
    /* Create TwitterOAuth object with app key/secret */
    $to = new TwitterOAuth($consumer_key, $consumer_secret);
	
    /* Request tokens from twitter Using call back url */
	$tok = $to->getRequestToken('http://greenbean.me/twitter_connect.php');	
	//print_r($tok);
	
    // $tok = $to->getRequestToken();	
    /* Save tokens for later */
    $_SESSION['oauth_token'] = $token = $tok['oauth_token'];
	$_SESSION['oauth_token_secret'] = $tok['oauth_token_secret'];
    $_SESSION['oauth_state'] = "start";

    /* Build the authorization URL */
	
	if ($to->http_code=='200'){
    echo $request_link = $to->getAuthorizeURL($token);
	header("Location: ". $request_link);   
	}
   
    break;
  case 'returned':
    /* If the access tokens are already set skip to the API call */
    if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['oauth_access_token'] = $access_token['oauth_token'];
$_SESSION['oauth_access_token_secret'] = $access_token['oauth_token_secret'];



}
    
	
    /* Create TwitterOAuth with app key/secret and user access key/secret */
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
	
    /* Run request on twitter API as user. */
	
	

	
    $content = $to->get('account/verify_credentials');
	
	if($_SESSION['userid']!=''){	
	
	$twitter_user_existance_query_for_registeration= mysql_query("SELECT user_id from gb_twitter_facebook_settings where user_id='".$_SESSION['userid']."'");// CHECKED FOR THAT LOGGEDIN USER EXIST OR NOT IF EXIST THEN UPDATE PROFILE OF USER
		
  	$twitter_user_num_rows= mysql_num_rows($twitter_user_existance_query_for_registeration); 
   
  	
		if($twitter_user_num_rows!=0){
			
						
			mysql_query("update `gb_twitter_facebook_settings` SET twitter_token='".$_SESSION['oauth_access_token']."',twitter_token_secretkey='".$_SESSION['oauth_access_token_secret']."',twitter_id='".$content->id."',updatedate='".time()."',twitter_username='".$content->screen_name."',twitter_image_path='".$content->profile_background_image_url."' where user_id=".$_SESSION['userid']);		
		
		}else{
						
			mysql_query("INSERT `gb_twitter_facebook_settings` SET twitter_token='".$_SESSION['oauth_access_token']."',twitter_token_secretkey='".$_SESSION['oauth_access_token_secret']."',twitter_id='".$content->id."',updatedate='".time()."',twitter_username='".$content->screen_name."' ,twitter_image_path='".$content->profile_background_image_url."',user_id=".$_SESSION['userid']);
		
		
		}	
		
		mysql_query("update `gb_users` SET twitter_setting='Y' where user_userid=".$_SESSION['userid']);
			
		header("Location: http://greenbean.me/user/settings"); 	
			
}


    break;
}



 

?>