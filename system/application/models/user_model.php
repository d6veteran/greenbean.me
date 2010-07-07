<?php
class User_model extends Model {
	
	function User_Model()
		{
			parent::Model();
		}
	
	function user_exists($username)
	{
		$this->db->select('user_username');
		$this->db->from('gb_users');
		$this->db->where('user_username', $username);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function create_user($fullname, $username, $email, $password)
	{
		$data = array('user_fullname' => $fullname, 'user_username' => $username, 'user_email' => $email, 'user_password' => $password);
		$this->db->insert('gb_users', $data);
	}
	
	
	
	function check_fbuser_exist($fb_id)
		{
		  $query = $this->db->query("SELECT user_userid FROM gb_users WHERE user_facebook_id =".$fb_id."");
		  $num = $query->num_rows();
		  if($num)
		   { 
		    $result = $query->result_array(); 
		    return $result[0]['user_userid'];
		  }
		  {
		    return false;
		  }
		
		}
		
		
		function check_twitter_user_exist($twitter_id)
		{
		  $query = $this->db->query("SELECT user_userid FROM gb_users WHERE user_twitter_id =".$twitter_id."");
		  $num = $query->num_rows();
		  if($num)
		   { 
		    $result = $query->result_array(); 
		    return $result[0]['user_userid'];
		  }
		  {
		    return false;
		  }
		
		}
		
		
		
		function reg_fb_user($user_data , $user_id)
		{
		    
			
			/*echo "<pre>";
			print($user_data);
			die;*/
			
		    $user_name = $this->username($user_data['first_name'], $user_data['last_name']);
			
			//GET FACEBOOK USERS IMAGE 
			$this->load->library('facebook_connect');
			$image_name ='';
			$image_url =  $this->facebook_connect->get_user_image($user_id);
			
			if($image_url !='' ){
			
				
			$image_name = end(explode("/",$image_url));
			//COPY THE IMAGE IN THE USER_IMAGES
			$dest = './public/user_image/'.$image_name ;
			copy($image_url, $dest);
			}

		    $query = $this->db->query("INSERT INTO gb_users (user_facebook_id ,user_username,  	user_first_name,user_last_name,user_account_type,facebook_proxied_emails,user_sign_date,user_photo,facebook_setting ) 
		    VALUES (".$user_id.",'".$user_name."','".$user_data['first_name']."','".$user_data['last_name']."', 'facebook','".$user_data['proxied_email']."','".date("Y-m-d H:i:s")."' , '".$image_name."','Y' ) ");
		   				
			if($query)
			{
				$user_id = $this->db->insert_id() ;
				return $user_id;
			}	   	
			else
			{
			 	return false;
			}	   
   
		}
		
		
			function reg_twitter_user($user_data , $user_id)
		{
		 	
		    $user_name = $this->twitter_username($user_data->screen_name);
			
			//GET FACEBOOK USERS IMAGE 
			
			$image_name ='';
			$image_url =  $user_data->profile_image_url;
			$image_url=str_replace("_normal","_bigger",$image_url);
			
			if($image_url !='' ){
			
				
			$image_name = end(explode("/",$image_url));
			//COPY THE IMAGE IN THE USER_IMAGES
			$dest = './public/user_image/'.$image_name ;
			copy($image_url, $dest);
			}

		    $query = $this->db->query("INSERT INTO gb_users (user_twitter_id ,user_username,user_first_name,user_account_type,user_sign_date,user_photo,twitter_token_secretkey,twitter_token,twitter_setting) 
		    VALUES (".$this->session->userdata("twitter_id").",'".$user_name."','".mysql_real_escape_string(strip_tags($user_data->name))."', 'twitter','".date("Y-m-d H:i:s")."' , '".$image_name."' , '".$_SESSION['twitter_oauth_tokens']['access_token_secret']."' , '".$_SESSION['twitter_oauth_tokens']['access_token']."','Y') ");
		   				
			if($query)
			{
				$user_id = $this->db->insert_id() ;
				return $user_id;
			}	   	
			else
			{
			 	return false;
			}	   
   
		}
		
		function fetch_user_data($uid)
		{
		 $query = $this->db->query("SELECT * from gb_users WHERE user_userid =".$uid." ");	
		 $result=$query->result_array();
		 return $result;
		}
		
		
			function getUserInfo($user_id)
		{
			$this->db->where('user_userid',$user_id);
			$Q=$this->db->get('gb_users');
			if($Q->num_rows()>0)
			{
				$result=$Q->result_array();
				return $result[0];
			}
		}
		
		
			function getUser_twitter_facebook_settings_info($user_id)
		{
			$this->db->where('user_id',$user_id);
			$Q=$this->db->get('gb_twitter_facebook_settings');
			if($Q->num_rows()>0)
			{
				$result=$Q->result_array();
				return $result[0];
			}
		}
		
			/* GET FACEBOOK USERNAME */
		function username($fname, $lname)
		{
		 $u_name = strtolower($fname).strtolower($lname);
		 
	     $Q1 = $this->db->query("SELECT user_username FROM gb_users WHERE user_username ='$u_name' LIMIT 1");
		 $num1 = $Q1->num_rows();
		 
		 if($num1 > 0)
		 {		 
			 $Q2 =$this->db->query("SELECT user_username FROM gb_users 
			                         WHERE user_username 
								   REGEXP '".$u_name."[[:digit:]]' 
			                         ORDER BY user_sign_date DESC LIMIT 1");
									 
			 $num2 = $Q2->num_rows();
			 
			 if($num2 > 0)
			 {
					   $db_name = $Q2->row_array();
					   $db_name1 = $db_name['user_username'];
					   
					   $name_suffix = end(explode("",$db_name1));
					   $name_arr = explode("",$db_name1);
					   
					   if(is_numeric($name_suffix) && $name_suffix!='')
					   {    
							$db_name_size = sizeof($name_arr);
							$pri_name = array_slice($name_arr,0,$db_name_size-1);
										
							$name_prefix = implode("",$pri_name);
					   
							$name_suffix++;
							$u_name= $name_prefix."".$name_suffix; 
					   }
					   else
					   {  
					    $u_name= $u_name."1"; 
					   } 
				  }
				  else
				  {
				  $u_name= $u_name."1";
				  }
		}
		else
		{
		  $u_name= $u_name;
		}
	   
   	    return $u_name;
			
		}
		
		
		/* GET TWITTER USERNAME */
		
			function twitter_username($screen_name)
		{
		 $u_name = strtolower($screen_name);
		 
	     $Q1 = $this->db->query("SELECT user_username FROM gb_users WHERE user_username ='$u_name' LIMIT 1");
		 $num1 = $Q1->num_rows();
		 
		 if($num1 > 0)
		 {		 
			 $Q2 =$this->db->query("SELECT user_username FROM gb_users 
			                         WHERE user_username 
								   REGEXP '".$u_name."_[[:digit:]]' 
			                         ORDER BY user_sign_date DESC LIMIT 1");
									 
			 $num2 = $Q2->num_rows();
			 
			 if($num2 > 0)
			 {
					   $db_name = $Q2->row_array();
					   $db_name1 = $db_name['user_username'];
					   
					   $name_suffix = end(explode("_",$db_name1));
					   $name_arr = explode("_",$db_name1);
					   
					   if(is_numeric($name_suffix) && $name_suffix!='')
					   {    
							$db_name_size = sizeof($name_arr);
							$pri_name = array_slice($name_arr,0,$db_name_size-1);
										
							$name_prefix = implode("_",$pri_name);
					   
							$name_suffix++;
							$u_name= $name_prefix."_".$name_suffix; 
					   }
					   else
					   {  
					    $u_name= $u_name."_1"; 
					   } 
				  }
				  else
				  {
				  $u_name= $u_name."_1";
				  }
		}
		else
		{
		  $u_name= $u_name;
		}
	   
   	    return $u_name;
			
		}
		
		
		
		function update_user_account($type ,$userid)
		{
			$amount ='';
			if($type == 'signin')
			{
			   $amount = 10;
			   $Q = $this->db->query("INSERT INTO tb_account SET userId='".$userid."' , transactionCredit ='".$amount."',   amountaddedFrom ='".$type."' ");	
			     
			}
			elseif($type == 'signup')
			{
			  $amount = 1000;
			  $Q = $this->db->query("INSERT INTO tb_account SET userId='".$userid."' , transactionCredit ='".$amount."',
			   amountaddedFrom ='".$type."' ");	
			}
					
		}
		
		function GetShortURL($url)
		{
						
			
			
			
			$xml_string="<?xml version='1.0'?>";
			$xml_string.=$this->shortern_url($url);
			$xml = simplexml_load_string($xml_string);
			foreach ($xml->results as $record)
			{
				$shortcodeurl= $record->nodeKeyVal->shortUrl;
			   $shortname=$record->nodeKeyVal->userHash;
			}
			$statuscode=$xml->statusCode;
			if($statuscode=="OK")
			{
			
					return trim($shortcodeurl);
			}
			

		}
		
		function shortern_url($url)
		{
					
			
			$addonurl=$url;
			$url="http://api.bit.ly/shorten?version=2.0.1&login=nitinfuterox&apiKey=R_f752c86139f11e79aad45f47405b8bf4&format=xml&longUrl=".$addonurl;
			
			$ch = curl_init();
			
			//Set curl to return the data instead of printing it to the browser.
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//Set the URL
			curl_setopt($ch, CURLOPT_URL, $url);
			//Execute the fetch
			$data = curl_exec($ch);
			
			curl_close($ch);
			
			return $data;

		}
		
		
}
?>