<?php

	class user_home extends Controller {
		
		function user_home()
		{
			parent::Controller();
			
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('User_Model');
			$this->load->model('Location_Model');
		}
		
		function index()
		{
			$this->load->library('facebook_connect');
			$this->load->database();
			$data = array(
						'user'		=> $this->facebook_connect->user,
						'user_id'	=> $this->facebook_connect->user_id
						
					);
		
			// This is how to call a client API methods
			//
			// $this->facebook_connect->client->feed_registerTemplateBundle($one_line_story_templates, $short_story_templates, $full_story_template);
			// 
			
			$data['user_update']=$this->functions->user_status_update();
			$data['admin_tags']=$this->functions->user_pre_tags();
			$ip = $this->input->ip_address();
			$geo_data = get_geolocation($ip);			
			$data['head_title']='User Home';
			$data['geo_location']=$this->functions->check_geo_location($geo_data);
			$data['top_users']=$this->functions->top_user_bylocation($geo_data); 
			$data['user_ip']=$ip;
			$data['file']='user_home';
			//*************************************** Add User Information***************************************
			$this->load->view('template', $data);
			
			

			
		}
	}