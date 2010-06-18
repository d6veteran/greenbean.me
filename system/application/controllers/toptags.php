<?php

	class Toptags extends Controller {
		
		function Toptags()
		{
			parent::Controller();
			
			$this->load->helper('url');
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
			// $this->facebook_connect->client->events_get($data['user_id']);
				$ip = $this->input->ip_address();
				$geo_data = get_geolocation($ip);
				$data['geo_location']=$geo_data;
				$data['user_update']=$this->functions->user_status_update();
				$data['top_tags']=$this->functions->top_tags();
				$data['top_users']=$this->functions->top_leaders_tags();
				$data['top_users_tags']=$this->functions->top_user_in_tags();
				$data['top_users_past_days']=$this->functions->top_user(7);	
				$data['head_title']='Top Tags';
				$data['file']='top_tags';
				
			//*************************************** Add User Information***************************************
					
			$this->load->view('template', $data);
			
		}
	}