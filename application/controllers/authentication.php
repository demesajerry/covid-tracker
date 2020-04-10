<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$this->login_page();
	}
	
	public function login_page()
	{
		if(!isset($this->session->userdata['logged_in']))
		{
			$this->data['page_title'] = 'Login';
			$this->data['content'] = 'admin/login_view';
			$this->data['validation_message'] = '';
			$this->load->view('authentication/login', $this->data);
		} else {
			redirect(site_url("patients"));
		}
	}
	
	public function login()
	{
		$message = "Not Validation";
		

		if(trim($this->input->post('username')) != "" && trim($this->input->post('password')) != "")
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');		
		
			$this->load->model('user_information_model', '', TRUE);
				$user_information = $this->user_information_model->backend_authentication_details($username, $password);
				
				if($user_information != false) 
				{

					$sessiondata = new stdClass();
					$sessiondata->userid = $user_information->userid;
					$sessiondata->username = $user_information->username;
					$sessiondata->password = $user_information->password;
					$sessiondata->fullname = $user_information->fname." ".$user_information->lname;
					$sessiondata->access = explode(",", $user_information->access);
									
					$this->session->set_userdata('logged_in', $sessiondata);
					$message = "Completed";
				}
				else
				{
					$message = "Please enter correct username and password";
				}					
		} 
		else 
		{
			$message = "Please enter correct values";					
		}	
		output_to_json($this, $message);	
	}	

	public function logout()
	{
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = '<strong>Info:</strong> Successfully Logout';
		redirect('authentication');
	}
	
}
