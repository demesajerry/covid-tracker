<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class general extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
	}


	public function add()
	{
		$this->load->model('admin_model', '', TRUE);
		$table = $this->input->post('table');
		$data = new stdClass();
		$data->{$table} = $this->input->post('new_item');
		$jsondata = new stdClass();
		$check = $this->admin_model->checker($data->{$table},$table);
		if($check == 0){
			$jsondata->id = $this->admin_model->add($data,$table);
		}
		else{
			$jsondata->id = '0';
		}
		$jsondata->new_item = $this->input->post('new_item');
		$jsondata->table = $this->input->post('table');

		header('Content-Type: application/json');
		echo json_encode( $jsondata );
	}

	public function municipality_list()
	{
		$this->load->model('general_model', '', TRUE);
		$provCode = $this->input->POST('provCode');
		$municipality_list = $this->general_model->get_municipality($provCode);
		echo json_encode($municipality_list);
	}
	public function brgy_list()
	{
		$this->load->model('general_model', '', TRUE);
		$citymunCode = $this->input->POST('citymunCode');
		$brgy_list = $this->general_model->get_brgy($citymunCode);
		echo json_encode($brgy_list);
	}
}
