<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); 

class login extends CI_Controller {
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');
		
		// Load session library
		$this->load->library('session');
		
		// Load database
		$this->load->model('login_database');
		
		// for pagination
		$this->load->helper("url");
        $this->load->library("pagination");
		//$this->output->enable_profiler(TRUE);
		
	}
	
	
	
		// Show login page
		public function index() {
		$this->user_login_process();	
		}	
		
		// Check for user login process
		public function user_login_process() {
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		

		
		if ($this->form_validation->run() == FALSE) {
		if(isset($this->session->userdata['logged_in'])){
		//call view function
		$this->view_dashboard();

		}else{
		$this->load->view('header');
		$this->load->view('login_form');
		}
		} else {
		$data = array(
		'username' => $this->input->post('username'),
		'password' => $this->input->post('password')
		);
		$result = $this->login_database->login($data);
		if ($result == TRUE) {
		$username = $this->input->post('username');
		$result = $this->login_database->read_user_information($username);
		if ($result != false) {
			//set session data	
			$session_data = new stdClass();
			$session_data->uid =  $result[0]->uid;
			$session_data->username =  $result[0]->username;
			$session_data->fname =  $result[0]->fname." ".$result[0]->lname;
			$session_data->division =  $result[0]->division;
			$session_data->unit =  $result[0]->unit;
			$session_data->priviledge =  $result[0]->priviledge;
			$session_data->userdp =  $result[0]->userdp;
			$this->session->set_userdata('logged_in', $session_data);
			//call view function
			$this->view_dashboard();
			}
		
		
		}else {
		$data = array(
		'error_message' => '<strong>Alert: </strong>Invalid Username or Password'
		);
		$this->load->view('header');
		$this->load->view('login_form', $data);
		}
		}
		}	
		
		// Logout from admin page
		public function logout() {
		
		// Removing session data
		$sess_array = array(
		'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = '<strong>Info:</strong> Successfully Logout';
		$this->load->view('header');
		$this->load->view('login_form', $data);
		}
	public function view_dashboard(){
		if(isset($this->session->userdata['logged_in'])){
			$this->load->model('user_information_model', '', TRUE);
			$receiveData = new stdClass;
			$receiveData->dtsno = $this->input->POST('search');
			$receiveData->opt = $this->input->POST('opt');
			$receiveData->view_data1 = $this->session->userdata('logged_in');
			//$receiveData->all_received = $this->user_information_model->all_receiveddocs($receiveData);
			
			$viewData = new stdClass();
			$viewData->view_data1 = $this->session->userdata('logged_in');
			//check all_received function returns true
			//if($receiveData->all_received){
				//$viewData->num_tomyunit = $this->user_information_model->count_tomyunit($receiveData);
				//for percentage graph only
				
				//for graph of received over total for recieved 
				//$unitreceive = count($this->user_information_model->count_allreceived($receiveData));
				//$totaltorec = count($viewData->num_tomyunit);
				//$viewData->statreceive = ($unitreceive / $totaltorec) * 100;
				
				//for graph of all received with action over all received with or without action
				//$viewData->statforaction = (count($this->user_information_model->count_allacted($receiveData)) / $unitreceive)*100;
				
				
			//}
			//if all_receifed fucntion returns false set variable value to false
			//else{
				//$viewData->num_received = false;
				//$viewData->num_forforward = false;
			//}
			//display number for received
			$viewData->num_received = $this->user_information_model->counter_receiveddocs($receiveData);
			//display number for archive
			$viewData->num_forarchive = $this->user_information_model->counter_forarchive($receiveData);
			//display number forwarded
			$viewData->num_forwarded = $this->user_information_model->counter_forwarded($receiveData);
			//display number for receive
			$viewData->num_forreceive = $this->user_information_model->counter_forreceive($receiveData);
			$viewData->checker = 2;
			
			$viewData->view_data2 = $this->user_information_model->fast_receive_view($viewData);
			//To identify that the document is not archived
			$status = '0';
			if($viewData->checker == 2 && isset($viewData->view_data2[0]->dtsno)){
			$viewData->copy_no = $this->user_information_model->detail_copy_counter($viewData->view_data2[0]->dtsno,$status);
			foreach($viewData->copy_no as $copy_no ){
			$viewData->view_detail[] = $this->user_information_model->viewdoc($viewData->view_data2[0]->dtsno,$copy_no->copy_no,$status);
			}
			$name = $viewData->view_detail[0][0]->value;
			$uid = explode(":",$name);
			$viewData->view_udetail = $this->user_information_model->get_userinfo($uid[0]);
			$viewData->switch_selector = $this->user_information_model->viewdoc_forswitch($viewData->view_data2[0]->dtsno,$status);
			}
			//if($viewData->checker == 2 && !isset($viewData->view_data2[0]->dtsno)){
			//$viewData->view_detail = 'empty';
			//}
			//$this->output->enable_profiler(TRUE);
			
			$this->load->view('header');
			$this->load->view('dashboard',$viewData);
		}
		else{
			$this->load->view('header');
			$this->load->view('login_form');
		}
	}
}
