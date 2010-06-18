<?php

	class Home extends Controller {
		
		function Home()
		{
			parent::Controller();
			
			$this->load->helper('url');
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

				$ip = $this->input->ip_address();
				$geo_data = get_geolocation($ip);				
				$data['user_update']=$this->functions->user_status_update();
				$data['geo_location']=$this->functions->check_geo_location($geo_data);
				$data['head_title']='Welcome Greenbean';
				$data['top_users']=$this->functions->top_user_bylocation($geo_data); 
				$data['file']='welcome_greenbean';
				
			
			$this->load->view('template', $data);
			
		}
	}