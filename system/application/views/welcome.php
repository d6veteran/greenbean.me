<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		//$this->load->view('welcome_message');
		$data = array(["title"]=>"Home");

		$this->load->view('welcome_greenbean',$data);
	}
	
	
	function facebook()
		{
			$this->load->library('facebook_connect');
			
			$data = array(
						'user'		=> $this->facebook_connect->user,
						'user_id'	=> $this->facebook_connect->user_id
					);

			// This is how to call a client API methods
			//
			// $this->facebook_connect->client->feed_registerTemplateBundle($one_line_story_templates, $short_story_templates, $full_story_template);
			// $this->facebook_connect->client->events_get($data['user_id']);

			$this->load->view('fbtest', $data);
		}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

