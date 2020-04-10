<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
	}

	public function index()
	{
		$this->list();
	}

	public function list()
	{
		$this->load->model('users_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'users/list';
		$this->data['users_list'] = $this->users_model->get_users_list();
		$this->load->view('template/admin', $this->data);
	}

	public function add_users()
	{
		$this->load->model('users_model', '', TRUE);
		$imagedata = $_POST["image"];

		$image_array_1 = explode(";", $imagedata);

		$image_array_2 = explode(",", $image_array_1[1]);

		$imagedata = base64_decode($image_array_2[1]);

		$data = array();
		$data["fname"] = $this->input->post('fname');
		$data["lname"] = $this->input->post('lname');
		$data["mname"] = $this->input->post('mname');
		$data["username"] = $this->input->post('username');
		$data["password"] = sha1($this->input->post('password'));
		$access = $this->input->post('access');
		foreach($access as $key=>$acc){
			if($key=='0'){
			$data["access"] = $acc;
			}
			else{
			$data["access"] .= ','.$acc;
			}
		}

		$id = $this->users_model->add_users($data);

		//add file name
		$imageName = 'user'.$id.'.jpg';
		//upload image
		file_put_contents("assets/images/user_photo/".$imageName, $imagedata);

		redirect(site_url("users/list"));
	}

	public function edit_users()
	{
		$this->load->model('users_model', '', TRUE);
		$imagedata = $_POST["image"];


		$data = array();
		$data["fname"] = $this->input->post('fname');
		$data["lname"] = $this->input->post('lname');
		$data["mname"] = $this->input->post('mname');
		$data["username"] = $this->input->post('username');
		$data["password"] = sha1($this->input->post('password'));
		$access = $this->input->post('access');
		foreach($access as $key=>$acc){
			if($key=='0'){
			$data["access"] = $acc;
			}
			else{
			$data["access"] .= ','.$acc;
			}
		}

		$id = $this->input->post('userid');

		//add file name
		$imageName = 'user'.$id.'.jpg';
		//upload image
		if(!empty($imagedata)){
		$image_array_1 = explode(";", $imagedata);
		$image_array_2 = explode(",", $image_array_1[1]);
		$imagedata = base64_decode($image_array_2[1]);
			file_put_contents("assets/images/user_photo/".$imageName, $imagedata);
		}

		$this->users_model->edit_users($data,$id);

		redirect(site_url("users/list"));
	}

}
