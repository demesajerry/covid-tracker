<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class contact_tracing extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->isLogin();
		//$this->output->enable_profiler(TRUE);
		 // Load Pagination library
    	$this->load->library('pagination');
    	$this->load->helper('captcha');
	}

	public function index()
	{
		$this->dashboard();
	}

	public function registration()
	{
		$this->load->model('contact_tracing_model');
		$this->data['content'] = 'contact_tracing/registration';
		$this->load->view('template/public', $this->data);
		
	}

}
