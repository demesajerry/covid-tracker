<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $data = array();
	protected $login_user_data = array();
	public function __construct()
	{
		parent::__construct();

		// $this->data['bread_crumbs'] = array();
	}
	
	public function admin_loader()
	{
		// $this->data["login_admin_data"] = $this->session->userdata('login_admin_data');
	}
	
	protected function redirect_to_default_page() 
	{				
 		//redirect(site_url("admin/home"));
	}
	
	protected function isLogin()
	{
		if(!$this->session->userdata('logged_in'))
		{
			redirect(site_url("authentication/logout"));
		}
	}
}
