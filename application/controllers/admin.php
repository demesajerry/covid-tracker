<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->isLogin();
	}


	public function preparation()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/preparation';
		$this->data['list'] = $this->admin_model->list("preparation");
		$this->load->view('template/admin', $this->data);
	}

	public function category()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/category';
		$this->data['category_list'] = $this->admin_model->category_list();
		$this->load->view('template/admin', $this->data);
	}	
	public function diagnosis()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->load->model('general_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/diagnosis';
		$this->data['diagnosis_list'] = $this->admin_model->diagnosis_list();
		$this->data['icd_group'] = $this->general_model->list('icd_group');
		$this->load->view('template/admin', $this->data);
	}
	public function medicine()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/medicine';
		$this->data['list'] = $this->admin_model->list("medicine");
		$this->load->view('template/admin', $this->data);
	}	
	public function laboratory()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/laboratory';
		$this->data['list'] = $this->admin_model->list("laboratory");
		$this->load->view('template/admin', $this->data);
	}
	public function source()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/source';
		$this->data['source_list'] = $this->admin_model->source_list();
		$this->load->view('template/admin', $this->data);
	}
	public function type()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/type';
		$this->data['type_list'] = $this->admin_model->type_list();
		$this->load->view('template/admin', $this->data);
	}
	public function vaccine()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/vaccine';
		$this->data['list'] = $this->admin_model->list("vaccine");
		$this->load->view('template/admin', $this->data);
	}

	public function mop()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/mop';
		$this->data['list'] = $this->admin_model->list("mop");
		$this->load->view('template/admin', $this->data);
	}
	public function hmo()
	{
		$this->load->model('admin_model', '', TRUE);
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'admin/hmo';
		$this->data['list'] = $this->admin_model->list("hmo");
		$this->load->view('template/admin', $this->data);
	}

	public function add_preparation()
	{
		$this->load->model('admin_model', '', TRUE);

		$data = array();
		$data["preparation"] = $this->input->post('preparation');
		$data["status"] = $this->input->post('status');
		$prep_id = $this->input->post('prep_id');

		if($prep_id == ""){
			$check = $this->admin_model->checker($data["preparation"],"preparation");
			if($check == 0){
				$this->admin_model->add_preparation($data);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data["preparation"].' has been added to preparation list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data["preparation"].' as preparation. Duplicate entry detected</div>');
			}
		}
		else{
			$this->admin_model->edit_preparation($data,$prep_id);
		}

		redirect(site_url("admin/preparation"));
	}

	public function add_category()
	{
		$this->load->model('admin_model', '', TRUE);

		$data = array();
		$data["category"] = $this->input->post('category');
		$data["status"] = $this->input->post('status');
		$cat_id = $this->input->post('cat_id');
		if($cat_id == ""){
			$check = $this->admin_model->checker($data["category"],"category");
			if($check == 0){
				$this->admin_model->add_category($data);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data["category"].' has been added to category list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data["category"].' as category. Duplicate entry detected</div>');
			}
		}
		else{
			$this->admin_model->edit_category($data,$cat_id);
		}

		redirect(site_url("admin/category"));
	}

	public function add_diagnosis()
	{
		$this->load->model('admin_model', '', TRUE);

		$data = array();
		$data["diagnosis"] = $this->input->post('diagnosis');
		$data["icd_code"] = $this->input->post('icd_code');
		$data["icd_group"] = $this->input->post('icd_group');
		$data["status"] = $this->input->post('status');
		$diagnosis_id = $this->input->post('diagnosis_id');
		if($diagnosis_id == ""){
			$check = $this->admin_model->checker($data["diagnosis"],"diagnosis");
			if($check == 0){
				$this->admin_model->add_diagnosis($data);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data["diagnosis"].' has been added to diagnosis list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data["diagnosis"].' as diagnosis. Duplicate entry detected</div>');
			}
		}
		else{
			$this->admin_model->edit_diagnosis($data,$diagnosis_id);
		}

		redirect(site_url("admin/diagnosis"));
	}

	public function delete_diagnosis()
	{
		$this->load->model('admin_model', '', TRUE);

		$diagnosis_id = $this->input->post('diagnosis_id');
		$diagnosis = $this->input->post('diagnosis');
		$this->admin_model->delete($diagnosis_id,'diagnosis_id','diagnosis');

		$this->session->set_flashdata('message', "<div class='alert alert-info'> Diagnosis  ".$diagnosis.' has been  deleted</div>');

		redirect(site_url("admin/diagnosis"));
	}
	public function delete_imm_place()
	{
		$this->load->model('admin_model', '', TRUE);

		$station_id = $this->input->post('station_id');
		$imm_place = $this->input->post('health_facility');
		$this->admin_model->delete($station_id,'station_id','health_station');

		$this->session->set_flashdata('message', "<div class='alert alert-info'> Place of Immunization  ".$imm_place.' has been  deleted</div>');

		redirect(site_url("clients/Immunization_place"));
	}

	public function add_source()
	{
		$this->load->model('admin_model', '', TRUE);

		$data = array();
		$data["source"] = $this->input->post('source');
		$data["status"] = $this->input->post('status');
		$source_id = $this->input->post('source_id');
		if($source_id == ""){
			$check = $this->admin_model->checker($data["source"],"source");
			if($check == 0){
				$this->admin_model->add_source($data);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data["source"].' has been added to source list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data["source"].' as source. Duplicate entry detected</div>');
			}			
		}
		else{
			$this->admin_model->edit_source($data,$source_id);
		}

		redirect(site_url("admin/source"));
	}
	public function add_type()
	{
		$this->load->model('admin_model', '', TRUE);

		$data = array();
		$data["type"] = $this->input->post('type');
		$data["status"] = $this->input->post('status');
		$type_id = $this->input->post('type_id');
		if($type_id == ""){
			$check = $this->admin_model->checker($data["type"],"type");
			if($check == 0){
				$this->admin_model->add_type($data);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data["type"].' has been added to type list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data["type"].' as type. Duplicate entry detected</div>');
			}			
			
		}
		else{
			$this->admin_model->edit_type($data,$type_id);
		}

		redirect(site_url("admin/type"));
	}
	public function add()
	{
		$this->load->model('admin_model', '', TRUE);
		$table = $this->input->post('table');
		$id_name = $this->input->post('id_name');
		$data = array();
		$data[$table] = $this->input->post('dbval');
		$data["status"] = $this->input->post('status');
		$id = $this->input->post('id');
		if($id == ""){
			$check = $this->admin_model->checker($data[$table],$table);
			if($check == 0){
				$this->admin_model->add($data,$table);
				$this->session->set_flashdata('message', "<div class='alert alert-info'>".$data[$table].' has been added to '.$table.' list.</div>');
			}
			else{
				$this->session->set_flashdata('message', "<div class='alert alert-warning'> Cannot add ".$data[$table].' as '.$table.'. Duplicate entry detected</div>');
			}			
			
		}
		else{
			$this->admin_model->edit($data,$id,$table,$id_name);
		}

		redirect(site_url("admin/".$table));
	}

	public function delete()
	{
		$this->load->model('admin_model', '', TRUE);
		$table = $this->input->post('table');
		$id_name = $this->input->post('id_name');
		$id = $this->input->post('id');
		$val = $this->input->post('dbval');
		$this->admin_model->delete($id,$id_name,$table);
		$this->session->set_flashdata('message', "<div class='alert alert-warning'>".$table. " " . $val . '  has been deleted</div>');
		redirect(site_url("admin/".$table));
	}

	public function edit_clients()
	{
		$this->load->model('clients_model', '', TRUE);

		$data = array();
		$data["fname"] = $this->input->post('fname');
		$data["lname"] = $this->input->post('lname');
		$data["mname"] = $this->input->post('mname');
		$data["brgy"] = $this->input->post('brgy');
		$data["gender"] = $this->input->post('gender');
		$data["birthday"] = $this->input->post('birthday');
		$clients_id = $this->input->post('clients_id');

		$this->clients_model->edit_clients($data,$clients_id);

		redirect(site_url("clients/list"));
	}

}
