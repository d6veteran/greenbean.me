<?php

	class Toplocation extends Controller {
		
		function Toplocation()
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
				$data['top_location']=$this->functions->top_location();
				$data['top_users_past_days']=$this->functions->top_user(7);				
				$data['file']='top_location';
				
			//*************************************** Add User Information***************************************
					
			$this->load->view('template', $data);
			
		}
	}