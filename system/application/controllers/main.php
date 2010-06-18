<?php
class main extends Controller {
	
	function index()
	{
		$this->load->view('main/index');
	}
	
	function signup()
	{
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model('User_model');
		
		$this->form_validation->set_rules('name', 'Name', 'required|min_length[5]|max_length[50]|trim|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[50]|trim|xss_clean|callback_user_exists');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[50]|trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|max_length[50]|valid_email');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('main/signup');
		} else {
			$this->User_model->create_user($this->input->post('name'), $this->input->post('username'), $this->input->post('email'), $this->input->post('password'));
			$this->load->view('main/signup_success');
		}
		
	}
	
	function signin()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->view('main/signin');
	}
	
	
	// Callback functions
	function user_exists($username)
	{
		if($this->User_model->user_exists($username) > 0)
		{
			$this->form_validation->set_message('user_exists', 'Username already in use!');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}

?>