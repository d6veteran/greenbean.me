<?php
/** 
 * CodeIgniter Facebook Connect Library (http://www.haughin.com/code/facebook/)
 * 
 * Author: Elliot Haughin (http://www.haughin.com), elliot@haughin.com
 * 
 * VERSION: 1.0 (2009-05-18)
 * LICENSE: GNU GENERAL PUBLIC LICENSE - Version 2, June 1991
 * 
 **/

	include(APPPATH.'libraries/facebook-client/facebook.php');

	class Facebook_connect {

		private $_obj;
		private $_api_key		= NULL;
		private $_secret_key	= NULL;
		public 	$user 			= NULL;
		public 	$user_id 		= FALSE;
		
		public $fb;
		public $client;

		function Facebook_connect()
		{
			$this->_obj =& get_instance();

			$this->_obj->load->config('facebook');
			$this->_obj->load->library('session');
			
			$this->_api_key		= $this->_obj->config->item('facebook_api_key');
			$this->_secret_key	= $this->_obj->config->item('facebook_secret_key');

			$this->fb = new Facebook($this->_api_key, $this->_secret_key);
			
			$this->client = $this->fb->api_client;
			
			$this->user_id = $this->fb->get_loggedin_user();

			$this->_manage_session();

			if ( $this->user_id !== NULL )
			{
				
			}
		}


		private function _manage_session()
		{
			$user = $this->_obj->session->userdata('facebook_user');

			if ( $user === FALSE && $this->user_id !== NULL )
			{
				$profile_data = array('uid','first_name', 'last_name', 'name','birthday','birthday_date', 'sex','hometown_location','current_location','username','locale', 'pic_square', 'proxied_email','profile_url');
				 try{	
				$info = $this->fb->api_client->users_getInfo($this->user_id, $profile_data);
				$user = $info[0];
				$this->_obj->session->set_userdata('facebook_user', $user);
				 }
				  catch(Exception $ex)
		   		{}
				
			}
			elseif ( $user !== FALSE && $this->user_id === NULL )
			{
				// Need to destroy session
			}

			if ( $user !== FALSE )
			{
				$this->user = $user;
			}
		}
		
			function get_user_image($user_id)
		{
		   $result=''; $newresult='';
		   $sqlUserDetails = "SELECT pic_big FROM user WHERE uid='$user_id'";	
		   	   
		   try{			   
		   $result = $this->fb->api_client->fql_query($sqlUserDetails);  
		   }
		   catch(Exception $ex)
		   {}
		 	
		   if($result!='')
		   {
		    $newresult =  $result[0]['pic_big'];
		   }	
				 		        
		   return $newresult;    
		}
		
		function check_permission($user_id , $type)
		{
		    $result = array();
			$Fql = "select publish_stream from permissions where uid ='".$user_id."' ";
			try
			{
				$result = $this->fb->api_client->fql_query($Fql);  
			}
			catch(FacebookRestClientException $ex)
			{}
									
			if($result != NULL)
			{
			  return $result[0]['publish_stream'];
			}
			else
			{
			  return false;
			}
		}
		
				
		function post_to_user_wall($fbid , $type , $message)
		{
				
				
				$is_published='';
				$share_link ='http://greenbean.me/';
				$message = "$message" ; 
						   $attachment = 
						   array( 'name' => 'GreenBean', 
								  'href' => $share_link, 
								  'caption' => '', 
								  'description' => '', 
				
										   );
						  
				$action_links = array( array('text' => 'Share', 'href' =>$share_link )); 
										
				$attachment = json_encode($attachment); 
				$action_links = json_encode($action_links); 
								
				try{
					$is_published = $this->fb->api_client->stream_publish($message, $attachment, $action_links, $fbid , $fbid);
				}
				catch(Exception $ex)
				{
				
				}
				if($is_published!='')
				{
				 // echo $is_published ; die;
				  return $is_published;
				}
				else
				{
				  return false;
				}

		}
		
	}