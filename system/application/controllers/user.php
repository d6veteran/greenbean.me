<?php

class User extends Controller {

	function User() {
		parent::Controller();
		$this->load->model('User_Model');
		$this->load->model('Location_Model');
		//$this->load->library('paypal_lib');
		/*$this->common_functions->checkMaintenanceMode();
		$this->load->model('Product_Model');
		$this->load->model('Info_Model');	
		$this->load->library('ajax');		
		
		if(!$this->session->userdata('currency'))
			$arrCurr=$this->common_functions->getDefaultCurrency();	*/	
	}
	
	function Index() {
		
								 
		/*$data["file"]="my_account";
		$this->load->view('template',$data);*/
	}
	
	
	function profile($userid){
		
		$this->load->library('facebook_connect');
		$data = array(
						'user'		=> $this->facebook_connect->user,
						'user_id'	=> $this->facebook_connect->user_id
						
					);
			
		$data["userid"]=$userid;
		$data["file"]="user_profile";
		$user_info=$this->functions->getUserInfo($userid);
		$data['admin_tags']=$this->functions->user_pre_tags();
		$ip = $this->input->ip_address();
		$geo_data = get_geolocation($ip);
		$data["head_title"]=$user_info['user_username'];
		$data['geo_location']=$this->functions->check_geo_location($geo_data);
		$data['user_ip']=$ip;		
		$this->load->view('template',$data);
		
	}
	
	
	function tags($tag_name){
		
		$this->load->library('facebook_connect');
		$data = array(
						'user'		=> $this->facebook_connect->user,
						'user_id'	=> $this->facebook_connect->user_id
						
					);
		
		
		$tag_id=$this->functions->show_tags_id($tag_name);
		
		$data["tag_id"]=$tag_id;
		$data["file"]="tags_profile";
		$data["tags_info"]=$this->Location_Model->get_recent_bean_bytags($tag_id);			
		$data['admin_tags']=$this->functions->user_pre_tags();
		$ip = $this->input->ip_address();
		$geo_data = get_geolocation($ip);
		
		$data["head_title"]=$this->functions->show_tags_name($tag_id);
		$data['geo_location']=$this->functions->check_geo_location($geo_data);
		$data['user_ip']=$ip;
		
		$this->load->view('template',$data);
		
	}
	
	function locations($locations_id){
		
		$this->load->library('facebook_connect');
		$data = array(
						'user'		=> $this->facebook_connect->user,
						'user_id'	=> $this->facebook_connect->user_id
						
					);
			
		$data["locations_id"]=$locations_id;
		
		$data["file"]="location_profile";
		
		$data["location_info"]=$this->Location_Model->get_recent_bean_bylocation($locations_id);
		
		$data['admin_tags']=$this->functions->user_pre_tags();
		$ip = $this->input->ip_address();
		$geo_data = get_geolocation($ip);
		$location_name=$this->functions->show_location_name($locations_id);
		$data["head_title"]=$location_name[0]['city'].", ".$location_name[0]['region_name']. ", ".$location_name[0]['country_name'];
		$data['geo_location']=$this->functions->check_geo_location($geo_data);
		$data['user_ip']=$ip;			
		
		$this->load->view('template',$data);
		
	}
	
	function settings(){
		
		if(!isset($_SESSION['userid'])){
			header('Location: http://greenbean.me/');
			exit();
		}
		
		
		$this->load->library('facebook_connect');
		$data = array(
						'user'		=> $this->facebook_connect->user,
						'user_id'	=> $this->facebook_connect->user_id
						
					);
			
		$data["userid"]=$_SESSION['userid'];
		$data["file"]="user_settings";
		
		$user_info=$this->functions->getUserInfo($_SESSION['userid']);
		$data['admin_tags']=$this->functions->user_pre_tags();
		$ip = $this->input->ip_address();
		$geo_data = get_geolocation($ip);
			//$data['geo_location']=$geo_data;
		$data['geo_location']=$this->functions->check_geo_location($geo_data);
		$data['user_ip']=$ip;
		$data["head_title"]=$user_info['user_username'];		
		$data["user_info"]=$user_info;
		$_SESSION['username']=$user_info['user_username'];
		$this->load->view('template',$data);
		
	}
	
	

	function login($page=NULL) {
	
	$red_page=NULL;
	$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']); 
	
		if($this->session->userdata("userid")!="")
			header("location: ".base_url());
	
		if($_POST)
		{
		    $is_loggedin = $this->user_model->loginuser($_POST );
			
			if($is_loggedin)
			{ 
			    // UPDATE USER LOG
				$ip=$_SERVER['REMOTE_ADDR'];

				$sql = mysql_query("select login_time from user_logs where user_id='".$is_loggedin."' order by id DESC limit 0,1");
				$sqlData = mysql_fetch_array($sql);
				if(mysql_num_rows($sql)>1)
					{
						$this->db->query("update tb_users set logstatus=1,numberofEmail=1 where user_userid='".$is_loggedin."'");
					}
				$query = mysql_query("SELECT DATEDIFF(now(),'".$sqlData['login_time']."') AS DiffDate");
				$queryData = mysql_fetch_array($query);
				if($queryData['DiffDate']>=1 || mysql_num_rows($sql)==0)
				{
				
				mysql_query("insert into user_logs SET user_id='".$is_loggedin."',login_time=now(),ip_address='".$ip."'");
				//UPDATE USER ACCOUNT (ONCE IN 24 HOUR)
			    $this-> user_model -> update_user_account('signin' , $is_loggedin );
				}
							
				// UPDATE USER LOG				
			
			   
				
				
				if($_SESSION['refered_from']!= '')
				{	
					if(isset($_POST['reffer_to']) and $_POST['reffer_to']=="browse_bet")
					$page="browse_bet";
					elseif(isset($_POST['reffer_to']) and $_POST['reffer_to']=="leaderboard")
					$page ="leaderboard";
					else
					$page="browse_bet";
					//redirect($this->session->userdata('refered_from')); 
					header("location: ".base_url().$page);
				}
				
				else
				{
					header("location: ".base_url());
				}	
			}
			else
			{
			   	$this->session->set_flashdata('login', 'Invalid Username or Password .');			
				redirect($this->session->userdata('refered_from')); 
			}
		}
	}

function feedback() {
		
	$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
	
			
		if($_POST)
		{ 		
				mysql_query("insert into tb_feedback SET name='".$_POST['name']."',feedback='".$_POST['feedback']."',email='".$_POST['email']."' ");
			
			$this->db->where('id',10);
			$Q=$this->db->get('tb_autoresponders');
			$row=$Q->result_array();
			$subject=$row[0]['subject'];
			$message=$row[0]['body'];
			$message=str_replace('{name}',$_POST['name'], $message);
			$message=str_replace('{email}',$_POST['email'], $message);
			$message=str_replace('{feedback}',$_POST['feedback'], $message);
			$headers="From: betzie.com <service@betzie.com>\n";
			$headers.="MIME-Version: 1.0\n";
			$headers.="Content-type: text/html; charset=iso-8859-1\n";
			$headers.="Content-Transfer-Encoding: base64\n";
			$message=rtrim(chunk_split(base64_encode($message)));
			
		$mail_sent=@mail('vipin@futerox.biz',$subject,$message,$headers) or die(mysql_error());
		}
		 header("location: ".$_SERVER['HTTP_REFERER']);
}


function loginpass($page=NULL) {
	$red_page=NULL;
	$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']); 
	
		if($this->session->userdata("userid")!="")
			header("location: ".base_url());
	
		if($_POST)
		{
		    $is_loggedin = $this->user_model->loginuser1($_POST );
			
			if($is_loggedin)
			{ 
			    // UPDATE USER LOG
				$ip=$_SERVER['REMOTE_ADDR'];

				$sql = mysql_query("select login_time from user_logs where user_id='".$is_loggedin."' order by id DESC limit 0,1");
				$sqlData = mysql_fetch_array($sql);
				$query = mysql_query("SELECT DATEDIFF(now(),'".$sqlData['login_time']."') AS DiffDate");
				$queryData = mysql_fetch_array($query);
				if($queryData['DiffDate']>=1 || mysql_num_rows($sql)==0)
				{
				
				mysql_query("insert into user_logs SET user_id='".$is_loggedin."',login_time=now(),ip_address='".$ip."'");
				//UPDATE USER ACCOUNT (ONCE IN 24 HOUR)
			    $this-> user_model -> update_user_account('signin' , $is_loggedin );
				}
							
				// UPDATE USER LOG				
			
			    if($_SESSION['refered_from']!= '')
				{	
					if(isset($_POST['reffer_to']) and $_POST['reffer_to']=="browse_bet")
					$page="browse_bet";
					elseif(isset($_POST['reffer_to']) and $_POST['reffer_to']=="leaderboard")
					$page ="leaderboard";
					else
					$page="browse_bet";
					//redirect($this->session->userdata('refered_from')); 
					header("location: ".base_url().$page);
				}	
				else
				{
					header("location: ".base_url());
				}	
			}
			else
			{
			   	$this->session->set_flashdata('login', 'Invalid Username or Password .');			
				redirect($this->session->userdata('refered_from')); 
			}
		}
	}



function assign_rand_value($num)
{

  switch($num){case "1":$rand_value = "a";break;case "2":$rand_value = "b";break;case "3":$rand_value = "c";break;case "4":$rand_value = "d";break;case "5":
     $rand_value = "e";break;case "6":$rand_value = "f";break;case "7":$rand_value = "g";break;case "8":$rand_value = "h";break;case "9":$rand_value = "i";
    break;case "10":$rand_value = "j";break;case "11":$rand_value = "k";break;case "12":$rand_value = "l";break;case "13":$rand_value = "m";break;case "14":
     $rand_value = "n";break;case "15":$rand_value = "o";break;case "16":$rand_value = "p"; break;case "17":$rand_value = "q";break;case "18":$rand_value = "r";
    break;case "19":$rand_value = "s";break;case "20":$rand_value = "t";break;case "21":$rand_value = "u";break;case "22":$rand_value = "v";break;case "23":$rand_value = "w";break;case "24":$rand_value = "x";break;case "25":$rand_value = "y";break;case "26":$rand_value = "z";break;case "27":$rand_value = "0";break;case "28": $rand_value = "1";break;case "29":$rand_value = "2";break;case "30":$rand_value = "3";break;case "31":$rand_value = "4";break;case "32":$rand_value = "5";break;
    case "33":$rand_value = "6";break;case "34":$rand_value = "7";break;case "35":$rand_value = "8";break;case "36":$rand_value = "9";break;}return $rand_value;
}
function get_rand_id($length)
{
  if($length>0) 
  { 
  $rand_id="";
   for($i=1; $i<=$length; $i++)
   {
   mt_srand((double)microtime() * 1000000);
   $num = mt_rand(1,36);
   $rand_id .= $this->assign_rand_value($num);
   }
  }
return $rand_id;
} 

	function forget_id(){
	if(isset($_POST['submit']))
		{
		$user_data=$this -> user_model ->check_user_mail($_POST['useremail'],$_POST['useremail']);
			
		if($user_data){
				
			$this->db->where('id',2);
			$Q=$this->db->get('tb_autoresponders');
			$row=$Q->result_array();
			$subject=$row[0]['subject'];
			$message=$row[0]['body'];
			
			$message=str_replace('{Username}',$user_data['user_username'], $message);
			
			$value=$this ->get_rand_id(10);
			$link='<a href="'.base_url().'home/reset_pass/'.$value.'">Link to pwd reset</a>';
			$message=str_replace('{Link to pwd reset}',$link,$message);
			
		
		
		
		/*$pass=$this ->get_rand_id('6');
		$pass1 = md5($pass);
		$Q = $this->db->query("update tb_users set password='$pass1' where user_userid='".$user_data['user_userid']."'");
		$subject='BetZie.com Account Assistance';
		$message="<html><body>";
		$message.='<table cellpadding="0" cellspacing="0" width="100%"><tr><td><a href="'.base_url().'">
<img border="0" src='.base_url()."public/images/logo.jpg".'></a></td></tr><tr><td style="font-size: 12px;color:#728085;" height="450" valign="top" >';
		$message.='<p><span>Dear '.$user_data['user_username'].'</span></p><p><span>As requested, here are your login details:</span></p><p>&nbsp;</p><p><span>Email address: '.$user_data['email'].' </span></p><p><span>Password: '.$pass.'</span></p><p><span>Please save this message for future reference.</span></p>';
		$message.="</td></tr></table></body></html>";		*/
		$headers="From: betzie.com <service@betzie.com>\n";
		$headers.="MIME-Version: 1.0\n";
		$headers.="Content-type: text/html; charset=iso-8859-1\n";
		$headers.="Content-Transfer-Encoding: base64\n";
		
		$message=rtrim(chunk_split(base64_encode($message)));
		$mail_sent=@mail($user_data['email'],$subject,$message, $headers) or die(mysql_error());	
		
	
		$rp=mysql_query("select * from tb_resetpassword where userid='".$user_data['user_userid']."' " );
		
		if(mysql_num_rows($rp)>0)
		{
		mysql_query("update tb_resetpassword set value='".$value."' where userid='".$user_data['user_userid']."' ");
		}
		else{
		mysql_query("insert into tb_resetpassword set userid='".$user_data['user_userid']."',value='".$value."' ");
		}
		
		}
		header("location:".base_url());
		}
		
	}
	
	function register() {
		if(isset($_POST['submit']))
		{
 			
			if(!empty($_POST['user']) && !empty($_POST['textPwd']) && !empty($_POST['email']))
		    {
				$exists =	$this -> user_model ->check_user($_POST['user'] , $_POST['email']);

				if(!$exists)
				{
				//CREATE USER ACCOUNT
			    $user_id = $this -> user_model ->create_user($_POST['user'] , $_POST['email'] , $_POST['textPwd'] );
				 $this -> user_model ->registered_email($_POST['user'] , $_POST['email'] , $_POST['textPwd'] );
				}
				
				if($user_id !='')
				{
					 
					 //UPDATE REFERER ACCOUT
					 if(isset($_SESSION['ref_user']) && is_numeric($_SESSION['ref_user']) && $_SESSION['ref_user']!='' && isset($_SESSION['to_email']))
					 {	
					 	$this->user_model ->update_referrer($_SESSION['ref_user'], trim($_SESSION['to_email']) , $user_id);
					 }
					 
					 $this->user_model ->user_rank($user_id);
					 
					 
					 // LOGIN USER 					 
					 $this->load->library('session');
					 $newdata = array(
								'userid' => $user_id ,
								'username'  => trim($_POST['user']),
								'email'     => trim($_POST['email']),
								'logged_in' => TRUE );
								
					  $this->session->set_userdata($newdata);		
					  $this->session->set_flashdata('com_reg', 'complete_registration');
					  //$this -> user_model ->registered_email( trim($_POST['user']), trim($_POST['email']) , $_POST['textPwd']);		  
					    
						
						// UPDATE USER LOG
						$ip=$_SERVER['REMOTE_ADDR'];
						$sql = mysql_query("select login_time from user_logs where user_id='".$user_id."' order by id DESC limit 0,1");
					if(mysql_num_rows($sql)>1)
					{
						$this->db->query("update tb_users set logstatus=1,numberofEmail=1 where user_userid='".$is_loggedin."'");
					}				
						$sqlData = mysql_fetch_array($sql);
						$query = mysql_query("SELECT DATEDIFF(now(),'".$sqlData['login_time']."') AS DiffDate");
						$queryData = mysql_fetch_array($query);
						
						if($queryData['DiffDate']>=1 || mysql_num_rows($sql)==0)
						{
						mysql_query("insert into user_logs SET user_id='".$user_id."',login_time=now(),ip_address='".$ip."'");
						
						}
						
					   // UPDATE ACCOUNT INFO
					   $this-> user_model -> update_user_account('signup' , $user_id );
						
					   header("location: ".base_url()."browse_bet/");
					  //EMAIL USER ACCOUNT DETAILS
					  
					  exit;
				}
		
			}			
		}
	}
	
	
	
	function thanks() 
	{
		$data = array('created' => 'yes' );				
		//$this->session->set_flashdata('home',"Account Created successfully.");
		$this->load->view('home',$data);	
	}
		
	function checkEmail() {		
		$email = trim(strtolower($_REQUEST['email']));
		$this->db->where('user_email', $email);
		$Q = $this->db->get('gb_users');
		$valid = 'true';
		$num = $Q->num_rows();
		if($num>0){
			$valid = '"Thats already taken."';
		}
		echo $valid;
	
	}
	
	
	function checkusername() {		
		$username = trim(strtolower($_REQUEST['username']));
		$this->db->where('user_username', $email);
		$Q = $this->db->get('gb_users');
		$valid = 'true';
		$num = $Q->num_rows();
		if($num>0){
		$valid = 'false';
		}
		echo $valid;
	
	}
	
	
	
	function delete_my_account() {
		
		if (isset($_SESSION['userid'])){
		$user_id=$_SESSION['userid'];
		// Delete records from gb_status_update tables
		$this->db->where('user_userid', $user_id);
		$this->db->delete('gb_status_update'); 
		
		// Delete records from gb_beans tables
		$this->db->where('user_id', $user_id);
		$this->db->delete('gb_beans'); 
		
		// Delete records from gb_users tables
		$this->db->where('user_userid', $user_id);
		$this->db->delete('gb_users'); 
		
		// Delete records from gb_twitter_facebook_settings tables
		$this->db->where('user_id', $user_id);
		$this->db->delete('gb_twitter_facebook_settings'); 
		
		// Delete records from gb_tags_relation tables
		$this->db->where('user_id', $user_id);
		$this->db->delete('gb_tags_relation'); 
		
		header("location: ".base_url()."user/logout");
		}
		else{
		header("location: ".base_url()."user/settings");	
		}
		}
	
	function welcome() {
		if($this->session->userdata("USER")=="")
			header("location: ".base_url('ssl')."user/login");
		else
		{
			$result=$this->Info_Model->getContent(16);
			$data["meta_keyword"]=$result->meta_keyword;
			$data["meta_description"]=$result->meta_description;
			$data["page_title"]="Payment successful";
			
			$user_id=$this->session->userdata("USER");
			$this->db->where('user_id',$user_id);
			$Q = $this->db->get('tb_users');
			$userInfo = $Q->result();
			
			$this->db->where('mobile',$userInfo[0]->mobile);
			$this->db->where('verified','Y');
			$Q = $this->db->get('tb_verification');
			$num = $Q->num_rows();
			if($num>0)
				$data["file"]="thanks1";
			else
				$data["file"]="thanks";
			
			$data["userInfo"]=$userInfo[0];		
			$data["user_id"]=$user_id;			
			
			$this->load->view('template',$data);
		}
	}
	
		

	function logout() 
	{
	    $appapikey = "f597c47cb01b3bb83b851fc34bb7ed3d";
		//$this->session->unset_userdata("USER","session_id","order_id");		
		$this->session->destroy();
		setcookie("X-Mapping-caklakng",  "", time()-3600);
		setcookie("PHPSESSID", "", time()-3600);	
		setcookie($appapikey."_user", "", time()-60*60*24,'/','ajaxdesigners.com');
		setcookie($appapikey."_session_key", "", time()-3600);
		setcookie($appapikey."_expires", "", time()-3600);
		setcookie($appapikey, "", time()-3600);		
		
		header("location: ".base_url()."");
				
	}

	function forgotPassword() {
		if(isset($_POST['forgot_email']))
		{
			$email=$_POST['forgot_email'];
			
			$this->db->where('email',$email);
			$this->db->where('status!=','2');
			$Q = $this->db->get('tb_users');
			$num = $Q->num_rows();
			if($num>0)
			{
				$pwd = $Q->result();
				
				$password= strtolower($pwd[0]->password);
			
				$this->db->where('id',2);
				$Q=$this->db->get('tb_autoresponders');
				if($Q->num_rows()>0)
				{
					$row=$Q->result_array();
					$subject=$row[0]['subject'];
					$message="<html><head><link href='".base_url()."public/css/dailysms.css' rel='stylesheet' type='text/css' media='all' /></head><body>";
					$message.="<table cellpadding='0' cellspacing='0' width='100%'><tr><td background='".base_url()."public/images/dailysms_email_bg.jpg' style='font-size: 12px;color:#728085;' height='450' valign='top' ><img src='".base_url()."public/images/dailysms_email_logo.gif' />";
					
					$message.=$row[0]['body'];
					$message=str_replace('"www.dailysms.com','"http://www.dailysms.com',$message);
					$message=str_replace('../../../','http://www.dailysms.com/',$message);
					
					$message=str_replace("__user_email__", $email, $message); 
					$message=str_replace("__user_password__", $password, $message); 
					
					$message.="</td></tr></table></body></html>";
					
					$message=rtrim(chunk_split(base64_encode($message)));

					$headers="From: DailySMS <service@dailysms.com>\n";
					$headers.="MIME-Version: 1.0\n";
					$headers.="Content-type: text/html; charset=iso-8859-1\n";
					$headers.="Content-Transfer-Encoding: base64\n";
					
					$mail_sent=@mail($email,$subject,$message, $headers);					
				}
				if($mail_sent)
				{
					$this->session->set_flashdata('login', 'Password sent to your email address.');
				}
				else
					$this->session->set_flashdata('login', 'Sorry! Email can not be sent right now. Try after sometime.');
			}
			else
				$this->session->set_flashdata('login', 'Given email address not registered on DailySMS.com.');
		}
		else
			$this->session->set_flashdata('login', 'Invalid Code.');
		
		header("location: ".base_url('ssl')."user/login");
	}

	
	function fb_reg()
	{  
		$this->load->library('facebook_connect');
		$data = array(
							'user'		=> $this->facebook_connect->user,
							'user_id'	=> $this->facebook_connect->user_id
		);
							
		$data['file']='home';
		
		$is_user_registered =  $this->user_model->check_fbuser_exist($data['user_id']);
		
		if($is_user_registered)
		{
		    // LOGIN USER IF FACEBOOK ID EXISTS
			$user_data = $this->user_model->fetch_user_data($is_user_registered);
			$this->load->library('session');
			$newdata = array(
								'userid' => $user_data[0]['user_userid'] ,
								'username'  => $user_data[0]['user_username'],
								'user_facebook_id' => $user_data[0]['user_facebook_id'],
								'user_photo' => $user_data[0]['user_photo'],
								'logged_in' => TRUE );
						
			$this->session->set_userdata($newdata);
			//UPDATE ACCOUNT BY LOGIN BETS
			$this->session->set_flashdata('fblogin', 'loggedin');
			
				
			//FACEBOOK PERMISSIONS
			$permission = $this->facebook_connect->check_permission($user_data[0]['user_facebook_id'],'publish_stream');
			if($permission)
			{
				$this->session->set_userdata('stream_publish',$permission);
			}else{
				$appapikey="e6c164cf398d87e015c3f943cac07617";
header("location:http://www.facebook.com/connect/prompt_permissions.php?api_key=$appapikey&v=1.0&next=http://greenbean.me/user_home&fbconnect=true&return_session=true&display=popup&ext_perm=offline_access,publish_stream");
	die;			
		}
						
			//UPDATE USER LOG TABLE
			$ip=$_SERVER['REMOTE_ADDR'];

			/*$sql = mysql_query("select login_time from user_logs where user_id='".$user_data[0]['user_userid']."' order by id DESC limit 0,1");
			$sqlData = mysql_fetch_array($sql);
			if(mysql_num_rows($sql)>1)
					{
						$this->db->query("update tb_users set logstatus=1,numberofEmail=1 where user_userid='".$is_loggedin."'");
					}
			$query = mysql_query("SELECT DATEDIFF(now(),'".$sqlData['login_time']."') AS DiffDate");
			$queryData = mysql_fetch_array($query);
			if($queryData['DiffDate']>=1 || mysql_num_rows($sql)==0)
			{
				
			mysql_query("insert into user_logs SET user_id='".$user_data[0]['user_userid']."',login_time=now(),ip_address='".$ip."'");
			
			//UPDATE USER ACCOUNT (ONCE IN 24 HOUR)
			 $this->user_model->update_user_account('signin' ,$user_data[0]['user_userid']);
			
			}*/
			//UPDATE USER LOG TABLE
			
			header("location: ".base_url()."user_home");
			exit;	
			
		}
		else
		{			
			 // REGISTER USER IF NOT EXISTS
			 $fb_acc_id =  $this->user_model->reg_fb_user($data['user'], $data['user_id']);	
			 
			 if($fb_acc_id)
			 {
			 	
				//UPDATE REFERER ACCOUT
					 if(isset($_SESSION['ref_user']) && is_numeric($_SESSION['ref_user']) && $_SESSION['ref_user']!='' && isset($_SESSION['to_email']))
					 {	
					 	$this->user_model ->update_referrer($_SESSION['ref_user'], trim($_SESSION['to_email']) , $user_id);
					 }
			   // LOGIN USER
			    $user_data = $this->user_model->fetch_user_data($fb_acc_id);
			    $this->load->library('session');
				$newdata = array(
								'userid' => $user_data[0]['user_userid'] ,
								'username'  => $user_data[0]['user_username'],
								'user_facebook_id' => $user_data[0]['user_facebook_id'],
								'user_photo' => $user_data[0]['user_photo'],
								'logged_in' => TRUE );
							
				$this->session->set_userdata($newdata);
				//$this->user_model ->user_rank($fb_acc_id);
				//UPDATE ACCOUNT BY SIGNUP BETS
							
				$this->session->set_flashdata('com_fb_reg', 'complete_registration');
				
				//UPDATE USER LOG TABLE
				$ip=$_SERVER['REMOTE_ADDR'];
				
				//FACEBOOK PERMISSIONS
			$permission = $this->facebook_connect->check_permission($user_data[0]['user_facebook_id'],'publish_stream');
			if($permission)
			{
				$this->session->set_userdata('stream_publish',$permission);
			}else{
				$appapikey="e6c164cf398d87e015c3f943cac07617";
header("location:http://www.facebook.com/connect/prompt_permissions.php?api_key=$appapikey&v=1.0&next=http://greenbean.me/user_home&fbconnect=true&return_session=true&display=popup&ext_perm=offline_access,publish_stream");
	die;			
		}

				/*$sql = mysql_query("select login_time from user_logs where user_id='".$user_data[0]['user_userid']."' order by id DESC limit 0,1");
				$sqlData = mysql_fetch_array($sql);
				if(mysql_num_rows($sql)>1)
					{
						$this->db->query("update tb_users set logstatus=1,numberofEmail=1 where user_userid='".$is_loggedin."'");
					}
				$query = mysql_query("SELECT DATEDIFF(now(),'".$sqlData['login_time']."') AS DiffDate");
				$queryData = mysql_fetch_array($query);
				if($queryData['DiffDate']>=1 || mysql_num_rows($sql)==0)
				{
				mysql_query("insert into user_logs SET user_id='".$user_data[0]['user_userid']."',login_time=now(),ip_address='".$ip."'");
				}
			   //UPDATE USER LOG TABLE
				
			   //UPDATE USER ACCOUNT 
			   $this->user_model->update_user_account('signup' , $user_data[0]['user_userid']);*/
				
				header("location: ".base_url()."user_home");	
				exit;
			 }
		 
		}
		//$this->load->view('template',$data);	
	    //header("location: ".base_url());
	}
	
	
	
	function twitter_reg()
	{  
	
		
		
	 	$twitter_userinfo=$this->session->set_userdata('twitter_userinfo');
		
		//print_r($twitter_userinfo);
		
	
				
		$is_user_registered =  $this->user_model->check_twitter_user_exist($this->session->userdata("twitter_id"));
		
		if($is_user_registered)
		{
		    // LOGIN USER IF FACEBOOK ID EXISTS
			$user_data = $this->user_model->fetch_user_data($is_user_registered);
			
			$newdata = array(
								'userid' => $user_data[0]['user_userid'] ,
								'username'  => $user_data[0]['user_username'],
								'user_twitter_id' => $user_data[0]['user_twitter_id'],
								'user_photo' => $user_data[0]['user_photo'],
								'logged_in' => TRUE );
						
			$this->session->set_userdata($newdata);
							
			//UPDATE USER LOG TABLE
			$ip=$_SERVER['REMOTE_ADDR'];
			 
			 //UPDATE USER LOG TABLE
			
			header("location: ".base_url()."user_home");
			exit;	
			
		}
		else
		{			
			 // REGISTER USER IF NOT EXISTS
			 $this->load->library('twitter');
			 
			 $twitter_userinfo=$this->twitter->call('users/show', array('id' => $_SESSION['twitter_id']));
					 
			 $twitter_acc_id =  $this->user_model->reg_twitter_user($twitter_userinfo,$twitter_userinfo->id);	
			 
			 if($twitter_acc_id)
			 {
			 	
				//UPDATE REFERER ACCOUT
					 if(isset($_SESSION['ref_user']) && is_numeric($_SESSION['ref_user']) && $_SESSION['ref_user']!='' && isset($_SESSION['to_email']))
					 {	
					 	$this->user_model ->update_referrer($_SESSION['ref_user'], trim($_SESSION['to_email']) , $user_id);
					 }
			   // LOGIN USER
			    $user_data = $this->user_model->fetch_user_data($twitter_acc_id);
			    $this->load->library('session');
				$newdata = array('userid' => $user_data[0]['user_userid'] ,
								'username'  => $user_data[0]['user_username'],
								'user_twitter_id' => $user_data[0]['user_twitter_id'],
								'user_photo' => $user_data[0]['user_photo'],
								'logged_in' => TRUE );
							
				$this->session->set_userdata($newdata);
				//$this->user_model ->user_rank($fb_acc_id);
				//UPDATE ACCOUNT BY SIGNUP BETS
							
				$this->session->set_flashdata('com_fb_reg', 'complete_registration');
				
				//UPDATE USER LOG TABLE
				$ip=$_SERVER['REMOTE_ADDR'];

				/*$sql = mysql_query("select login_time from user_logs where user_id='".$user_data[0]['user_userid']."' order by id DESC limit 0,1");
				$sqlData = mysql_fetch_array($sql);
				if(mysql_num_rows($sql)>1)
					{
						$this->db->query("update tb_users set logstatus=1,numberofEmail=1 where user_userid='".$is_loggedin."'");
					}
				$query = mysql_query("SELECT DATEDIFF(now(),'".$sqlData['login_time']."') AS DiffDate");
				$queryData = mysql_fetch_array($query);
				if($queryData['DiffDate']>=1 || mysql_num_rows($sql)==0)
				{
				mysql_query("insert into user_logs SET user_id='".$user_data[0]['user_userid']."',login_time=now(),ip_address='".$ip."'");
				}
			   //UPDATE USER LOG TABLE
				
			   //UPDATE USER ACCOUNT 
			   $this->user_model->update_user_account('signup' , $user_data[0]['user_userid']);*/
				
				header("location: ".base_url()."user_home");	
				exit;
			 }
		 
		}
		//$this->load->view('template',$data);	
	    //header("location: ".base_url());
	}
	
	
	function status_update()
	{
		if(ini_get('magic_quotes_gpc'))
		$_POST['inputField']=stripslashes($_POST['inputField']);
		$_POST['inputField'] = mysql_real_escape_string(strip_tags($_POST['inputField']));

		if(mb_strlen($_POST['inputField']) < 1 || mb_strlen($_POST['inputField'])>140)
		die("0");
			
			$status_updateQuery="INSERT INTO gb_status_update SET geo_location_id='".$_POST['geo_location_id']."',user_ip='".$_POST['user_ip']."', update_body='".$_POST['inputField']."',user_userid='".$_POST['user_id']."',status_update_date=NOW()";	
		 $query = $this->db->query($status_updateQuery);
		 $user_status_id = $this->db->insert_id() ;
		 
		 
//************************** Add tags (admin tags IN databse)******************************************************************


		 if(isset($_GET['send_tags'])) { $add_pre_tags = $_GET['send_tags']; } elseif(isset($_POST['send_tags'])) { $add_pre_tags = $_POST['send_tags']; } else { $add_pre_tags = false; }
		 
		 if($add_pre_tags){ 
			 foreach ($add_pre_tags as $pre_tags_add) {	
			 $status_updateQuery="INSERT INTO gb_tags_relation SET user_id='".$_POST['user_id']."',geo_location_id='".$_POST['geo_location_id']."',tag_id='".$pre_tags_add."',status_id='".$user_status_id."'";
			 $query = $this->db->query($status_updateQuery);
			 }
		}
//************************** Add New user tags ******************************************************************
 if(isset($_GET['tags'])) { $add_new_user_tags = $_GET['tags']; } elseif(isset($_POST['tags'])) { $add_new_user_tags = $_POST['tags']; } else { $add_new_user_tags = false; }
		
		if($add_new_user_tags){ 
		 
		 $this->add_new_user_tags($add_new_user_tags,$user_status_id,$_POST['user_id'],$_POST['geo_location_id']);
			
		}
		
		$user_info=$this->functions->getUserInfo($_POST['user_id']);
		
		/* Set up profile url for post */
		if ($user_info['user_profile_url']==""){
		$url_to_short="http://greenbean.me/user/profile/".$user_info['user_userid'];
		$profile_url=$this->user_model->GetShortURL($url_to_short);	
		$this->db->query("update gb_users set user_profile_url='".$profile_url."' where user_userid='".$_SESSION['userid']."'");
		
		}else{
			$profile_url=$user_info['user_profile_url'];
		}
		
		if($user_info['facebook_setting']=='Y'){
			$this->load->library('facebook_connect');
			$posting_settings=$this->functions->getUser_twitter_facebook_post_settings($_POST['user_id']);
			if(!isset($posting_settings)){
			$facebook_id=$user_info['user_facebook_id'];	
			}else{
			$facebook_id=$posting_settings['facebook_id'];
			$facebook_token=$posting_settings['facebook_token'];
			}
			$text_post_on_facebook=stripslashes($_POST['inputField']);
			
			/*$tag_array=$this->functions->status_tags($user_status_id);
			if($tag_array){ 
			for($i=0;$i<sizeof($tag_array);$i++) {
				$text_post_on_facebook.=" "."#".$tag_array[$i]['tag_name']." ";
				}
			}*/
			
			$text_post_on_facebook.=" ".$profile_url;
			
			echo $facebook_post_id=$this->facebook_connect->post_to_user_wall($facebook_id,"Green Bean Request",$text_post_on_facebook);
			
			
		}
		
		
		 if($user_info['twitter_setting']=='Y'){ 
		$this->load->library('twitter');

	
 $consumer_key = 'mtS3R3zUqDDoWG1KDKYbmQ';
 $consumer_secret = 'vdI3PWpIsyGHeQwWGSLBUBxYFh9Slestmabx4ZIGl8';
 $posting_settings=$this->functions->getUser_twitter_facebook_post_settings($_POST['user_id']);



if($posting_settings['twitter_token']==""){
$twitter_token=$user_info['twitter_token'];
$twitter_token_secretkey=$user_info['twitter_token_secretkey'];

}else{
	$twitter_token=$posting_settings['twitter_token'];
	$twitter_token_secretkey=$posting_settings['twitter_token_secretkey'];
	
}



	$text_post_on_twitter=stripslashes($_POST['inputField']);
	
	
	$tag_array=$this->functions->status_tags($user_status_id);
			if($tag_array){ 
			for($i=0;$i<sizeof($tag_array);$i++) {
				$text_post_on_twitter.=" "."#".$tag_array[$i]['tag_name']." ";
				
				 if(strlen($text_post_on_twitter)>=110){
					 break;
				 }
				}
			}
			
		$text_post_on_twitter.=" ".$profile_url;
		

$auth = $this->twitter->oauth($consumer_key, $consumer_secret, $twitter_token, $twitter_token_secretkey);
$this->twitter->call('statuses/update', array('status' => $text_post_on_twitter));

 }
		
		
		echo  $this->functions->formatTweet($_POST['inputField'],time(),$user_status_id);

	
	}
	
	
		function do_bean()
	{
		if(isset($_GET['bean_req_id'])) { $bean_req_id = $_GET['bean_req_id']; } elseif(isset($_POST['bean_req_id'])) { $bean_req_id = $_POST['bean_req_id']; } else { $bean_req_id = false; }
		if(isset($_GET['user_id'])) { $user_id = $_GET['user_id']; } elseif(isset($_POST['user_id'])) { $user_id = $_POST['user_id']; } else { $user_id = false; }
		if(isset($_GET['location_id'])) { $location_id = $_GET['location_id']; } elseif(isset($_POST['location_id'])) { $location_id = $_POST['location_id']; } else { $location_id = false; }
		
		$query_tags = $this->db->query("SELECT bean_id FROM gb_beans WHERE request_bean_id ='".$bean_req_id."' and user_id ='".$user_id."' and geo_location_id ='".$location_id."'");
		 $num = $query_tags->num_rows();
					
		if($num==0){					
				
		$bean_addQuery="INSERT INTO gb_beans SET request_bean_id='".$bean_req_id."',user_id='".$user_id."',bean_positive=1,bean_date=NOW(),geo_location_id='".$location_id."'";		
		 $query = $this->db->query($bean_addQuery);
		 $query_tags = $this->db->query("SELECT bean_id FROM gb_beans WHERE request_bean_id ='".$bean_req_id."'");
		echo $num = $query_tags->num_rows();
		}else{
			
			echo "error";
			
		}
	
	}
	
	
function add_new_user_tags($tags_array,$user_status_id,$user_id,$geo_location_id)
	{
		if($tags_array){ 			
			 foreach ($tags_array as $add_new_tags) {
				 //*************** Check Tags id already in database 
					 $query_tags = $this->db->query("SELECT tag_id FROM gb_tags WHERE label ='".$add_new_tags."'");
					 $num = $query_tags->num_rows();
					
				if($num==0){					
					 $status_addQuery="INSERT INTO gb_tags SET label='".$add_new_tags."',added_by='gb_user'";
					 $query = $this->db->query($status_addQuery);
					 $user_tag_id = $this->db->insert_id();
					 
					 $status_updateQuery="INSERT INTO gb_tags_relation SET user_id='".$user_id."',geo_location_id='".$geo_location_id."',tag_id='".$user_tag_id."',status_id='".$user_status_id."'";
					 $query = $this->db->query($status_updateQuery);
					}else{
					
					 $result = $query_tags->result_array(); 
					 $user_tag_id= $result[0]['tag_id'];
					$status_updateQuery="INSERT INTO gb_tags_relation SET user_id='".$user_id."',geo_location_id='".$geo_location_id."',tag_id='".$user_tag_id."',status_id='".$user_status_id."'";
					 $query = $this->db->query($status_updateQuery);
					}
			 }
	}
}
	function post_status()
	{	
		$type = 'signup';
		$userid = $_SESSION['userid'];
		$this->load->library('facebook_connect');
		if($type== 'signup' && $userid!=0)
		{	
			$result =array();
			$message = 'I just signed up for Green Beans  to bet on everything from sports to pop culture. Sign up here ';
			$qry = "SELECT * FROM tb_users WHERE user_userid =".mysql_real_escape_string($userid)." "; 	
			$Q = $this -> db->query($qry);
			//echo $this -> db->last_query(); 
			$num = $Q->num_rows();
			if($num > 0)
			{
			  $result = $Q->result_array();
			}		
			//print_r($result); 
			if($result!= NULL && $result[0]['user_facebook_id']!='' )
			{
				$is_allowed = $this->facebook_connect->check_permission($result[0]['user_facebook_id'] ,$type);
				if($is_allowed)
				{
					//POST THIS TO FACEBOOK	
					
					if($is_allowed)
					{
						$this->session->set_userdata('stream_publish',$is_allowed);
					}
								
			
				    $post_id = $this->facebook_connect->post_to_user_wall($result[0]['user_facebook_id'],$type,$message);			
					if($post_id!='')
					{
					  $this->user_model->Fb_feed_details($userid, $_SESSION['user_facebook_id'] ,'fbpost_signup',$message, $post_id);
					}
					$this->user_model-> account_amount_credit($userid ,500, 'fbpost_signup');						
				}
			}
			else
			{
				$this->session->set_userdata('stream_publish',0);
			}
			
			echo "<div id='fb_message' class='gry32'>
		  			<tr><td align='center' class='gry32'><br/>
					Posted to facebook successfully
					</td><br/>
					<a href='javascript:void(0)' onclick='closebox_fb()' id='mybutton' >
					<img src='".base_url()."public/images/ok.jpg' alt='fb_icon' align='absmiddle' border='0' /></a></tr>
					</div>";
			
		}
		//header('location:'.base_url().'browse_bet');
		//exit;
	}
	
	function fb_getid()
	{
	  	$this->load->library('facebook_connect');
		$data = array(
							'user'		=> $this->facebook_connect->user,
							'user_id'	=> $this->facebook_connect->user_id
		);
		
		$is_user_registered =  $this->user_model->check_fbuser_exist($data['user_id']);
		
		if($is_user_registered)
		{
		  // SHOW ERROR MESSAGE TAHT THE USER ALREADY EXISTS
		  echo "alerady exist";
		}
		else
		{
		  //$data['user_id'];
		  //ASSOCIATE FACEBOOK USER ID TO CURRENT ACCOUNT
		 $is_accociated = $this->user_model->associate_facebook_userid($_SESSION['userid'] , $data['user_id']);
		 if($is_accociated)
		 {
		      $this->session->set_userdata('user_facebook_id', $data['user_id']);
			  //ASK FOR PERMISSION
		 }
		 echo $data['user_id'];
		}
	}
	
	
	function updates()
	{
		$username=$_POST['username'];
		$_POST['firstname']=stripslashes($_POST['firstname']);
		$firstname=mysql_real_escape_string(strip_tags($_POST['firstname']));
		
		$_POST['lastname']=stripslashes($_POST['lastname']);
		$lastname=mysql_real_escape_string(strip_tags($_POST['lastname']));
		
		$user_email=stripslashes($_POST['user_email']);
		$user_location=$_POST['user_location'];
		if($user_location!=""){
		$location_info=explode(",", $user_location);
		
		$country_code=$_POST['q2'];
		$country_name=$_POST['q5'];
		$region_name=$location_info[1];
		$latitude=$_POST['q3'];
		$longitude=$_POST['q4'];
		$location_city=$location_info[0];
		
		$Q=$this->db->query("SELECT id FROM gb_geo_location where city ='".$location_city."' ORDER BY id DESC" );
		 $row=$Q->result();		
			if($Q->num_rows() ==0){
				$query = $this->db->query("INSERT INTO gb_geo_location (country_code,country_name,region_name,city,latitude,longitude) 

		    VALUES ('".$country_code."','".$country_name."','".$region_name."','".$location_city."', '".$latitude."','".$longitude."' ) ");
				
				if($query)

			{

				echo $geo_location_id = $this->db->insert_id() ;
				
			}
				 
			}else{
				echo $geo_location_id=$row[0]->id;
			}
			
			

		}		
	
		if (isset($_POST['twitter_setting'])=='on'){
		$twitter_setting='Y';
		}else {
			$twitter_setting='N';
		}
		if (isset($_POST['facebook_setting'])=='on'){
		$facebook_setting="Y";		
		}else{
			$facebook_setting="N";		
		}
		
		$this->db->query("update gb_users set user_username='".$username."',user_first_name='".$firstname."',user_last_name='".$lastname."',user_email='".$user_email."',user_location='".$geo_location_id."',twitter_setting='".$twitter_setting."',facebook_setting='".$facebook_setting."' where user_userid='".$_SESSION['userid']."'");
	$this->session->set_flashdata('success_msg', 'Profile updated successfully');
	header("location: ".base_url()."user/settings");	
	die;
		
	}
	
	
	
	function update_location()
	    {
	$user_location=$_POST['user_location'];
		
	         if($user_location!="")
			         {
					     
		$location_info=explode(",", $user_location);
		
		if(isset($location_info[1]))
		  {
		    $region_name=$location_info[1];  
		  }
		 else 
		   {
		     echo "Please enter city name as well"; die;
		     
		   }
		
		$location_city=$location_info[0];

		$country_code=$_POST['q2'];
		$country_name=$_POST['q5'];
		
		
		$latitude=$_POST['q3'];
		$longitude=$_POST['q4'];
				
		$Q=$this->db->query("SELECT id FROM gb_geo_location where city ='".$location_city."' ORDER BY id DESC" );
		 $row=$Q->result();		
			if($Q->num_rows() ==0){
				$query = $this->db->query("INSERT INTO gb_geo_location (country_code,country_name,region_name,city,latitude,longitude) 

		    VALUES ('".$country_code."','".$country_name."','".$region_name."','".$location_city."', '".$latitude."','".$longitude."' ) ");
				
				if($query)

			{

				$geo_location_id = $this->db->insert_id() ;
				
			}
				 
			}else{
				$geo_location_id=$row[0]->id;
			}
			
			

		
		             }
					 
	
	$this->db->query("update gb_users set user_location='".$geo_location_id."' where user_userid='".$_SESSION['userid']."'");
		 
		 echo $user_location;
		 echo ",";
		 echo $geo_location_id;
		 
	
		}

}
?>