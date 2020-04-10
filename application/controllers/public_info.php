<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class public_info extends MY_Controller {

	public function __construct() {
		parent::__construct();
		//$this->isLogin();
		//$this->output->enable_profiler(TRUE);
		 // Load Pagination library
    	$this->load->library('pagination');
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		$this->load->model('public_info_model');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$this->data['content'] = 'public_info/index';
		$this->data['confirmed'] = $this->public_info_model->count('0','');
		$this->data['pui'] = $this->public_info_model->count('1','');
		$this->data['pum'] = $this->public_info_model->count('2','');
		$this->data['deceased'] = $this->public_info_model->count('0','deceased');
		$this->data['recovered'] = $this->public_info_model->count('0','recovered');
		$this->data['active_case'] = $this->data['confirmed'] - ($this->data['deceased']+$this->data['recovered']);
		$this->load->view('template/public', $this->data);
	}

	public function list()
	{
		$this->data['content'] = 'public_info/confirmed';

		$this->load->view('template/public', $this->data);
	}

	public function pui()
	{
		$this->data['content'] = 'public_info/pui';

		$this->load->view('template/public', $this->data);
	}

	public function pum()
	{
		$this->data['content'] = 'public_info/pum';

		$this->load->view('template/public', $this->data);
	}
	public function patient_data($rowno=''){
		$this->load->model('public_info_model');
		$classification = $this->input->post('classification');

		// Row per page
	    $rowperpage = 4;

	    // Row position
	    if($rowno != 0){
	      $rowno = ($rowno-1) * $rowperpage;
	    }
	    // All records count
    	$allcount = $this->public_info_model->getrecordCount($classification);

    	// Get records
        $patients = $this->public_info_model->patient_data($rowno,$rowperpage,$classification);

		// Pagination Configuration
	    $config['base_url'] = base_url().'public_info/patient_data';
	    $config['use_page_numbers'] = TRUE;
	    $config['total_rows'] = $allcount;
	    $config['per_page'] = $rowperpage;
  		$choice = $config['total_rows'] / $config['per_page'];
		$config['num_links'] = floor($choice);
		$limit = $config['per_page'];
		$config['num_links'] = 2;
		$config['full_tag_open'] = '<ul class="pagination">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li class="page-item">';        
        $config['first_tag_close'] = '</li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="prev page-item">';        
        $config['prev_tag_close'] = '</li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li class="page-item">';        
        $config['next_tag_close'] = '</li>';        
        $config['last_tag_open'] = '<li class="page-item">';        
        $config['last_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="active page-link"><a href="#"class="disable">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li class="page-item">';        
        $config['num_tag_close'] = '</li>';	
		$config['attributes'] = array('class' => 'page-link');
	    // Initialize
	    $this->pagination->initialize($config);

	    // Initialize $data Array
	    $data['pagination'] = $this->pagination->create_links();
	    $data['result'] = $patients;
	    $data['row'] = $rowno;

		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function get_patients(){
		$table = $this->input->get('table');
		if($table == 'pum'){
			$class = 'PUM';
		}else if($table == 'pui'){
			$class = 'PUI';
		}else if($table == 'confirmed'){
			$class = 'LB';
		}
		$this->load->model('patients_model');

		$columns = array( 
                            0 =>'patient_id', 
                            1 =>'brgy',
                            2=> 'gender',
                            3=> 'status',
                            4=> 'current_location',
                            5=> 'age',
                            6=> 'symptoms',
                            7=> 'transmission',
                            8=> 'travel_history',
                            9=> 'current_condition',
                        );

		$limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->patients_model->allpatients_count($table);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $patients = $this->patients_model->allpatients($limit,$start,$order,$dir,$table);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $patients =  $this->patients_model->patients_search($limit,$start,$search,$order,$dir,$table);

            $totalFiltered = $this->patients_model->patients_search_count($search,$table);
        }

        $data = array();
        if(!empty($patients))
        {
            foreach ($patients as $val)
            {
				$symptoms_started=date_create($val->symptoms_started);
				$symptoms_started=date_format($symptoms_started,"F d, Y");
				$result_date=date_create($val->result_date);
				$result_date=date_format($result_date,"F d, Y");
                         $nestedData['patient_id'] = $class.$val->id;
                $nestedData['brgy'] = $val->brgy;
                $nestedData['gender'] = $val->gender;
                $nestedData['status'] = $val->status;
                $nestedData['current_location'] = $val->current_location;
                $nestedData['age'] = $val->age;
                $nestedData['symptoms'] = $val->symptoms;
                $nestedData['transmission'] = $val->transmission;
                $nestedData['travel_history'] = $val->travel_history;
                $nestedData['current_condition'] = $val->current_condition;
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
	}

	public function add_patients()
	{
		$symptoms_started=date_create($this->input->post('symptoms_started'));
		$symptoms_started=date_format($symptoms_started,"Y-m-d");
		$result_date=date_create($this->input->post('result_date'));
		$result_date=date_format($result_date,"Y-m-d");
		$date_recovered=date_create($this->input->post('date_recovered'));
		$date_recovered=date_format($date_recovered,"Y-m-d");
		$date_died=date_create($this->input->post('date_died'));
		$date_died=date_format($date_died,"Y-m-d");
		$symptoms = $this->input->post('symptoms');
		$table = $this->input->post('classification');
		$this->load->model('patients_model', '', TRUE);
		$data = new stdClass();
		$data->name = $this->input->post('name');
		$data->age = $this->input->post('age');
		$data->gender = $this->input->post('gender');
		$data->brgy = $this->input->post('brgy');
		$data->travel_history = $this->input->post('travel_history');
		$data->status = $this->input->post('status');
		$data->current_location = $this->input->post('current_location');
		$data->symptoms_started = $symptoms_started;
		$data->result_date = $result_date;
		$data->date_recovered = $date_recovered;
		$data->date_died = $date_died;
		$data->current_condition = $this->input->post('current_condition');
		$data->transmission = $this->input->post('transmission');
		$data->possible_link = $this->input->post('possible_link');
		foreach($symptoms as $key=>$val){
			if($key=='0'){
			$data->symptoms = $val;
			}
			else{
			$data->symptoms .= ','.$val;
			}
		}

		$id = $this->patients_model->add_patients($data,$table);
		$data->name = $data->name;
		$data->patient_id = $id;
		$data->action = 'added';
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function edit_patients()
	{
		$this->load->model('patients_model', '', TRUE);
		$symptoms_started=date_create($this->input->post('symptoms_started'));
		$symptoms_started=date_format($symptoms_started,"Y-m-d");
		$result_date=date_create($this->input->post('result_date'));
		$result_date=date_format($result_date,"Y-m-d");
		$date_recovered=date_create($this->input->post('date_recovered'));
		$date_recovered=date_format($date_recovered,"Y-m-d");
		$date_died=date_create($this->input->post('date_died'));
		$date_died=date_format($date_died,"Y-m-d");
		$symptoms = $this->input->post('symptoms');
		$table = $this->input->post('classification');
		$id = $this->input->post('id');
		$this->load->model('patients_model', '', TRUE);
		$data = new stdClass();
		$data->name = $this->input->post('name');
		$data->age = $this->input->post('age');
		$data->gender = $this->input->post('gender');
		$data->brgy = $this->input->post('brgy');
		$data->travel_history = $this->input->post('travel_history');
		$data->status = $this->input->post('status');
		$data->current_location = $this->input->post('current_location');
		$data->symptoms_started = $symptoms_started;
		$data->result_date = $result_date;
		$data->date_recovered = $date_recovered;
		$data->date_died = $date_died;
		$data->current_condition = $this->input->post('current_condition');
		$data->transmission = $this->input->post('transmission');
		$data->possible_link = $this->input->post('possible_link');
		foreach($symptoms as $key=>$val){
			if($key=='0'){
			$data->symptoms = $val;
			}
			else{
			$data->symptoms .= ','.$val;
			}
		}
		$this->patients_model->edit_patients($data,$id,$table);
		$data->id=	$id;
		$data->action = 'edited';
		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function pie_data()
	{
		$classification = $this->input->post('classification');
		$this->load->model('public_info_model', '', TRUE);
		$data = new stdClass();
		$data->pie_data = $this->public_info_model->pie_data($classification);

		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function bar_data()
	{
		$classification = $this->input->post('classification');
		$this->load->model('public_info_model', '', TRUE);
		$data = new stdClass();
		$data->pui_active = $this->public_info_model->bar_data(1,'');
		$data->pui_cleared = $this->public_info_model->bar_data(1,'CLEARED');
		$data->pum_active = $this->public_info_model->bar_data(2,'');
		$data->pum_cleared = $this->public_info_model->bar_data(2,'CLEARED');
		$data->test_conducted = $this->public_info_model->test_data('');
		$data->test_positive = $this->public_info_model->test_data('POSITIVE');
		$data->test_negative = $this->public_info_model->test_data('NEGATIVE');
		$data->test_waiting = $this->public_info_model->test_data('WAITING');

		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function area_data()
	{
		$this->load->model('public_info_model', '', TRUE);
		$data = new stdClass();
		$data->area_data = $this->public_info_model->area_data();
		$data->recoveries_data = $this->public_info_model->recoveries_data();
		$data->death_data = $this->public_info_model->death_data();

		header('Content-Type: application/json');
		echo json_encode( $data );
	}

	public function tree_data()
	{
		$this->load->model('public_info_model', '', TRUE);
		$data = new stdClass();
		$tree_data = $this->public_info_model->tree_data();

		function buildTreeFromObjects($items) {

		    $childs = [];

		    foreach ($items as $item){
		        $childs[$item->possible_link][] = $item;
		    }

		    foreach ($items as $item){ 
		    	if (isset($childs[$item->id])){
		        $item->children = $childs[$item->id];
		    	}
			}
		        unset($childs->possible_link);

		    return $childs[0];
		}

		$tree = buildTreeFromObjects($tree_data);

		header('Content-Type: application/json');
		echo json_encode( $tree );
	}

}
